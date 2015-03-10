<script type="text/javascript" src="js/player_kills.js"></script>
<script type="text/javascript" src="js/player_deaths.js"></script>
<script>
	$(document).ready(function() {
		$('#killstats').dataTable({
			responsive: true
		});
	} );
var username = "<?=$player->playerName?>"
var playerId = <?=$player->playerId?>;

<?php /* If url rewrites have been disabled */ if ($this->config["url"]["rewrite"]==false) :?>
var killsurl = './ajax/call.php?func=playerKillsChart';
<?php else: ?>
var killsurl = '<?=$this->config["url"]["base"]?>/ajax/?func=playerKillsChart';
<?php endif; ?>

<?php /* If url rewrites have been disabled */ if ($this->config["url"]["rewrite"]==false) :?>
var deathsurl = './ajax/call.php?func=playerDeathsChart';
<?php else: ?>
var deathsurl = '<?=$this->config["url"]["base"]?>/ajax/?func=playerDeathsChart';
<?php endif; ?>

getDeathData(playerId,deathsurl);
getKillData(playerId,killsurl);
</script>

<item class="row">
	<section class="col-md-6 text-center">
		<h2>Kill Stats Graph</h2>
		<canvas id="killsChart" width="400" height="400"></canvas>
	</section>
	<section class="col-md-6 text-center">
		<h2>Death Stats Graph</h2>
		<canvas id="deathsChart" width="400" height="400"></canvas>
	</section>
</item>