<table class="table table-striped table-bordered" id="killstats">
	<thead>
		<tr>
			<th>Killed</th>
			<th>Amount</th>
		</tr>
	</thead>
	<tbody>
		<?php $kill_stats = kill_stats($player->playerId,$mysqli,$config[$serverId]["mysql"]["stats"]["table_prefix"]); ?>
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
