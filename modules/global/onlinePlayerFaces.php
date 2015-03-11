<div class="text-center">
	<?php 
	foreach($this->onlinePlayers as $player):
	$imageUrl = player_face($player,$this->config["faces"]["home"]["size"],$this->config["faces"]["home"]["url"]);

	if ($this->config["url"]["player"]["useName"])
		$player_url = urlencode($player);
	else
		$player_url = getPlayerId($player,$this->mysqli,$this->config["mysql"]["stats"]["table_prefix"]);
	
	$player_url = makePlayerUrl($player_url,$this->config["url"]["base"],$this->config["url"]["rewrite"],$this->config["url"]["player"]["useName"]) 
	?>
	<a href="<?=$player_url?>">
		<img src="<?=$imageUrl?>" alt="" title="<?=$player?>" data-toggle="tooltip" data-placement="top">
	</a>
	<?php endforeach; ?>
</div>