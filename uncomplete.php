<?php
session_start();
include_once('connection.php');

#get ids from post and session
$questionid = $_POST["questionid"];
$userid = $_SESSION["userid"];
$singlequestion = $_POST["singlequestion"];

#check if the question is from a single question paper
if($singlequestion == 1){
    #find paper id
    $stmt = $conn->prepare("SELECT paperid FROM userdoespaperdoesquestion WHERE userid = :userid AND questionid = :questionid");
    $stmt->bindParam(':userid', $userid);
    $stmt->bindParam(':questionid', $questionid);
    $stmt->execute();
    $paperid = $stmt->fetchColumn();
    #echo($paperid);

    #delete record for user does paper does question table
    $stmt = $conn->prepare("DELETE FROM userdoespaperdoesquestion WHERE userid = :userid AND questionid = :questionid");
    $stmt->bindParam(':userid', $userid);
    $stmt->bindParam(':questionid', $questionid);
    $stmt->execute();

    #delete record from user creates paper table
    $stmt = $conn->prepare("DELETE FROM usercreatespaper WHERE userid = :userid AND paperid = :paperid");
    $stmt->bindParam(':userid', $userid);
    $stmt->bindParam(':paperid', $paperid);
    $stmt->execute();

    #delete record from user does paper table
    $stmt = $conn->prepare("DELETE FROM userdoespaper WHERE userid = :userid AND paperid = :paperid");
    $stmt->bindParam(':userid', $userid);
    $stmt->bindParam(':paperid', $paperid);
    $stmt->execute();

    #unset complete variable in the session
    unset($_SESSION["complete"]);

    #redirect to questions page 
    header('Location: display-question.php');
    exit();
}   
else{
    echo("not a single question");
}
?>