<?php
session_start();

#connect to the database
include_once('connection.php');
#print_r($_SESSION);
#print_r($_POST);

#reset error session variable to try again
unset($_SESSION["error"]);

#check if any fields were left empty
$requiredFields = ["surname", "forename", "email", "password"];
foreach ($requiredFields as $field) {
    if (empty($_POST[$field])) {
        #one was blank

        #set session variable to indicate nature of error
        $_SESSION["error"] = "emptyAccount";
        #redirect back to sign in again
        header('Location: signin.php');
        exit();
    }
}

#search through database for email entered
$email = $_POST['email'];
$stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
$stmt->bindParam(':email', $email);
$stmt->execute();
$count = $stmt->fetchColumn();
if ($count > 0) {
    #a user does already exist with this email

    #set session variable to indicate nature of error
    $_SESSION["error"] = "emailExists";
    #redirect back to sign in again
    header('Location: signin.php');
    exit();
}

#Use number for role
switch($_POST["role"]){
    case "Student":
        $role=0;
        break;
    case "Teacher":
        $role=1;
        break;
}
#et role session variable
$_SESSION["role"] = $role;

#avoid malicious attack injecting code
array_map("htmlspecialchars", $_POST);

#enter user into users table
$stmt = $conn->prepare("INSERT INTO users(surname,forename,email,password,role)
    VALUES (:surname,:forename,:email,:password,:role)");
    $stmt->bindParam(':surname', $_POST["surname"]);
    $stmt->bindParam(':forename', $_POST["forename"]);
    $stmt->bindParam(':email', $email);
    $hashedPassword = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':role', $role);
$stmt->execute();

#get value of auto incremented userid to set as session variable to sign in
$userID = $conn->lastInsertId();
$_SESSION["userid"] = $userID;
#redirect to homepage 
header('Location: homepage.php');
exit();
?>