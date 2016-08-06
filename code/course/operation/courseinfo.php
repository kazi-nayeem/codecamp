<?php 

function getCourseOwnerId($course_id){
	$dbn = getDBH();
	$stmt = $dbn->prepare('SELECT `course_table`.`owner_id` FROM `course_table` WHERE `course_table`.`course_id` = ?;');
	$stmt->bind_param('i', $db_course_id);
	$db_course_id = $course_id;
	$stmt->execute();
	$stmt->bind_result($result);
	$stmt->fetch();
	$dbn->close();
	return $result;
}

function getCourseTitle($course_id){
	$dbn = getDBH();
	$stmt = $dbn->prepare('SELECT `course_table`.`course_title` FROM `course_table` WHERE `course_table`.`course_id` = ?;');
	$stmt->bind_param('i', $db_course_id);
	$db_course_id = $course_id;
	$stmt->execute();
	$stmt->bind_result($result);
	$stmt->fetch();
	$dbn->close();
	return $result;
}

function getRegistrationCode($course_id){
	$dbn = getDBH();
	$stmt = $dbn->prepare('SELECT `course_table`.`course_password` FROM `course_table` WHERE `course_table`.`course_id` = ?;');
	$stmt->bind_param('i', $db_course_id);
	$db_course_id = $course_id;
	$stmt->execute();
	$stmt->bind_result($result);
	$stmt->fetch();
	$dbn->close();
	return $result;
}


function getTotalStudent($course_id){
	$dbn = getDBH();
	$stmt = $dbn->prepare('SELECT COUNT(`enroll_table`.`student_id`) FROM `enroll_table` WHERE `enroll_table`.`course_id` = ?;');
	$stmt->bind_param('i', $db_course_id);
	$db_course_id = $course_id;
	$stmt->execute();
	$stmt->bind_result($result);
	$stmt->fetch();
	$dbn->close();
	return $result;
}

function getCourseStartDate($course_id){
	$dbn = getDBH();
	$stmt = $dbn->prepare('SELECT `course_table`.`start_date` FROM `course_table` WHERE `course_table`.`course_id` = ?;');
	$stmt->bind_param('i', $db_course_id);
	$db_course_id = $course_id;
	$stmt->execute();
	$stmt->bind_result($result);
	$stmt->fetch();
	$dbn->close();
	return $result;
}

function getCourseEnrollID($course_id,$student_id){

	$dbn = getDBH();
	$stmt = $dbn->prepare('SELECT `enroll_table`.`enroll_id` FROM `enroll_table` WHERE `enroll_table`.`course_id` = ? AND `enroll_table`.`student_id` = ?;');
	$stmt->bind_param('ii', $db_course_id,$db_student_id);
	$db_course_id = $course_id;
	$db_student_id = $student_id;
	$stmt->execute();
	$stmt->bind_result($result);
	$stmt->fetch();
	$dbn->close();
	
	return $result;
}

?>