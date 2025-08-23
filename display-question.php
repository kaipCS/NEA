<?php
session_start();
include_once('connection.php');

$questionid = $_GET['id']; 

$stmt = $conn->prepare("SELECT * FROM questions WHERE questionid = :questionid");
$stmt->bindParam(':questionid', $questionid);
$stmt->execute();
$question = $stmt->fetch(PDO::FETCH_ASSOC);

if ($question["paper"] == 1){
    $_SESSION["paper"] = "I";
}
else if ($question["paper"] == 2){
    $_SESSION["paper"] = "II";
}
else{
    $_SESSION["paper"] = "III";
}


$_SESSION["year"] = $question["year"];

if (!empty($question['solution'])) {
    #echo($question['solution']);
    $_SESSION["solution"] = $question["solution"];
}

$code = $question['code'];

$stmt = $conn->prepare("SELECT * FROM userdoespaperdoesquestion WHERE userid = :userid AND questionid = :questionid AND complete = 1");
$stmt->bindParam(':userid', $_SESSION["userid"] );
$stmt->bindParam(':questionid', $questionid);
$stmt->execute();
$answer = $stmt->fetch(PDO::FETCH_ASSOC); 

#print_r($answer);
if ($answer) {
    $_SESSION["complete"] = 1;
    if (isset($answer["note"]) and !empty($answer["note"])){
        $_SESSION["note"] = $answer["note"];
    } 
    if (isset($answer["mark"]) and !empty($answer["mark"])){
        $_SESSION["mark"] = $answer["mark"];
    }
}



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

    $_SESSION["display-code"] = $revisedCode;
}
else{
    $_SESSION["display-code"] = $code;
}

$_SESSION["questionid"] = $questionid;

header('Location: questionspage.php');
exit();
?>


</body>
</html>