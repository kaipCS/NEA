<?php
session_start();

include_once ("connection.php");

if (empty($_POST["search"])){
    #set session variable to indicate nature of error
    $_SESSION["error"] = "emptySearch";
    #redirect back to sign in again
    header('Location: questionspage.php');
    exit(); 
} 
else{
    $search = $_POST["search"];

    $questions = [];

    #echo($search);

    #topics first

    $search = "%$search%";  

    $stmt = $conn->prepare("SELECT questionid FROM questions WHERE topic LIKE :search");
    $stmt->bindParam(":search", $search);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $questions[] = $row["questionid"];
    }

    print_r($questions);
    #then keywords

    $stmt = $conn->prepare("SELECT questionid FROM questionhaskeyword WHERE keyword LIKE :search");
    $stmt->bindParam(":search", $search);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if(!in_array($row["questionid"], $questions)){
            $questions[] = $row["questionid"];
        } 
    }

    print_r($questions);

    $_SESSION["results"] = $questions;

    header('Location: questionspage.php');
}
?>