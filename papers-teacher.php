<?php 
session_start();
unset($_SESSION["paperid"]);
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
    <button class="create-paper-button" onclick="openForm()">Create new paper +</button>
  </div>
  <!-- Javascript to open and close create paper pop up-->
  <script>
    function openForm() {
      document.getElementById("create-paper").style.display = "block";
    }
    function closeForm() {
      document.getElementById("create-paper").style.display = "none";
    }
  </script>

<!-- Papers -->
<?php
  #search dataase for papers created by the current user
  $singlequestion = 0;
  $stmt = $conn -> prepare("SELECT * FROM usercreatespaper WHERE userid = :userid AND singlequestion = :singlequestion
  ORDER BY dateedited DESC");
  $stmt->bindParam(':userid', $_SESSION["userid"]);
  $stmt->bindParam(':singlequestion', $singlequestion);
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
          <input type='submit' class='delete-paper' onclick='return confirm(\"Are you sure you want to delete this paper?\")' value='Delete'>
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

<!-- create paper pop up-->
<div id="create-paper">
  <form action="create-paper.php" method="post" class="form-container">
    <button type="button" class="btn close" onclick="closeForm()">🞪</button>
    <h3>Create a new paper</h3>
    <br>
    <input id="input-title"  type="text" placeholder="Enter a title..." name="title" required>
    <br>
    <br>
    <input type="submit" value="Create"></input>
  </form>
</div>

<!-- Bottom blue bar -->
<div class="bottom-bar">
<a> </a>
</div>

</body>
</html>