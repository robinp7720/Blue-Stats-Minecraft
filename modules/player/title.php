<?php
if($this->config["player"]["nameHistory"]){
  // Get player usernames 
  $past_usernames = $player->getUserNames();

  $amountOfUsernames = count($past_usernames);
  if ($amountOfUsernames>1){
  	if (isset($past_usernames[$amountOfUsernames-2]))
  		$formerUsername = $past_usernames[$amountOfUsernames-2];
  }
}else{
  $amountOfUsernames=0;
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
