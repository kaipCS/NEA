<?php 
session_start();

include_once ("connection.php");
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
<div class="container">
    <h2>
    YOUR SCHOOL CODE:
    <?php
    echo $_SESSION["schoolID"];
    ?>
    </h2>
    <?php 
    $role = $_SESSION["role"]; 
    if ($role == 1){
        echo '<div class="grey-text"> Share this code with students and other teachers to join your school </div>';
    }
    ?>
    <br>
    <div id="in-school">
    <div class="col-sm-4">
        Teachers in your school:
        <br>
        <br>
        <?php
        $stmt = $conn -> prepare("SELECT * FROM users WHERE role=1");
        $stmt -> execute();
        while ($row = $stmt -> fetch(PDO::FETCH_ASSOC))
        {
            echo($row["surname"]. ", ". $row["forename"]." (". $row["email"].") <br>"); 
}
        ?> 
    </div>
    <?php
    if ($role == 1){
        echo '<div class="col-sm-8"> The students in your school: <br><br>';
        $stmt = $conn -> prepare("SELECT * FROM users WHERE role=0");
        $stmt -> execute();
        while ($row = $stmt -> fetch(PDO::FETCH_ASSOC))
        {
            echo($row["surname"]. ", ". $row["forename"]." (". $row["email"].") <br>"); 

    } echo '</div>'; }?>
</div>
</div>

<!-- Bottom blue bar -->
<div class="bottom-bar">
<a> </a>
</div>

</body>
</html>