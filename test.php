<?php session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>School</title>
  <!-- Links to style sheet and bootstrap -->
  <link rel="stylesheet" href="stylesheet.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<?php 
include 'navbar-signedin.php';
?>

<!-- Page contents -->
<div id="no-school" class="container">
    <div class="col-sm-4">
        <h2>
            JOIN SCHOOL
        </h2>

        <form action="test2.php"  method="POST">
            Enter school code<br>
            <input type="text" id="schoolID" name="schoolID"><br>
            <br>
            <input type="submit" value="Join">
        </form>

        <?php
        if ($_SESSION["role"] == 1){
        echo '<hr>
        <h2>
            CREATE SCHOOL
        </h2>
                
        <form action="createschool.php"  method="POST">
            <div class="grey-text">
                Choose a 5 digit number to share with students and teachers to join your school, for example your centre code.
            </div>
            <br>
            <input type="text" id="createSchoolID" name="createSchoolID"><br>
            <br>
            <input type="submit" value="Create school code">
        </form>';
        }
        ?>
    </div>
</div>

<br>
<br>
<!-- Bottom blue bar -->
<div class="bottom-bar">
<a> </a>
</div>

</body>
</html>