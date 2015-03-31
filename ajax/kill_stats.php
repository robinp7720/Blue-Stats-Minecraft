
<?php
$mysqli = $BlueStats->mysqli->get("BlueStats");
$pvp_stats = kill_global_stats($mysqli,$config[$serverId]["mysql"]["stats"]["table_prefix"]);
if (!empty($pvp_stats)){
	foreach ($pvp_stats as $id => $value){
		/* Get player names and player images */
		$player_name = htmlentities(getPlayersName($value["player_id"],$mysqli,$config[$serverId]["mysql"]["stats"]["table_prefix"]));
		$player_image_url = player_face($player_name,$config[$serverId]["faces"]["pvp"]["size"],$config[$serverId]["faces"]["pvp"]["url"]);

		/* Get player link */
		if ($config[$serverId]["url"]["player"]["useName"])
			$player_url = urlencode($player_name);
		else
			$player_url = $player_name;

		$player_label = '<a href="'.makePlayerUrl($player_url,$config[$serverId]["url"]["base"],$config[$serverId]["url"]["rewrite"],$config[$serverId]["url"]["player"]["useName"]).'"><img class="player-head-player_page" src="'.$player_image_url.'" alt="'.$player_name.'"/> '.$player_name.'</a></td>';

		if ($config[$serverId]["server"]["query_enabled"]){
			if (isset($BlueStats->onlinePlayers)){
				if (playerOnline($player_name, $BlueStats->onlinePlayers)){
					$status = '<span class="label label-success">Online</span>';
				}else{
					$status = '<span class="label label-danger">Offline</span>';
				}
			}
		}

		/* Other stats */
		$world  = $value["world"];
		$type   = $value["type"];
		$amount = $value["amount"];

		if ($config[$serverId]["server"]["query_enabled"]){
			$output["data"][]=array(
				$player_label,
				$status,
				$world,
				$type,
				$amount
			);
		}else{
			$output["data"][]=array(
				$player_label,
				$world,
				$type,
				$amount
			);
		}
	}
};
