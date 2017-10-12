  
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/Overlay-Bootstrap/overlay-bootstrap.min.css">
    <link rel="stylesheet" href="css/reset.css"> <!-- CSS reset -->
    <link rel="stylesheet" href="css/style.css"> <!-- Gem style -->

    <title>ShowBug</title>
  </head>
  <body>
    <?php
    header('Cache-Control: no-cache, must-revalidate');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
    include 'connect.php';
    $address = array();
    $name = array();
    $language = array();
    $ID = array();
    ?> 
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <a href="home.php"><img src="logo.jpg" width="18%"></a>
        </div>
        <ul class="nav navbar-nav navbar-right">
          <li>
            <a href="login.php">
              <span class="glyphicon glyphicon-user"></span> Login User
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <div class="carousel slide" id="featured" data-ride="carousel" data-interval="2000">

      <ol class="carousel-indicators">
        <li data-target="#featured" data-slide-to="0"></li>
        <li data-target="#featured" data-slide-to="1"></li>
        <li data-target="#featured" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner" style="margin-top: 50px;" >
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
  </div>

  <a class="left carousel-control" href="#featured" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
  </a>
  <a class="right carousel-control" href="#featured" role="button" data-slide="next">
   <span class="glyphicon glyphicon-chevron-right "></span>
 </a>
</div>
<br>
<br>


  <form action="" method="POST" style="margin-left: 20%"> 
    <div class="row">
      <div class="col-md-9 col-md-9">
       <div class="input-group">
         <input type="text" class="form-control" name="Search" placeholder="Search Movies or Plays Here" id="txtSearch"/>
         <div class="input-group-btn">
          <button class="btn btn-primary" name= "submit" value="submit" type="submit">
           <span class="glyphicon glyphicon-search"></span>
         </button>
       </div>
     </div>
   </div>
 </div>
</form>
<?php
$pattern = '%';
$pattern .= $_POST['Search'];
$pattern .= '%';
if(isset($_POST[submit]))
{
  $query = "SELECT * FROM Shows WHERE Title LIKE '".$pattern."' OR Language LIKE '".$pattern."' and Release_Date < '2017-09-01'";
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
            <a href="info1.php?variable=<?php echo $ID[$b]; ?>" class="info"><span class="glyphicon glyphicon-info-sign"></span> Info</a>
          </div>
          <div class="details">
            <b><?php echo $name[$b]; ?></b><br>
            <i><?php echo $language[$b]; ?></i>
          </div>   
        </div>
        <a href="login.php" class="btn btn-primary btn-my-primary">Book Now</a>
      </div>
    </div>
    <?php $k++; $b++; }?>
  </div>
  <br>
  <?php  $l++; }}}else{ ?>
</div>
<br>





<br>
<br>
<br>
<h1 class="well well-sm" style="font-size: 35px;"> Featured Now </h1>
<div class="carousel slide container-fluid" id="recommended" data-ride="carousel" data-interval="3500">
  <div class="carousel-inner">
   <?php 
   $query = "SELECT * FROM `Shows` WHERE Release_Date < '2017-09-01'";     
   $result = $con->query($query);
   $result->data_seek(0);  
   $i = 1;
   while($row = $result->fetch_assoc()){     
    $address[$i] = $row[Poster1];
    $name[$i] = $row[Title];
    $language[$i] = $row[Language];
    $ID[$i] = $row[Show_ID];
    $i++;
  }
  $j = (int) ($i/4);
  $b = 1;
  ?>  
  <div class="item active">
    <div class="row">
      <?php $k=1; while($k<=4){?>

      <div class="col-md-3">
          <div class="square">
            <img src=<?php echo $address[$b]; ?> alt=<?php echo $name[$b]; ?>   class="blockimages">
            <div class="overlay">
              <a href="info1.php?variable=<?php echo $ID[$b]; ?>" class="info"><span class="glyphicon glyphicon-info-sign"></span> Info</a>
            </div>
            <div class="bold">
              <?php echo $name[$b]; ?><br>
            </div>
            <div class="italics">
              <?php echo $language[$b]; ?>
            </div>   
          </div>
      </div>

      <?php  $b++; $k++; }?>
    </div>
  </div>
  <?php $l=1; while($l <= $j){?>   
  <div class="item">
    <div class="row">
      <?php $k=1; while($k <= 4 && $b < $i ){?>

      <div class="col-md-3">
          <div class="square">
            <img src=<?php echo $address[$b]; ?> alt=<?php echo $name[$b]; ?>   class="blockimages">
            <div class="overlay">
              <a href="info1.php?variable=<?php echo $ID[$b]; ?>" class="info"><span class="glyphicon glyphicon-info-sign"></span> Info</a>
            </div>
            <div class="bold">
              <?php echo $name[$b]; ?><br>
            </div>
            <div class="italics">
              <?php echo $language[$b]; ?>
            </div>  
          </div>
      </div>

      <?php $b++; $k++; }?>
    </div>
  </div>
  <?php  $l++; } ?>
  <a class="left carousel-control" href="#recommended" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
  </a>
  <a class="right carousel-control" href="#recommended" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right "></span>
  </a>
</div>
</div>
<br>
<h1 class="well well-sm" style="font-size: 35px;">Coming Soon</h1>
<div class="carousel slide container-fluid" id="comingsoon" data-ride="carousel" data-interval="3500">
  <div class="carousel-inner">
   <?php 
   $query = "SELECT * FROM `Shows` WHERE Release_Date > '2017-09-01' ORDER BY Release_Date"; 		
   $result = $con->query($query);
   $result->data_seek(0);	
   $i = 1;
   while($row = $result->fetch_assoc()){			
     $address[$i] = $row[Poster1];
     $name[$i] = $row[Title];
     $language[$i] = $row[Language];
     $ID[$i] = $row[Show_ID];
     $i++;
   }
   $j = (int) ($i/4);

   $b = 1;
   ?>	
   <div class="item active">
     <div class="row">
      <?php $k=1; while($k<=4){?>

      <div class="col-md-3">

        <div class="square">
          <img src=<?php echo $address[$b]; ?> alt=<?php echo $name[$b]; ?>   class="blockimages">
          <div class="overlay">
            <a href="info1.php?variable=<?php echo $ID[$b]; ?>" class="info"><span class="glyphicon glyphicon-info-sign"></span> Info</a>
          </div>
          <div class="bold">
            <?php echo $name[$b]; ?><br>
          </div>
          <div class="italics">
            <?php echo $language[$b]; ?>
          </div>  
        </div>


      </div>

      <?php $b++; $k++; }?>
    </div>
  </div>
  <?php $l=1; while($l < $j){?>		
  <div class="item">
   <div class="row">
    <?php $k=1; while($k <= 4 && $b < $i ){?>

    <div class="col-md-3">
      <div class="square">
        <img src=<?php echo $address[$b]; ?> alt=<?php echo $name[$b]; ?>   class="blockimages">
        <div class="overlay">
          <a href="info1.php?variable=<?php echo $ID[$b]; ?>" class="info"><span class="glyphicon glyphicon-info-sign"></span> Info</a>
        </div>
        <div class="bold">
          <?php echo $name[$b]; ?><br>
        </div>
        <div class="italics">
          <?php echo $language[$b]; ?>
        </div>  
      </div>

    </div>

    <?php $b++; $k++; }?>
  </div>
</div>
<?php  $l++; } ?>
<a class="left carousel-control" href="#comingsoon" role="button" data-slide="prev">
  <span class="glyphicon glyphicon-chevron-left"></span>
</a>
<a class="right carousel-control" href="#comingsoon" role="button" data-slide="next">
  <span class="glyphicon glyphicon-chevron-right "></span>
</a>
</div>
</div>

<br>

<br>

<?php }?>

  </script>
<script src="bootstrap/jquery-3.2.1.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="js/main.js"></script> <!-- Gem jQuery -->
<script src="js/modernizr.js"></script> <!-- Modernizr -->

<?php include 'footer.php';?>
</body>
</html>

