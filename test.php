<?php
# connext to database
include_once("connection.php");
#get file
$file = file_get_contents('questions.json');
$questions = json_decode($file, true);
#iterate through each question in the file to add to database
foreach ($questions as $question) {
    print_r($question);
    echo("<br>");
}
?>
