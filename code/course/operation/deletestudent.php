<?php 
require '..\..\component\security.php';
require '..\..\db\database.php';
require 'courseinfo.php';

if(isset($_GET["course"]) and isset($_GET["student"])){
	$course_id = $_GET["course"];
	$student_id = $_GET["student"];

	if($student_id == $_SESSION["userid"]){
		deleteStudent($course_id,$student_id);
		require 'movetodashboard.php';	
	}elseif (getCourseOwnerId($course_id) == $_SESSION["userid"]) {
		deleteStudent($course_id,$student_id);
		$host  = $_SERVER['HTTP_HOST'];
		$uri   = '/codecamp/course';
		$extra = 'dashboard.php?course='.$course_id;
		header("Location: http://$host$uri/$extra");
		die();
	}else{
		require 'movetodashboard.php';
	}


}else{
	require 'movetodashboard.php';
}

echo "string";


function deleteStudent($course_id,$student_id){
	//delete approve info
	$dbn = getDBH();
	$stmt = $dbn->prepare('DELETE FROM `approve_table` WHERE `student_id` = ? AND `contest_id` IN (SELECT `contest_list`.`contest_id` FROM `contest_list` WHERE `contest_list`.`course_id` = ?);');
	$stmt->bind_param('ii', $db_student, $db_course);
	$db_course = $course_id;
	$db_student = $student_id;
	$stmt->execute();
	$stmt->close();
	$dbn->close();

	//delete solve problem list
	$dbn = getDBH();
	$stmt = $dbn->prepare('DELETE FROM `solve_list` WHERE `student_id` = ? AND `problem_id` IN (SELECT `contest_problem_list`.`problem_id` FROM `contest_problem_list` WHERE `contest_problem_list`.`contest_id` IN (SELECT `contest_list`.`contest_id` FROM `contest_list` WHERE `contest_list`.`course_id` = ?));');
	$stmt->bind_param('ii', $db_student, $db_course);
	$db_course = $course_id;
	$db_student = $student_id;
	$stmt->execute();
	$stmt->close();
	$dbn->close();

	//delete enroll info
	$dbn = getDBH();
	$stmt = $dbn->prepare('DELETE FROM `enroll_table` WHERE `enroll_table`.`course_id` = ? AND `enroll_table`.`student_id` = ?;');
	$stmt->bind_param('ii',$db_course,$db_student);
	$db_course = $course_id;
	$db_student = $student_id;
	$stmt->execute();
	$stmt->close();
	$dbn->close();
}

 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>delete student</title>
 </head>
 <body>
 
 </body>
 </html>