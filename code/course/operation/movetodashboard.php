<?php 
$host  = $_SERVER['HTTP_HOST'];
$uri   = '/codecamp';
$extra = 'dashboard.php';
header("Location: http://$host$uri/$extra");
die();
?>