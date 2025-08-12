<?php
session_start();

$questions = [];

print_r($_POST);

include_once ("connection.php");

if(!empty($_POST["papers"])){
    if (!empty($_POST["pure-topics"]) || !empty($_POST["mech-topics"]) || !empty($_POST["stats-topics"])){
        
        $topics = array_merge(
            $_POST["pure-topics"] ?? [],
            $_POST["mech-topics"] ?? [],
            $_POST["stats-topics"] ?? []
        );

        if(!isset($_POST["from"])){
            $from = 1986;
        }
        else{
            $from = $_POST["from"];
        }
        if(!isset($_POST["to"])){
            $to = 2018;
        }
        else{
            $to = $_POST["to"];
        }
        echo("here");

        $papers = $_POST["papers"];
     
        $papersList = "'" . implode("','", $papers) . "'";
        $topicsList = "'" . implode("','", $topics) . "'";
        
        echo("here");

        $stmt = $conn->query("SELECT questionid FROM questions WHERE (year <= $to AND year >= $from) AND (paper IN ($papersList)) AND (topic IN ($topicsList))"); 

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $questions[] = $row["questionid"];   
        }

        print_r($questions);

        if (empty($_POST["exclude-complete"])) {
            $_SESSION["results"] = $questions;
            header('Location: questionspage.php');
            exit();
        }

        else if (!empty($questions)){

            $questionsList = "'" . implode("','", $questions) . "'";

            $userid = $_SESSION["userid"];
            $stmt = $conn->query("SELECT questionid FROM userdoespaperdoesquestion WHERE (userid = $userid) AND (complete = 1) AND (questionid IN ($questionsList))"); 
        
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $questions = array_diff($questions, [$row["questionid"]]);   
            }

            $_SESSION["results"] = $questions;
        }

        header('Location: questionspage.php');
        exit();

    }
    else{
        $_SESSION["results"] = $questions;
        header("Location: questionspage.php");
        exit(); 
    }
}
else{
    $_SESSION["results"] = $questions;
    header("Location: questionspage.php");
    exit();    
}
?>