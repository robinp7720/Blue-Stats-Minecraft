
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
		if ($enable_url_rewrite==false){
			$killer_label = '<a href="?page=player&player='.$value["player_id"].'">';
		}else{
			$killer_label = '<a href="'.$site_base_url.'/player/'.$value["player_id"].'/">';
		}

		/* Add player image and name to label */
		$killer_label .= '<img class="player-head-player_page" src="'.$image_killer_url.'"/> '.$killer.'</a>';


		if (isset($Online_Players)){
			if (playerOnline($killer, $Online_Players)){
				$killer_status = '<a class="tag-online">Online</a>';
			}else{
				$killer_status = '<a class="tag-offline">Offline</a>';
			}
		}

		/* KILLDED */
		/* Get player link */
		if ($enable_url_rewrite==false){
			$killed_label = '<a href="?page=player&player='.$value["killed"].'">';
		}else{
			$killed_label = '<a href="'.$site_base_url.'/player/'.$value["killed"].'/">';
		}

		/* Add player image and name to label */
		$killed_label .= '<img class="player-head-player_page" src="'.$image_killed_url.'"/> '.$killed.'</a>';


		if (isset($Online_Players)){
			if (playerOnline($killed, $Online_Players)){
				$killed_status = '<a class="tag-online">Online</a>';
			}else{
				$killed_status = '<a class="tag-offline">Offline</a>';
			}
		}

		/* Other stats */
		$weapon = $value["weapon"];
		$amount = $value["amount"];

		$output["data"][]=array(
			$killer_label,
			$killer_status,
			$killed_label,
			$killed_status,
			$weapon,
			$amount
		);
	}
};
