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
        <form action="search-questions.php"  method="POST">
            <input type="text" id="search" name="search" placeholder="Search...">
            <input type="submit" value="Search">
        </form>
        <br>
        <form action="filter-questions.php"  method="POST">
            <input type="checkbox" name="paper" value="1" checked> STEP I <br>
            <input type="checkbox" name="paper" value="2" checked> STEP II <br>
            <input type="checkbox" name="paper" value="3" checked> STEP III <br>
            <br>
            Year
            <br>
            from  <input type="text" class="year" name="from" value="1986"> to  <input type="text" class="year" name="to" value="2018">
            <br>
            <br>

            <div class="option-section">
                <div class="option-row">
                    <label>
                    <input id="pure-checkbox" type="checkbox" name="area" value="pure" checked>  Pure
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
                        checkbox.name = "pure-topic";
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
                            const allTopicCheckboxes = document.querySelectorAll('input[name="pure-topic"]');
                            allTopicCheckboxes.forEach(checkbox => {
                                checkbox.checked = true;
                            });
                        }
                        else{
                            const allTopicCheckboxes = document.querySelectorAll('input[name="pure-topic"]');
                            allTopicCheckboxes.forEach(checkbox => {
                                checkbox.checked = false;
                            });
                        }
                    }
                
                    pureCheckbox.addEventListener("change", pureChange);
                    
                    function displayTopics(){
                        if (pureTopics.style.display == "none"){
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
                    <input id="mech-checkbox" type="checkbox" name="area" value="mechanics" checked>  Mechanics
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
                        checkbox.name = "mech-topic";
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
                            const allTopicCheckboxes = document.querySelectorAll('input[name="mech-topic"]');
                            allTopicCheckboxes.forEach(checkbox => {
                                checkbox.checked = true;
                            });
                        }
                        else{
                            const allTopicCheckboxes = document.querySelectorAll('input[name="mech-topic"]');
                            allTopicCheckboxes.forEach(checkbox => {
                                checkbox.checked = false;
                            });
                        }
                    }
                
                    mechCheckbox.addEventListener("change", mechChange);
                    
                    function displayTopics(){
                        if (mechTopics.style.display == "none"){
                            mechTopics.style.display = "block";
                            mechButton.textContent = "▼";
                        }
                        else{
                            mechTopics.style.display = "none"
                            mechButton.textContent = "◀";
                        }
                    }

                    pureButton.addEventListener("click", displayTopics);
                });

            </script>

            <br>
            <input type="checkbox" name="exclude-complete" value="yes"> Exclude completed questions <br>
            <br>
            <input type="submit" value="Apply filters">
            </form>

        <br>
    </div>
    <div id="questions-list" class="col-sm-4">
        questions
    </div>
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