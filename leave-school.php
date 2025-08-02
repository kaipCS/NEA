<?php
session_start();
unset($_SESSION["schoolID"]);

include_once ("connection.php");
#remove from database
$stmt = $conn->prepare("UPDATE users SET schoolID = NULL WHERE userid = :userid");
$stmt->bindParam(':userid', $_SESSION["userid"]);
$stmt->execute();

#redirect back to no school page
header('Location: no-school.php');
?>