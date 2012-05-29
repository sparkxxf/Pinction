<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>已完成拍卖</title>
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
 include ('core/sql.php');
 $obj = new sql;
 $aidList=$obj->finishBid();
 if (count($aidList)>0)
 {
  for($i=0;$i<count($aidList);$i++)
  {
   $data=$obj->getItemInfo($aidList[$i]);
   if (count($data)>1)
    echo 'Name <b>'.$data[0].'</b> <img src="img/item'.$data[2].'.jpg" width="128px"/><br/>详情：<b>'.$data[1].'</b><br/>价格：<b>'.$data[3].'</b><br/>开始时间：<b>'.$data[4].'</b>结束时间：<b>'.$data[5].'</b><br/>';
   else
    echo '无法找到竞品!';
   $data=$obj->getItemOwner($aidList[$i]);
   if (count($data)>1)
    echo '<br>以人民币'.$data[2].'元，卖给用户 <a href="profile.php?id='.$data[0].'">'.$data[1].'</a>';
  }
 }
 else
  echo '没有结束的竞拍!';
?>
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
</body>
</html>