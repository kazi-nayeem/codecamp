<?php 
require '..\..\component\security.php';
require '..\..\db\database.php';
require 'contest.php';

if(empty($_GET['id']) ){
	require 'movetodashboard.php';
}
$contest_id = $_GET['id'];


if(getContestOwnerID($contest_id) != $_SESSION["userid"]){
	require 'movetodashboard.php';	
}

$dbn = getDBH();
$stmt = $dbn->prepare('UPDATE `approve_table` SET `approve` = 1 WHERE `approve_table`.`contest_id` = ?;');
$stmt->bind_param('i', $db_contest_id);
$db_contest_id = $contest_id;

$stmt->execute();

$stmt->close();
$dbn->close();

$host  = $_SERVER['HTTP_HOST'];
$uri   = '/codecamp/course';
$extra = 'contest.php?id='.$contest_id;
header("Location: http://$host$uri/$extra");
die();

 ?>