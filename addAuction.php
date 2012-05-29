<?php
session_start();
$error_reporting_level=0;
error_reporting($error_reporting_level);
if (!isset($_SESSION['admin']))
{
 header('Location: home.php');
 exit;
}
$date1 = date("Y-m-d");
$date2 = date("Y-m-d", strtotime("$date1 +15 days"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>添加新的拍卖</title>
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
    <link href="css/validationEngine.jquery.css" rel="stylesheet" />

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
include ('header.php');
?>
<form name="form" id="form" enctype="multipart/form-data" action="backend.newItem.php" method="POST">
<table align="center">
    <tr>
      <td>竞品名：</td>
      <td><input name="name" type="text" id="name" maxlength="40" class="validate[required]"/></td>
    </tr>
    <tr>
      <td>详情：</td>
      <td><textarea name="desc" id="desc"></textarea></td>
    </tr>
    <tr>
      <td>最低价格：</td>
      <td><input name="val" type="text" id="val" maxlength="20" class="validate[required,custom[onlyNumber]]"/></td>
    </tr>
    <tr>
	 <td>选择图片：</td>
	 <td><input type="file" name="img" id="img"/></td>
	</tr>
	<tr>
	 <td>开始时间：</td><td><b><?php echo $date1; ?></b></td>
	 </tr>
	 <tr>
	 <td>结束时间：</td><td><b><?php echo $date2; ?></b></td>
	</tr>
	<tr>
	 <td colspan="2" align="center">
      <input type="submit" name="btn" id="btn" value="确认" />
      <input type="reset" name="Submit" value="重置" />
	 </td>
	</tr>
<?php
if (isset($_GET['err']))
 echo '<tr><td colspan="2">出错，请重试 !</td></tr>';
?>
</table>
</form>
<?php
include ('footer.php');
?>
<!-- Le javascript -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-dropdown.js"></script>
<script src="js/jquery.easing.js"></script>
<script src="js/jquery.validationEngine-pinction.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/main.js"></script>
<script>
    $(document).ready(function() {
        $("#form").validationEngine()
    });
</script>
</body>
</html>