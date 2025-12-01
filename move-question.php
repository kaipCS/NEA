<?php 
session_start();
include_once('connection.php');
$questionid = $_POST["questionid"];
$direction = $_POST["direction"];
$questionnumber = $_POST["questionnumber"];
#print_r($_POST);
$paperid = $_SESSION["paperid"];
#echo($direction);
#not redirecting back
if($direction == "up"){
    $previousnumber = $questionnumber -1;
    #echo($previousnumber. $questionnumber);
    $stmt = $conn -> prepare("UPDATE questioninpaper SET questionnumber = CASE 
                            WHEN questionnumber = :previousnumber THEN :questionnumber 
                            WHEN questionnumber = :questionnumber THEN :previousnumber
                            ELSE questionnumber
                            END
                            WHERE paperid = :paperid");
    $stmt->bindParam(':paperid', $paperid);
    $stmt->bindParam(':previousnumber', $previousnumber);
    $stmt->bindParam(':questionnumber', $questionnumber);
    $stmt->execute();
}
else{
    $nextnumber = $questionnumber +1;
    #echo($nextnumber. $questionnumber);
    $stmt = $conn -> prepare("UPDATE questioninpaper SET questionnumber = CASE 
                            WHEN questionnumber = :nextnumber THEN :questionnumber 
                            WHEN questionnumber = :questionnumber THEN :nextnumber
                            ELSE questionnumber
                            END
                            WHERE paperid = :paperid");
    $stmt->bindParam(':paperid', $paperid);
    $stmt->bindParam(':nextnumber', $nextnumber);
    $stmt->bindParam(':questionnumber', $questionnumber);
    $stmt->execute();
}

header('Location: open-paper.php');
exit();

?>