<div class="container">
	<?php
	/* Make sure input is a number */
	if (!empty($player_name)&&isset($player_id)){
		/* Player name and id is defined in parts/head.php */

		/* Get player face */
		$image_url = player_face($player_name,$config["faces"]["player"]["size"],$config["faces"]["player"]["url"]);
		$uuid = getPlayerUUID($player_id,$mysqli,$stats_mysql["table_prefix"]);
		$uuid=str_replace('-', '', $uuid);
		
		// Get player usernames 
		$ch = curl_init();
	    // set url 
	    curl_setopt($ch, CURLOPT_URL, "https://api.mojang.com/user/profiles/$uuid/names"); 
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    $output = curl_exec($ch); 
	    curl_close($ch); 

	    $past_usernames = json_decode($output,true);
	    
	    $amountOfUsernames = count($past_usernames);
	    if ($amountOfUsernames>1){
	    	$formerUsername = $past_usernames[$amountOfUsernames-2];
	    }

	?>
	<div class="page-header">
	  <h1><?=$player_name?> <?php if ($amountOfUsernames>1):?><small>Formerly known as <?=$formerUsername["name"]?></small><?php endif;?></h1>
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
</div>



