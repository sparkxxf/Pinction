<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>主页</title>
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
 if (isset($_GET['limit']))
  $limit=intval($_GET['limit']);
 else
  $limit=0;

 include ('core/sql.php');
 $obj = new sql;
 if (isset($_GET['limit']))
  $obj->showLatestItems(intval($_GET['limit']));
 else
  $obj->showLatestItems();

if ($limit >= 0)
{
    echo '<center><h2>';
    if ($limit>0)
    {
        $limit--;
        echo '<a href="home.php?limit='.$limit.'" title="Previous page"><img src="img/prev.png" alt="<-" /></a> &nbsp;';
        $limit++;
    }
    $limit++;
    echo '&nbsp;<a href="home.php?limit='.$limit.'" title="Next page"><img src="img/next.png" alt="->" /></a>';
    echo '</h2></center>';
    $limit--;
}
?>
<?php
include ('footer.php');
?>

<!-- Le javascript -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-dropdown.js"></script>
<script type="text/javascript" src="js/jquery.easing.js"></script>
<script src="js/main.js"></script>
</body>
</html>