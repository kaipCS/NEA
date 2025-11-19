<?php session_start();
include_once('connection.php');
$paperid = $_SESSION["paperid"];

if(!empty($_POST["title"])){
    $stmt = $conn->prepare("UPDATE usercreatespaper SET title = :title WHERE paperid = :paperid");
    $stmt->bindParam(':paperid', $paperid);
    $stmt->bindParam(':title', $_POST["title"]);
    $stmt->execute();
}

if(!empty($_POST["time"])){
    $stmt = $conn->prepare("UPDATE usercreatespaper SET time = :time WHERE paperid = :paperid");
    $stmt->bindParam(':paperid', $paperid);
    $stmt->bindParam(':time', $_POST["time"]);
    $stmt->execute();
}

header('Location: open-paper.php');
exit();

?>