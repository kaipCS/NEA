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

        <!--  Join school form -->
        <form action="joinschool.php"  method="POST">
            Enter school code<br>
            <input type="text" id="schoolID" name="schoolID"><br>

            <!-- Error messages  -->
            <div class="error-message">
                <?php
                if ($_SESSION["error"] == "emptySchool"){
                    if ($_SESSION["role"] == 1){
                        echo "Enter a school code. If you do not have a code, create a school below.";
                    }
                    else{
                        echo "Please enter a school code.";
                    }
                }
                if ($_SESSION["error"] == "noID"){
                    if ($_SESSION["role"] == 1){
                        echo "There is no school registered with this code. If you do not have a code, create a school below.";
                    }
                    else{
                        echo "There is no school registered with this code. Check with your teacher.";
                    }
                }
                ?>
            </div>
            <br>
            <input type="submit" value="Join">
        </form>

        <!-- Create school form only for teachers-->
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
                
                <!-- Error messages-->
                <div class="error-message">';
                    if ($_SESSION["error"] == "emptyCode"){
                        echo "Please enter a school code.";
                    }
                    if ($_SESSION["error"] == "length"){
                        echo "Please enter a 5 digit code.";
                    }
                    if ($_SESSION["error"] == "codeExists"){
                        echo "A school with this code already exists. Enter the code above to join your school.";
                    }

                echo '</div> <br>
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