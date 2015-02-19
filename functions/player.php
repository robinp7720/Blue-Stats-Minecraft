<?php
function getStat($stat,$player_id,$mysqli,$prefix){
	if ($stat=="lastleave"||$stat=="lastjoin"){
		/* Get Latest date */
		if ($stmt = $mysqli->prepare("SELECT {$stat} FROM `{$prefix}player` WHERE `player_id` = ? ORDER BY {$stat} DESC LIMIT 1")) {
			$stmt->bind_param("i",$player_id);
			$stmt->execute();

 			/* bind result variables */
   			 $stmt->bind_result($output);

    		/* fetch value */
   			 $stmt->fetch();

   			 return $output;
		}	
	}else{
		/* Get total of all stats if not Last left or last joined */
		if ($stmt = $mysqli->prepare("SELECT sum({$stat}) FROM `{$prefix}player` WHERE `player_id` = ?")) {
			$stmt->bind_param("i",$player_id);
			$stmt->execute();

 			/* bind result variables */
   			 $stmt->bind_result($output);

    		/* fetch value */
   			 $stmt->fetch();

   			 return $output;
		}	
	}
}
function getStatTotal($stat,$mysqli,$prefix){
	/* Get total of all stats */
	if ($stmt = $mysqli->prepare("SELECT sum({$stat}) FROM `{$prefix}player`")) {
		$stmt->execute();
		/* bind result variables */
		$stmt->bind_result($output);
		/* fetch value */
		$stmt->fetch();
		return $output;
	}	
}

function getPlayersName($id,$mysqli,$prefix){
	if ($stmt = $mysqli->prepare("SELECT name FROM `{$prefix}players` where player_id=?")) {
		$stmt->bind_param("i", $id);
		$stmt->execute();
		/* bind result variables */
		$stmt->bind_result($output);
		/* fetch value */
		$stmt->fetch();
		return $output;
	}
}
function getPlayerUUID($id,$mysqli,$prefix){
	if ($stmt = $mysqli->prepare("SELECT UUID FROM `{$prefix}players` where player_id=?")) {
		$stmt->bind_param("i", $id);
		$stmt->execute();
		/* bind result variables */
		$stmt->bind_result($output);
		/* fetch value */
		$stmt->fetch();
		return $output;
	}
}
function getPlayerId($name,$mysqli,$prefix){
	if ($stmt = $mysqli->prepare("SELECT player_id FROM `{$prefix}players` where name=?")) {
		$stmt->bind_param("s", $name);
		$stmt->execute();
		/* bind result variables */
		$stmt->bind_result($output);
		/* fetch value */
		$stmt->fetch();
		return $output;
	}
}
function blocksMinedBy($id,$mysqli,$prefix){
	if ($stmt = $mysqli->prepare("SELECT * FROM `{$prefix}block` where player_id=?")) {
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		while ($row = $result->fetch_assoc()) {
			$output[]=$row;
		}
		$stmt->close();
		if (!empty($output))return $output;
	}
}
function pvp_stats($id,$mysqli,$prefix){
	if ($stmt = $mysqli->prepare("SELECT * FROM `{$prefix}pvp` where player_id=?")) {
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		while ($row = $result->fetch_assoc()) {
			$output[]=$row;
		}
		$stmt->close();
		if (!empty($output))return $output;
	}
}

function death_stats($id,$mysqli,$prefix){
	if ($stmt = $mysqli->prepare("SELECT * FROM `{$prefix}death` where player_id=? group by `cause`")) {
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		while ($row = $result->fetch_assoc()) {
			$output[]=$row;
		}
		$stmt->close();
		if (!empty($output))return $output;
	}
}
function kill_stats($id,$mysqli,$prefix){
	if ($stmt = $mysqli->prepare("SELECT * FROM `{$prefix}kill` where player_id=? group by `type`")) {
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		while ($row = $result->fetch_assoc()) {
			$output[]=$row;
		}
		$stmt->close();
		if (!empty($output))return $output;
	}
}

function player_face($name,$size,$url){
	$image_player_url = str_replace ('{USERNAME}',$name,$url);
	$image_player_url = str_replace ('{SIZE}',$size,$image_player_url);
	return $image_player_url;
}
