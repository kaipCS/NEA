<?php session_start();

#connect to the databse 
include_once('connection.php');

#get question and paper id 
$questionid = $_POST["questionid"];
$paperid = $_SESSION["paperid"];

#find the question number of the question to delete 
$stmt = $conn -> prepare("SELECT questionnumber FROM questioninpaper WHERE questionid = :questionid AND paperid=:paperid");
$stmt->bindParam(':paperid', $paperid);
$stmt->bindParam(':questionid', $questionid);
$stmt->execute();
$questionNumber = $stmt->fetchColumn();

#decrement the question numbers of all questions after the one to delete
$stmt = $conn -> prepare("UPDATE questioninpaper SET questionnumber = questionnumber - 1 WHERE paperid=:paperid and questionnumber > :questionnumber");
$stmt->bindParam(':paperid', $paperid);
$stmt->bindParam(':questionnumber', $questionNumber);
$stmt->execute();

#delete the question
$stmt = $conn->prepare("DELETE FROM questioninpaper WHERE questionid = :questionid AND paperid = :paperid");
$stmt->bindParam(':questionid', $questionid);
$stmt->bindParam(':paperid', $paperid);
$stmt->execute();

#redirect back to the open paper page
header('Location: test.php');
exit();

?>