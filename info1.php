  <!DOCTYPE html>
  <html lang="en">
  <head>
  	<meta charset="UTF-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  	<link rel="stylesheet" href="bootstrap/Overlay-Bootstrap/overlay-bootstrap.min.css">
  	<link rel="stylesheet" href="css/style.css"> <!-- Gem style -->
  	<title>ShowBug</title>
  	<style >
  	.square3
  	{
  		width:155px;
  		height: 300px;
  		border:1px solid black;
  	}
  </style>
</head>
<body>
	<?php 
	include 'connect.php';
	$address = array();
	$name = array();
	$language = array();
	
	$directors = array();
	$actors = array();
	if(isset($_GET['variable']))
	{
		$ID = $_GET['variable'];
		$query = "SELECT * FROM `Shows` WHERE Show_ID = '".$ID."'"; 		
		$result = $con->query($query);
		$result->data_seek(0);
		$row = $result->fetch_assoc();
		$Poster1 = $row[Poster1];
		$Poster2 = $row[Poster2];
		$Title = $row[Title];
		$Language = $row[Language];
		$Movie_type = $row[Movie_type]; 
		$Release_Date = $row[Release_Date];
		$Duration = $row[Duration];
		$Certifiication = $row[Certification];

		$query = "SELECT * FROM Actors,Acts_in WHERE Show_ID = '".$ID."' and Actors.Actor_ID = Acts_in.Actor_ID"; 		
		$result = $con->query($query);
		$result->data_seek(0);
		$a = 1;
		$Actor_Name = array();
		$Actor_img = array();
		while($row = $result->fetch_assoc())
		{
			$Actor_Name[$a] = $row[Actor_Name];
			$Actor_img[$a] = $row[Actor_Img];
			$a++;
		}
		$a--;

		$query = "SELECT * FROM `Directors` WHERE Show_ID = '".$ID."'"; 		
		$result = $con->query($query);
		$result->data_seek(0);
		$d = 1;
		$Director_Name = array();
		while($row = $result->fetch_assoc())
		{
			$Director_Name[$d] = $row[Director_Name];
			$d++;
		}
		$d--;

		$query = "SELECT * FROM `Genre` WHERE Show_ID = '".$ID."'" ; 		
		$result = $con->query($query);
		$result->data_seek(0);
		$g = 1;
		$genre = array();
		while($row = $result->fetch_assoc())
		{
			$genre[$g] = $row[Genre_Type];
			$g++;
		}
		$g--;
	}
	?>

	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
          <a href="home.php"><img src="logo.jpg" width="20%"></a>
				
			</div>
			<ul class="nav navbar-nav navbar-right main-nav" style="margin-top: 5px;">
				<li><div style="margin-top: 15px;font-size: 20px; color: white;"> Welcome</div></li>
				<li><a href="login.php">Sign in</a></li>
			</ul>
		</div>
	</nav>

	<div style="margin-top: 55px;">
		<img src=<?php echo $Poster1; ?> width="100%" height="450px;">
		<div style="position: absolute;left: 50px;top: 355px; z-index: 1;" >
			<img src=<?php echo $Poster2; ?> height="250px" width="250px">
		</div>
		<div style="position: absolute;left: 325px;top: 355px; color: lightgrey	 ">
			<div style="font-size: 50px; font-weight: bold; color: white;">
				<?php echo $Title; ?>
			</div>
			<span class="glyphicon glyphicon-calendar"> <?php echo $Release_Date; ?> </span> &nbsp &nbsp &nbsp <span class="glyphicon glyphicon-time"> 	<?php echo $Duration; ?> </span>
			<br>
		</div>
		<div style="background-color: grey; position: absolute;top: 448px; width: 100%;">
			<div style="font-size: 25px; font-style: italic; margin-left: 325px;padding-top: 10px;padding-bottom: 10px;" >
				<div class="btn btn-2-primary">Action</div> <div class="btn btn-2-primary">Comedy</div> <div class="btn btn-2-primary">Romance</div>		
				<br>
			</div>
		</div>
		<div style="margin-left: 325px;margin-top: 20px; font-size: 20px; font-family: Times New Roman">
			<span style="font-style: italic;"><?php echo $Language; ?></span> &nbsp &nbsp &nbsp
			<span style="font-weight: bold;"> <?php echo $Movie_type; ?></span>
			<br>
			<span style="border:1px solid grey; border-radius: 25px; background-color: grey;color: white;">&nbsp<?php echo $Certifiication;?>&nbsp</span>
			<span style="float: right;margin-right: 50px;"><b>Directors:</b>
				<?php while($d>=1) {echo "<i>".$Director_Name[$d].",</i>"; $d--;}?>
			</span>
		</div>

		<div class="container-fluid" style="margin-top: 50px;">
			<div class="well well-sm" style="font-size: 20px;font-weight: bold;font-family: Georgia"> 
				Cast
			</div>
			<div class="row" style="font-weight: bold; color: #444">
				<?php while($a>=1) {?>
				<div class="col-sm-2"><center><img src=<?php echo $Actor_img[$a];?> class="img-circle" width="150px" height="150px"><br> <?php echo $Actor_Name[$a];?> </center></div>
				<?php $a--;}?>
			</div>
		</div>

	</div>
<?php include 'footer.php';?>
</body>
</html>