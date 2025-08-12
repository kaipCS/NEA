<?php session_start();

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
                    <input id="pure-checkbox" type="checkbox" name="area" value="pure" checked> Pure
                    </label>
                    <button type="button" id="toggle-pure-topics" class="collapse-button">◀</button>
                </div>

                <div id="pure-topics">
                    <!-- topic checkboxes -->
                </div>
                </div>

                <script>
                const pureCheckbox = document.getElementById("pure-checkbox");
                const pureContainer = document.getElementById('pure-topics');
                const pureToggleBtn = document.getElementById('toggle-pure-topics');

                // Fetch and display pure topics checkboxes
                fetch('topics.json')
                    .then(response => response.json())
                    .then(data => {
                    const pureTopics = data.pure;

                    for (const [topic, count] of Object.entries(pureTopics)) {
                        const checkbox = document.createElement('input');
                        checkbox.type = 'checkbox';
                        checkbox.name = 'pure-topic';
                        checkbox.value = topic;
                        checkbox.checked = true;
                        function changeCheckbox(){
                                if (!checkbox.checked) {
                                    pureCheckbox.checked = false;
                                }
                            }


                        checkbox.addEventListener("change", changeCheckbox);

                        const label = document.createElement('label');
                        label.appendChild(checkbox);
                        label.appendChild(document.createTextNode(` ${topic} (${count})`));

                        pureContainer.appendChild(label);
                        pureContainer.appendChild(document.createElement('br'));
                    }
                    });

                
                    pureCheckbox.addEventListener('change', () => {
                    const allPureTopicCheckboxes = document.querySelectorAll('input[name="pure-topic"]');
                    allPureTopicCheckboxes.forEach(cb => {
                    cb.checked = pureCheckbox.checked;
                    });
                });

                // Toggle visibility of pure topics on button click (icon does NOT change)
                pureToggleBtn.addEventListener('click', () => {
                    if (pureContainer.style.display === 'none' || pureContainer.style.display === '') {
                    pureContainer.style.display = 'block';
                    } else {
                    pureContainer.style.display = 'none';
                    }
                });
                </script>

            <div class="option-section">
                <div class="option-row">
                    <label>
                    <input id="mech-checkbox" type="checkbox" name="area" value="mechanics" checked> Mechanics
                    </label>
                    <button type="button" id="toggle-mech-topics" class="collapse-button">◀</button>
                </div>

                <div id="mech-topics">
                    <!-- Checkboxes will be loaded here -->
                </div>
                </div>

                <script>
                const mechCheckbox = document.getElementById('mech-checkbox');
                const mechContainer = document.getElementById('mech-topics');
                const mechToggleBtn = document.getElementById('toggle-mech-topics');

                // Fetch and display pure topics checkboxes
                fetch('topics.json')
                    .then(response => response.json())
                    .then(data => {
                    const mechTopics = data.mech;
                    mechContainer.innerHTML = "";

                    for (const [topic, count] of Object.entries(mechTopics)) {
                        const checkbox = document.createElement('input');
                        checkbox.type = 'checkbox';
                        checkbox.name = 'mech-topic';
                        checkbox.value = topic;
                        checkbox.checked = true;

                        checkbox.addEventListener('change', () => {
                        if (!checkbox.checked) {
                            mechCheckbox.checked = false;
                        } else {
                            const allChecked = Array.from(document.querySelectorAll('input[name="mech-topic"]'))
                            .every(cb => cb.checked);
                            mechCheckbox.checked = allChecked;
                        }
                        });

                        const label = document.createElement('label');
                        label.appendChild(checkbox);
                        label.appendChild(document.createTextNode(` ${topic} (${count})`));

                        mechContainer.appendChild(label);
                        mechContainer.appendChild(document.createElement('br'));
                    }
                    });

                mechCheckbox.addEventListener('change', () => {
                    const allMechTopicCheckboxes = document.querySelectorAll('input[name="mech-topic"]');
                    allMechTopicCheckboxes.forEach(cb => {
                    cb.checked = mechCheckbox.checked;
                    });
                });

                // Toggle visibility of pure topics on button click (icon does NOT change)
                mechToggleBtn.addEventListener('click', () => {
                    if (mechContainer.style.display === 'none' || mechContainer.style.display === '') {
                    mechContainer.style.display = 'block';
                    } else {
                    mechContainer.style.display = 'none';
                    }
                });
                </script>


            <div class="option-section">
                <div class="option-row">
                    <label>
                    <input id="stats-checkbox" type="checkbox" name="area" value="probability" checked> Probability
                    </label>
                    <button type="button" id="toggle-stats-topics" class="collapse-button">◀</button>
                </div>

                <div id="stats-topics">
                    <!-- Checkboxes will be loaded here -->
                </div>
                </div>

                <script>
                const statsCheckbox = document.getElementById('stats-checkbox');
                const statsContainer = document.getElementById('stats-topics');
                const statsToggleBtn = document.getElementById('toggle-stats-topics');

                // Fetch and display pure topics checkboxes
                fetch('topics.json')
                    .then(response => response.json())
                    .then(data => {
                    const statsTopics = data.stats;
                    statsContainer.innerHTML = "";

                    for (const [topic, count] of Object.entries(statsTopics)) {
                        const checkbox = document.createElement('input');
                        checkbox.type = 'checkbox';
                        checkbox.name = 'stats-topic';
                        checkbox.value = topic;
                        checkbox.checked = true;

                        checkbox.addEventListener('change', () => {
                        if (!checkbox.checked) {
                            statsCheckbox.checked = false;
                        } else {
                            const allChecked = Array.from(document.querySelectorAll('input[name="stats-topic"]'))
                            .every(cb => cb.checked);
                            statsCheckbox.checked = allChecked;
                        }
                        });

                        const label = document.createElement('label');
                        label.appendChild(checkbox);
                        label.appendChild(document.createTextNode(` ${topic} (${count})`));

                        statsContainer.appendChild(label);
                        statsContainer.appendChild(document.createElement('br'));
                    }
                    });

                statsCheckbox.addEventListener('change', () => {
                    const allStatsTopicCheckboxes = document.querySelectorAll('input[name="stats-topic"]');
                    allStatsTopicCheckboxes.forEach(cb => {
                    cb.checked = statsCheckbox.checked;
                    });
                });

                // Toggle visibility of pure topics on button click (icon does NOT change)
                statsToggleBtn.addEventListener('click', () => {
                    if (statsContainer.style.display === 'none' || statsContainer.style.display === '') {
                    statsContainer.style.display = 'block';
                    } else {
                    statsContainer.style.display = 'none';
                    }
                });
                </script>

            <br>
            <input type="checkbox" name="exclude-complete" value="yes"> Exclude completed questions <br>
            <br>
            <input type="submit" value="Apply filters">

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