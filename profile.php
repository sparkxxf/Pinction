<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>个人主页</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
        body {
            padding-top: 60px;
            padding-bottom: 40px;
        }
    </style>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="js/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
</head>
<body>
<?php
session_start();
if (isset($_SESSION['id']))
  include ('header.php');
else
{
 include ('core/html.php');
  echo '<h3 align="right"><a href="index.php">Join eAuction</a></h3>';
}
if (!isset($_GET['id']))
 $_GET['id']=$_SESSION['id'];
include ('core/sql.php');
 
$obj = new sql;
$data=$obj->getUserInfo($_GET['id']);
$obj2 = new html;
$data[7]=$obj2->encode($data[7]);
echo '<table><tr><td><img src="img/user',$data[4],'.jpg" width="200px"/></td><td>姓名: <b>',$data[1],' ',$data[2],'</b><br/>邮箱: <b>',$data[0],'</b><br/>性别: <b>',$data[3],'</b><br/>地址: <b>',$data[7], '</b><br/>是否管理员: <b>',$data[8].'</b></td></tr></table>';
?>
<!--<hr style="border: dashed"/>-->
<h3 align="center">属于此用户的竞品 </h3>
<?php
$data=$obj->getMyItems($_GET['id']);
if ($data == 0)
 echo '没有竞品 !';
?>

<!-- Le javascript -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-dropdown.js"></script>
<script src="js/jquery.easing.js"></script>
<script src="js/main.js"></script>
</body>
</html>