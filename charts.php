<?php include "database.php" ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>SB Admin - Start Bootstrap Template</title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->
  <?php include "navbar.php" ?>

  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Charts</li>
      </ol>


<form id="dateSelect" method="get">

        year
        <select id="year" name="year" style="height: 30px;width: 250px;">
            <option value="-1">Select a year...</option>
            <?php

            for ($i=2000; $i <= 2050; $i++) {
              echo "<option value=\"".$i."\">".$i."</option>";
            }

            ?>
        </select>

        Month
        <select id="month" name="month" style="height: 30px;width: 250px;">
            <option value="-1">Select a month...</option>
            <?php

            for ($i=1; $i <= 12; $i++) {
              echo "<option value=\"".$i."\">".$i."</option>";
            }

            ?>
        </select>

        <button class="btn btn-default" type="submit">Refresh</button>
    </form>

      <!-- Area Chart Example-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-area-chart"></i> Area Chart Example</div>
        <div class="card-body">
          <canvas id="myAreaChart" width="100%" height="30"></canvas>
        </div>
        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
      </div>
      <div class="row">
        <div class="col-lg-8">
          <!-- Example Bar Chart Card-->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-bar-chart"></i> Bar Chart Example</div>
            <div class="card-body">
              <canvas id="myBarChart" width="100" height="50"></canvas>
            </div>
            <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
          </div>
        </div>
        <div class="col-lg-4">
          <!-- Example Pie Chart Card-->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-pie-chart"></i> Pie Chart Example</div>
            <div class="card-body">
              <canvas id="myPieChart" width="100%" height="150"></canvas>
            </div>

            <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.container-fluid-->

    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © Marshall Asch 2018</small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>




    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="vendor/chart.js/Chart.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
   <!-- <script src="js/sb-admin-charts.min.js"></script> -->


<?php


function getLables()
{
  $labels = "";

    foreach (getAllDates() as $date) {
      $labels = $labels. '"'. $date["date"].'", ';
    }

    return $labels;
}


function getDataSet($tag)
{

    $colors = ['#007bff', '#dc3545', '#ffc107', '#00ffaa', '#aabbcc', '#0a0a0a', '#f7f7f7', '#ff0000', '#0000ff', '#28a745', '#aaaaaa', '#020202', '#202020'];

  if ($tag == -1){
    $title = "Total";
    $res = getTotalSpent();
    $color = '#007bff';

  } else {
    $title = getTagTitle($tag);
    $res = getTotoalTag($tag);
    $color = $colors[$tag];
  }




  $data = "";
  foreach ($res as $row) :
        $data = $data."'".$row["spent"]."', ";
   endforeach;


   $dataset = "
            {
                label: \"{$title}\",
                lineTension: 0.3,
                backgroundColor: \"{$color}30\",
                borderColor: \"{$color}ff\",
                pointRadius: 5,
                pointBackgroundColor: \"{$color}ff\",
                pointBorderColor: \"rgba(255,255,255,0.8)\",
                pointHoverRadius: 5,
                pointHoverBackgroundColor: \"{$color}ff\",
                pointHitRadius: 20,
                pointBorderWidth: 2,
                data: [{$data}],
            }";

  return $dataset;
}




?>

<!-- For the line chart-->
<script type="text/javascript">
  var ctx = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [ <?php echo getLables(); ?>],
            datasets: [

            <?php

            for ($i=1; $i < 13; $i++) {
              if ($i == 9 || $i == 10 || $i == 7) {
                continue;
              }
                echo getDataSet($i).',';

              }
              echo getDataSet(-1).',';

            ?>

            ],
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            max: 40000,
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, .125)",
                        }
                    }],
                },
                legend: {
                    display: true
                }
            },
        },
    }
);

</script>

<!-- This is for the one month pi chart-->
   <script type="text/javascript">
<?php

$year = date("Y");
$month = date("m");

if (isset($_GET["year"]) && $_GET["year"] > 1960 && $_GET["year"] < 2100) {
  $year = $_GET["year"];
}


if (isset($_GET["month"]) && $_GET["month"] > 0 && $_GET["month"] < 32) {
  $month = $_GET["month"];
}



$res = getTotalsForMonth($year, $month);

$labelList = "";
$valueList = "";
foreach ($res as $row) :
      $labelList = $labelList."'".$row["name"]."', ";
      $valueList = $valueList."'".$row["total"]."', ";
 endforeach;
 ?>

var labels = [<?php echo $labelList; ?>];
var colors = ['#007bff', '#dc3545', '#ffc107', '#00ffaa', '#aabbcc', '#0a0a0a', '#f7f7f7', '#ff0000', '#0000ff', '#28a745', '#aaaaaa', '#020202', '#202020'];
var data = [<?php echo $valueList; ?>];

Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';
  // -- Pie Chart Example
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: 'pie',
  data: {
    labels: labels,
    datasets: [{
      data: data,
      backgroundColor: colors,
    }],
  },
});

</script>
  </div>
</body>

</html>
