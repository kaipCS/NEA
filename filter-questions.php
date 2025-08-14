<?php
session_start();

$questions = [];

#print_r($_POST);

include_once ("connection.php");

if(!empty($_POST["papers"])){
    if (!empty($_POST["pure-topics"]) || !empty($_POST["mech-topics"]) || !empty($_POST["stats-topics"])){

        $topics = [];

        if (!empty($_POST["areas"])){
            $areas = $_POST["areas"];
        }
        else{
            $areas = [];
        }

        $completeAreas = [];


        // Process PURE topics
        if (!empty($_POST["pure-topics"])) {
            // If "pure" area is selected, use area filter
            if (in_array("pure", $areas)) {
                $completeAreas[] = 0; // Filter by pure area (0)
            } 
            // Otherwise, use specific topics
            else {
                $topics = array_merge($topics, $_POST["pure-topics"]);
            }
        }

        // Process MECHANICS topics (same pattern)
        if (!empty($_POST["mech-topics"])) {
            if (in_array("mechanics", $areas)) {
                $completeAreas[] = 1;
            } else {
                $topics = array_merge($topics, $_POST["mech-topics"]);
            }
        }

        // Process STATISTICS topics (same pattern)
        if (!empty($_POST["stats-topics"])) {
            if (in_array("probability", $areas)) {
                $completeAreas[] = 2;
            } else {
                $topics = array_merge($topics, $_POST["stats-topics"]);
            }
        }

        #print_r($completeAreas);
        
        #print_r($topics);

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

        #print_r($completeAreas);
        #print_r($topics);

        $papers = $_POST["papers"];

        $areasList  = !empty($completeAreas) ? implode(",", $completeAreas) : "-1"; 
        $papersList = "'" . implode("','", $papers) . "'";

        if (empty($topics)){
            $topics = ["topic"];
        }

        $chunks = array_chunk($topics, 100);


        foreach ($chunks as $chunkIndex => $chunk) {
            #print_r($topics);
            #var_dump($areasList);

            $topicsList = '"' . implode('","', $chunk) . '"';

            $sql = "
                SELECT DISTINCT questionid 
                FROM questions
                WHERE year BETWEEN $from AND $to
                  AND paper IN ($papersList)
                  AND (area IN ($areasList)
                  OR topic IN ($topicsList))
            ";

            #echo $sql;
            $result = $conn->query($sql);
            if ($result) {
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $questions[$row['questionid']] = true; // Deduplicate
                }
            }
        }

        $questions = array_keys($questions);
        
        #print_r($questions);

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