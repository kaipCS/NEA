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
                #get list of completed questions  
                $stmt = $conn -> prepare("SELECT * FROM userdoespaperdoesquestion 
                INNER JOIN  questions ON userdoespaperdoesquestion.questionid = questions.questionid
                WHERE userdoespaperdoesquestion.userid = :userid 
                ORDER BY userdoespaperdoesquestion.datecompleted DESC");
                $stmt->bindParam(':userid', $_SESSION["userid"]);
                $stmt -> execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC); 

                #initalise array for the papers pie chart 
                $papers = [0,0,0];

                #initalise array for areas [pure, mechanics, probability]
                $areas = [0,0,0];

                #intialise the array to count the questions completed each month 
                $questions = [];

                #intialise the array to count the average marks each month
                $marks = [];

                #iterate through questions
                foreach($rows as $row){
                    #print_r($row);

                    #correct the format of paper and add to the papers array
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

                    #add to totals in areas array for pie chart
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

                    #output the question
                    echo("STEP " . $paper . " " . $row["year"] . " " . $row["topic"]);

                    #get month and year of completion
                    $timestamp = strtotime($row["datecompleted"]);
                    $date = date("m-y", $timestamp);

                    #check if this date is already in the questions array
                    if (isset($questions[$date])) {
                        $questions[$date]++;
                    } else {
                        $questions[$date] = 1;
                    }

                    #check if the question has a mark
                    if ($row["mark"] !== NULL){
                        #output mark out of 20 
                        echo(" ". $row["mark"] . "/20");

                        #check if the month is already in the marks array
                        if (!isset($marks[$date])) {
                            #add in inital value for this month
                            $marks[$date] = [1, $row["mark"]];
                        }
                        else{
                            #increment number of questions marked 
                            $marks[$date][0]++;

                            #add current mark to total 
                            $marks[$date][1] += $row["mark"];
                        }
                    }

                    echo("<br>");

                    #just reverse arrays as already in descending order
                }
                #reverse the questions array 
                $questions = array_reverse($questions);

                #seperate the variables in the questions array
                $questionsMonths = array_keys($questions);  
                $questionsCounts = array_values($questions);

                #reverse the marks array
                $marks = array_reverse($marks);

                #seperate months from the marks into an array 
                $marksMonths = array_keys($marks); 

                #initialise marksAverages arrays
                $marksAverages = [];

                #iterate through marks array
                foreach($marks as $mark){
                    #calculate average and add to array
                    $marksAverages[] = ($mark[1])/($mark[0]) ;
                }

                print_r($marksMonths);
                print_r($marksAverages);

                #print_r($questionsCounts);
                #print_r($marks);
            ?>
        </div>
        

        <!-- Papers pie chart -->
        <canvas id="papers-chart"></canvas>

        <script>
            //get papers array from php
            var papers = <?php echo json_encode($papers); ?>;
            
            //pie chart using chart.js
            const papersChart = document.getElementById('papers-chart');
            new Chart(papersChart, {
            type: 'doughnut',
            data: {
                labels: ['STEP I', 'STEP II', 'STEP III'],
                datasets: [{
                data: papers
                }]
            },
            });
        </script>
        <br>
        <br>

        <!-- Areas pie chart -->
        <canvas id="areas-chart"></canvas>

        <script>
            //get areas array from php
            var areas = <?php echo json_encode($areas); ?>;
            
            //pie chart using chart.js
            const areasChart = document.getElementById('areas-chart');
            new Chart(areasChart, {
            type: 'doughnut',
            data: {
                labels: ['Pure', 'Mechanics', 'Probability'],
                datasets: [{
                data: areas
                }]
            },
            });
        </script>
        <br>
        <br>

    </div>

    <!-- Bar and line charts -->
    <div class="col-sm-7">
        <!-- Chart showing number of questions completed each month-->
        <canvas id="questions-chart"></canvas>

        <script>
        const questionsChart = document.getElementById('questions-chart');

        //get arrays from php
        var questionsMonths = <?php echo json_encode($questionsMonths); ?>;
        var questionsCounts = <?php echo json_encode($questionsCounts); ?>;

        //bar chart using chart.js
        new Chart(questionsChart, {
            type: 'bar',
            data: {
            labels: questionsMonths,
            datasets: [{
                label: 'Number of questions completed each month',
                data: questionsCounts,
                borderWidth: 1
            }]
            },
        });
        </script>

        <!-- Chart showing average mark each month-->
        <canvas id="marks-chart"></canvas>

        <script>
        const marksChart = document.getElementById('marks-chart');

        //get arrays from php
        var marksMonths = <?php echo json_encode($marksMonths); ?>;
        var marksAverages = <?php echo json_encode($marksAverages); ?>;

        //bar chart using chart.js
        new Chart(marksChart, {
            type: 'line',
            data: {
            labels: marksMonths,
            datasets: [{
                label: 'Average marks each month',
                data: marksAverages,
            }]
            },
        });
        </script>

    </div>
</div>

<!-- Bottom blue bar -->
<div class="bottom-bar">
<a> </a>
</div>

</body>
</html>