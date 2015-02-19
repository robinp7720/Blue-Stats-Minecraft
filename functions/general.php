<?php
function getPlayers($mysqli,$prefix,$stat = "playtime",$min = 0){
	$dates = array("lastleave","lastjoin");
	if (in_array($stat, $dates)){
		$query = "
		SELECT player_id,max($stat) AS $stat
		FROM {$prefix}player
		GROUP BY player_id
		ORDER BY max($stat)
		DESC";
	}else{
		$query = "
		SELECT player_id,sum($stat) AS $stat
		FROM {$prefix}player
		WHERE $stat >= $min
		GROUP BY player_id
		ORDER BY sum($stat)
		DESC";
	}
	if ($stmt = $mysqli->prepare($query)) {
		$stmt->execute();
		$result = $stmt->get_result();
		while ($row = $result->fetch_assoc()) {
			$row["name"]=getPlayersName($row["player_id"],$mysqli,$prefix);
			$output[]=$row;

		}
		$stmt->close();
		if (!empty($output))return $output;
	}
}

function get_highscore($mysqli,$prefix,$stat,$limit){
	$dates = array("lastleave","lastjoin");
	if (in_array($stat, $dates)){
		$query = "
		SELECT player_id,max($stat) AS $stat
		FROM {$prefix}player
		GROUP BY player_id
		ORDER BY max($stat)
		DESC LIMIT $limit";
	}else{
		$query = "
		SELECT player_id,sum($stat) AS $stat
		FROM {$prefix}player
		GROUP BY player_id
		ORDER BY sum($stat)
		DESC LIMIT $limit";
	}
	if ($stmt = $mysqli->prepare($query)) {
		$stmt->execute();
		$result = $stmt->get_result();
		while ($row = $result->fetch_assoc()) {
			$row["name"]=getPlayersName($row["player_id"],$mysqli,$prefix);
			$output[]=$row;

		}
		$stmt->close();
		if (!empty($output))return $output;
	}
}

function secondsToTime($seconds,$contract=false) {
	$dtF = new DateTime("@0");
	$dtT = new DateTime("@$seconds");
	if($contract){
		if ($seconds>=86400){
			if ($seconds < 172800){
				if ($dtF->diff($dtT)->format('%h')==1){
					return $dtF->diff($dtT)->format('%a day and %h hour');
				}else{
					return $dtF->diff($dtT)->format('%a day and %h hours');
				}
			}else{
				if ($dtF->diff($dtT)->format('%h')==1){
					return $dtF->diff($dtT)->format('%a days and %h hour');
				}else{
					return $dtF->diff($dtT)->format('%a days and %h hours');
				}
			}
		}elseif ($seconds>=3600){
			if ($seconds < 7200){
				if ($dtF->diff($dtT)->format('%i')==1){
					return $dtF->diff($dtT)->format('%h hour and %i minute');
				}else{
					return $dtF->diff($dtT)->format('%h hour and %i minutes');
				}
			}else{
				if ($dtF->diff($dtT)->format('%i')==1){
					return $dtF->diff($dtT)->format('%h hours and %i minute');
				}else{
					return $dtF->diff($dtT)->format('%h hours and %i minutes');
				}
			}
		}elseif ($seconds>=60){
			if ($seconds<120){
				return $dtF->diff($dtT)->format('%i minute');
			}else{
				return $dtF->diff($dtT)->format('%i minutes');
			}
			
		}else{
			return $seconds." seconds";
		}
	}else{
		if ($seconds>=86400){
			return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes and %s seconds');
		}elseif ($seconds>=3600){
			return $dtF->diff($dtT)->format('%h hours, %i minutes and %s seconds');
		}elseif ($seconds>=60){
			return $dtF->diff($dtT)->format('%i minutes and %s seconds');
		}else{
			return $seconds." seconds";
		}
	}
}


function getPlayerCount($mysqli,$prefix){
	if ($stmt = $mysqli->prepare("SELECT count(*) FROM `{$prefix}players`")) {
		$stmt->execute();
		$result = $stmt->get_result();
		while ($row = $result->fetch_assoc()) {
			$output[]=$row;
		}
		$stmt->close();
		if (!empty($output))return $output;
	}
}

function getMaterialFromId($id,$data,$blocks_names ) {
	foreach($blocks_names as $item)
	{
		if ($item['type'] == $id && $item['meta'] == $data)
			return $item['name'];
	}

	return false;
}

function playerOnline($name, $list){
	return in_array($name,$list);
}

function make_date($date){
	$year = $date[0].$date[1].$date[2].$date[3];
	return $year;
}

function makePlayerUrl($player_id,$site_base_url,$url_rewrite,$use_name){
	if ($url_rewrite)
		return $site_base_url.'/player/'.$player_id."/";
	else
		return '?page=player&player='.urlencode($player_id);

}
function stringToColorCode($str) {
  $code = dechex(crc32($str));
  $code = substr($code, 0, 6);
  return $code;
}
