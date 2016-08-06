<?php 
require '..\..\component\security.php';
require '..\..\db\database.php';
require 'courseinfo.php';

if(isset($_GET["course"])) {
	$course_id = $_GET["course"];
	if (getCourseOwnerId($course_id) == $_SESSION["userid"]) {
		deleteCourse($course_id);
	}
}

require 'movetodashboard.php';

function deleteCourse($course_id) {
	//delete approve info
	$dbn = getDBH();
	$stmt = $dbn->prepare('DELETE FROM `approve_table` WHERE `contest_id` IN (SELECT `contest_list`.`contest_id` FROM `contest_list` WHERE `contest_list`.`course_id` = ?);');
	$stmt->bind_param('i', $db_course);
	$db_course = $course_id;	
	$stmt->execute();
	$stmt->close();
	$dbn->close();

	//delete student contest solve list
	$dbn = getDBH();
	$stmt = $dbn->prepare('DELETE FROM `solve_list` WHERE `problem_id` IN (SELECT `contest_problem_list`.`problem_id` FROM `contest_problem_list` WHERE `contest_problem_list`.`contest_id` IN (SELECT `contest_list`.`contest_id` FROM `contest_list` WHERE `contest_list`.`course_id` = ?));');
	$stmt->bind_param('i', $db_course);
	$db_course = $course_id;
	$stmt->execute();
	$stmt->close();
	$dbn->close();

	//delete course contest problem list
	$dbn = getDBH();
	$stmt = $dbn->prepare('DELETE FROM `contest_problem_list` WHERE `contest_id` IN (SELECT `contest_list`.`contest_id` FROM `contest_list` WHERE `contest_list`.`course_id` = ?);');
	$stmt->bind_param('i', $db_course);
	$db_course = $course_id;
	$stmt->execute();
	$stmt->close();
	$dbn->close();

	//delete course contest list
	$dbn = getDBH();
	$stmt = $dbn->prepare('DELETE FROM `contest_list` WHERE `course_id` = ?;');
	$stmt->bind_param('i', $db_course);
	$db_course = $course_id;
	$stmt->execute();
	$stmt->close();
	$dbn->close();

	//delete enroll list
	$dbn = getDBH();
	$stmt = $dbn->prepare('DELETE FROM `enroll_table` WHERE `enroll_table`.`course_id` = ?');
	$stmt->bind_param('i',$db_course);
	$db_course = $course_id;
	
	$stmt->execute();
	$stmt->close();

	//delete course
	$stmt = $dbn->prepare('DELETE FROM `course_table` WHERE `course_table`.`course_id` = ?');
	$stmt->bind_param('i',$db_course);
	$db_course = $course_id;
	
	$stmt->execute();
	$stmt->close();

	$dbn->close();
}

?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>delete course</title>
 </head>
 <body>
 
 </body>
 </html>