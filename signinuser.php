<?php
session_start();
include_once('connection.php');
print_r($_SESSION);
print_r($_POST);
if (empty($_POST["email"]) or empty($_POST["password"])){
    $_SESSION["error"] = "emptySignIn";
    header('Location: signin.php');
    exit(); 
} 
else{
    $email = $_POST['email'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user){
        #user exists
        $password = $user["password"];
        if (password_verify($_POST["password"], $password)){
            $_SESSION["role"] = $user["role"];
            $_SESSION["userid"] = $user["userid"];
            header('Location: homepage.php');
            exit();
        }
        else{
            #incorrect password
            $_SESSION["error"] = "password";
            header('Location: signin.php');
            exit(); 
        }
    }
    else{
        $_SESSION["error"] = "noUser";
        header('Location: signin.php');
        exit(); 
    }
}
?>