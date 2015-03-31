<?php
$serverId = 0;

$app_path = __DIR__."/..";

/* Configs */
require $app_path."/configs/mysql.php";
require $app_path."/configs/player.php";
require $app_path."/configs/highscores.php";
require $app_path."/configs/blocknames.php";
require $app_path."/configs/faces.php";
require $app_path."/configs/all-players.php";
require $app_path."/configs/general.php";
require $app_path."/configs/server.php";
require $app_path."/configs/home.php";
require $app_path."/configs/local.php";

/* Functions */
require $app_path."/functions/general.php";
require $app_path."/functions/player.php";
require $app_path."/functions/global_stats.php";
require $app_path."/functions/image.php";

/* Classes */
require $app_path."/classes/query.php";
require $app_path."/classes/queryException.php";
require $app_path."/classes/ping.php";
require $app_path."/classes/pingException.php";

require $app_path."/classes/main.class.php";
require $app_path."/classes/player.class.php";
require $app_path."/classes/mysqli.class.php";
require $app_path."/classes/plugins.class.php";

/* Setup BlueStats Core */
$BlueStats = new BlueStats($config,$serverId,$app_path);

/* Get block names */
$blocks_names = $BlueStats->getBlockNames();


/* Init output */
$output = array();
$output["data"] = array();

/* Get Requested Function */
$function = $_GET["func"];
if ($function=="allplayers"){
	include "allplayers.php";
}elseif ($function=="pvp"){
	include "pvp_stats.php";
}elseif ($function=="kills"){
	include "kill_stats.php";
}elseif ($function=="deaths"){
	include "death_stats.php";
}elseif ($function=="playerKillsChart"){
	include "playerKillsChart.php";
}elseif ($function=="playerDeathsChart"){
	include "playerDeathsChart.php";
}elseif ($function=="dump"){
	include "dump.php";
}


/* Return output as json*/
if (isset($output))
	echo json_encode($output);
