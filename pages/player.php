<div class="container">
<?php
/* Make sure input is a number */
if (!empty($player_name)){
	/* Player name and id is defined in parts/head.php */

	/* Get player face */
	$image_url = player_face($player_name,$config["faces"]["player"]["size"],$config["faces"]["player"]["url"]);

	echo '<h1>'.$player_name.'</h1><img class="center-block" src="'.$image_url.'"/>';

	/* Include General Stats First */
	include $app_path."/include/player/general_stats.php";

	/* Include pvp stats */
	include $app_path."/include/player/pvp_stats.php";

	/* Include Block Stats Last */
	include $app_path."/include/player/block_stats.php";
}else{
	?>
	<b>This user does not exist</b>
	<?php
}
?>
</div>



