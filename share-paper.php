<?php
session_start();

#connect to database
include_once('connection.php');

#validate that student does not already have the paper
$stmt = $conn->prepare("SELECT COUNT(*) FROM userdoespaper WHERE paperid = :paperid AND userid = :userid");
$stmt->bindParam(':userid', $_POST["student"]);
$stmt->bindParam(':paperid', $_POST["paperid"]);
$stmt->execute();
$count = $stmt->fetchColumn();
if ($count == 0) {
    #echo("new paper");
    #they do not already have it

    #set single question as false
    $singlequestion = 0;

    #add to database
    $stmt = $conn->prepare("INSERT INTO userdoespaper(userid,paperid,singlequestion)
    VALUES (:userid,:paperid,:singlequestion)");
    $stmt->bindParam(':paperid', $_POST["paperid"]);
    $stmt->bindParam(':userid', $_POST["student"]);
    $stmt->bindParam(':singlequestion', $singlequestion);
    $stmt->execute();

    #redirect to open paper page
    header('Location: open-paper.php');
    exit();
}
else{
    #echo("already have paper");
    #already has it so redirect back without editing the database
    header('Location: open-paper.php');
    exit(); 
}

?>