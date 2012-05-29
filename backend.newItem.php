<?php
session_start();
header("Content-Type: text/html; charset=UTF-8");
if (!isset($_SESSION['admin']))
{
 header('Location: home.php');
 exit;
}
$error_reporting_level=0;
error_reporting($error_reporting_level);
$name=$_POST['name'];
$description=$_POST['desc'];
$amount=$_POST['val'];
include ('core/sql.php');
$obj = new sql;
$data=$obj->newItem($name,$description,$amount);
if ($data>0 && isset($_FILES['img']))
{
 $uploadFile = 'img/item'.$data.'.jpg';
 move_uploaded_file($_FILES['img']['tmp_name'], $uploadFile);
 $tmp=$obj->updateItemImg($data);
 header('Location: auctionDetail.php?id='.$data);
}
else
 header('Location: addAuction.php?err=1');
?>