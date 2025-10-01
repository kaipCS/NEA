<?php 
session_start();
include_once('connection.php');
?>
<!DOCTYPE html>
<html>
<head>
  <title>Papers</title>
  <!-- Links to style sheet and bootstrap -->
  <link rel="stylesheet" href="stylesheet.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<!-- Link to include navbar -->
<?php 
include 'navbar-signedin.php'

#inner join for user's name ;
?>
<!-- Page contents -->
<div id="papers-list" class="container">
 <div class="row"> 
  <div class="col-sm-6">
  <form action="create-paper.php" method="post">
    <input type="submit" value = "Create new paper +"> 
  </form>
</div>
<div class="col-sm-2">
Last edited
</div>
</div><br>
<?php
$stmt = $conn -> prepare("SELECT * FROM usercreatespaper WHERE userid = :userid ");
$stmt->bindParam(':userid', $_SESSION["userid"]);
$stmt -> execute();
while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
  echo("<div class='row paper-row'>
    <div class='col-sm-6'>"
    .$row["title"]."
    </div>
    <div class='col-sm-2'>"
    . date("Y-m-d", strtotime($row["dateedited"]))."
    </div>
    <div class='col-sm-2'>
      <form action='delete-paper.php' method='post'>
      <input id='paperid' type='hidden' value = ' ". $row["paperid"]. "'> 
        <input id='delete-paper' type='submit' value = 'Delete'> 
      </form>
    </div>
    </div> <br>");
}
  ?>

</div>

<!-- Bottom blue bar -->
<div class="bottom-bar">
<a> </a>
</div>

</body>
</html>