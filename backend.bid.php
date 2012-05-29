<?php
session_start();
header("Content-Type: text/html; charset=UTF-8");
$error_reporting_level=0;
error_reporting($error_reporting_level);
$amount=$_POST['amount'];
$aid=$_POST['aid'];
include ('core/sql.php');
$obj = new sql;
$data=$obj->newBid($aid,$_SESSION['id'],$_SESSION['name'],$amount);
echo $data;
?>