<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>恢复密码</title>
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
    <link rel="stylesheet" href="css/validationEngine.jquery.css" media="screen"/>

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

<form name="form" id="form" method="post">
<table align="center">
<tr>
<td>邮箱：</td> <td> <input type="text" name="email" id="email" class="validate[required,custom[email]]"/>  </td></tr><tr>
<td>安全码：</td> <td>  <input type="text" name="code" id="code" maxlength="8" class="validate[required,custom[onlyNumber]]"/>  </td></tr><tr>
<td>新密码</td> <td><input type="password" name="pwd" id="pwd" class="validate[required]"/>  </td></tr><tr>
<td>重复新密码</td> <td> <input type="password" name="pwd2" id="pwd2" class="validate[required]"/>  </td></tr><tr>
<td colspan="2"><input type="submit" value="确认"/></tr>
</form>
<?php
$error_reporting_level=0;
error_reporting($error_reporting_level);
if (isset($_POST['email'],$_POST['code'],$_POST['pwd'],$_POST['pwd2']))
{
    $data = 0;
    include ('core/sql.php');
    $obj = new sql;
    if ($_POST['pwd'] == $_POST['pwd2'])
        $data=$obj->resetPassword($_POST['email'],$_POST['code'],$_POST['pwd']);
    if ($data == 1)
        echo '更新成功！<br/><a href="index.php">Login</a></br>';
    else
        echo '错误，请检查！<br/>';
}
?>
<?php
include ('footer.php');
?>
<!-- Le javascript -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-dropdown.js"></script>
<script src="js/jquery.easing.js"></script>
<script src="js/main.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/jquery.validationEngine-pinction.js"></script>
<script>
$(document).ready(function() {
			$("#form").validationEngine()
});
</script>
</body>
</html>