<?php
session_start();
header("Content-Type: text/html; charset=UTF-8");
unset($_SESSION['id']);
unset($_SESSION['name']);
session_destroy();
header('Location: index.php');
?>