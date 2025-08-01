<?php
session_start();

#connect to database
include_once('connection.php');

#check if field was left empty
if (empty($_POST["schoolID"])){
    #it was left blank

    #set session variable to indicate nature of error
    $_SESSION["error"] = "emptySchool";
    #redirect back to sign in again
    header('Location: no-school.php');
    exit(); 
} 
else{
    #id was entered
    $school = $_POST["schoolID"];
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE schoolID = :schoolID");
    $stmt->bindParam(':schoolID', $school);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    if ($count >0){
        $school = htmlspecialchars($school);

        $stmt = $conn->prepare("UPDATE users SET schoolID = :schoolID WHERE userid = :userid");
        $stmt->bindParam(':schoolID', $school);
        $stmt->bindParam(':userid', $_SESSION["userid"]);
        $stmt->execute();

        $_SESSION["schoolID"] = $school;
        header('Location: in-school.php');
        exit();
}
    else{
        $_SESSION["error"] = "noID";  
        header('Location: no-school.php');
        exit(); 
    }}

?>