<div class="text-center">
	<?php foreach($Online_Players as $player):
	$imageUrl = player_face($player,$config[$serverId]["faces"]["home"]["size"],$config[$serverId]["faces"]["home"]["url"]);

	if ($config[$serverId]["url"]["player"]["useName"])
		$player_url = urlencode($player);
	else
		$player_url = getPlayerId($player,$mysqli,$config[$serverId]["mysql"]["stats"]["table_prefix"]);
	
	$player_url = makePlayerUrl($player_url,$config[$serverId]["url"]["base"],$config[$serverId]["url"]["rewrite"],$config[$serverId]["url"]["player"]["useName"]) 
	?>
	<a href="<?=$player_url?>">
		<img src="<?=$imageUrl?>" alt="" title="<?=$player?>" data-toggle="tooltip" data-placement="top">
	</a>
	<?php endforeach; ?>
</div>