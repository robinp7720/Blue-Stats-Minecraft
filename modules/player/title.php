<?php
/* Initialize new player */
$player = new player;
$player->loadBlueStats($this);

/* Get player id and name */
if (!is_numeric($_GET["player"])){
  if ($this->config["url"]["player"]["useName"]){
    $player->setPlayerName($_GET["player"]);
  }
}else{
  $player->setPlayerName($_GET["player"]);
}
  

// Get player usernames 
$past_usernames = $player->getUserNames();

$amountOfUsernames = count($past_usernames);
if ($amountOfUsernames>1){
	$formerUsername = $past_usernames[$amountOfUsernames-2];
}
$online="";
if (isset($this->onlinePlayers)){
	if (playerOnline($player->playerName, $this->onlinePlayers)){
		$online = '<span class="label label-success">Online</span>';
	}else{
		$online = '<span class="label label-danger">Offline</span>';
	}
}
?>
<div class="page-header">
  <h1>
  	<?=$player->playerName?>
  	 <?=$online?>
  	<?php if ($amountOfUsernames>1):?>
  	<small>
  		Formerly known as <?=$formerUsername["name"]?>
  	</small>
  	<?php endif;?>
  </h1>
</div>