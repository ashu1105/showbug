<?php

include 'connect.php';
 
$id = $_GET['var'];
$uid = $_GET['uid'];

$q1 = "DELETE FROM `Show_Details` WHERE SD_ID= '".$id."' ";

$r1 = $con->query($q1); 
header('Location:vendor.php?uid='.$uid);
?>