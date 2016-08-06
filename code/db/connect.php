<?php

$host = $_SERVER["HTTP_HOST"];
$dbusername = 'root';
$dbpassword = '';
$dbname = 'codecampdb';

$db = new mysqli('localhost',$dbusername, $dbpassword, $dbname);

if($db->connect_errno){
	die($db->connect_error);
}

?>