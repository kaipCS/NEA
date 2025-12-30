<?php
session_start();
#connect to the database
include_once('connection.php');

#get paper id from the POST
$paperid = $_POST["paperid"];

#set details to null for paper 
$stmt = $conn->prepare("UPDATE usercreatespaper SET details = NULL WHERE paperid = :paperid");
$stmt->bindParam(':paperid', $paperid);
$stmt->execute();

#update date edited in user creates paper table
$stmt = $conn->prepare("UPDATE usercreatespaper SET dateedited = CURRENT_TIMESTAMP WHERE paperid = :paperid;");
$stmt->bindParam(':paperid', $paperid);
$stmt->execute();

#redirect back to paper page 
header('Location: open-paper.php');
exit();
?>