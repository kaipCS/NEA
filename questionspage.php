<?php session_start();

include_once('connection.php');

$json = file_get_contents('topics.json');
$data = json_decode($json, true); 

$pure_topics = $data['pure'];
$mech_topics = $data['mech'];
$stats_topics = $data['stats'];
?>
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
                        <input type="checkbox" name="area" value="pure" checked> Pure
                    </label>
                    <button type="button" class="collapse-button" data-toggle="collapse" data-target="#pure-topics">◀</button>
                </div>
                <div id="pure-topics" class="collapse">
                <?php
                    foreach ($pure_topics as $topic => $count) {
                        echo '<input type="checkbox" name="topic" value="' . ($topic) . '" checked> ' . ($topic) . " ($count) <br>";
                    }
                ?>
                </div>
            </div>

            <div class="option-section">
                <div class="option-row">
                    <label>
                        <input type="checkbox" name="area" value="mechanics" checked> Mechanics
                    </label>
                    <button type="button" class="collapse-button" data-toggle="collapse" data-target="#mechanics-topics">◀</button>
                </div>
                <div id="mechanics-topics" class="collapse">
                <?php
                    foreach ($mech_topics as $topic => $count) {
                        echo '<input type="checkbox" name="topic" value="' . ($topic) . '" checked> ' . ($topic) . " ($count) <br>";
                    }
                ?>
                </div>
            </div>

            <div class="option-section">
                <div class="option-row">
                    <label>
                        <input type="checkbox" name="area" value="probability" checked> Probability
                    </label>
                    <button type="button" class="collapse-button" data-toggle="collapse" data-target="#probability-topics">◀</button>
                </div>
                <div id="probability-topics" class="collapse">
                    <?php
                        foreach ($stats_topics as $topic => $count) {
                            echo '<input type="checkbox" name="topic" value="' . ($topic) . '" checked> ' . ($topic) . " ($count) <br>";
                        }
                    ?>
                </div>
            </div>
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