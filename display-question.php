<?php
session_start();
include_once('connection.php');

$questionid = $_GET['id']; 

$stmt = $conn->prepare("SELECT solution, code FROM questions WHERE questionid = :questionid");
$stmt->bindParam(':questionid', $questionid);
$stmt->execute();
$question = $stmt->fetch(PDO::FETCH_ASSOC);

$code = $question['code'];

if (!empty($question['solution'])) {
    #echo($question['solution']);
    $_SESSION["solution"] = $question["solution"];
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


header('Location: questionspage.php');
exit();
?>


</body>
</html>