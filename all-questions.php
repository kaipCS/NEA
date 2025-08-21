<?php
session_start();
include_once('connection.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>All questions</title>
    <!-- Links to style sheet and bootstrap -->
    <link rel="stylesheet" href="stylesheet.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script>
        MathJax = {
        tex: {
            inlineMath: {'[+]': [['$', '$']]}
        }
        };
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/mathjax@4/tex-svg.js"></script>

</head>
<body>


<?php

for ($j=1; $j < 100; $j++){

    echo($j);
    echo("\n");

    $stmt = $conn->prepare("SELECT code FROM questions WHERE questionid = :questionid");
    $stmt->bindParam(':questionid', $j);
    $stmt->execute();
    $code = $stmt->fetch(PDO::FETCH_ASSOC);

    $code= $code['code'];

    if (str_contains($code, "\begin{questionparts}")) {
        $sections1 = explode("\begin{questionparts}", $code);
        $revisedCode = $sections1[0];
        $sections2 = explode("end{questionparts}", $sections1[1]);
        #not working because backslash 
        #print_r($sections2);
        $questionparts = $sections2[0];
        $questionparts = substr($questionparts, 0, -1);
        $revisedCode = $revisedCode . "<ol>";

        $parts = explode("\item", $questionparts);

        #skip first 
        for ($i = 1; $i < count($parts); $i++) {
            $revisedCode = $revisedCode . "<li>" . $parts[$i] . "</li>";
        }

        $revisedCode = $revisedCode . "</ol>" . $sections2[1];

        echo ($revisedCode);
    }
    else{
        echo($code);
    }
}


?>
