<?php
$mysqli = $this->mysqli->get("BlueStats");
?>
<table class="table table-striped table-bordered" id="deathstats">
	<thead>
		<tr>
			<th>Cause</th>
			<th>Amount</th>
		</tr>
	</thead>
	<tbody>
		<?php $death_stats = death_stats($player->playerId,$mysqli,$this->config["mysql"]["stats"]["table_prefix"]); ?>
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