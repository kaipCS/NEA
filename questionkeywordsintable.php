<?php
# connext to database
include_once("connection.php");
#get file
$file = file_get_contents('questionkeywords.json');
$items = json_decode($file, true);
#iterate through each item in file 
foreach ($items as $item) {
#extract data from dictionary
$keywords = $item["keywords"];
$questionid = $item["questionid"];
#insert into table
$stmt = $conn->prepare("INSERT INTO questionhaskeyword (questionid, keyword) VALUES (:questionid, :keyword)");
foreach ($keywords as $keyword){
    $stmt->bindParam(":questionid", $questionid);
    $stmt->bindParam(":keyword", $keyword);
    $stmt->execute();
}}
echo("added succesfully");
?>
