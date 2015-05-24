<?php
$defaultText = array(
	"arrows" => "Sot {VALUE} arrows",
	"beds_entered" => "Entered {VALUE} beds",
	"blocks_broken" => "Broke {VALUE} blocks",
	"blocks_placed" => "Placed {VALUE} blocks",
	"buckets_emptied" => "Emptied {VALUE} buckets",
	"buckets_filled" => "Filled {VALUE} buckets",
	"commands_done" => "Executed {VALUE} commands",
	"damage_taken" => "Took {VALUE} damage",
	"death" => "Died {VALUE} times",
	"eggs_thrown" => "Threw {VALUE} eggs",
	"fish_caught" => "Caught {VALUE} fish",
	"items_crafted" => "Crafted {VALUE} items",
	"items_dropped" => "Dropped {VALUE} items",
	"items_picked_up" => "Picked up {VALUE} items",
	"joins" => "Joined {VALUE} times",
	"kill" => "Killed {VALUE} things",
	"last_join" => "Last Joined",
	"last_seen" => "Last Left",
	"move" => "Traveled {VALUE} blocks",
	"omnomnom" => "Ate {VALUE} foods",
	"playtime" => "Played for {VALUE}",
	"pvp" => "Died {VALUE} to another player",
	"shears" => "Striped {VALUE} sheep",
	"teleports" => "Teleported {VALUE} times",
	"times_changed_world" => "Traveled through {VALUE} realms",
	"times_kicked" => "Was kicked {VALUE} times",
	"tools_broken" => "Broke {VALUE} tools",
	"trades" => "Traded {VALUE} times",
	"votes" => "Voted for the server {VALUE} times",
	"words_said" => "Said {VALUE} words",
	"xp_gained" => "Gained {VALUE} XP",
);

if (!config::configExist("english","MODULE_topPlayers_lolmewnStats")){
	config::set("english",json_encode($defaultText),"MODULE_topPlayers_lolmewnStats");
}
if (!config::configExist("stats","MODULE_topPlayers_lolmewnStats")){
	config::set("stats",json_encode(array("playtime","joins","move","votes")),"MODULE_topPlayers_lolmewnStats");
}
$english = json_decode(config::get("english","MODULE_topPlayers_lolmewnStats"),true);
$stats = json_decode(config::get("stats","MODULE_topPlayers_lolmewnStats"),true);
?>
<div class="row">
<?php foreach ($stats as $stat): ?>
<?php 
$data = $plugin->getAllPlayerStats($stat,1); 
if ($stat=="playtime"){
	$display = secondsToTime($data[0]["value"]);
}else{
	$display = $data[0]["value"];
}
?>
<div class="col-md-3 col-sm-4 col-xs-6">
	<div class="panel panel-default">
		<img src="https://minotar.net/helm/<?=$data[0]["name"]?>/300.png" alt="" style="width:100%;">
		<div class="panel-body">
			<h3 style="margin-top:0;padding:0;"><?=$data[0]["name"]?></h3>
			<h6 style="margin-top:0;padding:0;" class="text-muted"><?=str_replace("{VALUE}", $display, $english[$stat])?></h6>
		</div>
	</div>
</div>
<?php endforeach; ?>
</div>