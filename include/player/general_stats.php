
	<table class="table table-striped table-bordered" id="sorted">
		<thead>
			<tr>
				<th>Stat</th>
				<th>Value</th>
				<th>Server Average</th>
				<th>Server Total</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($stats_tracked_player as $stat) :?>
			<?php
$player_stat = getStat($stat,$player_id,$mysqli,$stats_mysql["table_prefix"]);

if ($stat!="lastjoin"&&$stat!="lastleave"){
	$server_total =  getStatTotal($stat,$mysqli,$stats_mysql["table_prefix"]);
}else{
	$server_total="";
}

if ($stat!="lastjoin"&&$stat!="lastleave"){
	$server_average = round($server_total / getPlayerCount($mysqli,$stats_mysql["table_prefix"])[0]["count(*)"]);
}else{
	$server_average="";
}

if ($stat == "playtime"){
	$player_stat=secondsToTime($player_stat);
	$server_total=secondsToTime($server_total);
	$server_average=secondsToTime($server_average);
}
$statTitle="";
if (isset($stats_names[$stat])){
	$statTitle=$stats_names[$stat];
}else{
	$statTitle=$stat;
}
			?>
			<tr>
				<td><?=$statTitle; ?></td>
				<td><?=$player_stat; ?></td>
				<td><?=$server_average ?></td>
				<td><?=$server_total ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

