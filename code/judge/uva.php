<?php 
 function getUVAHandle($user_id){
 	$dbn = getDBH();
	$stmt = $dbn->prepare('SELECT `handle_table`.handle FROM `handle_table` JOIN `uva_user` ON `handle_table`.judge_code_id = `uva_user`.judge_code_id WHERE `uva_user`.user_id = ?;');
	$stmt->bind_param('i', $id);
	$id = $user_id;
	$stmt->execute();
	$stmt->bind_result($userUvaHandel);
	$stmt->fetch();
	$dbn->close();
	return $userUvaHandel;
 }

function deleteUVAHandle($user_id){
 	$dbn = getDBH();
	$stmt = $dbn->prepare('DELETE FROM `uva_user` WHERE `uva_user`.`user_id` = ?;');
	$stmt->bind_param('i', $id);
	$id = $user_id;
	$stmt->execute();
	$dbn->close();
 }

 function updateUserUVAHandle($id,$handle){
 	$dbn = getDBH();
	$stmt = $dbn->prepare('UPDATE `uva_user` SET `judge_code_id` = ? WHERE `uva_user`.`user_id` = ?;');
	$stmt->bind_param('ii', $judge_code,$user_id);
	$user_id = $id;
	$judge_code = getUVaJudgeCodeID($handle);
	$stmt->execute();
	
	if($stmt->affected_rows!=1){
		$dbn2 = getDBH();
		$stmt = $dbn2->prepare('INSERT INTO `uva_user` (`user_id`, `judge_code_id`) VALUES (?, ?);');
		$stmt->bind_param('ii',$user_id,$judge_code);
		$user_id = $id;
		$judge_code = getUVaJudgeCodeID($handle);
		$stmt->execute();
		$dbn2->close();
	}
	$dbn->close();
 }

 

 function getUVaJudgeCodeID($handle){
 	$dbn = getDBH();
	$stmt = $dbn->prepare("SELECT `handle_table`.judge_code_id FROM `handle_table` WHERE `handle_table`.judge_name = 'uva' AND `handle_table`.handle = ?;");
	$stmt->bind_param('s', $id);
	$id = $handle;
	$stmt->execute();
	$stmt->bind_result($judge_code);
	$stmt->fetch();
	$dbn->close();
	if($judge_code>0)
		return $judge_code;
	else
		return insertUVAHandle($handle);
 }

 function insertUVAHandle($handle){
 	$dbn = getDBH();
	$stmt = $dbn->prepare("INSERT INTO `handle_table` (`judge_name`, `handle`) VALUES ('uva', ?);");
	$stmt->bind_param('s', $id);
	$id = $handle;
	$stmt->execute();
	$dbn->close();
	return $stmt->insert_id;
 }

function updateUserUvaSolve($user_id){
	$userUvaHandle = getUVAHandle($user_id);
	if(is_null($userUvaHandle)) return;
	$uva_judge_code_id = getUVaJudgeCodeID($userUvaHandle);

	$respond = file_get_contents("http://uhunt.felix-halim.net/api/uname2uid/".$userUvaHandle);
	$userid = trim($respond);
	$lastid = getUvaLastSubID($uva_judge_code_id);

	$link = "http://uhunt.felix-halim.net/api/subs-user/".$userid."/".$lastid;
	$respond = file_get_contents($link);
	$result = json_decode($respond,true);
	$subs = $result["subs"];
	$dbn = getDBH();
	$stmt = $dbn->prepare('INSERT INTO `uva_solve` (`problem_number`, `judge_code_id`, `uva_judge_id`, `timestamp`) VALUES (?, ?, ?, ?);');
	$stmt->bind_param('iiis', $problem_number,$judge_code_id,$uva_sub_id,$timestamp);
	
	$judge_code_id = $uva_judge_code_id;

	$queueTime = time()+(7*24*60*60);

	for($i = 0; $i < count($subs); $i++){
		if($subs[$i][2] == 90){
			$uva_sub_id = $subs[$i][0];
			$problem_number = $subs[$i][1];
			$timestamp = $subs[$i][4];
			$stmt->execute();
		}elseif ($subs[$i][2] == 20) {
			$queueTime = max($queueTime,$subs[$i][4]);
		}
	}
	$stmt->close();
	$dbn->close();
	deleteUvaSolveProblem($queueTime);
}

function deleteUvaSolveProblem($time){
	$dbn = getDBH();
	$stmt = $dbn->prepare('DELETE FROM `uva_solve` WHERE `uva_solve`.`timestamp`>=?;');
	$stmt->bind_param('i', $ti);
	$ti = $time;
	$stmt->execute();
	$stmt->close();
	$dbn->close();
}

function getUvaLastSubID($judge_code_id){
	$dbn = getDBH();
	$stmt = $dbn->prepare("SELECT MAX(`uva_solve`.`uva_judge_id`) FROM `uva_solve` WHERE `uva_solve`.`judge_code_id` = ?;");
	$stmt->bind_param('i', $id);
	$id = $judge_code_id;
	$stmt->execute();
	$stmt->bind_result($judge_sub_id);
	$stmt->fetch();
	$dbn->close();
	if($judge_sub_id>=0)
		return $judge_sub_id;
	return 0;
}

function getUvaNumberOfSolve($user_id,$time = 0){
	$dbn = getDBH();
	$stmt = $dbn->prepare("SELECT COUNT(`uva_solve`.`problem_number`) FROM `uva_solve` WHERE `uva_solve`.`judge_code_id` = ? AND `uva_solve`.`timestamp`>=?;");
	$stmt->bind_param('ii', $id,$last_time);

	$id = getUVaJudgeCodeID(getUVAHandle($user_id));
	$last_time = $time;
	$stmt->execute();
	$stmt->bind_result($prob_no);
	$stmt->fetch();
	$dbn->close();
	if($prob_no>=0)
		return $prob_no;
	return 0;
}

?>