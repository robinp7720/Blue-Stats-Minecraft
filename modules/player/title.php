<?php
// Get player usernames 
$past_usernames = $player->getUserNames();

$amountOfUsernames = count($past_usernames);
if ($amountOfUsernames>1){
	$formerUsername = $past_usernames[$amountOfUsernames-2];
}
$online="";
if (isset($Online_Players)){
	if (playerOnline($player->playerName, $Online_Players)){
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