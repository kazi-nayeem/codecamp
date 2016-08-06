<?php 
 function getCodeForcesHandle($user_id){
 	$dbn = getDBH();
	$stmt = $dbn->prepare('SELECT `handle_table`.handle FROM `handle_table` JOIN `codeforces_user` ON `handle_table`.judge_code_id = `codeforces_user`.judge_code_id WHERE `codeforces_user`.user_id = ?;');
	$stmt->bind_param('i', $id);
	$id = $user_id;
	$stmt->execute();
	$stmt->bind_result($userCodeForcesHandel);
	$stmt->fetch();
	$dbn->close();
	return $userCodeForcesHandel;
 }

function deleteCodeforcesHandle($user_id){
 	$dbn = getDBH();
	$stmt = $dbn->prepare('DELETE FROM `codeforces_user` WHERE `codeforces_user`.`user_id` = ?;');
	$stmt->bind_param('i', $id);
	$id = $user_id;
	$stmt->execute();
	$dbn->close();
 }

 function updateUserCodeforcesHandle($id,$handle){
 	$dbn = getDBH();
	$stmt = $dbn->prepare('UPDATE `codeforces_user` SET `judge_code_id` = ? WHERE `codeforces_user`.`user_id` = ?;');
	$stmt->bind_param('ii', $judge_code,$user_id);
	$user_id = $id;
	$judge_code = getCodeforcesJudgeCodeID($handle);
	$stmt->execute();
	
	if($stmt->affected_rows!=1){
		$dbn2 = getDBH();
		$stmt = $dbn2->prepare('INSERT INTO `codeforces_user` (`user_id`, `judge_code_id`) VALUES (?, ?);');
		$stmt->bind_param('ii',$user_id,$judge_code);
		$user_id = $id;
		$judge_code = getCodeforcesJudgeCodeID($handle);
		$stmt->execute();
		$dbn2->close();
	}
	$dbn->close();
 }

 

 function getCodeforcesJudgeCodeID($handle){
 	$dbn = getDBH();
	$stmt = $dbn->prepare("SELECT `handle_table`.judge_code_id FROM `handle_table` WHERE `handle_table`.judge_name = 'codeforces' AND `handle_table`.handle = ?;");
	$stmt->bind_param('s', $id);
	$id = $handle;
	$stmt->execute();
	$stmt->bind_result($judge_code);
	$stmt->fetch();
	$dbn->close();
	if($judge_code>0)
		return $judge_code;
	else
		return insertCodeforcesHandle($handle);
 }

 function insertCodeforcesHandle($handle){
 	$dbn = getDBH();
	$stmt = $dbn->prepare("INSERT INTO `handle_table` (`judge_name`, `handle`) VALUES ('codeforces', ?);");
	$stmt->bind_param('s', $id);
	$id = $handle;
	$stmt->execute();
	$dbn->close();
	return $stmt->insert_id;
 }

function updateCodeforcesUserID($user_id){
	$handle = getCodeForcesHandle($user_id);
	if(is_null($handle)) return;
	$link = "http://codeforces.com/api/user.status?handle=".$handle;
	
	$respond = file_get_contents($link);
	$result = json_decode($respond,true);

	if($result["status"] == "OK"){
		$result = $result["result"];
	}else{
		return;
	}

	$dbn = getDBH();
	$stmt = $dbn->prepare('INSERT INTO `codeforces_solve` (`problem_number`, `judge_code_id`, `timestamp`) VALUES (?, ?, ?);');
	$stmt->bind_param('sii',$problem_number,$judge_code_id,$timestamp);
	$judge_code_id = getCodeforcesJudgeCodeID($handle);

	$stmt2 = $dbn->prepare('INSERT INTO `codeforces_category` (`problem_number`, `category`) VALUES (?, ?);');
	$stmt2->bind_param('ss',$problem_number,$category);

	for($i = 0; $i < count($result); $i++){
		$subs = $result[$i];
		
		if($subs["verdict"] != "OK") continue;

		$timestamp = $subs["creationTimeSeconds"];

		$problem = $subs["problem"];
		
		
		$problem_number = $problem["contestId"].$problem["index"];
		$stmt->execute();

		$tags = $problem["tags"];
		
		for($j = 0; $j < count($tags); $j++){
			$category = $tags[$j];
			$stmt2->execute();
		}
	
	}

	$stmt->close();
	$stmt2->close();
	$dbn->close();
}

function getCodeforcesNumberOfSolve($user_id,$time = 0){
	$dbn = getDBH();
	$stmt = $dbn->prepare("SELECT COUNT(`codeforces_solve`.`problem_number`) FROM `codeforces_solve` WHERE `codeforces_solve`.`judge_code_id` = ? AND `codeforces_solve`.`timestamp`>=?;");
	$stmt->bind_param('ii', $id,$last_time);

	$id = getCodeforcesJudgeCodeID(getCodeforcesHandle($user_id));
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