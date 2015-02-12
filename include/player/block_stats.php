   <div class="box">
	<div class="container-head">
		<a class="title">Block Stats</a>
	</div>
	<table class="display" id="sorted2">
		<thead>
			<tr>
				<th>Block</th>
				<th>Amount of times placed</th>
				<th>Amount of times broken</th>		
				<th>Item ID</th>
			</tr>
		</thead>
		<tbody>
			<?php
/* Get all block stats from player */
$blocks_raw = blocksMinedBy($player_id,$mysqli,$stats_mysql["table_prefix"]);
/* If player as not placed any blocks, ignore this */
if (!empty($blocks_raw)){
	/* Loop through all blocks to make it usable. */
	foreach ($blocks_raw as $item => $value){
		/* Set Block ID and Block Data for later just in case */
		$blocks[$value["blockID"].":".$value["blockData"]]["id"] = $value["blockID"];
		$blocks[$value["blockID"].":".$value["blockData"]]["data"] = $value["blockData"];
		if ($value["break"]==0){
			/* If item is already in array aka if another world has been found in array */
			if (!isset($blocks[$value["blockID"].":".$value["blockData"]]["placed"])){
				$blocks[$value["blockID"].":".$value["blockData"]]["placed"] = $value["amount"];
			}else{
				$blocks[$value["blockID"].":".$value["blockData"]]["placed"] += $value["amount"];
			}

			if (!isset($blocks[$value["blockID"].":".$value["blockData"]]["break"])){
				$blocks[$value["blockID"].":".$value["blockData"]]["break"]=0;
			}
		}else{
			/* If item is already in array aka if another world has been found in array */
			if (!isset($blocks[$value["blockID"].":".$value["blockData"]]["break"])){
				/* Set item */
				$blocks[$value["blockID"].":".$value["blockData"]]["break"] = $value["amount"];
			}else{
				$blocks[$value["blockID"].":".$value["blockData"]]["break"] += $value["amount"];
			}

			if (!isset($blocks[$value["blockID"].":".$value["blockData"]]["placed"])){
				$blocks[$value["blockID"].":".$value["blockData"]]["placed"]=0;
			}
		}

	}
}else{
	/* If no blocks mined/placed by player, declare and empty blocks variable */
	$blocks = array();
}


			?>
			<?php foreach ($blocks as $item => $value) :?>
			<?php 
$block_name = strtolower(getMaterialFromId($value["id"],$value["data"],$blocks_names )); 
if (empty($block_name)){
	$block_name = strtolower(getMaterialFromId($value["id"],0,$blocks_names )); 
}
			?>
			<tr>
				<td><?php 
/* If block icons are turned on add them to the html here */
if ($block_players_display_icons==true){
	if(file_exists($app_path."/images/blocks/".$value["id"]."-".$value["data"].'.png')){
		echo '<img class="block-icon" src="'."images/blocks/".$value["id"]."-".$value["data"].'.png"/> ';
	}else{
		echo '<img class="block-icon" src="'."images/blocks/".$value["id"].'-0.png"/> ';
	}
}

echo $block_name ?>
				</td>
				<td><?=$value["placed"] ?></td>
				<td><?=$value["break"] ?></td>
				<td><?=$value["id"].":".$value["data"]; ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
