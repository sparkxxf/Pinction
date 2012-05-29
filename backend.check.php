<?php
session_start();
header("Content-Type: text/html; charset=UTF-8");
$error_reporting_level=0;
error_reporting($error_reporting_level);
$data=1;
if (strlen($_POST['email']))
{
 include ('core/sql.php');
 $obj = new sql;
 $data=$obj->check($_POST['email']);
}
echo $data;
?>