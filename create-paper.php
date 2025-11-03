<?php
session_start();
include_once('connection.php');

#initalise single question as false
$singlequestion= 0;

# create paper record in the user creates paper table
$stmt = $conn->prepare("INSERT INTO usercreatespaper(userid,title,singlequestion)
VALUES (:userid,:title,:singlequestion)");
$stmt->bindParam(':title', $_POST["title"]);
$stmt->bindParam(':userid', $_SESSION["userid"]);
$stmt->bindParam(':singlequestion', $singlequestion);
$stmt->execute();

# get the paper id just created  by the user creates paper table
$paperid = $conn->lastInsertId();
# store the paper id in the session 
$_SESSION["paperid"] = $paperid;

#check if the student is a teacher or student
if($_SESSION["role"] == 0){
    #user is a student
    
    # create paper record in the user does paper table
    $stmt = $conn->prepare("INSERT INTO userdoespaper(userid,paperid,singlequestion)
    VALUES (:userid,:paperid,:singlequestion)");
    $stmt->bindParam(':paperid', $paperid);
    $stmt->bindParam(':userid', $_SESSION["userid"]);
    $stmt->bindParam(':singlequestion', $singlequestion);
    $stmt->execute();
}

# open the paper they jsut created
header('Location: open-paper.php');
exit();
?>