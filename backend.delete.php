<?php
session_start();
header("Content-Type: text/html; charset=UTF-8");
$amount=$_POST['amount'];
$aid=$_POST['aid'];
include ('core/sql.php');
$obj = new sql;
$data=$obj->del_comment($_SESSION['id'],$_GET['id']);
header('Location: auctionDetail.php?id='.$_GET['aid']);
?>