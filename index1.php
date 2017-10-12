<!DOCTYPE HTML>
<html>
	<head>
        <?php include 'connect.php';?>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/Overlay-Bootstrap/overlay-bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css"> <!-- Gem style -->
		<title>Highcharts Example</title>

		<style type="text/css">

		</style>
	</head>
	<body>
    <?php
        include 'connect.php';
        $uid = $_GET['uid'];
        $query = "SELECT Vendor_name FROM Theater_vendor WHERE Vendor_ID='".$uid."'";
        $result = $con->query($query);
        $result->data_seek(0); 
        $row = $result->fetch_assoc();
        $uname = $row[Vendor_name];

    ?> 
        <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <ul class="nav navbar-nav">
         <li ><a href="vendor.php?uid=<?php echo $uid;?>">My Shows</a></li>
         <li class="active"><a href="index1.php?uid=<?php echo $uid;?>">Statistics</a></li>
       </ul>
       <ul class="nav navbar-nav navbar-right main-nav" style="margin-top: 5px;">
        <li><div style="margin-top: 15px;font-size: 20px; color: white;"> Welcome <?php echo $uname; ?></div></li>
        <li><a href="home.php">Sign out</a></li>
    </ul>
  </div>
</nav>
<script src="highcharts/code/highcharts.js"></script>
<script src="highcharts/code/modules/exporting.js"></script>
<?php 
$tid = array();
$query = "SELECT DISTINCT T_ID FROM Theater WHERE Vendor_ID = ".$uid."";

$result = $con->query($query);
$j=1;

while($row = $result->fetch_assoc()){
$tid[$j] = $row['T_ID'];
$j++;
}
$j--;
?>

<div >
<?php 
$title = array();
$income = array();
$i=1;
$query = "SELECT Title,SUM(Price) FROM Stats WHERE T_ID=".$tid[1]." AND Show_Date BETWEEN CURDATE() - INTERVAL 1 DAY AND CURDATE() GROUP BY Title";

$result = $con->query($query);
while($row = $result->fetch_assoc()){
$title[$i] = $row[Title];
$income[$i] = $row['SUM(Price)'];

$i++;
}
$i--;
?>
<div id="container1" style="min-width: 310px; height: 400px; margin: 0 auto"> </div>
<?php if($i==0){ ?> <center><span style="color: red;"><b>No Shows In Last day!</b></span></center> 

<?php } else {?>
<script type="text/javascript">

Highcharts.chart('container1', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Last Day Total Income'
    },

    xAxis: {
        categories: [
            <?php $l=1; while($l<=$i){ ?>'<?php  echo $title[$l]; ?>' , <?php $l++;  } ?>
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Income'
        }
    },
    series: [{
        name: ' ',
        data: [<?php $l=1; while($l<=$i){ ?><?php  echo $income[$l]; ?> , <?php $l++;  } ?>],

    }]
});
        </script>
        <?php } ?>
        <hr>

<?php 
$title = array();
$income = array();
$i=1;
$query = "SELECT Title,SUM(Price) FROM Stats WHERE T_ID=".$tid[1]." AND Show_Date BETWEEN CURDATE() - INTERVAL 8 DAY AND CURDATE() GROUP BY Title";

$result = $con->query($query);
while($row = $result->fetch_assoc()){
$title[$i] = $row[Title];
$income[$i] = $row['SUM(Price)'];

$i++;
}
$i--;
?>
<div id="container2" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<?php if($i==0){ ?> <center><span style="color: red;"><b>No Shows In Last week!</b></span></center> 

<?php } else {?>
<script type="text/javascript">

Highcharts.chart('container2', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Last Week Total Income'
    },
    xAxis: {
        categories: [
            <?php $l=1; while($l<=$i){ ?>'<?php  echo $title[$l]; ?>' , <?php $l++;  } ?>
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Income'
        }
    },
    series: [{
        name: ' ',
        data: [<?php $l=1; while($l<=$i){ ?><?php  echo $income[$l]; ?> , <?php $l++;  } ?>],

    }]
});
        </script>
        <?php } ?>
<hr>




<?php 
$i=1;
$query = "SELECT Title,SUM(Price) FROM Stats WHERE T_ID=".$tid[1]." AND Show_Date BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() GROUP BY Title";

$result = $con->query($query);
while($row = $result->fetch_assoc()){
$title[$i] = $row[Title];
$income[$i] = $row['SUM(Price)'];

$i++;
}
$i--;
?>
<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<?php if($i==0){ ?> <center><span style="color: red;"><b>No Shows In Last month!</b></span></center> 

<?php } else {?>
<script type="text/javascript">

Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Last Month Total Income'
    },
    xAxis: {
        categories: [
            <?php $l=1; while($l<=$i){ ?>'<?php  echo $title[$l]; ?>' , <?php $l++;  } ?>
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Income'
        }
    },
    series: [{
        name: ' ',
        data: [<?php $l=1; while($l<=$i){ ?><?php  echo $income[$l]; ?> , <?php $l++;  } ?>],

    }]
});
		</script>
        <?php } ?>
        </div>
            <script src="bootstrap/jquery-3.2.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/main.js"></script> <!-- Gem jQuery -->
    <script src="js/modernizr.js"></script> <!-- Modernizr -->
<?php include 'footer.php';?>

	</body>
</html>
