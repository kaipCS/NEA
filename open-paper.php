<?php session_start();
include_once('connection.php');

?>
<!DOCTYPE html>
<html>
<head>
  <title>Paper</title>
  <!-- Links to style sheet and bootstrap -->
  <link rel="stylesheet" href="stylesheet.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<!-- Link to navbar -->
<?php 
include 'navbar-signedin.php';?>

<!-- Page contents -->
<div class="container">
  List of questions:

  <?php
    $paperid = $_POST["paperid"];
    $stmt = $conn -> prepare("SELECT * FROM questioninpaper INNER JOIN questions
    ON questioninpaper.questionid = questions.questionid
    WHERE questioninpaper.paperid = :paperid ORDER BY questioninpaper.questionnumber ASC");
    $stmt->bindParam(':paperid', $paperid);
    $stmt -> execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);  
    foreach($rows as $row){
      print_r($row);
    }
  ?>
</div>

<!-- Bottom blue bar -->
<div class="bottom-bar">
<a> </a>
</div>

</body>
</html>