<?php session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Sign in</title>
  <!-- Links to style sheet and bootstrap -->
  <link rel="stylesheet" href="stylesheet.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<!-- Link to include signed out navbar -->
<?php 
include 'navbar-signedout.php';
?>

<!-- Page contents -->
<div id="sign-in" class="container">
  <!-- Sign in box -->
  <div class="col-sm-4">
      <h3>
          SIGN IN
      </h3>
  
      <!-- Sign in form -->
      <form action="signinuser.php"  method="POST">
          Email<br>
          <input type="text" id="email" name="email"><br>
          Password<br>
          <input type="password" id="password" name="password">
          <div class="error-message">
            <?php
            #print_r($_SESSION);
            if ($_SESSION["error"] == "emptySignIn"){
              echo "Please enter details into all fields.";
            }
            if ($_SESSION["error"] == "noUser"){
              echo "There is no account associated with this email. If you have not signed up, create an account.";
            }
            if ($_SESSION["error"] == "password"){
              echo "Unsuccessful login. Check your password and try again.";
            }
            ?>
          </div>
          <br>
          <input type="submit" value="Sign in">
      </form>
  </div>
  
  <!-- Create account box -->
  <div class="col-sm-4">
      <h3>
          CREATE ACCOUNT    
      </h3>

      <!-- Create account form -->
      <form action="test.php"  method="POST">
          Forename<br>
          <input type="text" id="forename" name="forename"><br>
          Surname<br>
          <input type="text" id="surname" name="surname"><br>
          Email<br>
          <input type="text" id="email" name="email"><br>
          Password<br>
          <input type="password" id="password" name="password"><br>
          <input type="radio" name="role" value="Student" checked> Student
          <input type="radio" name="role" value="Teacher"> Teacher
          <br>
          <div class= "error-message">
            <?php
            #print_r($_SESSION);
            if ($_SESSION["error"] == "emptyAccount"){
              echo "Please enter details into all fields.";
            }
            if ($_SESSION["error"] == "emailExists"){
              echo "An account with this email already exists. Sign in to access your account.";
            }
            ?>
          </div>
          <br>
          <input type="submit" value="Create account">
      </form>
  </div>
</div>

<!-- Bottom blue bar -->
<div class="bottom-bar">
<a> </a>
</div>

</body>
</html>