<?php
session_start();
include_once('connection.php');

$questionid = $_POST["questionid"];
$userid = $_SESSION["userid"];
$paperid = $_SESSION["paperid"];
#echo($userid);
#echo($paperid);

#delete from user creates paper table

$sql= "DELETE FROM usercreatespaper WHERE userid = $userid AND paperid = $paperid";
$result = $conn->query($sql);

#delete from user does paper table

$sql= "DELETE FROM userdoespaper WHERE userid = $userid AND paperid = $paperid";
$result = $conn->query($sql);

#delete from user does paper does question table

$sql= "DELETE FROM userdoespaperdoesquestion WHERE userid = $userid AND paperid = $paperid AND questionid= $questionid";
$result = $conn->query($sql);

#unset complete flag
unset($_SESSION["complete"]);

#redirect to questions page 
header('Location: display-question.php');
exit();
?>