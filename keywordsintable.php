<?php
# connect to database
include_once("connection.php");
#get file
$file = fopen("keywords.txt", "r");
#insert into database
$stmt = $conn->prepare("INSERT INTO keywords (keyword) VALUES (:keyword)");
#iterate through each keyword (each line) in the file to add to database
while (($line = fgets($file)) !== false) {
    #remove spaces and new line
    $line = trim($line); 
    $stmt->bindParam(":keyword", $line);
    $stmt->execute();
}
echo("added succesfully")
?>


