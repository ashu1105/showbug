<!DOCTYPE html>
<?php
include 'connect.php';
$uid = $_GET['uid'];
$address = array();
$name = array();
$language = array();
$ID = array();
$query = "SELECT Name FROM User WHERE U_ID='".$uid."'";
$result = $con->query($query);
$result->data_seek(0); 
$row = $result->fetch_assoc();
$uname = $row[Name];

?> 
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="bootstrap/Overlay-Bootstrap/overlay-bootstrap.min.css">
	<link rel="stylesheet" href="bootstrap/Overlay-Bootstrap/overlay-bootstrap.min.css">
	<link rel="stylesheet" href="css/reset.css"> <!-- CSS reset -->
	<link rel="stylesheet" href="css/style.css"> <!-- Gem style -->
	<title>ShowBug</title>
</head>
<body>
	<?php if(isset($_GET['variable']))
	{
		$ID = $_GET['variable'];
		$seat =1;

	} ?>
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">
			<ul class="nav navbar-nav">
				<li class="active"><a href="home.php"><span class="glyphicon glyphicon-home"></span></a></li>
				<li class="active"><a href="movies1.php?uid=<?php echo $uid;?>">MOVIES</a></li>
				<li><a href="plays1.php?uid=<?php echo $uid;?>">PLAYS</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><div style="margin-top: 15px;font-size: 20px; color: white;">Welcome <?php echo $uname; ?></div></li>
				<li><a href="home.php">Sign out</a></li>
			</ul>
		</div>
	</nav>

	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>

	<div class="row container-fluid">
		<div class="col-md-3"></div>
		<div class="col-md-6" style="border: 1px solid black;border-radius: 10px;">
			<form  action = "" method = "POST">
				<section id="seats">

					
					<?php
					while($seat <= 60)  {
						$query = "SELECT * FROM `Booking_Details` WHERE SD_ID = '".$ID."' and Seat_no = '".$seat."'"; 		
						$result = $con->query($query);
						$result->data_seek(0);
						if(($seat%10) == 1){echo "<br><br>";}
						if($result->num_rows == 0 )
						{ 
							?>
							<input id=<?php echo $seat;?> class="seat-select" type="checkbox" name=<?php echo $seat; ?> value=<?php echo $seat;?> > <label for=<?php echo $seat; ?> class="seat"><?php echo $seat;?></label>
							<?php 
						} 
						else { 
							$row = $result->fetch_assoc(); 
							?>
							<input id=<?php echo $seat;?> class="seat-select" type="checkbox" name=<?php echo $seat; ?> value=<?php echo $seat;?> > <label for=<?php echo $seat;?> class="disable"><?php echo $seat;?> </label>
							<?php  
						}
						if(($seat%10) == 0){echo "<br>";}
						$seat++;
						
					} 
					?>

					
				</section>
				<br>
				<br>
				<br>
				<br>
				<div style="border: 1px solid blue;text-align: center;padding: 3px; width: 85%">
					Screen Here
				</div>
				<br>
			</div>
		</div>
		<form action = "" method="POST">
			<button class="btn btn-my-primary"  name = "Submit" value="Submit">Submit</button>
		</form>
		<?php
		if(isset($_POST[Submit]))
		{
			while($seat>0)
			{
				if(isset($_POST[$seat]))
				{
					$query = "INSERT INTO Booking_Details values(NULL,".$uid.",$ID,$seat,now(),0)";
					$result = $con->query($query);
				}
				$seat--;
			}
			$test = "<script>window.location.assign('ticket.php?id=";
			$test .=$uid;
			$test .="')</script>";
			echo $test;
		}


		?>
	</form>

	<script src="bootstrap/jquery-3.2.1.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="js/main.js"></script> <!-- Gem jQuery -->
	<script src="js/modernizr.js"></script> <!-- Modernizr -->
	
</body>
</html>