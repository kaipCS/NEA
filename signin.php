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
    <form action="signinsession.php">
      <div>
        <label for="email">Email</label><br>
        <input type="text" id="email" name="email">
      </div>
      <div>
        <label for="password">Password</label><br>
        <input type="password" id="password" name="password">
      </div>
      <br>
      <input type="submit" value="Sign in">
    </form>
  </div>
  
  <div class="col-sm-4">
    <h3>
      CREATE ACCOUNT    
    </h3>
    <form action="createaccount.php">
      <div>
        <label for="forename">Forename</label><br>
        <input type="text" id="forename" name="forename">
      </div>
      <div>
        <label for="surname">Surname</label><br>
        <input type="text" id="surname" name="surname">
      </div>
      <div>
        <label for="email">Email</label><br>
        <input type="text" id="email" name="email">
      </div>
      <div>
        <label for="password">Password</label><br>
        <input type="password" id="password" name="password">
      </div>
      <br>
      <div>
        <input type="radio" id="role1" name="role" value="Student" checked>
        <label for="role1">Student</label>
        <input type="radio" id="role2" name="role" value="Teacher">
        <label for="role2">Teacher</label>
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