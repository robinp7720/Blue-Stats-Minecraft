<?php
/* Get all players */
$players = getPlayers($mysqli,$stats_mysql["table_prefix"],$allPlayers_default_stat_displayed,$allPlayers_min_value);

/* Loop Through each player */
foreach ($players as $item => $player){
	
	/* If the stat is playtime make it readable */
	if ($allPlayers_default_stat_displayed=="playtime"){
		$stat = secondsToTime($player[$allPlayers_default_stat_displayed],$play_time_contract);
	}else{
		$stat = $player[$allPlayers_default_stat_displayed];
	}
	
	
	/* Get image url */
	$image_url = player_face($player["name"],$config["faces"]["allplayers"]["size"],$config["faces"]["allplayers"]["url"]);

	/* Get user label (Click able username and image) */
	if ($config["url"]["player"]["useName"])
		$player_url = urlencode($player["name"]);
	else
		$player_url = $player["player_id"];
	
	$player_label = '<a href="'.makePlayerUrl($player_url,$site_base_url,$enable_url_rewrite,$config["url"]["player"]["useName"]).'"><img class="player-head-player_page" src="'.$image_url.'" alt="'.$player["name"].'"/> '.$player["name"].'</a></td>';
	
	/* If mc query is enabled */
	if ($server_info["query_enabled"]){
		/* Get player status */
		if (isset($Online_Players)){
			if (playerOnline($player["name"], $Online_Players)){
				$status = '<span class="label label-success">Online</span>';
			}else{
				$status = '<span class="label label-danger">Offline</span>';
			}
		}
		$output["data"][]=array(
			$player_label,
			$status,
			$stat,
			$player[$allPlayers_default_stat_displayed]
		);
	}else{
		$output["data"][]=array(
			$player_label,
			$stat,
			$player[$allPlayers_default_stat_displayed]
		);
	}
} 
?>
