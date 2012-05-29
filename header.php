<?php
$error_reporting_level=0;
error_reporting($error_reporting_level);
session_start();
header("Content-Type:text/html; charset=uft-8");
if (!isset($_SESSION['id']))
{
 header('Location: index.php');
 exit;
}
if (!function_exists('encode'))
 include ('core/html.php');
$obj = new html;
$data=$obj->draw('table',2,10);
?>
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
                    <li class="active"><a href="profile.php?id=<?php echo $_SESSION['id']; ?>">主页</a></li>
                    <?php
                    if (isset($_SESSION['admin']) && $_SESSION['admin']==1)
                    {
                        echo '<li><a href="addAuction.php"> 添加新的竞品</li><li><a href="finishAuction.php">已完成的竞拍</a></li><li><a href="register.php">增加管理员帐户</a></li><li><a href="browse.php">浏览</a></li>';
                    }
                    else
                    {
                    ?>
                    <li><a href="home.php">竞品</a></li>
                    <li><a href="myBids.php">我的竞拍</a></li>
                    <li>
                        <a href="wonAuctions.php">竞拍成功的商品</a></li>
                    <?php
                    }
                    ?>
                    <li><a href="search.php">搜索</a></li>
                </ul>
                <ul class="nav pull-right">
                    <li class="dropdown">
                        <a href="#"
                           class="dropdown-toggle" data-toggle="dropdown">
                            <?php echo $_SESSION['name']; ?>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="account.php">个人设置</a></li>
                            <li><a href="logout.php">注销</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>