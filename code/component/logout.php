<?php
session_start();
session_unset();
session_destroy(); 
$host  = $_SERVER['HTTP_HOST'];
$uri   = "/codecamp";
$extra = 'login.php';
echo "http://$host$uri/$extra";
header("Location: http://$host$uri/$extra");
die();
?>