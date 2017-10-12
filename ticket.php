
<!DOCTYPE html>
<html>
<head>
	<title>My Ticket</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/Overlay-Bootstrap/overlay-bootstrap.min.css">
     <link rel="stylesheet" href="css/style.css">

    <script src="bootstrap/jquery-3.2.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/main.js"></script> <!-- Gem jQuery -->
    <script src="js/modernizr.js"></script>
	<style>
  .c1{
     border-style: solid;
     border-width: 5 px;
     border-color: #FFE16D;
     border-radius: 10px;
     background-color: #FFF3BF;
     width: 40%;
     margin-left: 400px;
     padding:10px;
 }
 .c2{
     border-style: solid;
     border-width: 0 px;
     border-color: #FFE9AB;
     border-radius: 5px;
     background-color: #FFE9AB;
     width: 90%;
     margin-left: 20px;
     padding-left:10px;
 }
 hr {

  border-top:2px dashed #6B6B6B;
  

  height:0px;
  width: 100%;
  
}

</style>
</head>
<body>

  <?php
  include 'connect.php';
  $booked = array();
  $i = 1;
  $uid = $_GET['id'];
  $bdid = array();
 
  $query  = "SELECT * FROM `Booking_Details` WHERE U_ID = '".$uid."' and Booking_Time >= now()- INTERVAL 5 second";
  $result = $con->query($query);
  $result->data_seek(0);
  while($row = $result->fetch_assoc())
  {
    $booked[$i]=$row[Seat_no];
    $sdid=$row[SD_ID];
    $bookingtime= $row[Booking_Time];
    $bdid[$i] = $row[BD_ID];
    $i++;
  }
  $i--;
  $tickets_booked=$i;

  
  $l = $i;
  $j=1; $sum=0;
  while($l>=1){
  $query8 = "SELECT Seats.seat_type+0 FROM Seats,Show_Details,Booking_Details WHERE Booking_Details.SD_ID= ".$sdid." and Booking_Details.Seat_no=".$booked[$l]." AND Booking_Details.SD_ID=Show_Details.SD_ID and Show_Details.T_ID=Seats.T_ID and Show_Details.S_ID=Seats.S_ID and Booking_Details.Seat_no=Seats.Seat_no";
   $result8 = $con->query($query8);
  $result8->data_seek(0);
  $row8 = $result8->fetch_assoc();
  $index = $row8['Seats.seat_type+0'];
   $q1 = "CALL updateprice('".$index."','".$sdid."','".$bdid[$l]."')";
   $r1 = $con->query($q1);
    
   $q2 = "SELECT Show_ID,T_ID,Show_Date FROM Booking_Details,Show_Details WHERE Booking_Details.BD_ID=".$bdid[$l]." and Booking_Details.SD_ID= Show_Details.SD_ID";
   $r2 = $con->query($q2);
   $row5 = $r2->fetch_assoc();   
   $showid = $row5[Show_ID];
   $tid = $row5[T_ID];
   $showdate = $row5[Show_Date];
   
  $q2 = "SELECT Title FROM Booking_Details,Show_Details,Shows WHERE Booking_Details.BD_ID=".$bdid[$l]." and Booking_Details.SD_ID= Show_Details.SD_ID AND Show_Details.Show_ID=Shows.Show_ID";
   $r2 = $con->query($q2);
   $row5 = $r2->fetch_assoc();   
   $title = $row5[Title];
      
 
$q2 = "SELECT Price FROM Booking_Details WHERE BD_ID=".$bdid[$l]."";
   $r2 = $con->query($q2);
   $row5 = $r2->fetch_assoc();
   $price = $row5[Price];

   $q9 = "INSERT INTO Stats (Show_ID,Title,T_ID,Show_Date,Price) VALUES (".$showid.",".$title.",".$tid.",".$showdate.",".$price.")";
   $r9 = $con->query($q9);

   $sum = $sum+$row5[Price];

  $l--;
}


  $query  = "SELECT Shows.Poster1,Shows.Title,Shows.Language,Shows.Movie_type,Shows.Certification,Theater.Name,Show_Details.S_ID,Location.City,Show_Details.Show_Time,Show_Details.Show_Date 
  FROM Show_Details,Theater,Location,Shows
  WHERE SD_ID = '".$sdid."' and Show_Details.T_ID=Theater.T_ID and Show_Details.S_ID=Theater.S_ID and Show_Details.Show_ID=Shows.Show_ID and Theater.PIN=Location.PIN ";
  $result = $con->query($query);
  $result->data_seek(0);
  while($row = $result->fetch_assoc())
  {
    $title=$row[Title];
    $Language=$row[Language];
    $Movie_type=$row[Movie_type];
    $Certification=$row[Certification];
    $Name= $row[Name];
    $S_ID= $row[S_ID];
    $City=$row[City];
    $Show_Time= $row[Show_Time];
    $Show_Date= $row[Show_Date];
    $poster = $row[Poster1];
  }


  ?>

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
 <?php if($tickets_booked==0){ ?>
    <h2 style="text-align: center;"><span style="color: red;">SORRY!! No Tickets Selected!</span></h2>
 <?php   } 
 else{ ?>
    <h1 style="font-family:Arial;text-align: center;">SHOWBUG</h1>
    <div class="c1">
        <h2 style="text-align: center;">Tickets Booked <span style="color: green;"> Successfully </span></h2>
        <p style="text-align: center;">USER ID: <?php echo $uid; ?></p> 
        <div class="c2" style="font-size: 18px;">
           <center>
           <img src=<?php echo $poster ?> alt="Poster" style="width: 80%;height: 20%;">
         </center>
           <span style="float: right;margin-right: 70px;">
              <p><?php echo $title; ?> | <?php echo $Language; ?> |<?php echo "(".$Certification.")"; ?></p>
              <p><?php echo $Show_Time; ?> | <?php echo $Show_Date; ?></p>
              <p><?php echo $Name; ?> | <?php echo $City; ?></p>
          </span>
          <hr>
          <span style="float:right;margin-right: 20px;"> 
            <p><?php echo $tickets_booked; ?> Tickets</p>
            <p></p>
        </span>
        <p>Screen <?php echo $S_ID; ?></p>
        <p><?php
            if($index == 1)
              {echo "Gold"; }
            elseif($index == 2)
              {echo "Silver"; }
            elseif($index == 3)
              {echo "Platinum"; }
         ?>- <?php while($tickets_booked>=1){ echo $booked[$tickets_booked]." |"; $tickets_booked--;}?></p>

    </div>
    <p style="margin-left: 25px;">Amount Paid:<span style="margin-left: 20px"> Rs.<?php echo $sum; ?></span></p>
    <p style="margin-left: 25px;">Booking Date & Time: 2017-09-11 10:32:11</p>
    <hr>
    <p style="text-align: center;">Tickets once booked cannot be exchanged. cancelled or refunded.</p>
    <p style="margin-left:25px;">For Further Assistance Contact: <span style="float: right;margin-right: 20px;">9876543210</span></p>
</div>
<?php 
 }

?>

<center></center><script src="highcharts/code/modules/exporting.js"></script></center>
</body>
</html>