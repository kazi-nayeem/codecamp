<?php 
$userName = $_SESSION["username"];
$dbn = getDBH();
$stmt = $dbn->prepare('SELECT user_email,reg_date FROM `user_table` WHERE user_id = ?;');
$stmt->bind_param('i', $user_id);
$user_id = $_SESSION["userid"];
$stmt->execute();
$stmt->bind_result($userEmail,$userRegDate);
$stmt->fetch();

function getUserName($id){
	$dbn = getDBH();
	$stmt = $dbn->prepare('SELECT user_name FROM `user_table` WHERE user_id = ?;');
	$stmt->bind_param('i', $user_id);
	$user_id = $id;
	$stmt->execute();
	$stmt->bind_result($Name);
	$stmt->fetch();
	return $Name;
}

function updateUserName($id,$name){
	$dbn = getDBH();
	$stmt = $dbn->prepare('UPDATE `user_table` SET `user_name` = ? WHERE `user_table`.`user_id` = ?;');
	$stmt->bind_param('si', $user_name,$user_id);
	$user_id = $id;
	$user_name= $name;
	$stmt->execute();
}

function updateUserPassword($id,$pass){
	$dbn = getDBH();
	$stmt = $dbn->prepare('UPDATE `user_table` SET `password` = ? WHERE `user_table`.`user_id` = ?;');
	$stmt->bind_param('si', $user_pass,$user_id);
	$user_id = $id;
	$user_pass = $pass;
	$stmt->execute();
}

?>