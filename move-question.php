<?php 
session_start();
#connect to the database 
include_once('connection.php');

#get all the information from the POST
$questionid = $_POST["questionid"];
$direction = $_POST["direction"];
$currentquestion = $_POST["questionnumber"];

#get paper id from session 
$paperid = $_SESSION["paperid"];

#check which direction to move in 
if ($direction == "up"){
    #calculate question number of the question before the one to move up
    $previousquestion = $currentquestion -1;

    #swap the previous and current question
    $stmt = $conn -> prepare("UPDATE questioninpaper SET questionnumber = CASE 
                                WHEN questionnumber = :previousquestion THEN :currentquestion
                                WHEN questionnumber = :currentquestion THEN :previousquestion
                                ELSE questionnumber
                                END
                                WHERE paperid = :paperid");
        $stmt->bindParam(':paperid', $paperid);
        $stmt->bindParam(':previousquestion', $previousquestion);
        $stmt->bindParam(':currentquestion', $currentquestion);
        $stmt->execute();
}
else{
    #calculate question number of the question after the one to move down
    $nextquestion = $currentquestion +1;
    
    #swap the previous and next question
    $stmt = $conn -> prepare("UPDATE questioninpaper SET questionnumber = CASE 
        WHEN questionnumber = :nextquestion THEN :currentquestion
        WHEN questionnumber = :currentquestion THEN :nextquestion
        ELSE questionnumber
        END
        WHERE paperid = :paperid");
    $stmt->bindParam(':paperid', $paperid);
    $stmt->bindParam(':nextquestion', $nextquestion);
    $stmt->bindParam(':currentquestion', $currentquestion);
    $stmt->execute(); 
}

#update date edited in user creates paper table
$stmt = $conn->prepare("UPDATE usercreatespaper SET dateedited = CURRENT_TIMESTAMP WHERE paperid = :paperid;");
$stmt->bindParam(':paperid', $paperid);
$stmt->execute();

#redirect back to the open paper page 
header('Location: open-paper.php');
exit();
?>