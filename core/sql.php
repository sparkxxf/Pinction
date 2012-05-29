<?php
header("Content-Type:text/html; charset=UTF-8");
if (!function_exists('foo'))
 include ('config.php');
error_reporting(error_reporting_level);

class sql
{
 private $time;
 private $date;
 private $connections;
 function __construct()
 {
  $connections = mysql_connect(server, user,password) or die ('Unabale to connect to the database ! '.mysql_error($connections));
  mysql_select_db(dbase) or die ('Failed to select DB ! '.mysql_error($connections));
  $date = date('Y-m-d');
  foreach ($_POST as &$value) 
  {
   $value = mysql_escape_string($value);
  }
 }

 function __destruct()
 {}

 function check($email)
 {
  $result = $this->query("SELECT email FROM user WHERE email='$email'");
  if (mysql_num_rows($result)>0)
   return 1;
  else
   return 0;
 }

 function login($email, $pwd)
 {
  $pwd = sha1($pwd);
  $result = $this->query("SELECT uid,nameF,isAdmin FROM user WHERE email='$email' AND password='$pwd'");
  $row=mysql_fetch_row($result);
  if (mysql_num_rows($result)>0)
   return array($row[0],$row[1],$row[2]);
  else
  {
   $result = $this->query("SELECT uid FROM user WHERE email='$email'");
   $row=mysql_fetch_row($result);
   if (mysql_num_rows($result)>0)
    return 0;
   else
    return -1;
  }
 }

 function newUser($email,$pwd,$pwd2,$nameF,$nameL,$sex,$address,$code,$isAdmin=0)
 {
  $email = $this->verify('Email',$email,10,40);
  $pwd = $this->verify('Password',$pwd,6,20);
  $pwd2 = $this->verify('Password',$pwd2,6,20);
  $nameF = $this->strToTitle($this->verify('Name',$nameF,4,40));
  $nameL = $this->strToTitle($this->verify('Title',$nameL,4,40));
  $address = $this->encode($this->verify('Address',$address,6,120));
  $code = $this->verify('Code',$code,8,8);
  if ($pwd != $pwd2)
   return -1;
  $pwd = sha1($pwd);
  $result = $this->query("INSERT INTO user(email, password, nameF, nameL, sex, address, code, isAdmin)VALUES('$email','$pwd','$nameF','$nameL','$sex','$address','$code','$isAdmin');");
  if (mysql_affected_rows()>0)
   return mysql_insert_id();
  else
   return 0;
 }

 function getUserInfo($uid)
 {
  $uid = intval($uid);
  $result = $this->query("SELECT email, nameF, nameL, sex, img, country, state, address, isAdmin FROM user WHERE uid=$uid");
  $row=mysql_fetch_row($result);
  if (mysql_num_rows($result)>0)
  {
   if ($row[3]=='M')
    $row[3]='Male';
   else
    $row[3]='Female';
   if ($row[8]==0)
    $row[8]='No';
   else
    $row[8]='Yes';
   return array($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8]);
  }
  else
   return 0;
 }

 function showUpdateUser($uid)
 {
  $uid = intval($uid);
  $result = $this->query("SELECT email, nameF, nameL, sex, img, country, state, address, code FROM user WHERE uid=$uid");
  $row=mysql_fetch_row($result);
  if (mysql_num_rows($result)>0)
   return array($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8]);
  else
   return 0;
 }

 function updateUser($uid,$nameF,$nameL,$sex,$country,$state,$address,$code)
 {
  $result = $this->query("UPDATE user set nameF='$nameF', nameL='$nameL', sex='$sex', country='$country', state='$state', address='$address',code='$code' WHERE uid=$uid");
  return mysql_affected_rows();
 }

 function updateUserImg($uid)
 {
  $uid = intval($uid);
  $result = $this->query("UPDATE user set img=$uid WHERE uid=$uid");
  return mysql_affected_rows();
 }

 function changePassword($uid,$oldPwd,$newPwd)
 {
  $oldPwd = sha1($oldPwd);
  $newPwd = sha1($newPwd);
  $result = $this->query("UPDATE user set password='$newPwd' WHERE uid='$uid' and password='$oldPwd'");
  return mysql_affected_rows();
 }

 function resetPassword($email,$code,$pwd)
 {
  $pwd = sha1($pwd);
  $result = $this->query("UPDATE user set password='$pwd' WHERE email='$email' and code='$code'");
  return mysql_affected_rows();
 }

 function newBid($aid,$uid,$name,$amount)
 {
  $uid = intval($uid);
  $aid = intval($aid);
  if (intval($amount)<=0)
   return -3;
  $min = $this->getMinBid($aid);
  $max = $this->getMaxBid($aid);
  $max2 = $this->getMyMaxBid($aid,$uid);
  if ($amount<$min)
   return -2;
  if ($amount<=$max2)
   return -1;
  $result = $this->query("INSERT INTO bid (aid,uid,name,amount) VALUES ('$aid','$uid','$name','$amount');");
  if (mysql_affected_rows()>0)
  {
   if ($amount>$max[0])
    return 2;
   else
    return 1;
  }
  else
   return 0;
 }

 function getMinBid($aid)
 {
  $aid = intval($aid);
  $result = $this->query("SELECT amount FROM item WHERE aid=$aid");
  $row=mysql_fetch_row($result);
  return $row[0];
 }

 function getMaxBid($aid)
 {
  $aid = intval($aid);
  $result = $this->query("select amount,uid,name from bid where amount=(select max(amount) from bid where aid=$aid order by time desc) limit 1");
  $row=mysql_fetch_row($result);
  return array($row[0],$row[1],$row[2]);
 }

 function getMyMaxBid($aid,$uid)
 {
  $uid = intval($uid);
  $aid = intval($aid);
  $result = $this->query("SELECT max(amount) FROM bid WHERE aid=$aid and uid=$uid");
  $row=mysql_fetch_row($result);
  return $row[0];
 }

 function showItemBids($aid)
 {
  $aid = intval($aid);
  $result = $this->query("SELECT uid,name,amount,time FROM bid WHERE aid=$aid order by amount desc limit 20");
  while($row=mysql_fetch_array($result))
   echo '<a href="profile.php?id='.$row[0].'"><i>'.$row[1].'</i></a> 出价 RMB. '.$row[2].' on '.$row[3].'<br>';
 }

 function showLatestItems($limit=0)
 {
  $limit = $limit * 5;
  $result = $this->query("SELECT aid,name,description,img,amount,strtdate,enddate FROM item WHERE enddate>now() order by enddate limit $limit,5");

   echo '<table border="0" align="center">';
   echo '<tr><td align="center"><b>名称</b></td><td align="center" style="width: 20%"><b>详情</b></td><td align="center"><b>起拍价</b></td><td align="center"><b>开始时间</b></td><td align="center"><b>结束时间</b></td></tr>';
   while($row=mysql_fetch_array($result))
    echo '<tr><td align="center"><a href="auctionDetail.php?id='.$row[0].'"><img src="img/item'.$row[3].'.jpg" height="128px"/><br/>'.$row[1].'</a></td><td>'.$row[2].'</td><td><b>RMB.'.$row[4].'</b></td><td>'.$row[5].'</td><td>'.$row[6].'</td></tr>';
   echo '</table>';

 }
 
 function showItems()
 {
  $result = $this->query("SELECT aid,name,description,img,amount,enddate FROM item WHERE enddate>now() order by enddate limit 10");

  while($row=mysql_fetch_array($result))
   echo '<div class="item">'.$row[1].'<br/><a href="auctionDetail.php?id='.$row[0].'"><img src="img/item'.$row[3].'.jpg" width="256px" title="Last Date '.$row[5].'"/></a><br/>'.$row[2].', RMB <b>'.$row[4].'</b></div>';
//   echo '<div class="span4">'.$row[1].'<br/><a href="auctionDetail.php?id='.$row[0].'"><img src="img/item'.$row[3].'.jpg" width="256px" title="Last Date '.$row[5].'"/></a><br/>RMB <b>'.$row[4].'</b></div>';
 }

 function finishBid()
 {
  $i=0;
  $aidList=array();
  $result = $this->query("SELECT aid FROM item where enddate<=now() and uid=0 and uname=''");
   while($row=mysql_fetch_array($result))
   {
    $data=$this->getMaxBid($row[0]);
	if ($data[0]>0)
	{
     $result2 = $this->query("UPDATE item SET uamount='$data[0]',uid=$data[1],uname='$data[2]' WHERE aid=$row[0]");
     $aidList[$i]=$row[0];
     $i=$i+1;
	}
   }
  if (count($aidList)>0)
   return $aidList;
 }

 function newItem($name,$description,$price)
 {
  if (intval($price)<=0)
   return 0;
  $description = nl2br($description);
  $description = ucfirst(strtolower($description));
  $date1 = date("Y-m-d");
  $date2 = date("Y-m-d", strtotime("$date1 +15 days"));
  $result = $this->query("INSERT INTO item (name, description, amount, strtdate, enddate) VALUES ('$name', '$description','$price','$date1','$date2');");
  if (mysql_affected_rows()>0)
   return mysql_insert_id();
  else
   return 0;
 }

 function getItemInfo($aid)
 {
  $aid = intval($aid);
  $result = $this->query("SELECT name, description, img, amount, strtdate, enddate FROM item WHERE aid=$aid");
  $row=mysql_fetch_row($result);
  if (mysql_num_rows($result)>0)
   return array($row[0],$row[1],$row[2],$row[3],$row[4],$row[5]);
  else
   return array('找不到竞品!');
 }

 function getMyItems($id)
 {
  $id = intval($id);
  $result = $this->query("SELECT aid,name,description,img,uamount FROM item WHERE uid=$id");
  if (mysql_num_rows($result)>0)
  {
   echo '<table align="center">';
   echo '<tr><td><b>名称</b></td><td><b>详情</b></td><td><b>图片</b></td><td><b>金额</b></td></tr>';
   while($row=mysql_fetch_array($result))
    echo '<tr><td align="center"><a href="auctionDetail.php?id='.$row[0].'">'.$row[1].'</a></td><td>'.$row[2].'</td><td><a href="auctionDetail.php?id='.$row[0].'"><img src="img/item'.$row[3].'.jpg" height="128px"/></a></td><td>'.$row[4].'</td></tr>';
   echo '</table>';
  }
  else
   return 0;
 }

 function getMyBids($id)
 {
  $data = '你还没有任何出价！<br/>请继续……';
  $id = intval($id);
  $result = $this->query("SELECT aid,name,img FROM item WHERE aid in (select aid from bid where uid=$id)");
  if (mysql_num_rows($result)>0)
  {
   $data = '<table align="center">';
   $data = $data.'<tr><td><b>名称</b></td><td><b>图片</b></td></tr>';
   while($row=mysql_fetch_array($result))
    $data = $data.'<tr><td align="center"><a href="auctionDetail.php?id='.$row[0].'">'.$row[1].'</a></td><td><a href="auctionDetail.php?id='.$row[0].'"><img src="img/item'.$row[2].'.jpg" height="128px"/></a></td></tr>';
   $data = $data.'</table>';
  }
  return $data;
 }

 function getItemOwner($aid)
 {
  $aid = intval($aid);
  $result = $this->query("SELECT uid,uname,uamount FROM item WHERE aid=$aid");
  $row=mysql_fetch_row($result);
  if (mysql_num_rows($result)>0)
   return $row;
  else
   return 0;
 }

 function updateItemImg($aid)
 {
  $aid = intval($aid);
  $result = $this->query("UPDATE item set img=$aid WHERE aid=$aid");
  return mysql_affected_rows();
 }

  function search($type,$pid,$iid,$cid)
 {
  if ($type == 1)
  {
   $result = $this->query("SELECT `uid`, `email`, `nameF`, `img`, `isAdmin` FROM `user` WHERE uid = $pid");
   while($row=mysql_fetch_array($result))
   {
    echo '<table><tr><td>email</td><td>Name</td><td>Image</td><td>Is Admin ?</td></tr>';
    echo '<tr><td align="center"><a href="profile.php?id='.$row[0].'">'.$row[1].'</a></td><td>'.$row[2].'</td><td><img src="img/user'.$row[0].'.jpg" height="128px"/></td><td>'.$row[4].'</td></tr></table>';
   }
  }
  else if ($type == 2)
  {
   $result = $this->query("SELECT aid, name, description, img FROM item WHERE aid=$iid");
   while($row=mysql_fetch_array($result))
   {
    echo '<table><tr><td>Name</td><td>Description</td><td>Image</td></tr>';
    echo '<tr><td>'.$row[1].'</td><td align="center"><a href="auctionDetail.php?id='.$row[0].'">'.$row[2].'</a></td><td><img src="img/item'.$row[3].'.jpg" height="128px"/></td></tr>';
   }
  }
  else if ($type == 3)
  {
   $result = $this->query("");
  }
 }

 function searchItem($name)
 {
  $result = $this->query("SELECT aid, name, description, img FROM item WHERE name like '%$name%'");
  if (mysql_num_rows($result)>0)
  {
   echo '<table align="center">';
   while($row=mysql_fetch_array($result))
    echo '<tr><td align="center"><a href="auctionDetail.php?id='.$row[0].'"><img src="img/item'.$row[3].'.jpg" height="128px"/><br/>'.$row[1].'</a></td><td>'.$row[2].'</td></tr>';
   echo '</table>';
  }
  else
   return '没有结果!';
 }

 function searchUser($name)
 {
  $result = $this->query("SELECT uid,nameF,nameL,img FROM user WHERE nameF like '%$name%'");
  if (mysql_num_rows($result)>0)
  {
   echo '<table align="center">';
   while($row=mysql_fetch_array($result))
    echo '<tr><td align="center"><a href="profile.php?id='.$row[0].'"><img src="img/user'.$row[3].'.jpg" height="200px"/>'.$row[1].' '.$row[2].'</a></td></tr>';
   echo '</table>';
  }
  else
   return 'No result found !';
 }
 
 function comment($uid,$name,$aid,$sms)
 {
  $sms = strip_tags($sms).'<br/>On '.date("Y-m-d");
  $result = $this->query("INSERT INTO `review` (aid,uid,sms,name) VALUES ($aid, $uid, '$sms','$name');");
  if (mysql_affected_rows()>0)
   echo '<a href="profile.php?id='.$uid.'"><b>'.$name.'</b></a>: '.$sms.'<a href="backend.delete.php?aid='.$aid.'&id='.mysql_insert_id().'"><img src="img/cancel.png" alt="[X]"/></a><br/>';
  else
   return 0;
 }

 function del_comment($uid,$id)
 {
  $result = $this->query('delete from review where uid='.$uid.' and id='.$id);
 }

 function get_comment($aid)
 {
  $aid = intval($aid);
  $comnt = '';
  $result = $this->query("SELECT id,uid,name,sms FROM review WHERE aid=$aid");
  if (mysql_num_rows($result)>0)
  {
   while($row=mysql_fetch_array($result))
    $comnt = $comnt.'<a href="profile.php?id='.$row[1].'"><b>'.$row[2].'</b></a>: '.$row[3].'<a href="backend.delete.php?aid='.$aid.'&id='.$row[0].'"><img src="img/cancel.png" alt="[X]"/></a><br/>';
   return $comnt;
  }
  else
   return $comnt;
 }

 function query($query) 
 {
  //echo ' SQL=> <b>'.$query.'</b><br/>';
  mysql_query("set names utf8");
  $result = mysql_query($query) or die(mysql_error());
  return $result;
 }

 function printResults($result) 
 {
  while ($row = mysql_fetch_array($result))
  {
   for($i=0;$i<count($row)/2;$i++)
    echo $row[$i].' ';
   echo '<br>';
  }
 }

 function verify($paramName,$val,$len,$len2=0)
 {
  $val = trim($val);
  if (strlen($val)<$len)
  {
   echo '数据错误, '.$paramName;
   exit;
  }
  else
  {
   if ($len2 == 0)
    return $val;
   else
    return substr($val,0,$len2);
  }
 }

 function strToTitle($str)
 {
  return ucwords(strtolower($str));
 }
 
 function encode($html)
 {
   $html = trim($html);
   $html = strip_tags($html,'<b><i><u><img>');
   $html = htmlentities($html);
   $html = wordwrap($html, 60, "<br>");
   return nl2br($html);
 }
}
?>