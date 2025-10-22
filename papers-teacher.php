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
?>


<!-- Page contents -->
<div id="papers-list" class="container">

<div class="row"> 
  <div class='col-sm-6'>
    <!-- Button to create a new paper -->
    <form action="create-paper">
      <input type="submit" value = "Create new paper +"> 
    </form>
  </div>

<!-- Papers -->
<?php
  #search dataase for papers created by the current user
  $stmt = $conn -> prepare("SELECT * FROM usercreatespaper WHERE userid = :userid 
  ORDER BY usercreatespaper.dateedited DESC");
  $stmt->bindParam(':userid', $_SESSION["userid"]);
  $stmt -> execute();
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);       
  
  #check if user has created papers
  if (count($rows) > 0) {
    #column headers
    echo("
      <div class='col-sm-2'>
      Last edited
      </div>
      </div>
      <br>  "
    );
  
    #iterate through results 
    foreach ($rows as $row) {
      #output results
      echo("<div class='paper-row row'>
      <div class='col-sm-6'>
          <form action='open-paper.php' method='post'>
            <input type='hidden' name='paperid' id='paperid' value='".$row["paperid"]."'>
            <input type='submit' class='paper-button' value='".$row["title"]."'>
          </form>
      </div>
      <div class='col-sm-2'>
        " .date('d-m-y', strtotime($row['dateedited']))."
      </div>
      <div class='col-sm-2'>
        <form action='delete-paper.php' method='post'>
          <input type='hidden' name='paperid' id='paperid' value='".$row["paperid"]."'>
          <input type='submit' class='delete-paper' value='Delete'>
        </form>
      </div>
    </div> <br>");
    }
  }
  #if they do not yet have any papers
  else{
    echo("</div> You have not created any papers, click above to create your first paper");
  }

?>
</div>


<!-- Bottom blue bar -->
<div class="bottom-bar">
<a> </a>
</div>

</body>
</html>