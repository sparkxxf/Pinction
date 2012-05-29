<?php
session_start();
header("Content-Type: text/html; charset=UTF-8");
$n1=rand(5,9);
$n2=rand(1,4);
$n3=rand(1,3);
if ($n3 == 1)
{
 echo $n1.'+'.$n2;
 $_SESSION['key']=$n1+$n2;
}
else if($n3 == 2)
{
 echo $n1.'-'.$n2;
 $_SESSION['key']=$n1-$n2;
}
else
{
 echo $n1.'*'.$n2;
 $_SESSION['key']=$n1*$n2;
}
?>