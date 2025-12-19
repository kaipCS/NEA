<?php
session_start();
include_once('connection.php');

#print_r($_POST);

#get information about the question from the POST and session
$questionid = $_POST["questionid"];
$singlequestion = $_POST["singlequestion"];
$userid = $_SESSION["userid"];

#check if the question is a single question
if($singlequestion == 1){
    #add into user creates paper table 
    $stmt = $conn->prepare("INSERT INTO usercreatespaper(userid,singlequestion)
    VALUES (:userid,:singlequestion)");
    $stmt->bindParam(':userid', $userid);
    $stmt->bindParam(':singlequestion', $singlequestion);
    $stmt->execute();

    #get auto incremented paper of paper just created
    $paperid = $conn->lastInsertId();

    #add into user does paper table 
    $stmt = $conn->prepare("INSERT INTO userdoespaper(paperid,userid,singlequestion)
    VALUES (:paperid,:userid,:singlequestion)");
    $stmt->bindParam(':paperid', $paperid);
    $stmt->bindParam(':userid', $userid);
    $stmt->bindParam(':singlequestion', $singlequestion);
    $stmt->execute();
}
#if the question is in a paper, get the paper id from the session
else{
    $paperid = $_SESSION["paperid"];
}

#add into user does paper does question table 

#set note if it was added and leave null otherwise
if(!empty($_POST["note"])){
    $note = htmlspecialchars($_POST["note"]);
    $note = "'". $note . "'";
}
else{
    $note ="NULL";
}

#set mark if it was added and leave null otherwise
if(!empty($_POST["score"])){
    $mark = $_POST["score"];
}
else{
    $mark = "NULL";
}

#add question into user does paper does question table
$sql = "INSERT INTO userdoespaperdoesquestion(userid,questionid,paperid, mark, note) 
VALUES ($userid, $questionid, $paperid, $mark, $note)";
#echo($sql);
$result = $conn->query($sql);

#set complete as true
$_SESSION["complete"] =1;

#check if question is a single question
if($singlequestion == 1){
    $_SESSION["page"] = "questions";
}
else{
    $_SESSION["page"] = "open-paper";
}

#update date edited in user creates paper table
$stmt = $conn->prepare("UPDATE usercreatespaper SET dateedited = CURRENT_TIMESTAMP WHERE paperid = :paperid;");
$stmt->bindParam(':paperid', $paperid);
$stmt->execute();

#redirect to display questions page 
header('Location: display-question.php');
exit();
?>