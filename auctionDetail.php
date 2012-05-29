<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>B2C在线拍卖——拍卖详情</title>
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
                    <li><a href="index.php">最新拍卖</a></li>
                    <li class="active">

                    <a href="">拍卖详情</a>

                    </li>
                </ul>
                <ul class="nav pull-right">
                    <li><a href="index.php">返回</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php
 session_start();
 if (isset($_SESSION['id']))
  include ('header.php');
 else
//  echo '<h3 align="right"><a href="index.php">返回</a></h3>';
    echo '';

 include ('core/sql.php');
 $obj = new sql;
 $data=$obj->getItemInfo($_GET['id']);
 $date = date('Y-m-d');
 if (count($data)>1)
 {
  if (count($data)>1)
  {
   echo '<div class="row">';
      echo '<div class="span-two-thirds">';
        echo '<h2>'.$data[0].'</h2>';
         echo '详情： <b>'.$data[1].'</b><br/>金额： <b>'.$data[3].'</b><br/>拍卖开始时间： <b>'.$data[4].'</b><br/>拍卖结束时间 <b>'.$data[5].'</b><br/>';

      echo '</div>';
      echo '<div class="span-one-third">';
        if ($data[2] != 0)
          echo ' <br/><a href="img/item'.$data[2].'.jpg" target="_blank">[ View Full Image ]</a>';
        echo '<img src="img/item'.$data[2].'.jpg" width="384px"/>';
      echo '</div>';
   echo '</div>';

  }
  else
   echo '无法找到竞品信息！';
  $maxBid=$obj->getMaxBid($_GET['id']);
  if ($data[3]<$maxBid[0])
   $max=$maxBid[0];
  else
   $max=$data[3];
  echo '最高出价： <b><span id="dmax">'.$max.'</span></b><br/>';

 $diff = abs(strtotime($data[5]) - strtotime($date));
 $years = floor($diff / 31536000);
 $months = floor(($diff - $years * 31536000) / (2592000));
 $days = floor(($diff - $years * 31536000 - $months*2592000)/ (86400));
 echo '剩下天数：  <b>'.$days.'</b><br/>';
 }
 else
  echo '无法找到指定的商品！<br/>';

if (time() < strtotime($data[5]) &&  isset($_SESSION['id']))
{
?>
<form name="form" id="form">
 <input type="hidden" readonly="readonly" name="min" id="min" value="<?php echo $data[3]; ?>"/>
 <input type="hidden" readonly="readonly" name="max" id="max" value="<?php echo $max; ?>"/>
 <input type="hidden" readonly="readonly" name="aid" id="aid" value="<?php echo $_GET['id']; ?>"/>
 输入您的出价：<input type="text" name="amount" id="amount" size="5"/>
 <input type="button" id="btn" name="btn" value="Submit"/>
</form>
<b><div id="msg"></div></b>

<img id="btnBid" src="img/bid.png" alt="Bid" title="Bid"/>
<img id="btnRvw" src="img/review.png" alt="Review" title="Review"/>

<div id="holder"></div>

<div id="dComnt" style="display:none">
<form name="form2" id="form2">
<?php
$data=$obj->get_comment($_GET['id']);
echo $data;
?>
<input type="hidden" readonly="readonly" name="aaid" id="aaid" value="<?php echo $_GET['id']; ?>"/>
<br/>评论： <input type="text" id="sms" name="sms" maxlength="350" /><br/>
名字： <b><?php echo $_SESSION['name']; ?></b> <input type="button" id="btnComnt" name="btnComnt" value="Comment" onclick="comment()"/>
</form>
</div>

<div id="dBid" style="display:none">
<div id="bidList">
<?php
$data=$obj->showItemBids($_GET['id']);
echo '</div>';
}
else
{
 $data=$obj->getItemOwner($_GET['id']);
 if ($data[0] !=0)
  echo '<br>竞品卖给 <a href="profile.php?id='.$data[0].'">'.$data[1].'</a> 以人名币'.$data[2].'元';
}
?>
<?php
include ('footer.php');
?>
</div>
</div>
<!-- Le javascript -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-dropdown.js"></script>
<script src="js/jquery.easing.js"></script>
<script src="js/main.js"></script>
    <script>
        function comment()
        {
            var str = '';
            $.post("backend.review.php", $("#form2").serialize(),
                function(data){

                    $('#sms').val('');
                    if (data == 0)
                        alert('Failed to post comment !');
                    else
                    {
                        str = data + $('#dComnt').html();
                        $('#dComnt').html(str);
                        $('#holder').html(str);
                    }
                });
        }

        $("#btnBid").click(function () {
            $('#holder').html($('#dBid').html());
        });
        $("#btnRvw").click(function () {
            $('#holder').html($('#dComnt').html());
        });
        $('#holder').html($('#dBid').html());

        $("#btn").click(function () {
            var str = $('#dBid').html();
            var today=new Date();
            var date = today.getFullYear();
            date = date + '-' + today.getMonth();
            date = date + '-' + today.getDate();
            date = date + ' ' + today.getHours();
            date = date + ':' + today.getMinutes();
            date = date + ':' + today.getSeconds();

            $.post("backend.bid.php", $("#form").serialize(),
                function(data){
                    $('#msg').fadeIn('slow');
                    if (data==0)
                        $('#msg').html('<font color="red">出价失败！</font>');
                    else if (data==1)
                    {
                        $('#msg').html('<font color="green">出价成功！</font>');
                        str =  '<i><?php echo $_SESSION['name']; ?></i> 出价 RMB. ' + $('#amount').val() + ' on ' + date + '<br/>' + str;
                        $('#dBid').html(str);
                        $('#holder').html($('#dBid').html());
                    }
                    else if (data==2)
                    {
                        $('#msg').html('<font color="lime">恭喜你，是最高的出价！</font>');
                        str =  '<i><?php echo $_SESSION['name']; ?></i> 出价 RMB. ' + $('#amount').val() + ' on ' + date + '<br/>' + str;
                        $('#dBid').html(str);
                        $('#holder').html($('#dBid').html());
                        $('#max').val($('#amount').val());
                        $('#dmax').html($('#amount').val());
                    }
                    else if (data==-1)
                        $('#msg').html('<font color="orange">您的新出价低于已有的出价！<br/>出价失败！</font>');
                    else if (data==-2)
                        $('#msg').html('<font color="orange">您的出价低于限定值！</font>');
                    else if (data==-3)
                        $('#msg').html('<font color="red">您输入了一个非法的值！</font>');
                    document.form.reset();
                    $('#msg').fadeOut(4500);
                });
        });
    </script>
</body>
</html>