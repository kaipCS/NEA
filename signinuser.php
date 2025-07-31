<?php
session_start();

#connect to database
include_once('connection.php');
#print_r($_SESSION);
#print_r($_POST);

#check if either field was left empty
if (empty($_POST["email"]) or empty($_POST["password"])){
    #one or both were left blank

    #set session variable to indicate nature of error
    $_SESSION["error"] = "emptySignIn";
    #redirect back to sign in again
    header('Location: signin.php');
    exit(); 
} 
else{
    #both fields were entered
    $email = $_POST['email'];

    #search through users table for a record with the email entered
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user){
        #a user does exist with this email
        $password = $user["password"];

        #check that password in record matches the one enetered
        if (password_verify($_POST["password"], $password)){
            #password is correct

            #set role and userid session variables
            $_SESSION["role"] = $user["role"];
            $_SESSION["userid"] = $user["userid"];

            #redirect to homepage
            header('Location: homepage.php');
            exit();
        }
        else{
            #incorrect password

            #set session variable to indicate nature of error
            $_SESSION["error"] = "password";
            #redirect back to sign in again
            header('Location: signin.php');
            exit(); 
        }
    }
    else{
        #the email enetered is not in database

        #set session variable to indicate nature of error
        $_SESSION["error"] = "noUser";

        #redirect back to sign in again
        header('Location: signin.php');
        exit(); 
    }
}
?>