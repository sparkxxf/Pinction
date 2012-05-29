<?php
session_start();
header("Content-Type: text/html; charset=UTF-8");
$error_reporting_level=0;
error_reporting($error_reporting_level);
include ('core/sql.php');
$obj = new sql;
if (isset($_POST['email']))
{
 $data=$obj->updateUser($_SESSION['id'],$_POST['nameF'],$_POST['nameL'],$_POST['sex'],$_POST['country'],$_POST['state'],$_POST['address'],$_POST['code']);
 echo $data;
}
else if (isset($_POST['pwd']))
{
 $data=$obj->changePassword($_SESSION['id'],$_POST['pwd'],$_POST['pwd2']);
 echo $data;
}
else if(isset($_FILES['img']['name']) && !empty($_FILES['img']['name']))
{
 $uploadFile = 'img/user'.$_SESSION['id'].'.jpg';
 if (!move_uploaded_file($_FILES['img']['tmp_name'], $uploadFile))
   echo 0;
 else
 {
  $data=$obj->updateUserImg($_SESSION['id']);
  if ($data != 1)
   echo 'Oops, something went wrong !';
  header('Location: profile.php');
 }
}
?>