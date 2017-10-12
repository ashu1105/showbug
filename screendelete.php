<?php

include 'connect.php';
 
$tid = $_GET['var1'];
$sid = $_GET['var2'];
$uid = $_GET['uid'];

$q1 = "DELETE FROM `Theater` WHERE T_ID= '".$tid."' and S_ID= '".$sid."' ";

$r1 = $con->query($q1); 
header('Location:vendor.php?uid='.$uid);
?>