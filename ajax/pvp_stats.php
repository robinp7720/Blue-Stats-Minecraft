
<?php
$pvp_stats = pvp_global_stats($mysqli,$config[$serverId]["mysql"]["stats"]["table_prefix"]);
if (!empty($pvp_stats)){
	foreach ($pvp_stats as $id => $value){
		/* Get player names and player images */
		$killer = htmlentities(getPlayersName($value["player_id"],$mysqli,$config[$serverId]["mysql"]["stats"]["table_prefix"]));
		$killed = htmlentities(getPlayersName($value["killed"],$mysqli,$config[$serverId]["mysql"]["stats"]["table_prefix"]));
		$image_killer_url = player_face($killer,$config[$serverId]["faces"]["pvp"]["size"],$config[$serverId]["faces"]["pvp"]["url"]);
		$image_killed_url = player_face($killed,$config[$serverId]["faces"]["pvp"]["size"],$config[$serverId]["faces"]["pvp"]["url"]);

		/* KILLER */
		/* Get player link */
		if ($config[$serverId]["url"]["player"]["useName"])
			$player_url = urlencode($killer);
		else
			$player_url = $killer;

		$killer_label = '<a href="'.makePlayerUrl($player_url,$config[$serverId]["url"]["base"],$config[$serverId]["url"]["rewrite"],$config[$serverId]["url"]["player"]["useName"]).'"><img class="player-head-player_page" src="'.$image_killer_url.'" alt="'.$killer.'"/> '.$killer.'</a></td>';


		if ($config[$serverId]["server"]["query_enabled"]){
			if (isset($Online_Players)){
				if (playerOnline($killer, $Online_Players)){
					$killer_status = '<span class="label label-success">Online</span';
				}else{
					$killer_status = '<span class="label label-danger">Offline</span>';
				}
			}
		}
		/* KILLDED */
		/* Get player link */
		if ($config[$serverId]["url"]["player"]["useName"])
			$player_url = urlencode($killed);
		else
			$player_url = $killed;

		$killed_label = '<a href="'.makePlayerUrl($player_url,$config[$serverId]["url"]["base"],$config[$serverId]["url"]["rewrite"],$config[$serverId]["url"]["player"]["useName"]).'"><img class="player-head-player_page" src="'.$image_killed_url.'" alt="'.$killed.'"/> '.$killed.'</a></td>';

		if ($config[$serverId]["server"]["query_enabled"]){
			if (isset($Online_Players)){
				if (playerOnline($killed, $Online_Players)){
					$killed_status = '<span class="label label-success">Online</span>';
				}else{
					$killed_status = '<span class="label label-danger">Offline</span>';
				}
			}
		}

		/* Other stats */
		$weapon = $value["weapon"];
		$amount = $value["amount"];
		if ($config[$serverId]["server"]["query_enabled"]){
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
