<?php
if (!function_exists('foo'))
 include ('config.php');
error_reporting(error_reporting_level);

class html
{
 function __construct() { }

 function draw($tag,$_align=0,$border=1) {
  $align=array('justify','left','center','right');
  echo '<'.$tag.' align="'.$align[$_align].'" border="'.$border.'px">';
 }

 function encode($val) {
   $val = trim($val);
   $val = strip_tags($val,'<b><i><u><img>');
   $val = htmlentities($val);
   $val = wordwrap($val, 60, "<br>");
   return nl2br($val);
 }

 function decode($val) {
   return html_entity_decode($val);
 }
}
?>