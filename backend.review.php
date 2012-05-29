<?php
session_start();
header("Content-Type: text/html; charset=UTF-8");
$error_reporting_level=0;
error_reporting($error_reporting_level);
$sms=$_POST['sms'];
$aid=$_POST['aaid'];
include ('core/sql.php');
$obj = new sql;
$data=$obj->comment($_SESSION['id'],$_SESSION['name'],$aid,$sms);
echo $data;
?>