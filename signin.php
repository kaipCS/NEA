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

<!-- Link to include appropriate navbar -->
<?php 
include 'navbar-signedout.php';
?>

<!-- Page contents -->
<div id="sign-in" class="container">
  <div class="col-sm-4">
    <h3>
      SIGN IN
    </h3>
    <br>
    <form action="signinsession.php">
      <div>
        Email <input type="text" id="email" name="email"><br>
        Password <input type="password" id="password" name="password"><br>
        <input type="submit" value="Sign in">
      </div>
    </form>
  </div>
  <div class="col-sm-4">
    <h3>
      CREATE ACCOUNT    
    </h3>
    <br>
    <form action="createaccount.php">
      Forename <input type="text" id="forename" name="forename"> Surname <input type="text" id="surname" name="surname"><br>
      Email <input type="text" id="email" name="email"><br>
      Password <input type="password" id="password" name="password"><br>
      <input type="radio" id="role1" name="role" value="Student" checked="checked">
        <label for="role1">Student</label>
      <input type="radio" id="role2" name="role" value="Teacher">
        <label for="role2">Teacher</label>
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