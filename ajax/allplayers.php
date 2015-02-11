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
	if ($enable_url_rewrite==false){
		$player_label = '<a href="?page=player&player='.$player["player_id"].'"><img class="player-head-player_page" src="'.$image_url.'" alt="'.$player["name"].'"/> '.$player["name"].'</a>';
	}else{
		$player_label = '<a href="'.$site_base_url.'/player/'.$player["player_id"].'/"><img class="player-head-player_page" src="'.$image_url.'" alt="'.$player["name"].'"/> '.$player["name"].'</a>';
	}

	/* Get player status */
	if (playerOnline($player["name"], $Online_Players)){
		$status = '<a class="tag-online">Online</a>';
	}else{
		$status = '<a class="tag-offline">Offline</a>';
	}


	$output["data"][]=array(
		$player_label,
		$status,
		$stat,
		$player[$allPlayers_default_stat_displayed]
	);
} 
?>
