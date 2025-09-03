<?php
session_start();
include_once('connection.php');

$questionid = $_POST['id']; 

$diagrams = [2,6,11,50,60,84,
            107,139,145,165,193,204,
            246,252,254,255,285,288,
            296,299,301,302,309,318,
            320,333,334,335,336,339,
            344,348,359,366,383,397,
            449,451,521,551,578,731,
            733,735,824,887,924,927,
            1023,1035,1036,1061,1087,1112,
            1115,1122,1141,1167,1180,1191,
            1203,1219,1268,1271,1284,1291,
            1295,1336];

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

if (in_array($questionid, $diagrams)){
    if ($questionid == 1035){
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
        $tempCode = $code;
        $center1 = explode("\begin{center}", $tempCode);
        $code = $center1[0];
        $imageSrc = "diagrams/" . $questionid . "-diagram.png";
        $code .= '<img src="' . $imageSrc . '" style="width: 60%; display: block; margin: 0 auto;">';
        $center2 = explode("end{center}", $center1[1]);
        $code = $code . $center2[1];
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

    $code = $revisedCode;
    
}

#$result = str_replace("\noindent", "", $code);

$_SESSION["display-code"] = $code;


$_SESSION["questionid"] = $questionid;

header('Location: test.php');
exit();
?>


</body>
</html>