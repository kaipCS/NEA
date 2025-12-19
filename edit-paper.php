<?php session_start();
include_once('connection.php');

#get paper id from the session 
$paperid = $_SESSION["paperid"];

#check if the user entered a new title 
if(!empty($_POST["title"])){
    #update the table
    $stmt = $conn->prepare("UPDATE usercreatespaper SET title = :title WHERE paperid = :paperid");
    $stmt->bindParam(':paperid', $paperid);
    $stmt->bindParam(':title', $_POST["title"]);
    $stmt->execute();
}

#check if the user entered a new time 
if(!empty($_POST["time"])){
    #update the table
    $stmt = $conn->prepare("UPDATE usercreatespaper SET time = :time WHERE paperid = :paperid");
    $stmt->bindParam(':paperid', $paperid);
    $stmt->bindParam(':time', $_POST["time"]);
    $stmt->execute();
}

#update date edited in user creates paper table
$stmt = $conn->prepare("UPDATE usercreatespaper SET dateedited = CURRENT_TIMESTAMP WHERE paperid = :paperid;");
$stmt->bindParam(':paperid', $paperid);
$stmt->execute();

#redirect back
header('Location: test.php');
exit();
?>