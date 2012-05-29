<?php
header("Content-Type: text/html; charset=UTF-8");
$error_reporting_level=0;
error_reporting($error_reporting_level);
include ('core/sql.php');
$obj = new sql;
if ($_POST['cat']=='P')
 $data=$obj->searchUser($_POST['key']);
else
 $data=$obj->searchItem($_POST['key']);
?>