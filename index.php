<?php
session_start();
header("Content-Type: text/html; charset=UTF-8");
if (isset($_SESSION['id']))
{
 header('Location: home.php');
 exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>B2C在线拍卖</title>
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
    <link rel="stylesheet" href="css/style.css">

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
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="#">B2C在线拍卖</a>
            <div class="nav-collapse">
                <ul class="nav">
                    <li class="active"><a href="index.php">最新拍卖</a></li>
                </ul>
                <ul class="nav pull-right">
                    <li><form id="form1" name="form1" method="post" action="backend.login.php">
                        <?php
                        if (isset($_GET['err']) && $_GET['err']==1)
                            echo '<font color="red">[登录失败!]</font> ';
                        else if (isset($_GET['err']) && $_GET['err']==2)
                            echo '<font color="red">[不存在此用户！]</font> ';
                        ?>
                        <strong>邮箱</strong>
                        <input name="email" type="text" id="email" />
                        <strong> 密码</strong>
                        <input name="password" type="password" id="password" />
                        <input type="submit" name="Submit" value="登录" />
                        <input type="button" name="newUser" value="注册" onclick="window.location='register.php';" />
                        <?php
                        if (isset($_GET['err']) && $_GET['err']==1)
                            echo '<input type="button" name="forgotPass" value="忘记密码？" onclick="window.location=\'forgotPassword.php\';" />';
                        ?>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div id="container" style="margin:0 auto;">
    <div class="aside"></div>
    <div class="photo_box">
    <div class="row">
    <?php
    include ('core/sql.php');
    $obj = new sql;
    $obj->showItems();
    ?>
    </div>
    </div>
    </div>
<?php
include ('footer.php');
?>
</div>
<!-- Le javascript -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-dropdown.js"></script>
<script src="js/jquery.easing.js"></script>
<script src="js/main.js"></script>
<script src="js/jquery.masonry.min.js"></script>
<!--<script src="js/masonry.index.js"></script>-->
</body>
</html>