<?php
session_start();
include_once('connection.php');

#get question id of code from POST
$questionid = $_POST["questionid"]; 

#find question in database
$stmt = $conn->prepare("SELECT * FROM questions WHERE questionid = :questionid");
$stmt->bindParam(':questionid', $questionid);
$stmt->execute();
$question = $stmt->fetch(PDO::FETCH_ASSOC);

#store year in session 
$_SESSION["year"] = $question["year"];

#change paper numerals 
$paper = $question["paper"];
switch ($paper) {
    case 1:
        $paper = "I";
        break;
    case 2:
        $paper = "II";
        break;
    case 3:
        $paper = "III";
        break;
}
#store paper in session
$_SESSION["paper"] = $paper;

#if there is a solution link store it in the session
if(!empty($question["solution"])){
    $_SESSION["solution"] = $question["solution"];
}

#check if user has completed this question
$stmt = $conn->prepare("SELECT * FROM userdoespaperdoesquestion WHERE userid = :userid AND questionid = :questionid AND complete = 1");
$stmt->bindParam(':userid', $_SESSION["userid"] );
$stmt->bindParam(':questionid', $questionid);
$stmt->execute();
$answer = $stmt->fetch(PDO::FETCH_ASSOC); 

#if a record exists, the user has completed the question
if ($answer) {
    $_SESSION["complete"] = 1;

    #store note and mark in session if they have been entered
    if (isset($answer["note"]) and !empty($answer["note"])){
        $_SESSION["note"] = $answer["note"];
    } 
    if (isset($answer["mark"]) and !empty($answer["mark"])){
        $_SESSION["mark"] = $answer["mark"];
    }
}

print_r($_SESSION);

$code = $question["code"];

#check if the code contains a diagram
if (str_contains($code, "\begin{center}")) {

    #check for case where question has two images 
    if($questionid == 1035){
        $code = '\begin{questionparts}
        \item
        A uniform lamina $OXYZ$ is in the shape of the trapezium 
        shown in the diagram.
        It is right-angled at $O$ and
        $Z$, and $OX$ is parallel to $YZ$. The lengths of the sides are
        given by $OX=9\,$cm, $XY=41\,$cm, $YZ=18\,$cm and $ZO=40\,$cm.
        Show that its centre of mass is a distance $7\,$cm from the edge $OZ$.

        <img src="diagrams/1035-diagram-1.png" style="width: 60%; display: block; margin: 0 auto;">

        \item
        The diagram shows a tank with no lid made of thin sheet metal. The base 
        $OXUT$, the back $OTWZ$ and the front $XUVY$ are rectangular, 
        and each end is a trapezium as in part \textbf{(i)} . The width of 
        the tank is $d\,$cm.

        <img src="diagrams/1035-diagram-2.png" style="width: 60%; display: block; margin: 0 auto;">

        \vspace*{3mm}
        Show that the centre of mass of the tank, when empty,
        is a distance 
        \[
        \frac {3(140+11d)}{5(12+d)}\,\text{cm}
        \]
        from the back of the tank.

        The tank is then filled with a liquid.  
        The mass per unit volume of this liquid  is $k$ times the 
        mass per unit area of the sheet metal.
        In the case $d=20$, find an expression for the
        distance of the centre of mass of the filled tank from the back of the tank.

        \end{questionparts}';       
    }

    else{
    #contents before the image 
    $sections1 = explode("\begin{center}", $code);
    $revisedCode = $sections1[0];

    #create image source
    $imageSrc = "diagrams/" . $questionid . "-diagram.png";
    $revisedCode = $revisedCode . '<img src="' . $imageSrc . '">';

    #contents after the image
    $sections2 = explode("end{center}", $section1[1]);
    $code = $revisedCode . $sections[1];
    }
}


#if the code contains questions parts, replace with html
if (str_contains($code, "\begin{questionparts}")) {
    $sections1 = explode("\begin{questionparts}", $code);

    #add any contents before the question parts start into the revised code
    $revisedCode = $sections1[0];

    #extract the section in the question parts environment
    $sections2 = explode("end{questionparts}", $sections1[1]);
    $questionparts = $sections2[0];
    #remove backlash
    $questionparts = substr($questionparts, 0, -1);

    #begin ordered list
    $revisedCode = $revisedCode . "<ol>";

    #split into parts defined by the \item tag 
    $parts = explode("\item", $questionparts);

    #iterate through parts and add list tags around them 
    for ($i = 1; $i < count($parts); $i++) {
        $revisedCode = $revisedCode . "<li>" . $parts[$i] . "</li>";
    }

    #end ordered list and add any contents after question parts
    $revisedCode = $revisedCode . "</ol>" . $sections2[1];

    $code = $revisedCode;
}

#store code in session 
$_SESSION["display-code"] = $code;

#redirect back to questions page
header('Location: questionspage.php');
exit();
?>