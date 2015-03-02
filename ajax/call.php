<?php
/* Execution time */
$time_start = microtime(true);
$serverId = 0;

/* Configs */
include __DIR__."/../configs/mysql.php";
include __DIR__."/../configs/player.php";
include __DIR__."/../configs/highscores.php";
include __DIR__."/../configs/blocknames.php";
include __DIR__."/../configs/faces.php";
include __DIR__."/../configs/all-players.php";
include __DIR__."/../configs/general.php";
include __DIR__."/../configs/server.php";

/* Functions */
include __DIR__."/../functions/general.php";
include __DIR__."/../functions/player.php";
include __DIR__."/../functions/global_stats.php";
include __DIR__."/../functions/image.php";

/* Classes */
include __DIR__."/../classes/query.php";
include __DIR__."/../classes/queryException.php";

/* Get block names */
if (file_exists(__DIR__."/../cache/items.json")&&$config[$serverId]["blocks"]["cache"]){
	$blocks_names = json_decode(file_get_contents(__DIR__."/../cache/items.json"),true);
}else{
	if ($config["blocks"]["cache"]){
		$blocks_names = file_get_contents($config[$serverId]["blocks"]["url"]);
		file_put_contents(__DIR__."/../cache/items.json", $blocks_names);
	}else{
		$blocks_names = json_decode(file_get_contents($config[$serverId]["blocks"]["url"]),true);
	}
}

/* HTTP Headers*/
header("cache-control: private, max-age={$config[$serverId]["cache"]["ajax"]["max-age"]}");

/* Connect to mysql */
$mysqli = new mysqli(
	$config[$serverId]["mysql"]["stats"]["host"],
	$config[$serverId]["mysql"]["stats"]["username"],
	$config[$serverId]["mysql"]["stats"]["password"],
	$config[$serverId]["mysql"]["stats"]["dbname"]
);

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
}

$time_end = microtime(true);
$execution_time = $time_end - $time_start;
/* Return output as json*/
if (isset($output))
	echo json_encode($output);
