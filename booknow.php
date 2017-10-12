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
		<link rel="stylesheet" href="style.css">
		<title>ShowBug</title>
	</head>
	<body>
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container-fluid">
				<ul class="nav navbar-nav">
					<li class="active"><a href="movies1.php?uid=<?php echo $uid;?>">MOVIES</a></li>
         <li><a href="plays1.php?uid=<?php echo $uid;?>">PLAYS</a></li>
       </ul>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					        <li><div style="margin-top: 15px;font-size: 20px; color: white;"> Welcome <?php echo $uname; ?></div></li>
        <li><a href="home.php">Sign out</a></li>
				</ul>
			</div>
		</nav>
		<div>
			<br><br>
			<?php if(isset($_GET['variable']))
			{
				$ID = $_GET['variable'];
				$query = "SELECT * FROM `Shows` WHERE Show_ID = '".$ID."'"; 		
				$result = $con->query($query);
				$result->data_seek(0);
				$row = $result->fetch_assoc();
				$a = $row[Poster1];
				$n = $row[Title];
			} ?>
			<img src=<?php echo $a;?> width="100%" style="height: 400px;">	
			<div class="namebox"> <center style="font-size: 30px;font-family:Georgia"> <?php echo $n;?> </center></div>
		</div> 
		<br>
		<div class="row">
			<div class="col-sm-1">
			</div>
			<div class="col-sm-10">
				<div >
					<?php
					$theater=array();
					$time=array();
					$name=array();
					$i=1;
					$j=1;
					$query = "SELECT DISTINCT Show_Details.T_ID,Show_ID,Theater.Name FROM Show_Details,Theater WHERE Show_ID = '".$ID."' and Theater.T_ID=Show_Details.T_ID "; 		
					$result = $con->query($query);
					$result->data_seek(0);
					while($row = $result->fetch_assoc()){
						$theater[$i] = $row[T_ID];
						$name[$i] = $row[Name];
						$i++;
					}
					?>
					<br/>
					<?php $k=1; while($k<$i){?>
					<div class="row container-fluid" >
						<div class="col-sm-3">
							
							<?php echo $name[$k];?>
						</div>
						<?php 
						$query = "SELECT  SD_ID,Show_Time from Show_Details WHERE Show_ID= '".$ID."' and  T_ID='".$theater[$k]."' "; 		
						$result = $con->query($query);
						$result->data_seek(0);
						?>
						<div>
							<?php while($row = $result->fetch_assoc()){  ?>
							<a href="seats.php?variable=<?php echo $row[SD_ID];?>&uid=<?php echo $uid; ?>" class="btn btn-default" style="width: 100px;"><?php echo $row[Show_Time];?></a>
							<?php }?>
						</div>
						
					</div>
					<hr style="border: 1px solid #222" />
					<?php  $k++;}?>
					<br/>
				</div>
			</div>
		</div>



	</body>
	</html>