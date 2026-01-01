<?php
session_start();
#connect to the database
include_once('connection.php');

#print_r($_POST);
$codes = $_POST["codes"];

#calculate number of questions 
$numberOfQuestions = sizeof($codes);
#echo($numberOfQuestions);

#inital template code
$code = "\\documentclass{exam}
\\usepackage{fullpage}
\\setlength\\parindent{0pt}
\\usepackage{setspace}
\\setstretch{1.3}
\\usepackage[skip=15pt]{parskip}
\\usepackage{graphicx}
\\usepackage[T1]{fontenc}
\\usepackage{tgbonum}

\\begin{document}

\\vspace*{-\\topskip}
\\noindent\\hfill
\\includegraphics[width=0.5\\textwidth]{logo.png}

{\\fontfamily{phv}\\selectfont

\\LARGE{\\textbf{Sixth Term Examination Papers}}";

#add in time for the paper 
$code = $code . "\\hfill \\Large{Time: " . $_POST["time"] . " minutes}";

#add in title for the paper
$code = $code . "\n \n \\LARGE{\\textbf{".$_POST["title"]."}}";

#Add in information with number of questions 
$code = $code. "\n \n \\large{\\textbf{INFORMATION FOR CANDIDATES}}

The are " . $numberOfQuestions . " questions in this paper.

Each question is marked out of 20.

There is NO Mathematical Formulae Booklet.

Calculators are NOT permitted.";

#only include note section if a note exists
if (!empty($_POST["note"])) {
    $code = $code . "\n \n \\textbf{NOTES} \n \n " . $_POST["note"];
}

#start questions
$code = $code . "\n \n \\rule{\\textwidth}{0.5pt}

}

\\clearpage

\\begin{questions}";

#iterate through each question
foreach($codes as $question){
    #start with item tag 
    $code = $code . "\n \n \\item \n";

    #check if question contains parts
    if (!str_contains($question, "questionparts")){
        #no question parts 
        $code = $code . $question;
    }
    else{
        #contains parts 
        $sections1 = explode("\\begin{questionparts}", $question);

        #add any contents before the question parts start into the question's code
        $questionCode = $sections1[0];
    
        #extract the section in the question parts environment
        $sections2 = explode("end{questionparts}", $sections1[1]);
        $questionparts = $sections2[0];
        #remove backlash
        $questionparts = substr($questionparts, 0, -1);
    
        #begin subparts 
        $questionCode = $questionCode . "\\begin{subparts} ";
    
        #split into parts defined by the \item tag 
        $parts = explode("\\item", $questionparts);
    
        #iterate through parts and add a subpart tag for each
        for ($i = 1; $i < count($parts); $i++) {
            $questionCode = $questionCode . "\n \\subpart " . $parts[$i];
        }
    
        #end subparts and add any contents after question parts
        $questionCode = $questionCode . " \n \\end{subparts}" . $sections2[1];
    
        $code = $code . $questionCode;
    }
}

#end questions and paper 
$code = $code . "\n \n \\end{questions}

\\end{document}";

file_put_contents("paper-code.tex", $code);
?>