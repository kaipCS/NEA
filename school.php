<?php
session_start();

# connect to database
include_once("connection.php");

#get userid for current user 
$userid = $_SESSION["userid"];

#get schoolID for the current user for database
$stmt = $conn->prepare("SELECT schoolID FROM users WHERE userid = :userid");
$stmt->bindParam(':userid', $userid);
$stmt->execute();
$school = $stmt->fetch(PDO::FETCH_ASSOC);
#check if schoolID is null 
if ($school['schoolID'] !== null){
    #the user is in a school
    $_SESSION["schoolID"] = $school['schoolID'];
    header('Location: in-school.php');
    exit();
}
else{
    #the user is not in a school
    header('Location: no-school.php');
    exit();
}
?>