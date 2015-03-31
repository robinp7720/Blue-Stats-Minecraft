<?php
$mysqli = $BlueStats->mysqli->get("BlueStats");
if (isset($_GET["d"])){
	if (in_array($_GET["d"],$config[$serverId]["stats"]["id"])){
		$displayStat = $_GET["d"];
	}else{
		$displayStat = $BlueStats->config["allPlayers"]["defaultStat"];
	}
}else{
	$displayStat = $BlueStats->config["allPlayers"]["defaultStat"];
}

/* Get all players */
$players = getPlayers(
	$mysqli,
	$config[$serverId]["mysql"]["stats"]["table_prefix"],
	$displayStat,
	$config[$serverId]["allPlayers"]["min"]);

/* Loop Through each player */
foreach ($players as $item => $player){
	
	/* If the stat is playtime make it readable */
	if ($displayStat=="playtime"){
		$stat = secondsToTime($player[$displayStat]);
	}else{
		$stat = $player[$displayStat];
	}
	
	
	/* Get image url */
	$image_url = player_face($player["name"],$config[$serverId]["faces"]["allplayers"]["size"],$config[$serverId]["faces"]["allplayers"]["url"]);

	/* Get user label (Click able username and image) */
	if ($config[$serverId]["url"]["player"]["useName"])
		$player_url = urlencode($player["name"]);
	else
		$player_url = $player["player_id"];
	
	$player_label = '<a href="'.makePlayerUrl($player_url,$config[$serverId]["url"]["base"],$config[$serverId]["url"]["rewrite"],$config[$serverId]["url"]["player"]["useName"]).'"><img class="player-head-player_page" src="'.$image_url.'" alt="'.$player["name"].'"/> '.$player["name"].'</a></td>';
	
	/* If mc query is enabled */
	if ($BlueStats->config["server"]["query_enabled"]){
		/* Get player status */
		if (isset($BlueStats->onlinePlayers)){
			if (playerOnline($player["name"], $BlueStats->onlinePlayers)){
				$status = '<span class="label label-success">Online</span>';
			}else{
				$status = '<span class="label label-danger">Offline</span>';
			}
		}
		$output["data"][]=array(
			$player_label,
			$status,
			$stat,
			$player[$displayStat]
		);
	}else{
		$output["data"][]=array(
			$player_label,
			$stat,
			$player[$displayStat]
		);
	}
} 
?>
