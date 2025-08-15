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
</head>
<body>

<!-- Navbar -->
<?php 
    include 'navbar-signedin.php';
?>

<!-- Page contents -->
<div id="questions-page" class="container">
    <div class="col-sm-4">
        <div class="error-message">
            <?php
                if ($_SESSION['error'] == "emptySearch"){
                    echo("Please enter a search.");
                }
            ?>
        </div>
        <form action="search-questions.php"  method="POST">
            <input type="text" id="search" name="search" placeholder="Search...">
            <input type="submit" value="Search">
        </form>
        <br>
        <form action="filter-questions.php"  method="POST">
            <input type="checkbox" name="papers[]" value="1" checked> STEP I <br>
            <input type="checkbox" name="papers[]" value="2" checked> STEP II <br>
            <input type="checkbox" name="papers[]" value="3" checked> STEP III <br>
            <br>
            Year:
            <br>
            from  <input type="number" name="from" value="1986"> to  <input type="number" name="to" value="2018">
            <br>
            <br>

            <div class="option-section">
                <div class="option-row">
                    <label>
                    <input id="pure-checkbox" type="checkbox" name="areas[]" value="pure" checked>  Pure
                    <button type="button" id="toggle-pure-topics" class="collapse-button">◀</button>
                    </label>
                </div>

                <div id="pure-topics">
                    <!-- topic checkboxes -->
                </div>
            </div>

            <script>
                const pureCheckbox = document.getElementById("pure-checkbox");
                const pureTopics = document.getElementById("pure-topics");
                const pureButton = document.getElementById("toggle-pure-topics");

                fetch("topics.json")
                .then(response => response.json())
                .then(data => {
                    const pureData = data.pure;

                    for (const [topic, count] of Object.entries(pureData)) {
                        const checkbox = document.createElement("input");
                        checkbox.type = "checkbox";
                        checkbox.name = "pure-topics[]";
                        checkbox.value = topic;
                        checkbox.checked = true;
                        
                        function changeCheckbox(){
                            if (!checkbox.checked) {
                                pureCheckbox.checked = false;
                            }
                        }

                        checkbox.addEventListener("change", changeCheckbox);

                        const topicLabel = document.createElement("label");
                        topicLabel.appendChild(checkbox);
                        topicLabel.appendChild(document.createTextNode(` ${topic} (${count})`));
                        pureTopics.appendChild(topicLabel);
                        pureTopics.appendChild(document.createElement("br"));
                    }

                    function pureChange(){
                        if (pureCheckbox.checked){
                            const allTopicCheckboxes = document.querySelectorAll('input[name="pure-topics[]"]');
                            allTopicCheckboxes.forEach(checkbox => {
                                checkbox.checked = true;
                            });
                        }
                        else{
                            const allTopicCheckboxes = document.querySelectorAll('input[name="pure-topics[]"]');
                            allTopicCheckboxes.forEach(checkbox => {
                                checkbox.checked = false;
                            });
                        }
                    }
                
                    pureCheckbox.addEventListener("change", pureChange);
                    
                    function displayTopics(){
                        if (pureTopics.style.display == "none"  || pureTopics.style.display == ""){
                            pureTopics.style.display = "block";
                            pureButton.textContent = "▼";
                        }
                        else{
                            pureTopics.style.display = "none"
                            pureButton.textContent = "◀";
                        }
                    }

                    pureButton.addEventListener("click", displayTopics);
                });

            </script>
            
            <div class="option-section">
                <div class="option-row">
                    <label>
                    <input id="mech-checkbox" type="checkbox" name="areas[]" value="mechanics" checked>  Mechanics
                    <button type="button" id="toggle-mech-topics" class="collapse-button">◀</button>
                    </label>
                </div>

                <div id="mech-topics">
                    <!-- topic checkboxes -->
                </div>
            </div>

            <script>
                const mechCheckbox = document.getElementById("mech-checkbox");
                const mechTopics = document.getElementById("mech-topics");
                const mechButton = document.getElementById("toggle-mech-topics");

                fetch("topics.json")
                .then(response => response.json())
                .then(data => {
                    const mechData = data.mech;

                    for (const [topic, count] of Object.entries(mechData)) {
                        const checkbox = document.createElement("input");
                        checkbox.type = "checkbox";
                        checkbox.name = "mech-topics[]";
                        checkbox.value = topic;
                        checkbox.checked = true;
                        
                        function changeCheckbox(){
                            if (!checkbox.checked) {
                                mechCheckbox.checked = false;
                            }
                        }

                        checkbox.addEventListener("change", changeCheckbox);

                        const topicLabel = document.createElement("label");
                        topicLabel.appendChild(checkbox);
                        topicLabel.appendChild(document.createTextNode(` ${topic} (${count})`));
                        mechTopics.appendChild(topicLabel);
                        mechTopics.appendChild(document.createElement("br"));
                    }

                    function mechChange(){
                        if (mechCheckbox.checked){
                            const allTopicCheckboxes = document.querySelectorAll('input[name="mech-topics[]"]');
                            allTopicCheckboxes.forEach(checkbox => {
                                checkbox.checked = true;
                            });
                        }
                        else{
                            const allTopicCheckboxes = document.querySelectorAll('input[name="mech-topics[]"]');
                            allTopicCheckboxes.forEach(checkbox => {
                                checkbox.checked = false;
                            });
                        }
                    }
                
                    mechCheckbox.addEventListener("change", mechChange);
                    
                    function displayTopics(){
                        if (mechTopics.style.display == "none" || mechTopics.style.display == ""){
                            mechTopics.style.display = "block";
                            mechButton.textContent = "▼";
                        }
                        else{
                            mechTopics.style.display = "none"
                            mechButton.textContent = "◀";
                        }
                    }

                    mechButton.addEventListener("click", displayTopics);
                });

            </script>

            <div class="option-section">
                <div class="option-row">
                    <label>
                    <input id="stats-checkbox" type="checkbox" name="areas[]" value="probability" checked>  Probability
                    <button type="button" id="toggle-stats-topics" class="collapse-button">◀</button>
                    </label>
                </div>

                <div id="stats-topics">
                    <!-- topic checkboxes -->
                </div>
            </div>

            <script>
                const statsCheckbox = document.getElementById("stats-checkbox");
                const statsTopics = document.getElementById("stats-topics");
                const statsButton = document.getElementById("toggle-stats-topics");

                fetch("topics.json")
                .then(response => response.json())
                .then(data => {
                    const statsData = data.stats;

                    for (const [topic, count] of Object.entries(statsData)) {
                        const checkbox = document.createElement("input");
                        checkbox.type = "checkbox";
                        checkbox.name = "stats-topics[]";
                        checkbox.value = topic;
                        checkbox.checked = true;
                        
                        function changeCheckbox(){
                            if (!checkbox.checked) {
                                statsCheckbox.checked = false;
                            }
                        }

                        checkbox.addEventListener("change", changeCheckbox);

                        const topicLabel = document.createElement("label");
                        topicLabel.appendChild(checkbox);
                        topicLabel.appendChild(document.createTextNode(` ${topic} (${count})`));
                        statsTopics.appendChild(topicLabel);
                        statsTopics.appendChild(document.createElement("br"));
                    }

                    function statsChange(){
                        if (statsCheckbox.checked){
                            const allTopicCheckboxes = document.querySelectorAll('input[name="stats-topics[]"]');
                            allTopicCheckboxes.forEach(checkbox => {
                                checkbox.checked = true;
                            });
                        }
                        else{
                            const allTopicCheckboxes = document.querySelectorAll('input[name="stats-topics[]"]');
                            allTopicCheckboxes.forEach(checkbox => {
                                checkbox.checked = false;
                            });
                        }
                    }
                
                    statsCheckbox.addEventListener("change", statsChange);
                    
                    function displayTopics(){
                        if (statsTopics.style.display == "none" || statsTopics.style.display == ""){
                            statsTopics.style.display = "block";
                            statsButton.textContent = "▼";
                        }
                        else{
                            statsTopics.style.display = "none"
                            statsButton.textContent = "◀";
                        }
                    }

                    statsButton.addEventListener("click", displayTopics);
                });

            </script>

            <input type="checkbox" name="exclude-complete" value="yes"> Exclude completed questions <br>
            <br>
            <input type="submit" value="Apply filters">
            </form>

        <br>
    </div>
    <div id="questions-list" class="col-sm-4">

        Sort by:
        <select id="sort" onchange="sortQuestions(this.value)">
            <option value="oldest" 
            <?php  
                if(!isset($_GET["sort"]) || $_GET["sort"] == "oldest"){
                    echo 'selected="selected"';
                }
            ?>
            >Oldest First</option>
            <option value="newest"
            <?php
                if(isset($_GET['sort']) && $_GET['sort'] == 'newest'){
                    echo 'selected="selected"';
                } 
            ?>
            >Newest First</option>
        </select>
        
        <br>
        <br>

        <?php
            $order = "ASC";
            if (isset($_GET["sort"]) && $_GET["sort"] == 'newest') {
                $order = 'DESC'; 
            }

            $sql_order = "ORDER BY year $order, paper ASC";

            if (isset($_SESSION['results'])){
                if (empty($_SESSION['results'])){
                    echo ("No results.");
                }
                else{
                    $results = $_SESSION['results'];
                    $resultsList = "'" . implode("','", $results) . "'";

                    $stmt = $conn->query("SELECT * FROM questions WHERE questionid IN ($resultsList) $sql_order"); 
                    
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        if ($row["paper"] == 1){
                            $paper = "I";
                        }
                        else if ($row["paper"] == 2){
                            $paper = "II";
                        }
                        else{
                            $paper = "III";
                        }
                        
                        $stmt2 = $conn->prepare("SELECT keyword FROM questionhaskeyword WHERE questionid = :questionid");
                        $stmt2->bindParam(':questionid', $row["questionid"]);
                        $stmt2->execute();
    
                        $keywords = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                        $keywordList = implode(", ", array_column($keywords, 'keyword'));
    
                        echo "
                        <div class='button question-row' onclick=\"window.location.href='display-question.php?id={$row['questionid']}'\">
                            STEP $paper {$row['year']} {$row['topic']}
                            <div class='grey-text'>$keywordList</div>
                        </div>
                        <br>
                        ";
                    }

                }

                unset($_SESSION['results']);
            }
            else{
                #echo("show all questions");
                $stmt = $conn->prepare("SELECT * FROM questions $sql_order");
                $stmt -> execute();
                while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
                    if ($row["paper"] == 1){
                        $paper = "I";
                    }
                    else if ($row["paper"] == 2){
                        $paper = "II";
                    }
                    else{
                        $paper = "III";
                    }
                    
                    $stmt2 = $conn->prepare("SELECT keyword FROM questionhaskeyword WHERE questionid = :questionid");
                    $stmt2->bindParam(':questionid', $row["questionid"]);
                    $stmt2->execute();

                    $keywords = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                    $keywordList = implode(", ", array_column($keywords, 'keyword'));

                    echo "
                    <div class='button question-row' onclick=\"window.location.href='display-question.php?id={$row['questionid']}'\">
                        STEP $paper {$row['year']} {$row['topic']}
                        <div class='grey-text'>$keywordList</div>
                    </div>
                    <br>
                    ";


                }
            }
        ?>
    </div>
    
    <script>
    function sortQuestions(sortValue) {
        window.location.href = window.location.pathname + '?sort=' + sortValue;
    }
    </script>

    <div id="question-preview" class="col-sm-4">
        question
    </div>
</div>

<!-- Bottom blue bar -->
<div class="bottom-bar">
<a> </a>
</div>

</body>
</html>