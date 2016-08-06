<?php 
function getCurrentProblemToUpdate($user_id,$contest_id){
	$dbn = getDBH();
	$stmt = $dbn->prepare('SELECT `contest_problem_list`.`problem_id` FROM `contest_problem_list` WHERE `contest_problem_list`.`contest_id` = ? AND `contest_problem_list`.`problem_id` NOT IN (SELECT `solve_list`.`problem_id` FROM `solve_list` WHERE `solve_list`.`student_id` = ?) ORDER BY `contest_problem_list`.`problem_id`;');
	$stmt->bind_param('ii', $db_contest_id, $db_user_id);
	$db_user_id = $user_id;
	$db_contest_id = $contest_id;
	$stmt->execute();
	$result = $stmt->get_result();
	$res = NULL;
	if($row = $result->fetch_assoc()){
		$res = $row['problem_id'];
	}
	$result->free();
	$stmt->close();
	$dbn->close();
	return $res;
}

function getProblemName($problem_id){
	$dbn = getDBH();
	$stmt = $dbn->prepare('SELECT `contest_problem_list`.`problem_number` FROM `contest_problem_list` WHERE `contest_problem_list`.`problem_id` = ?;');
	$stmt->bind_param('i', $db_problem_id);
	$db_problem_id = $problem_id;
	$stmt->execute();
	$stmt->bind_result($res);
	$stmt->fetch();
	$stmt->close();
	$dbn->close();
	return $res;
}

function addProblemToUser($user_id,$problem_id,$solve_flag,$no_of_sub,$total_time){
	$dbn = getDBH();
	$stmt = $dbn->prepare('INSERT INTO `solve_list` (`problem_id`, `student_id`, `no_submission`, `solve_flag`, `time`) VALUES (?, ?, ?, ?, ?);');
	$stmt->bind_param('iiiii', $db_problem_id,$db_student_id,$db_no_of_sub,$db_solve,$db_time);
	$db_problem_id = $problem_id;
	$db_student_id = $user_id;
	$db_no_of_sub = $no_of_sub;
	$db_solve = $solve_flag;
	$db_time = $total_time;
	$stmt->execute();
	$stmt->close();
	$dbn->close();
}

 ?>