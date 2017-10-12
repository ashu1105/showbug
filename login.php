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
<body >
  
  <?php
  include 'connect.php';
  $address = array();
  $name = array();
  $language = array();
  $ID = array();


  header("Cache-Control: no-cache, must-revalidate");

  ?> 
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
      <div class="navbar-header">
          <a href="home.php"><img src="logo.jpg" width="18%"></a>
    </div>
  </nav>
  <div class="row"  style="margin-top: 70px;">
    <div class="col-sm-4">
    </div>
    <div class="col-sm-4" >
      <ul class="nav nav-tabs" >

        <li class="active"><a href="#signin" data-toggle="tab">Login</a></li>
        <li><a href="#signup" data-toggle="tab">Register</a></li>
        <li><a href="#why" data-toggle="tab">Why</a></li>
      </ul>
      <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade in" id="why">
          <p><br>We need this information so that you can receive access to the site and its content. Rest assured your information will not be sold, traded, or given to anyone.</p>
          <br> Please contact <a mailto:href="iamrajat10cube@gmail.com">iamrajat10cube@gmail.com</a> for any other inquiries.</p>
        </div>
        <div class="tab-pane fade active in" id="signin">
          <form class="form-horizontal" method="POST">
            <fieldset>
              <!-- Sign In Form -->
              <!-- Text input-->
              <label class="control-label" for="userid"><br>Email:<br><br></label>
              <div class="controls">
                <input required="" id="userid" name="userid" type="text" class="form-control" placeholder="example@xyz.com" class="input-medium" required="">
              </div>

              <!-- Password input-->
              <label class="control-label" for="passwordinput"><br>Password:<br><br></label>
              <div class="controls">
                <input required="" id="passwordinput" name="passwordinput" class="form-control" type="password" placeholder="********" class="input-medium">
              </div>

              <!-- Button -->
              <label class="control-label" for="signin"></label>
              <div style="text-align: center;">
                <br>
                <button id="signin" name="signin" class="btn btn-my1-primary" style="margin-top: 100px;">Sign In</button>
              </div>
            </fieldset>
          </form>
          <?php
          $email = $_POST['userid'];
          $pass = $_POST['passwordinput'];
          if(isset($_POST['signin'])){
            $query = "SELECT * FROM User WHERE E_mail = '".$email."' and Password = '".$pass."'";
            $result = $con->query($query);
            $query1 = "SELECT * FROM Theater_vendor WHERE Vendor_email = '".$email."' and Password = '".$pass."'";
            $result1 = $con->query($query1);
            if($result->num_rows !=0){

              $row = $result->fetch_assoc();
              $uid = $row[U_ID];
              header('Location:movies1.php?uid='.$uid);
            }
            elseif ($result1->num_rows !=0) {
              $row = $result1->fetch_assoc();
              $uid = $row[Vendor_ID];
              header('Location:vendor.php?uid='.$uid);
            }
            else{  ?>
            <br><br><center><span style="color: red;"><b>Invalid login credentials!</b></span></center>
          <?php }
         }
         ?>
       </div>
       <div class="tab-pane fade" id="signup">
        <?php
        $email = $_POST['Email'];
        $name = $_POST['name'];
        $pass = $_POST['password'];
        $pass1 = $_POST['reenterpassword'];
        $phone = $_POST['mobile'];
        $table = $_POST['humancheck'];
        if(isset($_POST['confirmsignup'])){

          $query = "INSERT INTO ".$table." values(NULL,'".$name."','".$email."','".$pass."','".$phone."')";
          $result = $con->query($query);
          if($table === "User"){
          $query = "SELECT U_ID FROM User WHERE E_mail ='".$email."' and Password ='".$pass."' and Name ='".$name."' and Phone_no ='".$phone."'";
                    $result = $con->query($query);
          $result->data_seek(0);
          $row = $result->fetch_assoc();
          $uid = $row[U_ID];
          header('Location:movies1.php?uid='.$uid);
        }
        else{
            $query = "SELECT Vendor_ID FROM Theater_vendor WHERE Vendor_email ='".$email."' and Password ='".$pass."' and Vendor_name ='".$name."' and Vendor_phone ='".$phone."'";         
                      $result = $con->query($query);
          $result->data_seek(0);
          $row = $result->fetch_assoc();
          $uid = $row[Vendor_ID];
          header('Location:vendor.php?uid='.$uid);
        }
          
        }
        ?>
        
        <form class="form-horizontal" action = "" method="POST">
          <fieldset>
            <!-- Sign Up Form -->
            <!-- Text input-->
            <div class="control-group">
              <label class="control-label" for="Email"><br>Email:<br></label>
              <div class="controls">
                <input required="" id="Email" name="Email" class="form-control" type="email" placeholder="example@xyz.com" class="input-large" required="">
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="name"><br>Name:<br></label>
              <div class="controls">
                <input required="" id="name" name="name" class="form-control" type="text" placeholder="Alex" class="input-large" required="">
              </div>
            </div>

            <!-- Password input-->
            <div class="control-group">
              <label class="control-label" for="password"><br>Password:<br></label>
              <div class="controls">
                <input required="" id="password" name="password" class="form-control" type="password" placeholder="********" class="input-large" required="">
              </div>
            </div>



            <!-- Text input-->
            <div class="control-group">
              <label class="control-label" for="reenterpassword"><br>Re-Enter Password:<br></label>
              <div class="controls">
                <input required="" id="reenterpassword" class="form-control" name="reenterpassword" type="password" placeholder="********" class="input-large" required="">
              </div>
            </div>

            <div class="control-group">
              <label class="control-label" for="Mobile"><br>Mobile No.:<br></label>
              <div class="controls">
                <input required="" id="mobile" name="mobile" class="form-control" type="text" placeholder="9876543210" class="input-large" required="">
              </div>
            </div>

            <!-- Multiple Radios (inline) -->
            <div style="margin-left: 20px;">
          <label class="control-label" for="humancheck"><br></label>
          <div class="controls container-fluid">
            <label class="radio inline" for="humancheck-0">
              <input type="radio" name="humancheck" id="humancheck-0" value="User" checked="checked">User</label>
              <br>
              <label class="radio inline" for="humancheck-1">
                <input  type="radio" name="humancheck" id="humancheck-1" value="Theater_vendor" >Theater Vendor</label>
              </div>
            </div>
            <br>


            <!-- Button -->
            <div class="control-group">
              <label class="control-label" for="confirmsignup"></label>
              <div class="controls">
                <button id="confirmsignup" name="confirmsignup" value="confirmsignup" class="btn btn-my1-primary" onclick="return Validate()" >Sign Up</button>
              </div>
            </div>
          </fieldset>
        </form>
        <script type="text/javascript">
          function Validate() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("reenterpassword").value;
            if (password != confirmPassword) {
              alert("Passwords do not match.");
              return false;
            }
            return true;
          }
        </script>
      </div>
    </div>
  </div>
  <div class="col-sm-4">
  </div>
</div>
<br><br>

<script src="bootstrap/jquery-3.2.1.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<?php include 'footer.php';?>
</body>
</html>