<?php 
require '..\..\component\security.php';
require '..\..\db\database.php';
require 'contest.php';

if(empty($_GET['id'])){
	require 'movetodashboard.php';
}
$contest_id = $_GET['id'];

if(getContestOwnerID($contest_id) != $_SESSION["userid"]){
	require 'movetodashboard.php';	
}
//delete all student submission
$dbn = getDBH();
$stmt = $dbn->prepare('DELETE FROM `solve_list` WHERE `solve_list`.`problem_id` IN( SELECT `contest_problem_list`.`problem_id` FROM `contest_problem_list` WHERE `contest_problem_list`.`contest_id` = ?);');
$stmt->bind_param('i', $db_contest_id);
$db_contest_id = $contest_id;
$stmt->execute();
$stmt->close();
$dbn->close();

//delete all problem list
$dbn = getDBH();
$stmt = $dbn->prepare('DELETE FROM `contest_problem_list` WHERE `contest_problem_list`.`contest_id` = ?;');
$stmt->bind_param('i', $db_contest_id);
$db_contest_id = $contest_id;
$stmt->execute();
$stmt->close();
$dbn->close();

//delete contest approve list
$dbn = getDBH();
$stmt = $dbn->prepare('DELETE FROM `approve_table` WHERE `approve_table`.`contest_id` = ?');
$stmt->bind_param('i', $db_contest_id);
$db_contest_id = $contest_id;
$stmt->execute();
$stmt->close();
$dbn->close();

$course_id = getContestCourseID($contest_id);

//delete contest from contest list
$dbn = getDBH();
$stmt = $dbn->prepare('DELETE FROM `contest_list` WHERE `contest_list`.`contest_id` = ?');
$stmt->bind_param('i', $db_contest_id);
$db_contest_id = $contest_id;
$stmt->execute();
$stmt->close();
$dbn->close();


$host  = $_SERVER['HTTP_HOST'];
$uri   = '/codecamp/course';
$extra = 'contestlist.php?course='.$course_id;
header("Location: http://$host$uri/$extra");
die();

 ?>