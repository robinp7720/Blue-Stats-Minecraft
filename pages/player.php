<?php
$player = new player;
$player->loadBlueStats($BlueStats);
$player->setPlayerId($player_id);

/* Make sure input is a number */
if (!empty($player_name)&&isset($player_id)){
	/* Player name and id is defined in parts/head.php */

	/* Get player face */
	$image_url = $player->playerFaceUrl();
	
	// Get player usernames 
    $past_usernames = $player->getUserNames();
    
    $amountOfUsernames = count($past_usernames);
    if ($amountOfUsernames>1){
    	$formerUsername = $past_usernames[$amountOfUsernames-2];
    }
    $online="";
	if (isset($Online_Players)){
		if (playerOnline($player_name, $Online_Players)){
			$online = '<span class="label label-success">Online</span>';
		}else{
			$online = '<span class="label label-danger">Offline</span>';
		}
	}

?>

<div class="page-header">
  <h1>
  	<?=$player_name?>
  	 <?=$online?>
  	<?php if ($amountOfUsernames>1):?>
  	<small>
  		Formerly known as <?=$formerUsername["name"]?>
  	</small>
  	<?php endif;?>
  </h1>
</div>

<img class="center-block" src="<?=$image_url?>" alt=""/>

<?php
	/* Include General Stats First */
	include $app_path."/include/player/general_stats.php";

	/* Include pvp stats */
	include $app_path."/include/player/pvp_stats.php";

	/* Include Block Stats Last */
	include $app_path."/include/player/block_stats.php";
}else{
	?>
	<div class="alert alert-danger" role="alert">This user does not exist!</div>
	<?php
}
?>



