<?php
session_start();

#print_r($_POST);

#connect to database
include_once ("connection.php");

#check papers have been left empty
if(!empty($_POST["papers"])){

    $papers = $_POST["papers"];

    #check topics havent been left empty
    if (!empty($_POST["pure-topics"]) || !empty($_POST["mech-topics"]) || !empty($_POST["stats-topics"])){
        
        #intalise area and topic arrays
        $completeAreas= [3];
        $topics = [["topic", 3]];

        #if at least one complete area has been selected
        if (!empty($_POST["areas"])){

            #if pure is checked as a complete area, add it to the array
            if (in_array("pure", $_POST["areas"])){
                $completeAreas[] = 0; 
            }

            #do the same for mech and stats
            if (in_array("mechanics", $_POST["areas"])){
                $completeAreas[] = 1; 
            }
            if (in_array("probability", $_POST["areas"])){
                $completeAreas[] = 2; 
            }

        }

        #if pure complete area is not checked but pure topics have been
        if (!in_array(0, $completeAreas) && !empty($_POST["pure-topics"])){
            foreach($_POST["pure-topics"] as $pureTopic){
                #use escape backlashes if topic contains an apostrophe
                if (str_contains($pureTopic, "'")){
                    $pureTopic = str_replace("'","\\'",$pureTopic);
                }
                $topics[] = [$pureTopic, 0];
            }
        }

        #do the same for stats and mech
        if (!in_array(1, $completeAreas) && !empty($_POST["mech-topics"])){
            foreach($_POST["mech-topics"] as $mechTopic){
                if (str_contains($mechTopic, "'")){
                    $mechTopic = str_replace("'","\\'",$mechTopic);
                }
                $topics[] = [$mechTopic, 1];
            }
        }
        if (!in_array(2, $completeAreas) && !empty($_POST["stats-topics"])){
            foreach($_POST["stats-topics"] as $statsTopic){
                if (str_contains($statsTopic, "'")){
                    $statsTopic = str_replace("'","\\'",$statsTopic);
                }
                $topics[] = [$statsTopic, 2];
            }
        }

        #print_r($topics);

        #set year range - if not given by user automatically make LB 1986 and UB 2018
        if(empty($_POST["from"])){
            $from = 1986;
        }
        else{
            $from = $_POST["from"];
        }
        if(empty($_POST["to"])){
            $to = 2018;
        }
        else{
            $to = $_POST["to"];
        }


        #implode arrays for use in sql
        $papers = "(" . implode(",", $papers) .")";
        $completeAreas = "(" . implode(",", $completeAreas) .")";

    
        $pairs = [];

        foreach ($topics as $pair) {
            $topic = $pair[0];   
            $area  = $pair[1];  
            $pairs[] = "('$topic',$area)";
        }

        $pairsList = "(" . implode(",", $pairs) . ")";


        #search for questions that satisfy filters
        $sql = "SELECT questionid FROM questions WHERE 
            (year BETWEEN $from AND $to ) 
            AND (paper IN $papers) 
            AND ((area IN $completeAreas) 
            OR ((topic,area) IN $pairsList )) ";

        #echo($sql);

        #store results in array
        $questions = [];

        $result = $conn->query($sql);
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $questions[] = $row["questionid"];
        }

        #if user wants to exclude questions they have already done
        if (!empty($_POST["exclude-complete"]) && !empty($questions)) {
            $user = $_SESSION["userid"];

            #store imploded version of questions array for sql
            $implodedQuestions = "(" . implode(",", $questions) .")";

            #search for questions that would be in results that they have done
            $sql = "SELECT questionid FROM userdoespaperdoesquestion WHERE 
                (userid = $user) 
                AND (questionid IN $implodedQuestions) ";
                
            #store results in array

            $toExclude = [];

            $result = $conn->query($sql);
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $toExclude[] = $row["questionid"];
            }
            
            #remove completed questions from array
            $questions = array_diff($questions, $toExclude);
        }

        #store results in session
        $_SESSION["results"] = $questions;

        #print_r($questions);

        #redirect back to questions page
        header("Location: questionspage.php");
        exit();   
    }
}

#papers are empty or topics are empty

#set results as empty array
$_SESSION["results"] = [];

#redirect back to questions page
header("Location: questionspage.php");
exit();   

?>