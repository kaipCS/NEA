<?php session_start();
include_once('connection.php');
$questionid = $_POST["questionid"];
$paperid = $_SESSION["paperid"];

$stmt = $conn -> prepare("SELECT questionnumber FROM questioninpaper WHERE questionid = :questionid AND paperid=:paperid");
$stmt->bindParam(':paperid', $paperid);
$stmt->bindParam(':questionid', $questionid);
$stmt->execute();
$questionNumber = $stmt->fetchColumn();

$stmt = $conn -> prepare("UPDATE questioninpaper SET questionnumber = questionnumber - 1 WHERE paperid=:paperid and questionnumber > :questionnumber");
$stmt->bindParam(':paperid', $paperid);
$stmt->bindParam(':questionnumber', $questionNumber);
$stmt->execute();

$stmt = $conn->prepare("DELETE FROM questioninpaper WHERE questionid = :questionid AND paperid = :paperid");
$stmt->bindParam(':questionid', $questionid);
$stmt->bindParam(':paperid', $paperid);
$stmt->execute();


header('Location: open-paper.php');
exit();

?>