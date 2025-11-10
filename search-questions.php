<?php
session_start();
unset($_SESSION["error"]);
include_once ("connection.php");

#check if no search was entered 
if (empty($_POST["search"])){
    #set session variable to indicate nature of error
    $_SESSION["error"] = "emptySearch";

    #echo("empty search");

    #redirect back to questions page
    header('Location: questionspage.php');
    exit(); 
} 
else{
    $search = $_POST["search"];
    
    #remove capitalisation and whitespace
    $search = trim($search);
    $search = strtolower($search);

    #add in wildcards
    $search = "%" . $search . "%";

    #search topics first
    $stmt = $conn->prepare("SELECT questionid FROM questions WHERE LOWER(topic) LIKE :search");
    $stmt->bindParam(":search", $search);
    $stmt->execute();

    #store results in array
    $results = $stmt->fetchAll(PDO::FETCH_COLUMN);

    #search keywords next

    $stmt = $conn->prepare("SELECT questionid FROM questionhaskeyword WHERE LOWER(keyword) LIKE :search");
    $stmt->bindParam(":search", $search);
    $stmt->execute();

    #store results in array
    $results2 = $stmt->fetchAll(PDO::FETCH_COLUMN);

    #iterate through results of search by keywords
    foreach ($results2 as $question) {
        # check if result from keyword was already in the topic results
        if(!in_array($question, $results)){
            #if not, add it to the results array
            $results[] = $question;
        }
    }

    #store results in session
    $_SESSION["results"] = $results;

    #print_r($results);

    #redirect back to questions page
    header('Location: questionspage.php');
    exit(); 
}
?>