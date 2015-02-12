<?php
/* Make sure input is a number */
if (is_numeric($_GET["player"])&&!empty($player_name)){
	/* Player name and id is defined in parts/head.php */

	/* Get player face */
	$image_url = player_face($player_name,$config["faces"]["player"]["size"],$config["faces"]["player"]["url"]);

	echo '<div class="center"><img class="player-head-player_page" src="'.$image_url.'"/></div>';
	
	echo '<div class="container">';

	/* Include General Stats First */
	include $app_path."/include/player/general_stats.php";

	/* Include pvp stats */
	include $app_path."/include/player/pvp_stats.php";

	/* Include Block Stats Last */
	include $app_path."/include/player/block_stats.php";

	echo '</div>';
}else{
	?>
	<div class="center" style="margin-top:5px;"><b>This user does not exist</b></div>
	<?php
}
?>



