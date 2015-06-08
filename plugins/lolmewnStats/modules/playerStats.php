<?php
$stats = $config->get("stats","lolmewnStats");
?>
<table class="table">
	<thead>
		<th>Stat</th>
		<th>Value</th>
	</thead>
	<tbody>
		<?php foreach ($stats as $id => $stat): ?>
		<?php
		$statVal = $plugin->getStat($id,$_GET["id"]);
		if (!empty($statVal)):?>
		<tr>
			<td><?=$stat?></td>
			<td><?=$statVal?></td>
		</tr>
		<?php endif; ?>
		<?php endforeach; ?>
	</tbody>
</table>