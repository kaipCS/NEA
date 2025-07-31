<?php
session_start();
include_once('connection.php');
print_r($_SESSION);
print_r($_POST);
#validation
#unset because otherwise would be impossible to retry
unset($_SESSION["error"]);
#boxes empty
#role will always have value
$requiredFields = ["surname", "forename", "email", "password"];
foreach ($requiredFields as $field) {
    if (empty($_POST[$field])) {
        $_SESSION["error"] = "emptyAccount";
        header('Location: signin.php');
        exit();
    }
}

#email exists
$email = $_POST['email'];
$stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
$stmt->bindParam(':email', $email);
$stmt->execute();
$count = $stmt->fetchColumn();
if ($count > 0) {
    $_SESSION["error"] = "emailExists";
    header('Location: signin.php');
    exit();
}

#if not set
switch($_POST["role"]){
    case "Student":
        $role=0;
        break;
    case "Teacher":
        $role=1;
        break;
}
$_SESSION["role"] = $role;
array_map("htmlspecialchars", $_POST);
$stmt = $conn->prepare("INSERT INTO users(surname,forename,email,password,role)
    VALUES (:surname,:forename,:email,:password,:role)");
    $stmt->bindParam(':surname', $_POST["surname"]);
    $stmt->bindParam(':forename', $_POST["forename"]);
    $stmt->bindParam(':email', $email);
    $hashedPassword = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':role', $role);
$stmt->execute();
$userID = $conn->lastInsertId();
$_SESSION["userid"] = $userID;
header('Location: homepage.php');
exit();
?>