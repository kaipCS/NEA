<?php
session_start();
include_once('connection.php');
$singlequestion= 0;

$stmt = $conn->prepare("INSERT INTO usercreatespaper(userid,title,singlequestion)
VALUES (:userid,:title,:singlequestion)");
$stmt->bindParam(':title', $_POST["title"]);
$stmt->bindParam(':userid', $_SESSION["userid"]);
$stmt->bindParam(':singlequestion', $singlequestion);
$stmt->execute();

$paperid = $conn->lastInsertId();
$_SESSION["paperid"] = $paperid;

if($_SESSION["role"] == 0){
    #user is a student
    echo "student";
    $stmt = $conn->prepare("INSERT INTO userdoespaper(userid,paperid,singlequestion)
    VALUES (:userid,:paperid,:singlequestion)");
    $stmt->bindParam(':paperid', $paperid);
    $stmt->bindParam(':userid', $_SESSION["userid"]);
    $stmt->bindParam(':singlequestion', $singlequestion);
    $stmt->execute();
}

header('Location: in-paper.php');
exit();
?>