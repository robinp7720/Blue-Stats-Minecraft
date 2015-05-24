<?php
if (!config::configExist("stats","MODULE_highscores_lolmewnStats")){
	config::set("stats",json_encode(array("playtime","joins")),"MODULE_highscores_lolmewnStats");
}
if (!config::configExist("show_name_head","MODULE_highscores_lolmewnStats")){
	config::set("show_name_head","true","MODULE_highscores_lolmewnStats");
}
if (!config::configExist("limit","MODULE_highscores_lolmewnStats")){
	config::set("limit","10","MODULE_highscores_lolmewnStats");
}
?>

<?php
$showPlayerTitle = config::get("show_name_head","MODULE_highscores_lolmewnStats");
$limit = config::get("limit","MODULE_highscores_lolmewnStats");
?>
<div class="row">
	<?php foreach (json_decode(config::get("stats","MODULE_highscores_lolmewnStats"),true) as $statName):?>
	<div class="col-md-6">
		<div class="panel panel-primary">
			  <div class="panel-heading">
			    <h2 class="panel-title">Top <?=$limit?> by <b><?=$plugin->statName($statName)?></b></h2>
			  </div>
			<div class="panel-body">
				<table class="table">
					<thead>
						<tr>
							<th><?php if ($showPlayerTitle=="true"){echo "Player";}?></th>
							<th><?=$plugin->statName($statName)?></th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($plugin->getAllPlayerStats($statName,$limit) as $stat){
							if ($statName=="playtime"){
								$statDisplay = secondsToTime($stat["value"],$contract=true);
							}else{
								$statDisplay = $stat["value"];
							}
							
							echo "
							<tr>
								<td>
									<a href=\"?page=player&amp;id={$stat["uuid"]}\"><img src=\"https://minotar.net/helm/{$stat["name"]}/32.png\" alt=\"\"> {$stat["name"]}</a>
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
		</div>
	</div>
	<?php endforeach;?>
</div>