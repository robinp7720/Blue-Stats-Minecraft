		<?php
		$output = array();
		$player_id = (int) $_GET["id"]; 
		$kill_stats = death_stats(
			$player_id,
			$mysqli,
			$config[$serverId]["mysql"]["stats"]["table_prefix"]
		);
		if (!empty($kill_stats)){
			foreach ($kill_stats as $id => $value){
				$output[]=array(
					"value" => $value["amount"],
					"label" => $value["cause"],
					"color" => "#".stringToColorCode($value["cause"]),
					
				);
				
			
			}
		}