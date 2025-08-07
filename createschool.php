<?php
session_start();

#connect to database
include_once('connection.php');

#check if field was left empty
if (empty($_POST["createSchoolID"])){
    #it was left blank

    #set session variable to indicate nature of error
    $_SESSION["error"] = "emptyCode";
    #redirect back to no school page
    header('Location: no-school.php');
    exit(); 
} 
else{
    $school = $_POST["createSchoolID"];
    #id was entered
    if  (strlen($school) == 5){
        #correct length

        #check does not already exist
        $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE schoolID = :schoolID");
        $stmt->bindParam(':schoolID', $school);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        if ($count > 0) {
            #a user does already exist with this school

            #set session variable to indicate nature of error
            $_SESSION["error"] = "codeExists";
            #redirect back to no school page
            header('Location: no-school.php');
            exit();
        }
        else{
            #successful school creation

            #avoid malicious attack injecting code
            $school = htmlspecialchars($school);

            #add school id into users table
            $stmt = $conn->prepare("UPDATE users SET schoolID = :schoolID WHERE userid = :userid");
            $stmt->bindParam(':schoolID', $school);
            $stmt->bindParam(':userid', $_SESSION["userid"]);
            $stmt->execute();

            #set school id session variable
            $_SESSION["schoolID"] = $school;

            #redirect to in school page
            header('Location: in-school.php');
            exit();
        }
    }
    else{
        #wrong length

        #set session variable to indicate nature of error
        $_SESSION["error"] = "length";
        #redirect back to no school page
        header('Location: no-school.php');
        exit();
    }
}
?>
