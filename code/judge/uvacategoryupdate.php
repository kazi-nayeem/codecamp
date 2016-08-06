<?php
require '..\db\database.php';
ini_set('max_execution_time', 3000);

$ProblemID = array();

$respond = file_get_contents("http://uhunt.felix-halim.net/api/p");
$result = json_decode($respond, true);

for($i = 0; $i < count($result); $i++){
	$ProblemID[$result[$i][1]] = $result[$i][0];
	//echo $result[$i][1]."->";
	//echo getProblemID($result[$i][1]);

	//echo "<br>";
}

update(3);

function update($id){
	$respond = file_get_contents("http://uhunt.felix-halim.net/api/cpbook/".$id);
	echo "http://uhunt.felix-halim.net/api/cpbook/".$id;
	$result = json_decode($respond, true);
	//var_dump($result);
	for($i = 0; $i < count($result); $i++){
		echo "<br>";
		echo "<br>";
		fun($result[$i], 1, array());
		echo "<br>";
		echo "<br>";
		echo "<br>";
	}
}

function fun($json , $di, $topic){
	echo "<br>";
	for($i = 0; $i < $di; $i++)
		echo "----";
	if($di<=2)
		echo $json["title"];
		if($di == 2){
			$topic[count($topic)] = $json["title"];
		}
	if($di == 3){
		echo $json[0];
		$topic[count($topic)] = $json[0];
		echo "<br> <br> final  ->";
		for($i = 0; $i < count($topic); $i++){
			echo $topic[$i]."-->";
		}
		echo "<br>";

		$dbn = getDBH();
		$stmt = $dbn->prepare('INSERT INTO `uva_problem_category` (`problem_number`, `category`) VALUES (?, ?);');
		$stmt->bind_param('is',$p_id,$p_ca);

		for($i = 1; $i < count($json); $i++){
			$p_id = getProblemID(abs($json[$i]));
			echo "pid->>".$p_id."->>";
			echo abs($json[$i]). "->>". $json[0];
			
			$p_ca = $json[0];
			if($stmt->execute() == true){
				echo "->>>add".$p_ca;
			}else{
				echo "->>>not added".$p_ca;
				//var_dump($stmt);
				break;
			}
			$p_ca = $topic[0];
			if($stmt->execute() == true){
				echo "->>>add".$p_ca;
			}else{
				echo "->>>not added".$p_ca;
			}
			echo "<br>";
		}

		echo "<br>";
		echo "<br>";
		$stmt->close();
		$dbn->close();
		return;
	}
	

	$arr = $json["arr"];

	for($i = 0; $i < count($arr); $i++){
		fun($arr[$i],$di+1, $topic);
	}
}

function getProblemID($problem_number){
	global $ProblemID;
	return $ProblemID[$problem_number];
}

?>