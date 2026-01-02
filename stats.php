<?php session_start();

#connect to database 
include_once ("connection.php");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Statistics</title>
  <!-- Links to style sheet and bootstrap -->
  <link rel="stylesheet" href="stylesheet.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <!-- Link to chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<!-- Link to navbar -->
<?php 
include 'navbar-signedin.php'; ?>

<!-- Page contents -->
<div class="container">

  <!-- List of completed questions -->
  <h3>Completed questions:</h3>
  <div class="col-sm-5">
  <div id="completed">
  <?php
    $stmt = $conn -> prepare("SELECT * FROM userdoespaperdoesquestion 
          INNER JOIN  questions ON userdoespaperdoesquestion.questionid = questions.questionid
          WHERE userdoespaperdoesquestion.userid = :userid ORDER BY userdoespaperdoesquestion.datecompleted DESC");
    $stmt->bindParam(':userid', $_SESSION["userid"]);
    $stmt -> execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC); 

    #initalise arrays to store data for charts

    #for papers pie chart
    $papers = [0,0,0];
    #for areas pie chart
    $areas = [0,0,0];
    #for marks line chart 
    $marks = [];
    #for questions bar chart
    $monthYears = [];
    foreach($rows as $row){
      #correct the format of paper and add data to array for papers pie chart
      $paper = $row["paper"];
      switch ($paper) {
        case 1:
            $paper = "I";
            $papers[0] += 1;
            break;
        case 2:
            $paper = "II";
            $papers[1] +=1;
            break;
        case 3:
            $paper = "III";
            $papers[2] += 1;
            break;
      }

      #add data to array for areas pie chart
      switch ($row["area"]) {
        case 0:
            $areas[0] += 1;
            break;
        case 1:
            $areas[1] +=1;
            break;
        case 2:
            $areas[2] += 1;
            break;
      }

      echo("STEP " . $paper . " " . $row["year"] . " " . $row["topic"]);

      #add data for questions bar chart
      $date = new DateTime($row['datecompleted']);
      $year  = $date->format('Y');   
      $month = $date->format('m');  
      $monthYear = $year . '-' . $month;  

      if (!isset($monthYears[$monthYear])) {
          $monthYears[$monthYear] = 1; 
      } 
      else {
          $monthYears[$monthYear] += 1;
      }


      if ($row["mark"] !== NULL){
        echo(" ". $row["mark"] . "/20");

        #add data for chart
        if (!isset($marks[$monthYear])) {
          $marks[$monthYear] = ['total' => $row["mark"], 'count' => 1 ];
        } 
        else {
            $marks[$monthYear]['total'] += $row["mark"];
            $marks[$monthYear]['count'] += 1;
        }
      }
      echo("<br>");

    }

  #print_r($monthYears);
  #sort arrays chronologically
  ksort($monthYears);
  ksort($marks);

  #seperate into two seperate arrays
  $labels = array_keys($monthYears);  
  $counts = array_values($monthYears); 

  #get data from marks
  $months = array_keys($marks); 
  $averages = [];
  foreach($marks as $mark){
    $averages[] = ($mark['total'])/($mark['count']) ;
  }
  #print_r($averages);
  
  ?>
  </div>

  <br>
  <form id="pie-options" action="pie-options.php" method="POST">
  Distribution across
  <select name="pie-options" onchange="changeOption()">
      <option value="papers" <?php if (!isset($_SESSION['pie-options']) || $_SESSION['pie-options'] === 'papers') echo 'selected'; ?>>
          papers
      </option>
      <option value="areas" <?php if ($_SESSION['pie-options'] == 'areas') echo 'selected'; ?>>
          areas
      </option>
  </select>
  </form>

  <!-- Submit sort form automatically if it is changed -->
  <script>
    function changeOption() {
        document.getElementById("pie-options").submit();
    }
</script>

 
<div id="papers-pie" >
  <canvas id="myChart1"></canvas>
</div>
 
<script>
  var papers = <?php echo json_encode($papers); ?>;
  const ctx1 = document.getElementById('myChart1');

  new Chart(ctx1, {
    type: 'doughnut',
    data: {
      labels: ['STEP I', 'STEP II', 'STEP III'],
      datasets: [{
        data: papers
      }]
    },
  });
</script>
 
<div id="areas-pie">
  <canvas id="myChart2"></canvas>
</div>
 
<script>
  var areas = <?php echo json_encode($areas); ?>;
  const ctx2 = document.getElementById('myChart2');

  new Chart(ctx2, {
    type: 'doughnut',
    data: {
      labels: ['Pure', 'Mechanics', 'Probability'],
      datasets: [{
        data: areas
      }]
    },
  });
</script>
</div> 

<?php 
if ($_SESSION["pie-options"] == "areas"){
    echo("
    <script>
      document.getElementById('papers-pie').style.display = 'none';
      document.getElementById('areas-pie').style.display = 'block';
    </script>");
}
else{
  echo("
  <script>
    document.getElementById('areas-pie').style.display = 'none';
    document.getElementById('papers-pie').style.display = 'block';
  </script>");  
}
?>

<div class="col-sm-7">
<div>
  <canvas id="myChart3"></canvas>
</div>

<script>
  const ctx3 = document.getElementById('myChart3');
  var labels = <?php echo json_encode($labels); ?>;
  var counts = <?php echo json_encode($counts); ?>;

  new Chart(ctx3, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        label: 'Number of questions completed each month',
        data: counts,
        borderWidth: 1
      }]
    },
  });
</script>

<div>
  <canvas id="myChart4"></canvas>
</div>

<script>
  const ctx4 = document.getElementById('myChart4');
  var months = <?php echo json_encode($months); ?>;
  var averages = <?php echo json_encode($averages); ?>;

  new Chart(ctx4, {
    type: 'line',
    data: {
      labels: months,
      datasets: [{
        label: 'Average marks each month',
        data: averages,
        fill: false
      }]
    },
  });
</script>
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