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
  </head>
  <body>
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
<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <ul class="nav navbar-nav">
         <li class="active"><a href="movies1.php?uid=<?php echo $uid;?>">MOVIES</a></li>
         <li><a href="plays1.php?uid=<?php echo $uid;?>">PLAYS</a></li>
       </ul>
       <ul class="nav navbar-nav navbar-right main-nav" style="margin-top: 5px;">
        <li><div style="margin-top: 15px;font-size: 20px; color: white;"> Welcome <?php echo $uname; ?></div></li>
        <li><a href="home.php">Sign out</a></li>
    </ul>
  </div>
</nav>

<div class="carousel slide" id="featured"  data-ride="carousel" data-interval="2000">

  <ol class="carousel-indicators">
    <li data-target="#featured" data-slide-to="0"></li>
    <li data-target="#featured" data-slide-to="1"></li>
    <li data-target="#featured" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner" style="position:relative;margin-top: 35px;" >
    <div class="item active" >
      <?php 
      $query = "SELECT * FROM `Shows` WHERE Release_Date < '2017-09-01' ORDER BY Release_Date DESC LIMIT 3 ";   
      $result = $con->query($query);
      $result->data_seek(0);  
      $i=1;
      while($row = $result->fetch_assoc()){       
        $address[$i] = $row[Poster1];
        $name[$i] = $row[Title];
        $i++;
      }
      ?>
      <img src=<?php echo $address[1] ?> alt=<?php echo $name[1] ?> width="100%" style="height:460px;">
    </div>
    <div class="item">
      <img src=<?php echo $address[2] ?> alt=<?php echo $name[2] ?> width="100%" style="height:460px">
    </div>
    <div class="item">
      <img src=<?php echo $address[3] ?> alt=<?php echo $name[3] ?> width="100%" style="height:460px">
    </div>   
    <form action="" method="POST" style="margin-left: 20%; position: absolute;top: 20px;width:60%; "> 
      <div class="input-group">
       <input type="text" class="form-control" style="height: 50px;" placeholder="   Search Movies Here" name="Search" id="txtSearch"/>
       <div class="input-group-btn">
        <button class="btn btn-primary" type="submit" name="submit" value="submit" style="height: 50px;width: 60px;">
         <span class="glyphicon glyphicon-search" ></span>
       </button>
     </div>
   </div>
 </form>
</div>
<?php
//$pattern = '%';
$pattern = $_POST['Search'];
//$pattern .= '%';
if(isset($_POST[submit]))
{
  $query = "CALL patternmatch('".$pattern."','Movie')";
  $result = $con->query($query);
  $result->data_seek(0);  
  $i=1;
  while($row = $result->fetch_assoc()){       
    $address[$i] = $row[Poster1];
    $name[$i] = $row[Title];
    $language[$i] = $row[Language];
    $ID[$i] = $row[Show_ID];
    $i++;
    $j = (int) ($i/4);

    $b = 1;
  }if($i==1){
  echo "<br><center>No results Found!</center>";
  }
  else {  ?>

<div style="margin:20px;">
  <?php $l=1; while($l <= $j+1){?> 
  <div class="row"  >
    <?php $k=1; while($k<=4 && $b < $i){?>
    <div class="col-md-3">
      <div class="square2">
        <div class="square">
          <img src=<?php echo $address[$b]; ?>  class="blockimages">
          <div class="overlay">
            <a href="info.php?variable=<?php echo $ID[$b]; ?>&uid=<?php echo $uid; ?>" class="info"><span class="glyphicon glyphicon-info-sign"></span> Info</a>
          </div>
          <div class="details">
            <b><?php echo $name[$b]; ?></b><br>
            <i><?php echo $language[$b]; ?></i>
          </div>   
        </div>
        <a href="booknow.php?variable=<?php echo $ID[$b]; ?>&uid=<?php echo $uid; ?>" class="btn btn-primary btn-my-primary">Book Now</a>
      </div>
    </div>
    <?php $k++; $b++; }?>
  </div>
  <br>
  <?php  $l++; }}}else{ ?>
</div>
<br>




<a class="left carousel-control" href="#featured" role="button" data-slide="prev">
  <span class="glyphicon glyphicon-chevron-left"></span>
</a>
<a class="right carousel-control" href="#featured" role="button" data-slide="next">
 <span class="glyphicon glyphicon-chevron-right "></span>
</a>
</div>
<?php  

$selected_langauage = "English";
if(isset($_POST['English'])){
  $selected_langauage = "English";
}
elseif (isset($_POST['Hindi'])) {
  $selected_langauage = "Hindi";
}
elseif (isset($_POST['Marathi'])){
  $selected_langauage = "Marathi";
}
$query = "SELECT * FROM `Shows` WHERE Language = '".$selected_langauage."' and Movie_type != 'Play' and Release_Date < '2017-09-01' ";   
$result = $con->query($query);
$result->data_seek(0);  
$i=1;
while($row = $result->fetch_assoc()){       
  $address[$i] = $row[Poster1];
  $name[$i] = $row[Title];
  $language[$i] = $row[Language];
  $ID[$i] = $row[Show_ID];
  $i++;
  $j = (int) ($i/4);

  $b = 1;
}
?>
<h1 class="well well-sm" style="text-align: center;"> Movies</h1>
<ul class="nav nav-tabs">
  <form action="" method="POST">
    <button class="btn btn-2-primary" name = "English" value = "English" >English</button>
    <button class="btn btn-2-primary" name = "Hindi" value = "Hindi" onclick="document.getElementById('lab').innerHTML='Hindi'">Hindi</button>
    <button class="btn btn-2-primary" name = "Marathi" value = "Marathi" onclick="document.getElementById('lab').innerHTML='Marathi'">Marathi</button>
  </form>
</ul>


<div style="margin:20px;">
  <?php $l=1; while($l < $j+1){?> 
  <div class="row"  >
    <?php $k=1; while($k<=4 && $b < $i){?>
    <div class="col-md-3">
      <div class="square2">
        <div class="square">
          <img src=<?php echo $address[$b]; ?>  class="blockimages">
          <div class="overlay">
            <a href="info.php?variable=<?php echo $ID[$b]; ?>&uid=<?php echo $uid; ?>" class="info"><span class="glyphicon glyphicon-info-sign"></span> Info</a>
          </div>
          <div class="details">
            <b><?php echo $name[$b]; ?></b><br>
            <i><?php echo $language[$b]; ?></i>
          </div>   
        </div>
        <a href="booknow.php?variable=<?php echo $ID[$b]; ?>&uid=<?php echo $uid; ?>" class="btn btn-primary btn-my-primary">Book Now</a>
      </div>
    </div>
    <?php $k++; $b++; }?>
  </div>
  <br>
  <?php  $l++; } ?>
</div>
<br>
<?php }?>
<script>
  function sendForm(e){
  e.preventDefault();
}

</script>

    <script src="bootstrap/jquery-3.2.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/main.js"></script> <!-- Gem jQuery -->
    <script src="js/modernizr.js"></script> <!-- Modernizr -->
<?php include 'footer.php';?>
  </body>
  </html>
