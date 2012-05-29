<?php
session_start();
header("Content-Type: text/html; charset=UTF-8");
$error_reporting_level=0;
error_reporting($error_reporting_level);
if (isset($_SESSION['id'],$_SESSION['admin']))
{
 include ('core/sql.php');
 $obj = new sql;
 $data=$obj->search($_POST['type'],$_POST['pid'],$_POST['iid'],$_POST['cid']);
 echo $data;
}
else
 echo 0;
?>