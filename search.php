<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>搜索</title>
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
?>

<form name="form" id="form">
 选择类别： <br/>
 用户 <input name="cat" id="cat" type="radio" value="P" checked="checked" />
 竞品 <input name="cat" id="cat" type="radio" value="I" /><br/>
<input type="text" id="key" name="key"/><input type="button" name="btn" id="btn" value="搜索"/>
</form>

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
    $("#btn").click(function () {
        if ($('#key').val().length==0)
        {
            alert('搜素不能为空!');
            return;
        }

        $.post("backend.search.php", $("#form").serialize(),
            function(data){
                if (data != '')
                    $('#msg').html(data);
                else
                    $('#msg').html("没有结果!");
            });
    });
</script>
</body>
</html>