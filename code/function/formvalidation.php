<?php 
function formatInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function nameErrCheck($data){
	return !preg_match("/^[a-zA-Z .]*$/", $data);
}

function emailErrCheck($data){
	return !filter_var($data,FILTER_VALIDATE_EMAIL);
}

function numberErrCheck($data){
	return !preg_match("/^[0-9]*$/", $data);
}

?>