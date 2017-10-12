	<!DOCTYPE html>
	<html lang="en">
	<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/Overlay-Bootstrap/overlay-bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css"> <!-- Gem style -->

		<title>BookATicket</title>
	</head>
	<body>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<link rel="stylesheet"
		href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
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
         <li class="active"><a href="vendor.php?uid=<?php echo $uid;?>">My Shows</a></li>
         <li ><a href="index1.php?uid=<?php echo $uid;?>">Statistics</a></li>
       </ul>
				<ul class="nav navbar-nav navbar-right">
					<li style="margin-top: 15px; color: white;">
						Welcome <?php echo $uname; ?>
					</li>
					<li>
						<a href="home.php">
							<span class="glyphicon glyphicon-log-out"></span> Logout
						</a>
					</li>
				</ul>
			</div>
		</nav>

		<div style="margin-top: 100px;">
			<div class="row">
				<div class="col-sm-1 col-md-1 col-lg-1">
				</div>
				<div class="col-sm-10">
					<div>
						<?php
						
						$query = "SELECT T_ID,Name,Capacity,S_ID,City,State,Theater.PIN  FROM Theater,Location WHERE Vendor_ID='".$uid."' and Theater.PIN=Location.PIN ";
						$result = $con->query($query);
						$result->data_seek(0);
						$i=1;
						$Theater = array();
						$Name = array();
						$Cap = array();
						$Screen = array();
						$City = array();
						$State = array(); 
						$Time = array();
						$Date = array();
						$Booked = array();
						$PIN = array();
						$shows = array();
						while($row=$result->fetch_assoc()){
							$Name[$i] = $row[Name];
							$Cap[$i] = $row[Capacity];
							$Screen[$i] = $row[S_ID];
							$City[$i] = $row[City];
							$State[$i] = $row[State]; 
							$PIN[$i] = $row[PIN];
							$Theater[$i] = $row[T_ID];
							$i++;
						} 

						$l=1;
						$j=1;$k=1;
						while($j<$i) { 
							$query = "SELECT SD_ID,Show_Time,Show_Date,Title  FROM Show_Details,Shows WHERE Show_Details.T_ID='".$Theater[$j]."' and Show_Details.S_ID='".$Screen[$j]."'  and Show_Details.Show_ID=Shows.Show_ID ";
							$result = $con->query($query);
							$result->data_seek(0); 

							?> 
							
							<!--Edit info -->
							<div id="info<?php echo $j;?>" style="display: none;">
								<?php 
								if(isset($_POST['save3'][$Theater[$j]][$Screen[$j]])){
									$showname = $_POST['show'];
									$date = $_POST['date1'];
									$time = $_POST['time1'];
									$q2 = "SELECT Show_ID FROM Shows WHERE Title = '".$showname."'";
									$r2 = $con->query($q2);
									$a = $r2->fetch_assoc();
									$showid = $a[Show_ID];
									$q2 = "INSERT INTO Show_Details VALUES(NULL,'".$time."','".$date."','".$showid."','".$Theater[$j]."','".$Screen[$j]."')";
									$r2 = $con->query($q2);
									$query9= "SELECT SD_ID FROM Show_Details WHERE Show_Time='".$time."' and Show_Date ='".$date."' and Show_ID='".$showid."' and T_ID='".$Theater[$j]."' and S_ID='".$Screen[$j]."'";
									$result9 = $con->query($query9);
									$row9 = $result9->fetch_assoc();
									$sdiid = $row9[SD_ID];

									$q1 = "INSERT INTO Price_Table VALUES(".$sdiid.",".$_POST['platinum']."),(".$sdiid.",".$_POST['gold']."),(".$sdiid.",".$_POST['silver'].")";
									$r1 = $con->query($q1);
									
								}

								?>
								<form action= "" method="POST" >
									<table class="table">
										<tr>
											<th>Theater ID : <?php echo $Theater[$j]; ?> </th>
											<th>Screen ID: <?php echo $Screen[$j]; ?></th>
										</tr>
										<tr>
											<th>TheaterName: <?php echo $Name[$j]; ?></th>
											<th>Capacity: <?php echo $Cap[$j]; ?></th>
											<th>City: <?php echo $City[$j]; ?></th>
											<th>State: <?php echo $State[$j]; ?></th>
											<th>PIN: <?php echo $PIN[$j]; ?> </th>
										</tr>
										
										
										
										<?php 
										$result = $con->query($query);
										$result->data_seek(0);  	
										while($row=$result->fetch_assoc()){
											$sdid = $row[SD_ID];
											?>
											<tr>
												<th>Show ID: <?php echo $row[SD_ID]; ?></th>
												<th>Show: <?php echo $row[Title]; ?></th>
												<th>Date: <?php echo $row[Show_Date]; ?></th>
												<th>Time: <?php echo $row[Show_Time]; ?></th>
												<?php $q= "SELECT Seat_no FROM Booking_Details WHERE Booking_Details.SD_ID = ".$row[SD_ID]."  ";
												$r = $con->query($q);
												?>
												<?php if($r->num_rows>0){ ?>
												<th>Booked: <?php echo $r->num_rows; ?></th>
												<?php }else { ?>
												
												<th> <a href = "showdelete.php?var=<?php echo $sdid; ?>&uid=<?php echo $uid; ?>"  onclick="return theFunction();"><span style="color: red;"> Delete </span></a></th>
												

												<?php }?>
											</tr>
											<?php $k++;}?>
											



										</table>
										<button class="btn btn-2-primary" style="width: 40%;float: left;" id="addshowid" onclick=funcabc1('<?php echo $j;?>') >Add Show</button>




										<!--Add Show -->
										<div id="infoa<?php echo $j;?>" style="display: none;">
											
											<table class="table">
												<tr>
													<th>
														<label for="show2">Show:</label>
														<select class="form-control" id="showid2" name="show">
															<?php
															$name1 = array();
															$ID1 = array();
															$query1 = "SELECT * FROM `Shows` WHERE Release_Date < '2017-09-01' ORDER BY Title";     
															$result1 = $con->query($query1);
															$result1->data_seek(0);
															$m = 1;
															while($row1 = $result1->fetch_assoc()){     
																$name1[$m] = $row1[Title];
																$ID1[$m] = $row1[Show_ID];
																$m++;
															}  
															$m--;
															?>

															<?php while($m>=1){?>
															<option><?php echo $name1[$m]; ?></option>
															<?php $m--; }?>
														</select>
													</th>
													<th>
														<label for="tim2">Time:</label><input required="" name="time1" type="Time" class="form-control">
													</th>
													<th>
														<label for="dat2">Date:</label><input required="" name="date1" type="Date" class="form-control" >
													</th>
												</tr>
												<tr>
											<th> Ticket Prices:</th>
										<th><label for="dat2">PLATINUM:</label><input required="" type="number"  name="platinum" class="form-control" id="dat2"></th>
											<th><label for="tim2">GOLD:</label><input required="" type="number" name="gold" class="form-control" id="tim2"></th>
											<th><label for="dat2">SILVER:</label><input required="" type="number"  name="silver" class="form-control" id="dat2"></th>
										</tr>
											</table>
											<button class="btn btn-2-primary" style="width: 40%;float: right;" id="addshowid" onclick=funcabc2('<?php echo $j;?>') >Back</button>
											<button class="btn btn-2-primary" style="width: 40%;float: left;" id="addshowid" name="save3[<?php echo $Theater[$j];?>][<?php echo $Screen[$j];?>]" >Save</button>
											
										</div>
										


										<br><br>

										<button class="btn btn-primary" style="width: 100%" name="save[<?php echo $j;?>]" value="save"  id="Editid" onclick=savefunc('<?php echo $j;?>') >Done!</button>

										<br><br>
									</form>

								</div>





								<!--Theater+Shows Info -->
								<div id="<?php echo $j;?>" style="display: block;" >
									<table class="table"><tr>
										<th>Theater ID : <?php echo $Theater[$j]; ?> </th>
										<th>Screen ID: <?php echo $Screen[$j]; ?></th>
										<th> </th>
										<th><th> <a href = "screendelete.php?var1=<?php echo $Theater[$j]; ?>&var2=<?php echo $Screen[$j]; ?>&uid=<?php echo $uid; ?>"  ><span style="color: red;"> Delete </span> </a></th> </th>
									</tr>
									<tr>
										<th>TheaterName: <?php echo $Name[$j]; ?></th>
										<th>Capacity: <?php echo $Cap[$j]; ?></th>
										<th>City: <?php echo $City[$j]; ?></th>
										<th>State: <?php echo $State[$j]; ?></th>
										<th>PIN: <?php echo $PIN[$j]; ?> </th>
									</tr>
									<?php $result = $con->query($query);
									$result->data_seek(0);  	while($row=$result->fetch_assoc()){?>
									<tr>
										<th>Show: <?php echo $row[Title]; ?></th>
										<th>Date: <?php echo $row[Show_Date]; ?></th>
										<th>Time: <?php echo $row[Show_Time]; ?></th>
										<?php $q= "SELECT Seat_no FROM Booking_Details WHERE Booking_Details.SD_ID = ".$row[SD_ID]."  ";
										$r = $con->query($q);
										?>
										<th>Booked: <?php echo $r->num_rows; ?></th>
									</tr>
									<?php $k++;}?>
								</table>

								<button class="btn btn-primary" style="display:bold;width: 100%" id="Editid" onclick=func('<?php echo $j;?>')>Edit</button><br><br>
							</div>
							<?php $j++; } ?>




							<!--Add Theater -->
							<div id="paraid" style="display: none;">
								<form action= "" method = "POST">
									<table class='table'>
										<tr>
											<th><label for="th2">Theater Name:</label><input required="" type="text" class="form-control" name = "name" id="th2"></th>
											<th><label for="cap2">Capacity:</label><input required="" type="text" name="cap" class="form-control" id="cap2"></th>
											<th><label for="pin2">PIN:</label><input required="" type="text" name="pin" class="form-control" id="pin2"></th>
										</tr>
										<tr>
											<th><label for="sid2">Screen:</label><input required="" type="text" name="screen" class="form-control" id="sid2"></th>
											<th>
												<div class="form-group">
													<label for="show2">Show:</label>
													<select class="form-control" id="showid2" name="show">
														<?php
														$name = array();
														$query = "SELECT * FROM `Shows` WHERE Release_Date < '2017-09-01' ORDER BY Title";     
														$result = $con->query($query);
														$result->data_seek(0);
														$i = 1;
														while($row = $result->fetch_assoc()){     
															$name[$i] = $row[Title];
															$ID[$i] = $row[Show_ID];
															$i++;
														}  
														$i--;
														?>
														<?php while($i>=1){?>
														<option><?php echo $name[$i]; ?></option>
														<?php $i--; }?>
													</select>
												</div>
											</th>
											<th><label for="dat2">Date:</label><input required="" type="Date"  name="date" class="form-control" id="dat2"></th>
											<th><label for="tim2">Time:</label><input required="" type="Time" name="time" class="form-control" id="tim2"></th>
										</tr>
										<tr>
											<th> Ticket Prices:</th>
										<th><label for="dat2">PLATINUM:</label><input required="" type="number"  name="platinum" class="form-control" id="dat2"></th>
											<th><label for="tim2">GOLD:</label><input required="" type="number" name="gold" class="form-control" id="tim2"></th>
											<th><label for="dat2">SILVER:</label><input required="" type="number"  name="silver" class="form-control" id="dat2"></th>
										</tr>
									</table>
									<div class="row">
										<div class="col-sm-4"></div>
										<div class="col-sm-4">
											<button style='display: bold; width: 100%;' class='btn btn-primary' id='submitid' name="submit"  value = "submit" >Submit</button><br><br>
										</div>
									</div>
								</form>
								<?php
								if(isset($_POST['submit']))
								{
									$query = "SELECT T_ID FROM Theater ORDER BY T_ID DESC LIMIT 1";
									$result = $con->query($query);
									$row = $result->fetch_assoc();
									$tid = $row[T_ID];
									$tid++;
									$sid= $_POST['screen'];
									$Name= $_POST['name'];
									$Capacity= $_POST['cap'];
									$PIN= $_POST['pin'];
									$Vendor_ID= $uid;
									$Show_Date= $_POST['date'];
									$Show_Time= $_POST['time'];
									$query = "SELECT Show_ID FROM `Shows` WHERE Title= '".$_POST[show]."'";
									$result = $con->query($query);
									$row = $result->fetch_assoc();
									$Show_ID = $row[Show_ID];

									$query= "INSERT INTO Theater values(".$tid.",".$sid.",'".$Name."',".$Capacity.",".$PIN.",".$Vendor_ID.")";
									$result = $con->query($query);
									$query = "CALL addseats(".$tid.",".$sid.",".$Capacity.")";
									$result = $con->query($query);
									$query= "INSERT INTO Show_Details values(NULL,'".$Show_Time."','".$Show_Date."',".$Show_ID.",".$tid.",".$sid.")";
									$result = $con->query($query);
									$query= "SELECT SD_ID FROM Show_Details WHERE Show_Time='".$Show_Time."' and Show_Date ='".$Show_Date."' and Show_ID=".$Show_ID." and T_ID=".$tid." and S_ID=".$sid."";
									$result = $con->query($query);
									$row = $result->fetch_assoc();
									$sdiid = $row[SD_ID];

									$q1 = "INSERT INTO Price_Table VALUES(".$sdiid.",".$_POST['platinum']."),(".$sdiid.",".$_POST['gold']."),(".$sdiid.",".$_POST['silver'].")";
									$r1 = $con->query($q1);
								}

								?>
							</div>
						</div>



						<!-- Add screen -->
						<div id="infob" style="display: none;">
							
							<?php 
							if(isset($_POST['adds'])){
								$q4 = "SELECT DISTINCT Name,PIN FROM Theater WHERE T_ID='".$_POST['theater']."'";
								
								$r4 = $con->query($q4);
								$row4 = $r4->fetch_assoc();

								$q5="INSERT INTO Theater VALUES('".$_POST['theater']."','".$_POST['scrid']."','".$row4[Name]."','".$_POST['cap']."','".$row4[PIN]."','".$uid."')";
								
								$r5 = $con->query($q5);
								$query6 = "CALL addseats('".$_POST['theater']."','".$_POST['scrid']."','".$_POST['cap']."')";
								$result6 = $con->query($query6);
								header('Location:vendor.php?uid='.$uid);
							}
							?>
							<form acction="" method="POST">
								<table class="table">
									<tr>
										<th><div class="form-group">
											<label for="show2">Theater:</label>
											<select class="form-control" id="showid2" name="theater">
												<?php
												$name = array();
												$query = "SELECT DISTINCT T_ID FROM `Theater` WHERE Vendor_ID = '".$uid."'";     
												$result = $con->query($query);
												$result->data_seek(0);
												?>
												<?php while($row = $result->fetch_assoc()){?>
												<option><?php echo $row[T_ID]; ?></option>
												<?php $i--; }?>
											</select>
										</div> </th>
										<th><label for="scr">Screen ID:</label><input required="" type="text" name="scrid" class="form-control" id="scr"></</th>
										<th><label for="cap">Capacity:</label><input required="" type="text" name="cap" class="form-control" id="cap"></</th>
									</tr>

								</table>
								<div class="row">
									<div class="col-sm-6"></div>
									<div class="col-sm-4">
										
										<button class="btn btn-2-primary" name="adds" style="width: 100%">submit</button>
									</div>
								</form>
								
								
							</div>
						</div>

					</div>
					<div class="row">
						<div class="col-sm-2"></div>
						<div class="col-sm-4">
							<button style="display: bold; width: 100%;" class="btn btn-primary" id="btnid" onclick=myfunc()>Add Theater</button></div>
							<div class="col-sm-4">
								<button style="display: bold; width: 100%;" class="btn btn-primary" id="btnid2" onclick=myfunc2()>Add Screen</button>
							</div>
						</div>
					</div>



					<script>
						var i=1;
						var j=1;
						function funcabc1(val)
						{
							document.getElementById('infoa'+val).style.display = "block";
							document.getElementById('info'+val).style.display = "block";
							document.getElementById(val).style.display = "none";
						}
						function funcabc2(val)
						{
							document.getElementById('infoa'+val).style.display = "none";
							document.getElementById('info'+val).style.display = "block";
							document.getElementById(val).style.display = "block";
						}
						function savefunc(val)
						{
							document.getElementById('infoa'+val).style.display = "none";
							document.getElementById('info'+val).style.display = "none";
							document.getElementById(val).style.display = "block";
						}
						function func(val)
						{
							document.getElementById('info'+val).style.display = "block";
							document.getElementById(val).style.display = "none";
						}

						function myfunc()
						{
							document.getElementById('paraid').style.display = "block";
							i++;
							if(i%2==0)
							{
								document.getElementById('btnid').style.display="none";
							}

						}
						function myfunc2()
						{
							document.getElementById('infob').style.display = "block";
							i++;
							if(i%2==0)
							{
								document.getElementById('btnid2').style.display="none";
							}

						}
						function myfunc3()
						{
							document.getElementById('infob').style.display = "none";
							i++;
							if(i%2==0)
							{
								document.getElementById('btnid2').style.display="block";
							}

						}
					</script>

					<script src="bootstrap/jquery-3.2.1.min.js"></script>
					<script src="bootstrap/js/bootstrap.min.js"></script>

    <script src="js/main.js"></script> <!-- Gem jQuery -->
    <script src="js/modernizr.js"></script> <!-- Modernizr -->
    <br><br>
<?php include 'footer.php';?>
					
				</body>
				</html>