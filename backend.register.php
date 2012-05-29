<?php
session_start();
header("Content-Type: text/html; charset=UTF-8");
if ($_SESSION['key']==$_POST['key'])
{
 if (!isset($_SESSION['admin']))
  $_SESSION['admin']=0;
 include ('core/sql.php');
 $obj  = new sql;
 $tmp_name = rand(1000,9999);
 $data = $obj->newUser($_POST['email'],$_POST['pwd'],$_POST['pwd2'],$_POST['nameF'],$_POST['nameL'],$_POST['sex'],$_POST['address'],$_POST['code'],$_SESSION['admin']);
 if ($data>0)
 {
  $_SESSION['id']=$data;
  $_SESSION['name']=$_POST['nameF'];
  echo '注册成功，点击 <a href="home.php">这里</a> 继续！';
 }
 else if($data = -1)
  echo '密码不匹配！';
 else
  echo '出错了！';
}
else
 echo '失败！';
?>