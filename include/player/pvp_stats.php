
<h2>PvP Stats</h2>

<table class="table table-striped table-bordered" id="pvpstats">
	<thead>
		<tr>
			<th>Player Killed</th>
			<th>Weapons used</th>
			<th>Amount Killed</th>
		</tr>
	</thead>
	<tbody>
		<?php $pvp_stats = pvp_stats($player_id,$mysqli,$stats_mysql["table_prefix"]); ?>
		<?php if (!empty($pvp_stats)): ?>
		<?php foreach ($pvp_stats as $id => $value) :?>
		<?php
			$killed = htmlentities(getPlayersName($value["killed"],$mysqli,$stats_mysql["table_prefix"]));
			$image_killed_url = player_face($killed,$config["faces"]["pvp"]["size"],$config["faces"]["pvp"]["url"]);
		?>
		<tr>
			<td>
				<?php /* If url rewrites have been disabled */ if ($enable_url_rewrite==false) :?>
					<a href="?page=player&player=<?=$value["killed"] ?>"><?='<img class="player-head-player_page" src="'.$image_killed_url.'" alt=""/> '.$killed; ?></a>
				<?php endif ?>
				<?php /* If url rewrites have been enabled */ if ($enable_url_rewrite==true) :?>
					<a href="<?= $site_base_url.'/player/'.$value["killed"]."/" ?>"><?='<img class="player-head-player_page" src="'.$image_killed_url.'" alt=""/> '.$killed; ?></a>
				<?php endif ?>
			</td>
			<td><?=$value["weapon"];?></td>
			<td><?=$value["amount"];?></td>
		</tr>
		<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
</table>
<script>
	$(document).ready(function() {
		$('#pvpstats').dataTable({
			responsive: true
		});
	} );
</script>

<h2>Death Stats</h2>

<table class="table table-striped table-bordered" id="deathstats">
	<thead>
		<tr>
			<th>Cause</th>
			<th>Amount</th>
		</tr>
	</thead>
	<tbody>
		<?php $death_stats = death_stats($player_id,$mysqli,$stats_mysql["table_prefix"]); ?>
		<?php if (!empty($death_stats)): ?>
		<?php foreach ($death_stats as $id => $value) :?>
		<tr>
			<td><?=$value["cause"];?></td>
			<td><?=$value["amount"];?></td>
		</tr>
		<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
</table>
<script>
	$(document).ready(function() {
		$('#deathstats').dataTable({
			responsive: true
		});
	} );
</script>

<h2>Kill Stats</h2>

<table class="table table-striped table-bordered" id="killstats">
	<thead>
		<tr>
			<th>Killed</th>
			<th>Amount</th>
		</tr>
	</thead>
	<tbody>
		<?php $kill_stats = kill_stats($player_id,$mysqli,$stats_mysql["table_prefix"]); ?>
		<?php if (!empty($kill_stats)): ?>
		<?php foreach ($kill_stats as $id => $value) :?>
		<tr>
			<td><?=$value["type"];?></td>
			<td><?=$value["amount"];?></td>
		</tr>
		<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
</table>
<script>
	$(document).ready(function() {
		$('#killstats').dataTable({
			responsive: true
		});
	} );
</script>

