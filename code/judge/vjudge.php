<?php 
 function getVjudgeHandle($user_id){
 	$dbn = getDBH();
	$stmt = $dbn->prepare('SELECT `handle_table`.handle FROM `handle_table` JOIN `vjudge_user` ON `handle_table`.judge_code_id = `vjudge_user`.judge_code_id WHERE `vjudge_user`.user_id = ?;');
	$stmt->bind_param('i', $id);
	$id = $user_id;
	$stmt->execute();
	$stmt->bind_result($userVjudgeHandel);
	$stmt->fetch();
	$dbn->close();
	return $userVjudgeHandel;
 }

 function deleteVjudgeHandle($user_id){
 	$dbn = getDBH();
	$stmt = $dbn->prepare('DELETE FROM `vjudge_user` WHERE `vjudge_user`.`user_id` = ?;');
	$stmt->bind_param('i', $id);
	$id = $user_id;
	$stmt->execute();
	$dbn->close();
 }

 function updateUserVjudgeHandle($id,$handle){
 	$dbn = getDBH();
	$stmt = $dbn->prepare('UPDATE `vjudge_user` SET `judge_code_id` = ? WHERE `vjudge_user`.`user_id` = ?;');
	$stmt->bind_param('ii', $judge_code,$user_id);
	$user_id = $id;
	$judge_code = getVjudgeJudgeCodeID($handle);
	$stmt->execute();
	
	if($stmt->affected_rows!=1){
		$dbn2 = getDBH();
		$stmt = $dbn2->prepare('INSERT INTO `vjudge_user` (`user_id`, `judge_code_id`) VALUES (?, ?);');
		$stmt->bind_param('ii',$user_id,$judge_code);
		$user_id = $id;
		$judge_code = getVjudgeJudgeCodeID($handle);
		$stmt->execute();
		$dbn2->close();
	}
	$dbn->close();
 }

 

 function getVjudgeJudgeCodeID($handle){
 	$dbn = getDBH();
	$stmt = $dbn->prepare("SELECT `handle_table`.judge_code_id FROM `handle_table` WHERE `handle_table`.judge_name = 'vjudge' AND `handle_table`.handle = ?;");
	$stmt->bind_param('s', $id);
	$id = $handle;
	$stmt->execute();
	$stmt->bind_result($judge_code);
	$stmt->fetch();
	$dbn->close();
	if($judge_code>0)
		return $judge_code;
	else
		return insertVjudgeHandle($handle);
 }

 function insertVjudgeHandle($handle){
 	$dbn = getDBH();
	$stmt = $dbn->prepare("INSERT INTO `handle_table` (`judge_name`, `handle`) VALUES ('vjudge', ?);");
	$stmt->bind_param('s', $id);
	$id = $handle;
	$stmt->execute();
	$dbn->close();
	return $stmt->insert_id;
 }


?>