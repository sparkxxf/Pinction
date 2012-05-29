<?php
session_start();
header("Content-Type: text/html; charset=UTF-8");
$error_reporting_level=0;
error_reporting($error_reporting_level);
$email=$_POST['email'];
$pwd=$_POST['password'];
include ('core/sql.php');
$obj = new sql;
$data=$obj->login($email,$pwd);
$n=count($data);
if ($n>1)
{
 $_SESSION['id']=$data[0];
 $_SESSION['name']=$data[1];
 if ($data[2] != 0)
  $_SESSION['admin']=$data[2];
 header('Location: home.php');
}
else
{
 if ($data==0)
  header('Location: index.php?err=1');
 else
  header('Location: index.php?err=2');
}
?>