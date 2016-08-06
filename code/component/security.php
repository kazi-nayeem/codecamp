<?php 
session_start();
ini_set('max_execution_time', 3000);
if(!(isset($_SESSION["userid"]) and isset($_SESSION["username"]))){
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = "/codecamp/component";
	$extra = 'logout.php';
	echo "http://$host$uri/$extra";
	header("Location: http://$host$uri/$extra");
	die();
}

?>