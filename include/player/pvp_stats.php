
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
<script type="text/javascript" src="js/player_kills.js"></script>
<script type="text/javascript" src="js/player_deaths.js"></script>
<script>
	$(document).ready(function() {
		$('#killstats').dataTable({
			responsive: true
		});
	} );
var username = "<?=$player_name?>"
var playerId = <?=$player_id?>;

<?php /* If url rewrites have been disabled */ if ($enable_url_rewrite==false) :?>
var killsurl = './ajax/call.php?func=playerKillsChart';
<?php else: ?>
var killsurl = '<?=$site_base_url?>/ajax/?func=playerKillsChart';
<?php endif; ?>

<?php /* If url rewrites have been disabled */ if ($enable_url_rewrite==false) :?>
var deathsurl = './ajax/call.php?func=playerDeathsChart';
<?php else: ?>
var deathsurl = '<?=$site_base_url?>/ajax/?func=playerDeathsChart';
<?php endif; ?>

getDeathData(playerId,deathsurl);
getKillData(playerId,killsurl);
</script>

<div class="row">
	<div class="col-md-6 text-center">
		<h2>Kill Stats Graph</h2>
		<canvas id="killsChart" width="400" height="400"></canvas>
	</div>
	<div class="col-md-6 text-center">
		<h2>Death Stats Graph</h2>
		<canvas id="deathsChart" width="400" height="400"></canvas>
	</div>
</div>
