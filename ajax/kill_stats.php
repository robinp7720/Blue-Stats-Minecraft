
<?php
$pvp_stats = kill_global_stats($mysqli,$stats_mysql["table_prefix"]);
if (!empty($pvp_stats)){
	foreach ($pvp_stats as $id => $value){
		/* Get player names and player images */
		$player_name = htmlentities(getPlayersName($value["player_id"],$mysqli,$stats_mysql["table_prefix"]));
		$player_image_url = player_face($player_name,$config["faces"]["pvp"]["size"],$config["faces"]["pvp"]["url"]);

		/* Get player link */
		if ($config["url"]["player"]["useName"])
			$player_url = urlencode($player_name);
		else
			$player_url = $player_name;

		$player_label = '<a href="'.makePlayerUrl($player_url,$site_base_url,$enable_url_rewrite,$config["url"]["player"]["useName"]).'"><img class="player-head-player_page" src="'.$player_image_url.'" alt="'.$player_name.'"/> '.$player_name.'</a></td>';

		if ($server_info["query_enabled"]){
			if (isset($Online_Players)){
				if (playerOnline($player_name, $Online_Players)){
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

		if ($server_info["query_enabled"]){
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
