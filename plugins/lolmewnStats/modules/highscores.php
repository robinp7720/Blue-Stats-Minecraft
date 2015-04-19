<?php
if (!config::configExist("stats","MODULE_highscores_lolmewnStats")){
	config::set("stats",json_encode(array("playtime","joins")),"MODULE_highscores_lolmewnStats");
}
if (!config::configExist("show_name_head","MODULE_highscores_lolmewnStats")){
	config::set("show_name_head","true","MODULE_highscores_lolmewnStats");
}
?>

<?php
$showPlayerTitle = config::get("show_name_head","MODULE_highscores_lolmewnStats");
?>
<div class="row">
	<?php foreach (json_decode(config::get("stats","MODULE_highscores_lolmewnStats"),true) as $statName):?>
	<div class="col-md-6">
		<table class="table" id="allPlayers">
			<thead>
				<tr>
					<th><?php if ($showPlayerTitle=="true"){echo "Player";}?></th>
					<th><?=$plugin->statName($statName)?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($plugin->getStats($statName,10) as $stat){
					if ($statName=="playtime"){
						$statDisplay = secondsToTime($stat["value"],$contract=true);
					}else{
						$statDisplay = $stat["value"];
					}
					
					echo "
					<tr>
						<td>
							{$stat["name"]}
						</td>
						<td>
							".$statDisplay."
						</td>
					</tr>";
				}
				?>
			</tbody>
		</table>
	</div>
	<?php endforeach;?>
</div>