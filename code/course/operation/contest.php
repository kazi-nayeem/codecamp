<?php 
function getContestOwnerID($contest_id){
	$dbn = getDBH();
	$stmt = $dbn->prepare('SELECT `course_table`.`owner_id` FROM `contest_list` JOIN `course_table` ON `contest_list`.`course_id` = `course_table`.`course_id` WHERE `contest_list`.`contest_id` = ?');
	$stmt->bind_param('i', $db_contest_id);
	$db_contest_id = $contest_id;
	$stmt->execute();
	$stmt->bind_result($res);
	$stmt->fetch();
	$stmt->close();
	$dbn->close();
	return $res;
}



function addNewContest($course_id, $contest_title, $contest_date, $no_of_problem){
	//var_dump($course_id);
	//var_dump($contest_title);
	//var_dump($contest_date);
	//var_dump($no_of_problem);
	$dbn = getDBH();
	$stmt = $dbn->prepare('INSERT INTO `contest_list` (`contest_id`, `course_id`, `contest_name`, `contest_date`) VALUES (NULL, ?, ?, ?);');
	$stmt->bind_param('iss', $db_courseid, $db_contestname,$db_contestdate);
	$db_courseid = $course_id;
	$db_contestname = $contest_title;
	$db_contestdate = $contest_date;
	$stmt->execute();
	$contest_id = $stmt->insert_id;
	$stmt->close();
	$dbn->close();
	
	addContestProblem($contest_id,$no_of_problem);
	return $contest_id;
}

function addContestProblem($contest_id, $no_of_problem){
	$dbn = getDBH();
	$stmt = $dbn->prepare('INSERT INTO `contest_problem_list` (`problem_id`, `problem_number`, `contest_id`, `difficulty`) VALUES (NULL, ? , ?, "1");');
	$stmt->bind_param('si', $db_p_name,$db_contestid);
	$db_contestid = $contest_id;
	$name = "A";
	for($i = 0; $i < $no_of_problem; $i++,$name++){
		$db_p_name = $name;
		$stmt->execute();
	}
	$stmt->close();
	$dbn->close();
}

function getMaxNumberOfProblem($course_id){
	$dbn = getDBH();
	$stmt = $dbn->prepare('SELECT  MAX(a.count) AS maxcount FROM `contest_list` JOIN (SELECT `contest_problem_list`.`contest_id`, COUNT(*)  as `count` FROM `contest_problem_list` GROUP BY `contest_problem_list`.`contest_id`) a ON a.contest_id = `contest_list`.`contest_id` WHERE `contest_list`.`course_id` = ?;');
	$stmt->bind_param('i', $db_courseid);
	$db_courseid = $course_id;
	$stmt->execute();
	$stmt->bind_result($res);
	$stmt->fetch();
	$stmt->close();
	$dbn->close();
	if($res>=3) return $res;
	return 5;
}

function getContestNameAndDate($contest_id){
	$dbn = getDBH();
	$stmt = $dbn->prepare('SELECT `contest_list`.`contest_name`,`contest_list`.`contest_date` FROM `contest_list` WHERE `contest_list`.`contest_id` = ?');
	$stmt->bind_param('i', $db_contestid);
	$db_contestid = $contest_id;
	$stmt->execute();
	$stmt->bind_result($name,$date);
	$stmt->fetch();
	$stmt->close();
	$dbn->close();
	return $name."(".$date.")";
}

function isEnrollForThisContest($user_id, $contest_id){
	$dbn = getDBH();
	$stmt = $dbn->prepare('SELECT COUNT(*) FROM `enroll_table` WHERE `enroll_table`.`student_id` = ? AND `enroll_table`.`course_id` LIKE
							(SELECT `contest_list`.`course_id` FROM `contest_list` WHERE `contest_list`.`contest_id` = ?);');
	$stmt->bind_param('ii', $db_user_id, $db_contest_id);
	$db_user_id = $user_id;
	$db_contest_id = $contest_id;
	$stmt->execute();
	$stmt->bind_result($res);
	$stmt->fetch();
	$stmt->close();
	$dbn->close();
	if($res == 1) return true;
	return false;
}

function requestForApprove($contest_id,$student_id){
	$dbn = getDBH();
	$stmt = $dbn->prepare('INSERT INTO `approve_table` (`contest_id`, `student_id`, `approve`) VALUES (?, ?, "0");');
	$stmt->bind_param('ii', $db_contest_id,$db_student_id);
	$db_contest_id = $contest_id;
	$db_student_id = $student_id;
	$stmt->execute();
	$stmt->close();
	$dbn->close();
}

function viewStudentSubmission($contest_id, $student_id, $numOfrow){
	$dbn = getDBH();
	$stmt = $dbn->prepare('SELECT `contest_problem_list`.`problem_id`, `solve_list`.`no_submission`, `solve_list`.`time` 
							FROM `contest_problem_list` LEFT JOIN `solve_list`
							ON `contest_problem_list`.`problem_id` = `solve_list`.`problem_id`
							WHERE `solve_list`.`student_id` = ? AND `contest_problem_list`.`contest_id` = ?
							ORDER BY `contest_problem_list`.`problem_number`');
	$stmt->bind_param('ii', $db_student_id,$db_contest_id);
	$db_student_id = $student_id;
	$db_contest_id = $contest_id;
	$stmt->execute();
	$result = $stmt->get_result();
	$i = 0;
	while ($row = $result->fetch_assoc()) {
		echo "<td>".subView($row['time'], $row['no_submission'])."</td>";
		$i++;
	}
	$result->free();
	$stmt->close();
	$dbn->close();
	//var_dump($numOfrow);
	while ($i<$numOfrow) {
		$i++;
		echo "<td>".''."</td>";
	}
}

function subView($time,$no_submission = 0){
	$str = "";
	if(!is_null($time) AND ($time != 0)){
		$hh = (int) ($time/3600);
		$mm = ((int) ($time/60))%60;
		$ss = $time%60;
		$str = $hh.":".$mm.":".$ss;
	}
	if(!is_null($no_submission) AND ($no_submission != 0)){
		$str = $str."(".$no_submission.")";
	}
	return $str;
}

function needToUpdate($contest_id,$student_id){
	$dbn = getDBH();
	$stmt = $dbn->prepare('SELECT COUNT(*) FROM `approve_table` WHERE `approve_table`.`student_id` = ? AND `approve_table`.`contest_id` = ?;');
	$stmt->bind_param('ii', $db_user_id, $db_contest_id);
	$db_user_id = $student_id;
	$db_contest_id = $contest_id;
	$stmt->execute();
	$stmt->bind_result($res);
	$stmt->fetch();
	$stmt->close();
	$dbn->close();
	if($res == 1) return false;
	return true;
}

function isPendingRequest($contest_id,$student_id){
	$dbn = getDBH();
	$stmt = $dbn->prepare('SELECT COUNT(*) FROM `approve_table` WHERE `approve_table`.`student_id` = ? AND `approve_table`.`contest_id` = ? AND 
							`approve_table`.`approve` = 1;');
	$stmt->bind_param('ii', $db_user_id, $db_contest_id);
	$db_user_id = $student_id;
	$db_contest_id = $contest_id;
	$stmt->execute();
	$stmt->bind_result($res);
	$stmt->fetch();
	$stmt->close();
	$dbn->close();
	if($res == 0) return true;
	return false;
}

function numberOfProblemInOneContest($contest_id){
	$dbn = getDBH();
	$stmt = $dbn->prepare('SELECT COUNT(*) FROM `contest_problem_list` WHERE `contest_problem_list`.`contest_id` = ?;');
	$stmt->bind_param('i', $db_contest_id);
	$db_contest_id = $contest_id;
	$stmt->execute();
	$stmt->bind_result($res);
	$stmt->fetch();
	$stmt->close();
	$dbn->close();
	return $res;
}

function getContestCourseID($contest_id){
	$dbn = getDBH();
	$stmt = $dbn->prepare('SELECT `contest_list`.`course_id` FROM `contest_list` WHERE `contest_list`.`contest_id` = ?');
	$stmt->bind_param('i', $db_contest_id);
	$db_contest_id = $contest_id;
	$stmt->execute();
	$stmt->bind_result($res);
	$stmt->fetch();
	$stmt->close();
	$dbn->close();
	return $res;
}

function getEnrollIDofStudent($contest_id,$student_id){
	$dbn = getDBH();
	$stmt = $dbn->prepare('SELECT `enroll_table`.`enroll_id` FROM `enroll_table` WHERE `enroll_table`.`student_id` = ? AND `enroll_table`.`course_id` = (SELECT `contest_list`.`course_id` FROM `contest_list` WHERE `contest_list`.`contest_id` = ?);');
	$stmt->bind_param('ii', $db_student_id, $db_contest_id);
	$db_contest_id = $contest_id;
	$db_student_id = $student_id;
	$stmt->execute();
	$stmt->bind_result($res);
	$stmt->fetch();
	$stmt->close();
	$dbn->close();
	return $res;
}

?>
