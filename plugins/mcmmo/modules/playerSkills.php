
<?php
$stats = $plugin->getStat("skills",$_GET["id"]);
/* Get headers */
$headers = array();
unset($stats[0]["user_id"]);
?>
<table class="table">
	<thead>
	</thead>
	<tbody>
	<?php foreach ($stats[0] as $key=>$val): ?>
		<tr>
			<th><?=ucfirst($key)?></th>
			<td><?=$val?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>