<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>个人设置</title>
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
 include ('header.php');
 include ('core/sql.php');
 $obj = new sql;
 $data=$obj->showUpdateUser($_SESSION['id']);
?>
<form name="form" id="form">
 <table border="0" align="center">
    <tr>
      <td><strong>邮箱：</strong></td>
      <td><input name="email" readonly="readonly" type="text" id="email" maxlength="40" value="<?php echo $data[0]; ?>" /></td>
    </tr>
    <tr>
      <td><strong>姓：</strong></td>
      <td><input name="nameF" type="text" id="nameF" maxlength="20" value="<?php echo $data[1]; ?>" /></td>
    </tr>
    <tr>
      <td><strong>名：</strong></td>
      <td><input name="nameL" type="text" id="nameL" maxlength="20" value="<?php echo $data[2]; ?>" /></td>
    </tr>
    <tr>
      <td><strong>性别：</strong></td>
      <td>
        <input name="sex" type="radio" value="M" <?php if($data[3]=='M') echo 'checked="checked"'; ?> />
          男
          <input type="radio" name="sex" value="F" <?php if($data[3]=='F') echo 'checked="checked"'; ?>/>
          女
      </td>
    </tr>
    <tr>
      <td><strong>地址：</strong></td>
      <td><textarea name="address" id="address"><?php echo $data[7]; ?></textarea></td>
    </tr>
    <tr>
      <td><strong>安全码：</strong></td>
      <td><input name="code" type="text" id="code" maxlength="8" value="<?php echo $data[8]; ?>" /></td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
        <input type="button" name="btn" id="btn" value="更新个人信息" />
        <input type="reset" name="Submit2" value="重置" />
      </div></td>
    </tr>
  </table>
</form>
<form name="form3" id="form3" enctype="multipart/form-data" action="backend.updateUser.php" method="POST">
    <table align="center">
        <tr>
            <td><img src="img/user<?php echo $data[4]; ?>.jpg" width="200px"/><td>
            <td><input type="file" name="img" id="img"/> <input type="submit" value="上传图片"/></td>
        </tr>
    </table>
</form>
</form>
<form name="form2" id="form2">
 <table border="0" align="center">
    <tr>
      <td><strong>当前密码：</strong></td>
      <td><input name="pwd" type="password" id="pwd" maxlength="20"/></td>
    </tr>
    <tr>
      <td><strong>密码：</strong></td>
      <td><input name="pwd3" type="password" id="pwd3" maxlength="20"/></td>
    </tr>
    <tr>
      <td><strong>重新输入密码：</strong></td>
      <td><input name="pwd2" type="password" id="pwd2" maxlength="20"/></td>
    </tr>
	<tr>
      <td colspan="2"><div align="center">
        <input type="button" name="btn2" id="btn2" value="更改密码" />
        <input type="reset" name="Submit2" value="重置" />
      </div></td>
    </tr>
 </table>

<div id="msg"></div>
<?php
include ('footer.php');
?>

<!-- Le javascript -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-dropdown.js"></script>
<script src="js/jquery.easing.js"></script>
<script src="js/main.js"></script>
<script>
    $("#btn2").click(function () {
        if ($('#pwd').val().length<8 || $('#pwd2').val().length<8 )
        {
            alert('密码太短!');
            return;
        }
        else if ($('#pwd3').val() != $('#pwd2').val())
        {
            alert('验证失败!');
            return;
        }
        $.post("backend.updateUser.php", $("#form2").serialize(),
            function(data){
                alert(data);
                if (data == 1)
                    $('#msg').html('密码已更改!');
                else
                    $('#msg').html('密码未更改!');
                document.form2.reset();
            });
    });

    $("#btn").click(function () {
        $.post("backend.updateUser.php", $("#form").serialize(),
            function(data){
                if (data == 1)
                    $('#msg').html('个人信息已更改!');
                else
                    $('#msg').html('个人信息未更改!');
                document.form.reset();
            });
    });
</script>
</body>
</html>