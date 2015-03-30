	<?php
	$mysqli = $BlueStats->mysqli->get("BlueStats");
	$columns = array("playtime","wordssaid");
	$columns = $BlueStats->config["stats"]["id"];
	$columnsEncoded = "";
	foreach ($columns as $column){
		$columnsEncoded .= ", sum(Stats_player.$column) as '$column'";
	}
	$query = 
	"
Select Stats_players.name $columnsEncoded
FROM Stats_player 
INNER JOIN Stats_players 
WHERE Stats_players.player_id = Stats_player.player_id 
GROUP by Stats_player.player_id
	";

	if ($stmt = $mysqli->prepare($query)) {
		$stmt->execute();
		$result = $stmt->get_result();
		while ($row = $result->fetch_assoc()) {
			$dump[]=$row;

		}
		$stmt->close();
	}
	$output["data"]=$dump;