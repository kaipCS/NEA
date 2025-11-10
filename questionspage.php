<?php 
session_start();
include_once('connection.php');?> 

<!DOCTYPE html>
<html>
<head>
    <title>Questions</title>
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

<!-- Navbar -->
<?php 
    include 'navbar-signedin.php';
?>

<!-- Page contents -->
<div id = "questions-page" class="container">

    <!-- Search and filter column-->
    <div class="col-sm-4">

        <!-- Error message for empty search -->
        <div class="error-message">
                <?php
                    if ($_SESSION["error"] == "emptySearch"){
                        echo("Please enter a search.");
                    }
                ?>
        </div>

        <!-- Search form -->
        <form action="search-questions.php"  method="POST">
                <input type="text" id="search" name="search" placeholder="Search...">
                <input type="submit" value="Search">
        </form>

        <br>

        <!-- Filters -->
        <form action="filter-questions.php"  method="POST">

            <!-- Paper (STEP I,II or III) -->
            <input type="checkbox" name="papers[]" value="1" checked> STEP I <br>
            <input type="checkbox" name="papers[]" value="2" checked> STEP II <br>
            <input type="checkbox" name="papers[]" value="3" checked> STEP III <br>
            <br>

            <!-- Year range -->
            Year:
            <br>
            from  <input class="year" type="number" name="from" value="1986" min="1986" max="2018"> 
            to  <input class="year" type="number" name="to" value="2018" min="1986" max="2018">
            <br>
            <br>

            <!-- Areas (pure, stats or mech) -->

            <!-- Pure checkboxes -->
            <label class="area-button">
            <input id="pure-checkbox" type="checkbox" name="areas[]" value="pure" checked>  Pure

            <!-- Button to display the pure topic checkboxes -->
            <button type="button" id="toggle-pure-topics" class="collapse-button">◀</button>
            </label>

            <div id="pure-topics" style="display: none;">
                    <!-- topic checkboxes to be edited with JavaScript  -->
            </div>

            <!-- Algorithm to display topics and checkboxes -->
            <script>
                // Store all the relevant html elements as constants
                const pureCheckbox = document.getElementById("pure-checkbox");
                const pureTopics = document.getElementById("pure-topics");
                const pureButton = document.getElementById("toggle-pure-topics");

                //read json file 
                fetch("topics.json")
                .then(response => response.json())
                .then(data => {

                    // extract pure topics
                    const pureData = data.pure;

                    //iterate through each topic
                    for (const [topic, count] of Object.entries(pureData)) {

                        //make checkbox element
                        const checkbox = document.createElement("input");
                        checkbox.type = "checkbox";
                        checkbox.name = "pure-topics[]";
                        checkbox.className = "pure-topic";
                        checkbox.value = topic;
                        checkbox.checked = true;

                        // alert(checkbox.outerHTML);

                        // check if checkbox has changed
                        checkbox.addEventListener("change", changePureCheckbox);
                        
                        // if it is not checked, then uncheck pure checkbox
                        function changePureCheckbox(){
                            if (!checkbox.checked) {
                                pureCheckbox.checked = false;
                            }
                        }

                        // create checkbox label 
                        const topicLabel = document.createElement("label");
                        topicLabel.append(checkbox);

                        // display count in brackets eg "Curve sketching (46)"
                        topicLabel.append(" " + topic + " (" + count + ")");

                        // add topic to end of list of topics
                        pureTopics.append(topicLabel);

                        // add line break
                        const lineBreak = document.createElement("br");
                        pureTopics.append(lineBreak);

                    }
                    
                    // check if pure checkbox has changed
                    pureCheckbox.addEventListener("change", pureChange);


                    // match all pure topic checkboxes to the status of the pure checkbox
                    function pureChange(){
                        // alert("pure change");
                        const allTopicCheckboxes = document.querySelectorAll(".pure-topic");
                        // alert(allTopicCheckboxes.length);
                        allTopicCheckboxes.forEach(checkbox => {
                            checkbox.checked = pureCheckbox.checked;
                        });
                    }
                    
                    // if the display button is clicked 
                    pureButton.addEventListener("click", displayPureTopics);

                    // if topics where hidden, display them and vise versa by changing CSS
                    function displayPureTopics(){
                        if (pureTopics.style.display == "none" ){
                            pureTopics.style.display = "block";
                            pureButton.innerHTML = "▼";
                        }
                        else{
                            pureTopics.style.display = "none"
                            pureButton.innerHTML = "◀";
                        }
                    }

                });

            </script>

            <br>
            <!-- Mechanics checkboxes -->
            <label class="area-button">
            <input id="mech-checkbox" type="checkbox" name="areas[]" value="mechanics" checked>  Mechanics

            <!-- Button to display the mechanics topic checkboxes -->
            <button type="button" id="toggle-mech-topics" class="collapse-button">◀</button>
            </label>

            <div id="mech-topics" style="display: none;">
                    <!-- topic checkboxes to be edited with JavaScript  -->
            </div>
            <br>

            <!-- Algorithm to display topics and checkboxes -->
            <script>
                // Store all the relevant html elements as constants
                const mechCheckbox = document.getElementById("mech-checkbox");
                const mechTopics = document.getElementById("mech-topics");
                const mechButton = document.getElementById("toggle-mech-topics");

                //read json file 
                fetch("topics.json")
                .then(response => response.json())
                .then(data => {

                    // extract mehcanics topics
                    const mechData = data.mech;

                    //iterate through each topic
                    for (const [topic, count] of Object.entries(mechData)) {

                        //make checkbox element
                        const checkbox = document.createElement("input");
                        checkbox.type = "checkbox";
                        checkbox.name = "mech-topics[]";
                        checkbox.className = "mech-topic";
                        checkbox.value = topic;
                        checkbox.checked = true;

                        // check if checkbox has changed
                        checkbox.addEventListener("change", changeMechCheckbox);
                        
                        // if it is not checked, then uncheck mech checkbox
                        function changeMechCheckbox(){
                            if (!checkbox.checked) {
                                mechCheckbox.checked = false;
                            }
                        }

                        // create checkbox label 
                        const topicLabel = document.createElement("label");
                        topicLabel.append(checkbox);

                        // display count in brackets eg "Curve sketching (46)"
                        topicLabel.append(" " + topic + " (" + count + ")");

                        // add topic to end of list of topics
                        mechTopics.append(topicLabel);

                        // add line break
                        const lineBreak = document.createElement("br");
                        mechTopics.append(lineBreak);

                    }
                    
                    // check if mech checkbox has changed
                    mechCheckbox.addEventListener("change", mechChange);


                    // match all mech topic checkboxes to the status of the mech checkbox
                    function mechChange(){
                        const allTopicCheckboxes = document.querySelectorAll(".mech-topic");
                        
                        allTopicCheckboxes.forEach(checkbox => {
                            checkbox.checked = mechCheckbox.checked;
                        });
                    }
                    
                    // if the display button is clicked 
                    mechButton.addEventListener("click", displayMechTopics);

                    // if topics where hidden, display them and vise versa by changing CSS
                    function displayMechTopics(){
                        if (mechTopics.style.display == "none" ){
                            mechTopics.style.display = "block";
                            mechButton.innerHTML = "▼";
                        }
                        else{
                            mechTopics.style.display = "none"
                            mechButton.innerHTML = "◀";
                        }
                    }

                });

            </script>

            <!-- Probability checkboxes -->
            <label class="area-button">
            <input id="stats-checkbox" type="checkbox" name="areas[]" value="probability" checked>  Probability

            <!-- Button to display the stats topic checkboxes -->
            <button type="button" id="toggle-stats-topics" class="collapse-button">◀</button>
            </label>

            <div id="stats-topics" style="display: none;">
                    <!-- topic checkboxes to be edited with JavaScript  -->
            </div>

            <!-- Algorithm to display topics and checkboxes -->
            <script>
                // Store all the relevant html elements as constants
                const statsCheckbox = document.getElementById("stats-checkbox");
                const statsTopics = document.getElementById("stats-topics");
                const statsButton = document.getElementById("toggle-stats-topics");

                //read json file 
                fetch("topics.json")
                .then(response => response.json())
                .then(data => {

                    // extract stats topics
                    const statsData = data.stats;

                    //iterate through each topic
                    for (const [topic, count] of Object.entries(statsData)) {

                        //make checkbox element
                        const checkbox = document.createElement("input");
                        checkbox.type = "checkbox";
                        checkbox.name = "stats-topics[]";
                        checkbox.className = "stats-topic";
                        checkbox.value = topic;
                        checkbox.checked = true;

                        // check if checkbox has changed
                        checkbox.addEventListener("change", changeStatsCheckbox);
                        
                        // if it is not checked, then uncheck stats checkbox
                        function changeStatsCheckbox(){
                            if (!checkbox.checked) {
                                statsCheckbox.checked = false;
                            }
                        }

                        // create checkbox label 
                        const topicLabel = document.createElement("label");
                        topicLabel.append(checkbox);

                        // display count in brackets eg "Curve sketching (46)"
                        topicLabel.append(" " + topic + " (" + count + ")");

                        // add topic to end of list of topics
                        statsTopics.append(topicLabel);

                        // add line break
                        const lineBreak = document.createElement("br");
                        statsTopics.append(lineBreak);

                    }
                    
                    // check if stats checkbox has changed
                    statsCheckbox.addEventListener("change", statsChange);


                    // match all stats topic checkboxes to the status of the stats checkbox
                    function statsChange(){
                        const allTopicCheckboxes = document.querySelectorAll(".stats-topic");

                        allTopicCheckboxes.forEach(checkbox => {
                            checkbox.checked = statsCheckbox.checked;
                        });
                    }
                    
                    // if the display button is clicked 
                    statsButton.addEventListener("click", displayStatsTopics);

                    // if topics where hidden, display them and vise versa by changing CSS
                    function displayStatsTopics(){
                        if (statsTopics.style.display == "none" ){
                            statsTopics.style.display = "block";
                            statsButton.innerHTML = "▼";
                        }
                        else{
                            statsTopics.style.display = "none"
                            statsButton.innerHTML = "◀";
                        }
                    }

                });

            </script>

            <br>
            <br>

            <!-- Exclude questions user has already done -->
            <label>
                <input type="checkbox" name="exclude-complete" value="yes"> Exclude completed questions 
            </label>
            <br>
            <input type="submit" value="Apply filters">
        </form>

    </div>

    <!-- Questions list column -->
    <div id="questions-list" class="col-sm-4">

        <div id="sort-clear">
            <!-- Sort questions -->
            <form id="optionForm" action="sort-questions.php" method="POST">
                Sort by:
                <select name="sort" onchange="changeOption()">
                    <option value="oldest">Oldest First</option>
                    <option value="newest">Newest First</option>
                </select>
            </form>

            <!-- Submit sort form automatically if it is changed -->
            <script>
                function changeOption() {
                    document.getElementById("optionForm").submit();
                }
            </script>

            <form action="reset.php">
                <input id ="clear-filters" type="submit" value="Clear filters"> 
            </form>
        </div>
        <br>

        <?php
            #set sort to default oldest or depending on session
            $order = "ASC";
            if(isset($_SESSION["sort"]) && $_SESSION["sort"] == "newest"){
                $order = "DESC";
            }

            #if results have been set then display these, otherwise show all questions
            if(isset($_SESSION["results"])){
                #print_r($_SESSION["results"]);

                #implode results list
                $results = $_SESSION["results"];
                $results = "(" . implode(",", $results) .")";

                #search for questions in results
                $sql = "SELECT * FROM questions WHERE questionid IN $results ORDER BY year $order, paper ASC ";

                #display question
                $result = $conn->query($sql);

                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

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

                    #search for the question's keywords
                    $sql = "SELECT * FROM questionhaskeyword WHERE questionid = $questionid";

                    $questions = $conn->query($sql);

                    #store results in array
                    $keywords= [];

                    while ($keyword = $questions->fetch(PDO::FETCH_ASSOC)) {
                        $keywords[] = $keyword["keyword"];
                    }

                    #implode keywords into list
                    $keywords = implode(", ", $keywords);

                    echo(" 
                    <form action='display-question.php' method = 'POST' class ='question-form'>
                        <input type = 'hidden' name='questionid' value='" . $questionid . "'>
                        <button type = 'submit' class='question-button' >
                            STEP " . $paper . " " . $row["year"] . " " . $row["topic"] . "<br>
                                <div class='grey-text'>" . $keywords . "</div>
                        </button>
                    </form>");
                }
                
            }
            else{
                #select all questions as no search made
                $sql = "SELECT * FROM questions ORDER BY year $order, paper ASC ";

                $result = $conn->query($sql);

                #display question
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

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

                    #search for the question's keywords
                    $sql = "SELECT * FROM questionhaskeyword WHERE questionid = $questionid";

                    $questions = $conn->query($sql);

                    #store results in array
                    $keywords= [];

                    while ($keyword = $questions->fetch(PDO::FETCH_ASSOC)) {
                        $keywords[] = $keyword["keyword"];
                    }
                    
                    #implode keywords into list
                    $keywords = implode(", ", $keywords);

                    echo("  
                    <form action='display-question.php' method = 'POST' class ='question-form'>
                        <input type = 'hidden' name='questionid' value='" . $questionid . "'>
                        <input type = 'hidden' name='redirect' value='questions'>
                        <button type = 'submit' class='question-button' >
                            STEP " . $paper . " " . $row["year"] . " " . $row["topic"] . "<br>
                                <div class='grey-text'>" . $keywords . "</div>
                        </button>
                    </form>");

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
                                        #form to add question to paper

                    #find all titles of papers a user has created (that are not single questions)
                    $singlequestion = 0;
                    $stmt = $conn->prepare("SELECT * FROM usercreatespaper WHERE userid = :userid AND singlequestion = :singlequestion");
                    $stmt->bindParam(':userid', $_SESSION["userid"]);
                    $stmt->bindParam(':singlequestion', $singlequestion);
                    $stmt->execute();
                    
                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                
                    if (count($rows) > 0) {
                    echo('
                    <form action="add-to-paper.php" method="POST">
                        Add to paper 
                        <input type="hidden" name="questionid" value="' . $_SESSION["questionid"] . '">
                        <select name="paper">');
                        foreach ($rows as $row) {
                            echo '<option value="' . $row["paperid"] . '">' . $row["title"] . '</option>';
                        }
                                        
                        echo('</select>
                        <input type="submit" value="Add">
                    </form>
                    <br>');
                    } 

                    #if no titles are found, direct the user to create a paper 
                    else {
                        echo "<br> Create a paper in the papers tab to add questions like this to it.";
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
                        
                        #if the user had not completed the question, show them the form to do so
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