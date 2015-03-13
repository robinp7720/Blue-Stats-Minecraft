<?php
header ('Access-Control-Allow-Origin: *');
/* Execution time */
$time_start = microtime(true);
$serverId = 0;

$app_path = __DIR__;

/* Configs */
require __DIR__."/../configs/mysql.php";
require __DIR__."/../configs/player.php";
require __DIR__."/../configs/highscores.php";
require __DIR__."/../configs/blocknames.php";
require __DIR__."/../configs/faces.php";
require __DIR__."/../configs/all-players.php";
require __DIR__."/../configs/general.php";
require __DIR__."/../configs/server.php";
require __DIR__."/../configs/home.php";
require __DIR__."/../configs/local.php";

/* Functions */
require __DIR__."/../functions/general.php";
require __DIR__."/../functions/player.php";
require __DIR__."/../functions/global_stats.php";
require __DIR__."/../functions/image.php";

/* Classes */
require __DIR__."/../classes/query.php";
require __DIR__."/../classes/queryException.php";
require __DIR__."/../classes/ping.php";
require __DIR__."/../classes/pingException.php";
require __DIR__."/../classes/main.class.php";
require __DIR__."/../classes/player.class.php";

/* Setup BlueStats Core */
$BlueStats = new BlueStats;
$BlueStats->setup($config,$serverId);
$BlueStats->setAppPath($app_path."/../");
$BlueStats->loadLocal($localization);

/* Get block names */
$blocks_names = $BlueStats->getBlockNames();

/* HTTP Headers*/
header("cache-control: private, max-age={$config[$serverId]["cache"]["ajax"]["max-age"]}");

/* Connect to mysql */
$mysqli = new mysqli(
	$config[$serverId]["mysql"]["stats"]["host"],
	$config[$serverId]["mysql"]["stats"]["username"],
	$config[$serverId]["mysql"]["stats"]["password"],
	$config[$serverId]["mysql"]["stats"]["dbname"]
);

$BlueStats->loadMySQL($mysqli);

/* Init Server query */
if($config[$serverId]["server"]["query_enabled"])
	include __DIR__."/../include/init_query.php";

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

$time_end = microtime(true);
$execution_time = $time_end - $time_start;
/* Return output as json*/
if (isset($output))
	echo json_encode($output);
