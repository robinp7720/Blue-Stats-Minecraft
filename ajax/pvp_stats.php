
<?php
$pvp_stats = pvp_global_stats($mysqli,$stats_mysql["table_prefix"]);
if (!empty($pvp_stats)){
	foreach ($pvp_stats as $id => $value){
		/* Get player names and player images */
		$killer = htmlentities(getPlayersName($value["player_id"],$mysqli,$stats_mysql["table_prefix"]));
		$killed = htmlentities(getPlayersName($value["killed"],$mysqli,$stats_mysql["table_prefix"]));
		$image_killer_url = player_face($killer,$config["faces"]["pvp"]["size"],$config["faces"]["pvp"]["url"]);
		$image_killed_url = player_face($killed,$config["faces"]["pvp"]["size"],$config["faces"]["pvp"]["url"]);

		/* KILLER */
		/* Get player link */
		if ($config["url"]["player"]["useName"])
			$player_url = urlencode($killer);
		else
			$player_url = $killer;

		$killer_label = '<a href="'.makePlayerUrl($player_url,$site_base_url,$enable_url_rewrite,$config["url"]["player"]["useName"]).'"><img class="player-head-player_page" src="'.$image_killer_url.'" alt="'.$killer.'"/> '.$killer.'</a></td>';


		if ($server_info["query_enabled"]){
			if (isset($Online_Players)){
				if (playerOnline($killer, $Online_Players)){
					$killer_status = '<a class="tag-online">Online</a>';
				}else{
					$killer_status = '<a class="tag-offline">Offline</a>';
				}
			}
		}
		/* KILLDED */
		/* Get player link */
		if ($config["url"]["player"]["useName"])
			$player_url = urlencode($killed);
		else
			$player_url = $killed;

		$killed_label = '<a href="'.makePlayerUrl($player_url,$site_base_url,$enable_url_rewrite,$config["url"]["player"]["useName"]).'"><img class="player-head-player_page" src="'.$image_killed_url.'" alt="'.$killed.'"/> '.$killed.'</a></td>';

		if ($server_info["query_enabled"]){
			if (isset($Online_Players)){
				if (playerOnline($killed, $Online_Players)){
					$killed_status = '<a class="tag-online">Online</a>';
				}else{
					$killed_status = '<a class="tag-offline">Offline</a>';
				}
			}
		}

		/* Other stats */
		$weapon = $value["weapon"];
		$amount = $value["amount"];
		if ($server_info["query_enabled"]){
			$output["data"][]=array(
				$killer_label,
				$killer_status,
				$killed_label,
				$killed_status,
				$weapon,
				$amount
			);
		}else{
			$output["data"][]=array(
				$killer_label,
				$killed_label,
				$weapon,
				$amount
			);
		}
	}
};
