<?php
$stats = json_decode(config::get("stats","lolmewnStats"),true);
?>
<table class="table">
	<thead>
		<th>Stat</th>
		<th>Value</th>
	</thead>
	<tbody>
		<?php foreach ($stats as $id => $stat): ?>
		<tr>
			<td><?=$stat?></td>
			<td><?=$plugin->getStat($id,$_GET["id"])?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>