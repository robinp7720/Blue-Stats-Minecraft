<div class="box">
	<div class="container-head">
		<a class="title"><?= $player_name; ?></a>
	</div>
	<table class="display" id="sorted">
		<thead>
			<th>Stat</th>
			<th>Value</th>
			<th>Server Average</th>
			<th>Server Total</th>
		</thead>
		<tbody>
			<?php foreach ($stats_tracked_player as $stat) :?>
			<?php
$player_stat = getStat($stat,$player_id,$mysqli,$stats_mysql["table_prefix"]);
$server_total =  getStatTotal($stat,$mysqli,$stats_mysql["table_prefix"]);
$server_average = round($server_total / getPlayerCount($mysqli,$stats_mysql["table_prefix"])[0]["count(*)"]);
if ($stat == "playtime"){
	$player_stat=secondsToTime($player_stat);
	$server_total=secondsToTime($server_total);
	$server_average=secondsToTime($server_average);
}
			?>
			<tr>
				<td><?=$stats_names[$stat]; ?></td>
				<td><?=$player_stat; ?></td>
				<td><?=$server_average ?></td>
				<td><?=$server_total ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>