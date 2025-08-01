<?php
session_start();

# connect to database
include_once("connection.php");

#redirect to correct page
$userid = $_SESSION["userid"];
$stmt = $conn->prepare("SELECT schoolID FROM users WHERE userid = :userid");
$stmt->bindParam(':userid', $userid);
$stmt->execute();
$school = $stmt->fetch(PDO::FETCH_ASSOC);
if ($school && $school['schoolID'] !== null){
    $_SESSION["schoolID"] = $school['schoolID'];
    header('Location: in-school.php');
    exit();
}
else{
    header('Location: no-school.php');
    exit();
}
?>