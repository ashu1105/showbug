<?php 
include 'connect.php';;
$uid = $_GET['v1'];
$sid = $_GET['v2'];


$query ="CALL review(".$uid.",".$sid.",2)";
$result = $con->query($query);
header("Location:info.php?variable=$sid&uid=$uid");
?>