<?php
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

/* HTTP Headers*/
header("cache-control: private, max-age={$config["cache"]["ajax"]["max-age"]}");

/* Connect to mysql */
$mysqli = new mysqli($stats_mysql["host"],$stats_mysql["username"],$stats_mysql["password"],$stats_mysql["dbname"]);

/* Init Server query */
if($server_info["query_enabled"])
	include __DIR__."/../include/init_query.php";

/* Init output */
$output         = array();
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
}


/* Return output as json*/
if (isset($output))
	echo json_encode($output);
