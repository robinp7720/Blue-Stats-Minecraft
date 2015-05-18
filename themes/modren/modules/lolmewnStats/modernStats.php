<?php
$stats = array(
	"playtime" => "Play Time",
	"blocks_broken" => "Blocks Broken",
	"blocks_placed" => "Block Placed"
);
$count=count($stats);
?>

<?php foreach ($stats as $id => $stat): ?>
<?php
$statVal = $plugin->getStat($id,$_GET["id"]);
?>

	<span class="stat" style="margin-left:<?=$count*40?>px">
		<span class="title"><?=$stat?>:</span>
		<span class="value"><?=$statVal?></span>
	</span>
<?php
	$count--;
?>
<?php endforeach; ?>
