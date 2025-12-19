<?php
session_start();
include_once('connection.php');


$paperid = $_POST["paper"];
$questionid = $_POST["questionid"];
#print_r($_POST);

#search for all questions in the paper
$stmt = $conn -> prepare("SELECT * FROM questioninpaper WHERE paperid = :paperid");
$stmt->bindParam(':paperid', $paperid);
$stmt->execute();
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
#print_r($questions);

#check if question is already in the paper
$questionids = array_column($questions, "questionid");
if(!(in_array($questionid,$questionids))){
    #if paper empty, make question number 1 
    if (empty($questions)){
        $questionNum = 1;
    }
    #otherwise, make it one more than the largest currently (add it to the end)
    else{
        $questionNumbers = array_column($questions, "questionnumber");
        $questionNum = max($questionNumbers) + 1 ;
    }

    #add into question in paper table to add to the paper
    $stmt = $conn->prepare("INSERT INTO questioninpaper(paperid,questionid,questionnumber)
    VALUES (:paperid,:questionid,:questionnumber)");
    $stmt->bindParam(':paperid', $paperid);
    $stmt->bindParam(':questionid', $questionid);
    $stmt->bindParam(':questionnumber', $questionNum);
    $stmt->execute();

    #update date edited in user creates paper table
    $stmt = $conn->prepare("UPDATE usercreatespaper SET dateedited = CURRENT_TIMESTAMP WHERE paperid = :paperid;");
    $stmt->bindParam(':paperid', $paperid);
    $stmt->execute();

}

#redirect to questions page 
header('Location: display-question.php');
exit();
?>