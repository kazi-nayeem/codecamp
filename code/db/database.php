<?php 

function getDBH(){
	$host = $_SERVER["HTTP_HOST"];
	$dbusername = 'root';
	$dbpassword = '';
	$dbname = 'codecampdb';
	
	$dbn = new mysqli('localhost',$dbusername, $dbpassword, $dbname);

	if($dbn->connect_errno){
		die($dbn->connect_error);
	}
	return $dbn;
}

?>