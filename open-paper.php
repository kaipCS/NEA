<?php session_start(); 
#connect to database
include_once('connection.php');

#check if the paper id is in the POST 
if(isset($_POST["paperid"])){
  $paperid = $_POST["paperid"];
  $_SESSION["paperid"] = $paperid;
}
#if it is not in the POST, get it from the session
else{
  $paperid = $_SESSION["paperid"];
}

#check if the creator is in the POST 
if(isset($_POST["creator"])){
    $creator = $_POST["creator"];
    $_SESSION["creator"] = $creator;
}
#if it is not in the POST, get it from the session
else{
    $creator = $_SESSION["creator"];
}
#echo($creator);

#calculate the users score
$stmt = $conn -> prepare("SELECT mark FROM userdoespaperdoesquestion WHERE paperid = :paperid AND userid = :userid ");
$stmt->bindParam(':paperid', $paperid);
$stmt->bindParam(':userid', $_SESSION["userid"]);
$stmt -> execute();
$marks = $stmt->fetchAll(PDO::FETCH_ASSOC);  
$correct = 0;
$total= 0;
#iterate through each completed question from this paper
foreach($marks as $mark){
    if (!empty($mark)){
        $total = $total + 20;
        $correct = $correct + $mark["mark"];
    }
}

#get the title, time and note for the paper
$stmt = $conn -> prepare("SELECT * FROM usercreatespaper WHERE paperid = :paperid");
$stmt->bindParam(':paperid', $paperid);
$stmt -> execute();
$paper= $stmt->fetch(PDO::FETCH_ASSOC); 
$title = $paper["title"];
$time = $paper["time"];
$note = $paper["details"];
?>

<!DOCTYPE html>
<html>
<head>
  <title>Paper</title>
  <!-- Links to style sheet and bootstrap -->
  <link rel="stylesheet" href="stylesheet.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script>
        MathJax = {
        tex: {
            inlineMath: {'[+]': [['$', '$']]}
        }
        };
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/mathjax@4/tex-mml-svg.js"></script>
</head>
<body>

<!-- Link to navbar -->
<?php 
include 'navbar-signedin.php';?>

<!-- Page contents -->
<div class="container">
    <!-- List of questions section of the page -->
    <div id="paper-questions" class="col-sm-8">
        <!-- Paper information -->

        <!-- Title and time -->
        <?php
            echo($title . " <br> (" .$time . " minutes)" );
        ?>

        <!-- Edit the title and time -->
        <?php 
        if ($creator == "You"){
            echo("<button class='edit-paper-button' onclick='openForm()'>Edit</button>
            <!-- Javascript to open and close edit information pop up-->
            <script>
                function openForm() {
                document.getElementById('edit-paper').style.display = 'block';
                }
                function closeForm() {
                document.getElementById('edit-paper').style.display = 'none';
                }
            </script>");
        }
        ?>

        <!-- Score -->
        <?php
        if($_SESSION["role"] == 0){
            echo("<div class='score'>
                Score: <br>" . $correct . "/" . $total . "
            </div>");
        }
        ?>

        <!-- Questions -->
        <div class="question-list">
            <?php
        
            #find all questions in paper selected
            $stmt = $conn -> prepare("SELECT * FROM questioninpaper INNER JOIN questions
                ON questioninpaper.questionid = questions.questionid
                WHERE questioninpaper.paperid = :paperid ORDER BY questioninpaper.questionnumber ASC");
            $stmt->bindParam(':paperid', $paperid);
            $stmt -> execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);  

            #check if no records were selected
            if (empty($rows)) {
                echo("Browse questions on the 'Questions' tab where you can add them to this paper");
            }
            else{
            #find the largest question number 
            $questionNumbers = array_column($rows, 'questionnumber');
            $maxNumber = max($questionNumbers);
            }

            #display all the information about each question
            foreach($rows as $row){
                #print_r($row);

                #correct the format of paper
                $paper = $row["paper"];
                switch ($paper) {
                    case 1:
                        $paper = "I";
                        break;
                    case 2:
                        $paper = "II";
                        break;
                    case 3:
                        $paper = "III";
                        break;
                }

                $questionid = $row["questionid"];

                #display each question as a button 
                echo("<div class='question-row'>
                ".$row["questionnumber"] . ".
                <form action='display-question.php' method = 'POST' class ='question-form'>
                    <input type = 'hidden' name='page' value='open-paper'>
                    <input type = 'hidden' name='questionid' value='" . $questionid . "'>
                    <button type = 'submit' class='question-button' >
                        STEP " . $paper . " " . $row["year"] . " " . $row["topic"] . "<br>
                    </button>
                </form>");

                if($creator == "You"){
                    echo("<form action='delete-question.php' method='post'>
                        <input type='hidden' name='questionid' value='".$questionid."'>
                        <input type='submit' class='delete-question move-button' onclick='return confirm(\"Are you sure you want to delete this question?\")' value='X'>
                    </form>");

                    #only have an up button if the question is not at the top
                    if($row["questionnumber"] != 1){
                        echo("<form action='move-question.php' method='post'>
                            <input type='hidden' name='questionid'  value='".$questionid."'>
                            <input type='hidden' name='direction' id='direction' value='up'>
                            <input type='hidden' name='questionnumber' value='".$row["questionnumber"]."'>
                            <input type='submit' class='move-button' value='▲'>
                        </form>");
                    }

                    #only have a down button if the question is not the last one
                    if ($row["questionnumber"] != $maxNumber){
                        echo("<form action='move-question.php' method='post'>
                            <input type='hidden' name='questionid' value='".$questionid."'>
                            <input type='hidden' name='direction' id='direction' value='down'>
                            <input type='hidden' name='questionnumber' value='".$row["questionnumber"]."'>
                            <input type='submit' class='move-button' value='▼'>
                        </form>");
                    }
                }

                echo("</div>");
            }

            ?>
        </div>

        <!-- Notes on paper -->
        <?php
        #display the note if they added one 
        if (!empty($note)) {
            echo 'Note: <br> ' . $note;
            echo "<br>";

            if($creator == "You"){
                #form to edit the question with hidden input in post 
                echo '
                <form action="edit-note.php" method="POST">
                    <input type="hidden" name="paperid" value="' . $paperid . '">
                    <input type="submit" value="Delete and edit">
                </form>
                ';
            }
        }

        #if the user had not added a note
        else{
            #if the user owns the paper
            if($creator == "You"){
                echo '
                    <form action="add-note.php" method="POST">
                        <input type="hidden" name="paperid" value=" '.$paperid.'">
                        <textarea name="details" placeholder="Add notes about this paper..." ></textarea>
                        <input type="submit" value="Save note">
                    </form>
                ';
            }
        }
        ?>

    </div>
    
    <!-- Question preview column -->
    <div class="question-preview col-sm-4">
        <div class="latex-question">
            <?php
                #if the user has selected a question 
                if (isset($_SESSION["display-code"])){
                    echo($_SESSION["display-code"]);
                    unset($_SESSION["display-code"]);
                echo ("</div>");

                    #print the question paper and year
                    echo ("STEP " . $_SESSION["paper"] . " " . $_SESSION["year"] . ". ");

                    unset($_SESSION["year"]);
                    unset($_SESSION["paper"]);

                    #if there is a solution avaliable, include it as a link
                    if(isset($_SESSION["solution"])){
                        echo("<a href = " .$_SESSION["solution"] . "> Link to solution </a> " );
                        unset($_SESSION["solution"]);
                    }
                    else{
                        echo(" No solution is avaliable for this question. ");
                    }

                    #only allow to the user to complete a question is they are a student
                    if ($_SESSION["role"] == 0){

                        #if the question selected has already been complete 
                        if (isset($_SESSION["complete"])) {

                            #display the note if they added one 
                            if (isset($_SESSION["note"])) {
                                echo 'Note: ' . $_SESSION["note"];
                                echo "<br>";
                                unset($_SESSION["note"]);
                            }

                            #display the mark if they added one 
                            if (isset($_SESSION["mark"])) {
                                echo 'Score: ' . $_SESSION["mark"];
                                unset($_SESSION["mark"]);
                            }
                            unset($_SESSION["complete"]);

                            #form to uncomplete the question with hidden input in post 
                            echo '
                                <form action="uncomplete.php" method="POST">
                                    <input type="hidden" id="singlequestion" name="singlequestion" value=0>
                                    <input type="hidden" name="questionid" value="' . $_SESSION["questionid"] . '">
                                    <input type="submit" value="Uncomplete">
                                </form>
                            ';
                        }
                        
                        #if the user had not completed the question, show them the form to do so
                        else{
                            echo '
                                <form action="mark-complete.php" method="POST">
                                    <input type="hidden" id="singlequestion" name="singlequestion" value="0">
                                    <input type="hidden" name="questionid" value=" '.$_SESSION["questionid"].'">
                                    <textarea name="note" placeholder="Add notes about this question..." ></textarea>
                                    Score <input type="number" id="score" name="score" min="0" max="20" >
                                    <input type="submit" value="Complete">
                                </form>
                            ';
                    
                        }
                    }
                }
                else{
                    echo("Select a question to view it.");
                }
            ?>

        </div>
</div>

<!-- create paper pop up-->
<div id="edit-paper">
  <form action="edit-paper.php" method="post" class="form-container">
    <button type="button" class="btn close" onclick="closeForm()">🞪</button>
    <h3>Edit paper information</h3>
    <br>
    Title: <br> <input id='edit-title'  type='text' name='title'>
    <br>
    Time (minutes): <br> <input id='edit-time'  type='number' placeholder='typically 30 minutes per question...' name='time'>
    <br>
    <br>
    <input type="submit" value="Update"></input>
  </form>
</div>

<!-- Bottom blue bar -->
<div class="bottom-bar">
<a> </a>
</div>


</body>
</html>