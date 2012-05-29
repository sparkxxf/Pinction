<?php
session_start();
header("Content-Type:text/html; charset=UTF-8");
$error_reporting_level=0;
error_reporting($error_reporting_level);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>注册帐号</title>
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
if (isset($_SESSION['admin']) && $_SESSION['admin']==1)
 include ('header.php');
?>
<h2 align="center">欢迎注册！</h2>
<form id="form1" name="form1">
  <table border="0" align="center">
    <tr>
      <td><strong>邮箱</strong></td>
      <td><input name="email" type="text" id="email" maxlength="40" class="validate[required,custom[email]]" /> <span id="img"></span></td>
    </tr>
    <tr>
      <td><strong>密码</strong></td>
      <td><input name="pwd" type="password" id="pwd" maxlength="20" class="validate[required]" /></td>
    </tr>
    <tr>
      <td><strong>重新输入密码</strong></td>
      <td><input name="pwd2" type="password" id="pwd2" maxlength="20" class="validate[required]" /></td>
    </tr>
    <tr>
      <td><strong>姓</strong></td>
      <td><input name="nameF" type="text" id="nameF" maxlength="20" class="validate[required]" /></td>
    </tr>
    <tr>
      <td><strong>名</strong></td>
      <td><input name="nameL" type="text" id="nameL" maxlength="20" class="validate[required]" /></td>
    </tr>
    <tr>
      <td><strong>性别</strong></td>
      <td>
        <input name="sex" type="radio" value="M" checked="checked" />
          男
          <input type="radio" name="sex" value="F" />
          女
      </td>
    </tr>
    <tr>
      <td><strong>地址</strong></td>
      <td><textarea name="address" id="address"></textarea></td>
    </tr>
    <tr>
      <td><strong>验证码</strong> </td>
      <td><span id="captcha"></span><img src="img/reload.png" id="refresh" alt="Refresh" title="Refresh"/>
 = 
<input name="key" type="text" id="key" size="2" maxlength="2" data-provide="typeahead" class="validate[required,custom[onlyNumber]]"/></td>
    </tr>
    <tr>
      <td><strong>密码找回安全码</strong></td>
      <td><input name="code" type="text" id="code" size="8" maxlength="8" data-provide="typeahead" class="validate[required,custom[length]]"/></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
        <input type="submit" name="btn" id="btn" value="提交" />
        <input type="reset" name="Submit2" value="重置" />
<!--        <input type="submit" name="return" value="返回" />-->
      </div></td>
    </tr>
  </table>
</form>
<div id='msg'></div>
<?php
include ('footer.php');
?>
<!-- Le javascript -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-dropdown.js"></script>
<script src="js/bootstrap-typeahead.js"></script>
<script src="js/jquery.easing.js"></script>
<script src="js/jquery.validationEngine-pinction.js"></script>
<script src="js/jquery.validationEngine.js"></script>
<script src="js/main.js"></script>
<script>
    $(document).ready(function() {
        $.post("backend.captcha.php", $("#form1").serialize(),
            function(data){
                $('#captcha').html(data);
            });
        $("#form1").validationEngine()
    });

    $("#refresh").click(function () {
        $.post("backend.captcha.php", $("#form1").serialize(),
            function(data){
                $('#captcha').html(data);
            });
    });

    $("#btn").click(function () {
        $.post("backend.register.php", $("#form1").serialize(),
            function(data){
                $('#msg').html(data);
            });
    });

    $("#pwd").click(function () {
        $.post("backend.check.php", $("#form1").serialize(),
            function(data){
                if (data == 1)
                    $("#img").html('<img src="img/false.png"/>');
                else
                    $("#img").html('<img src="img/true.png"/>');
            });
    });
</script>
</body>
</html>
