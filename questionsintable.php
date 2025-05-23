<?php
# connect to database
include_once("connection.php");
#get file
$file = file_get_contents('questions.json');
$questions = json_decode($file, true);
#insert into database
$stmt = $conn->prepare("INSERT INTO questions (topic, year, paper, area, code) VALUES (:topic, :year, :paper, :area, :code)");
#iterate through each question in the file to add to database
foreach ($questions as $question) {
    #print_r($question);
    #echo("<br>");
    $stmt->bindParam(":topic", $question["topic"]);
    $stmt->bindParam(":year", $question["year"]);
    $stmt->bindParam(":paper", $question["paper"]);
    $stmt->bindParam(":area", $question["area"]);
    $stmt->bindParam(":code", $question["code"]);
    $stmt->execute();
}
echo("added succesfully")
?>
