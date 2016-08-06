<?php 
require '..\..\component\security.php';
require '..\..\db\database.php';
require 'contest.php';

if(empty($_GET['id']) or empty($_GET['student'])){
	require 'movetodashboard.php';
}
$contest_id = $_GET['id'];
$student_id = $_GET['student'];

if(getContestOwnerID($contest_id) != $_SESSION["userid"]){
	require 'movetodashboard.php';	
}

$dbn = getDBH();
$stmt = $dbn->prepare('DELETE FROM `solve_list` WHERE `solve_list`.`student_id` = ? AND `solve_list`.`problem_id` IN (SELECT `contest_problem_list`.`problem_id` FROM `contest_problem_list` WHERE `contest_problem_list`.`contest_id` = ?)');
$stmt->bind_param('ii', $db_student_id, $db_contest_id);
$db_student_id = $student_id;
$db_contest_id = $contest_id;
$stmt->execute();
$stmt->close();
$dbn->close();

$dbn = getDBH();
$stmt = $dbn->prepare('DELETE FROM `approve_table` WHERE `approve_table`.`contest_id` = ? AND `approve_table`.`student_id` = ?');
$stmt->bind_param('ii', $db_contest_id, $db_student_id);
$db_student_id = $student_id;
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