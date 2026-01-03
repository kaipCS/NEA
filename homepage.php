<?php session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Homepage</title>
  <!-- Links to style sheet and bootstrap -->
  <link rel="stylesheet" href="stylesheet.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<!-- Link to include appropriate navbar -->
<?php 
#echo($_SESSION['userid']);
if (isset($_SESSION['userid'])):
  include 'navbar-signedin.php';
else:
  include 'navbar-signedout.php';
endif; ?>

<!-- Page contents -->
<div class="container">

  <!-- What is step and dates -->
  <div class="row">
    <div class="col-sm-9">
    <h2>
      What is STEP 
    </h2>
    <p>
      STEP (Sixth term examination paper) is an additional mathematics examination, taken at the end of Year 13, which forms part of conditional offers to applicants for mathematics and some related degrees at Cambridge and some other universities. It is designed to test candidates on questions that are similar in style to undergraduate mathematics.
    <br>
      There are two STEP examinations: STEP 2 and STEP 3. Students are usually required to sit either one or both of the examinations, depending on the requirements of the universities they have applied to. STEP 2 is based on A level Mathematics and AS level Further Mathematics. STEP 3 is based on a typical Further Mathematics A-level syllabus.
    </p>
    </div>
    <div class="col-sm-3">
      <h3>  
        Upcoming dates
      </h3>
      <h3>
        STEP II: 04/06/26
      </h3>
      <h3>
        STEP III: 10/06/26
      </h3>
    </div>
  </div>

  <!-- How to use website -->
  <div class="row">
    <div class="col-sm-6">
      <h2>
        How to use this website
      </h2>
      <p>
        Sign in or create an account to make a paper. You can create these on the papers tab (under account) and then browse questions from the questions tab to add to these. Papers can be downloaded as printable pdfs. 
      </p>
    </div>
    <div class="col-sm-3">
      <h3>
        For teachers
      </h3>
      <p>
        Create a school code to share with your students or other teachers from your school. You can share your papers with students and see their progress statistics. 
      </p>
    </div>
    <div class="col-sm-3">
      <h3>
        For students
      </h3>
      <p>
      There are links to solutions that you can use to mark questions and save your score. You can keep track of your progress on the statistics tabs. Join a school with a code from your teacher which allows them to send you papers.
      </p>
    </div>
  </div>

    <!-- How to prepare -->
    <div class="row">
    <div class="col-sm-12">
      <h2>
        Tips for preparation
      </h2>
      <p> 
        The best preparation for STEP is to work slowly through past questions that you can browse through on the questions tab of this website. Do not worry if they initially seem very difficult:  the questions are much longer and more demanding than A-level questions. With enough practice you will get better at tackling STEP questions and you will be well prepared to achieve the grades you need.
      <br>
        Consider starting with older questions and working chronologically (questions go back to 1986). Older papers tend to have easier questions and generally get gradually more challenging recently. You can also start with STEP I (which was discontinued in 2019) as these only use single A-level mathematics content.
      <br>
        The University of Cambridge have produces the STEP support programme which has foundation modules to use before past questions. In addition, the Advanced Problems in Mathematics book by Stephen Siklos analyses STEP questions followed by a comment and a full solution.
      </p>
    </div>
  </div>
</div>

<br>
<!-- Bottom blue bar -->
<div class="bottom-bar">
<a> </a>
</div>

</body>
</html>