<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>浏览</title>
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
if (isset($_SESSION['id'],$_SESSION['admin']))
  include ('header.php');
else
  echo '<script>window.location="home.php";</script>';
?>
<form name="form" id="form">
输入用户 ID <input type="text" name="pid" id="pid" /> <input type="button" id="btn1" name="btn1" value="获取"/>
<div id="profile"></div>

输入竞品 ID <input type="text" name="iid" id="iid" /> <input type="button" id="btn2" value="获取"/>
<div id="item"></div>

删除留言 ID <input type="text" name="cid" id="cid" /> <input type="button" id="btn3" value="删除"/>
<div id="comment"></div>
<input type="hidden" id="type" name="type" value="0"/>
</form>
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
    $("#btn1").click(function () {
        $('#type').val('1');
        $.post("backend.get.php", $("#form").serialize(),
            function(data){
                if (data == 0)
                    alert('无法获取数据!');
                else
                    $('#profile').html(data);
            });
    });

    $("#btn2").click(function () {
        $('#type').val('2');
        $.post("backend.get.php", $("#form").serialize(),
            function(data){
                if (data == 0)
                    alert('无法获取数据!');
                else
                    $('#item').html(data);
            });
    });

    $("#btn3").click(function () {
        $('#type').val('3');
        $.post("backend.get.php", $("#form").serialize(),
            function(data){
                if (data == 0)
                    alert('无法获取数据!');
                else
                    $('#comment').html(data);
            });
    });
</script>
</body>
</html>