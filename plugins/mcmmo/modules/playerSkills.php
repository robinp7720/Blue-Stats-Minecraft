
<?php
$stats = $plugin->getStat("skills",$_GET["id"]);
/* Get headers */
$headers = array();
unset($stats[0]["user_id"]);
foreach ($stats[0] as $key => $value){
	$headers[]=$key;
}

?>
<table class="table">
	<thead>
		<tr>
			<?php foreach ($headers as $key=>$name): ?>
				<th><?=$name?></th>
			<?php endforeach; ?>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($stats as $key=>$playerStats): ?>
		<tr>
		<?php
		unset($playerStats["user_id"]);
		foreach ($playerStats as $statVal){
			echo "<td>$statVal</td>";
		}
		?>
	</tr>
	<?php endforeach; ?>
	</tbody>
</table>