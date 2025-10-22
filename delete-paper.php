<?php
session_start();
include_once('connection.php');

#get paper id from post
$paperid = $_POST["paperid"];

#update single question in the user creates paper table
$singlequestion = 1;
$stmt = $conn->prepare("UPDATE usercreatespaper SET singlequestion = :singlequestion WHERE paperid = :paperid");
$stmt->bindParam(':paperid', $paperid);
$stmt->bindParam(':singlequestion', $singlequestion);
$stmt->execute();

#check user's role 
if($_SESSION["role"] == 0){
    #user is a student
    #update single question in user does paper table
    $singlequestion = 1;
    $stmt = $conn->prepare("UPDATE userdoespaper SET singlequestion = :singlequestion WHERE paperid = :paperid");
    $stmt->bindParam(':paperid', $paperid);
    $stmt->bindParam(':singlequestion', $singlequestion);
    $stmt->execute();

    #redirect to student papers page 
    header('Location: papers-student.php');
    exit();
}

#user is a teacher
#redirect to the teacher papers page
header('Location: papers-teacher.php');
exit();
?>