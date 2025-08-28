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
        <form action="test-filters.php"  method="POST">

            <!-- Paper (STEP I,II or III) -->
            <input type="checkbox" name="papers[]" value="1" checked> STEP I <br>
            <input type="checkbox" name="papers[]" value="2" checked> STEP II <br>
            <input type="checkbox" name="papers[]" value="3" checked> STEP III <br>
            <br>

            <!-- Year range -->
            Year:
            <br>
            from  <input class="year" type="text" name="from" value="1986"> to  <input class="year" type="text" name="to" value="2018">
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
        <?php
            print_r($_SESSION["results"]);
        ?>
    </div>

    <!-- Question preview column -->
    <div id="question-preview" class="col-sm-4">
        Question preview
    </div>
</div>

<!-- Bottom blue bar -->
<div class="bottom-bar">
<a> </a>
</div>

</body>
</html>