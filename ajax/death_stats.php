
<?php
$pvp_stats = death_global_stats($mysqli,$stats_mysql["table_prefix"]);
if (!empty($pvp_stats)){
	foreach ($pvp_stats as $id => $value){
		/* Get player names and player images */
		$player_name = htmlentities(getPlayersName($value["player_id"],$mysqli,$stats_mysql["table_prefix"]));
		$player_image_url = player_face($player_name,$config["faces"]["pvp"]["size"],$config["faces"]["pvp"]["url"]);

		/* Get player link */
		if ($enable_url_rewrite==false){
			$player_label = '<a href="?page=player&player='.$value["player_id"].'">';
		}else{
			$player_label = '<a href="'.$site_base_url.'/player/'.$value["player_id"].'/">';
		}

		/* Add player image and name to label */
		$player_label .= '<img class="player-head-player_page" src="'.$player_image_url.'"/> '.$player_name.'</a>';


		if (isset($Online_Players)){
			if (playerOnline($player_name, $Online_Players)){
				$status = '<a class="tag-online">Online</a>';
			}else{
				$status = '<a class="tag-offline">Offline</a>';
			}
		}

		/* Other stats */
		$world  = $value["world"];
		$cause   = $value["cause"];
		$amount = $value["amount"];

		$output["data"][]=array(
			$player_label,
			$status,
			$world,
			$cause,
			$amount
		);
	}
};
