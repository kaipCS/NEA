<?php session_start();
if(isset($_POST["paperid"])){
  $paperid = $_POST["paperid"];
  $_SESSION["paperid"] = $paperid;
}
else{
  $paperid = $_SESSION["paperid"];
}

include_once('connection.php');

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
  <div id="paper-questions" class="col-sm-8">
  <?php
    $stmt = $conn -> prepare("SELECT * FROM questioninpaper INNER JOIN questions
    ON questioninpaper.questionid = questions.questionid
    WHERE questioninpaper.paperid = :paperid ORDER BY questioninpaper.questionnumber ASC");
    $stmt->bindParam(':paperid', $paperid);
    $stmt -> execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);  
    foreach($rows as $row){
      $paper = $row["paper"];
      #correct the format of paper
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

    echo("<div class='question-rows row'>
    ".$row["questionnumber"] . ".
    <div class='question-row col-sm-8'>  
        <form action='display-question.php' method = 'POST' class ='question-form'>
          <input type='hidden' name='paperid' id='paperid' value='".$row["paperid"]."'>
          <input type='submit' class='paper-question-button' value=' STEP " . $paper . " " . $row["year"] . " " . $row["topic"] ."'>
        </form>
    </div>
    
    <div class='col-sm-1'>
      <input type='hidden' name='paperid' id='paperid' value='".$row["paperid"]."'>
      <input type='submit' class='delete-question move-button' onclick='return confirm(\"Are you sure you want to delete this questions?\")' value='X'>
    </div>
    <div class='col-sm-1'>
      <input type='hidden' name='paperid' id='paperid' value='".$row["paperid"]."'>
      <input type='submit' class='move-button' value='▲'>
    </div>
    <div class='col-sm-1'>
      <input type='hidden' name='paperid' id='paperid' value='".$row["paperid"]."'>
      <input type='submit' class='move-button' value='▼'>
    </div>
  </div> <br>");

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
                                    <input type="hidden" id="singlequestion" name="singlequestion" value=1>
                                    <input type="hidden" id="questionid" name="questionid" value="' . $_SESSION["questionid"] . '">
                                    <input type="submit" value="Uncomplete">
                                </form>
                            ';
                        }
                        
                        #if the user had no completed the question, show them the form to do so
                        else{
                            echo '
                                <form action="mark-complete.php" method="POST">
                                    <input type="hidden" id="singlequestion" name="singlequestion" value="1">
                                    <input type="hidden" id="questionid" name="questionid" value=" '.$_SESSION["questionid"].'">
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

<!-- Bottom blue bar -->
<div class="bottom-bar">
<a> </a>
</div>

</body>
</html>