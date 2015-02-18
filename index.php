<?php
/* Track page execution time */
$time_start = microtime(true);

/* Configs */
include __DIR__."/configs/mysql.php";
include __DIR__."/configs/player.php";
include __DIR__."/configs/highscores.php";
include __DIR__."/configs/blocknames.php";
include __DIR__."/configs/faces.php";
include __DIR__."/configs/all-players.php";
include __DIR__."/configs/general.php";
include __DIR__."/configs/server.php";
include __DIR__."/configs/home.php";

/* Functions */
include __DIR__."/functions/general.php";
include __DIR__."/functions/player.php";
include __DIR__."/functions/global_stats.php";
include __DIR__."/functions/image.php";

/* Classes */
include __DIR__."/classes/query.php";
include __DIR__."/classes/queryException.php";

/* Themes */
include __DIR__."/themes/theme_settings.php";

/* Get block names */
if (file_exists(__DIR__."/cache/items.json")&&$config["blocks"]["cache"]){
	$blocks_names = json_decode(file_get_contents(__DIR__."/cache/items.json"),true);
}else{
	if ($config["blocks"]["cache"]){
		$blocks_names = file_get_contents($config["blocks"]["url"]);
		file_put_contents(__DIR__."/cache/items.json", $blocks_names);
	}else{
		$blocks_names = json_decode(file_get_contents($config["blocks"]["url"]),true);
	}
}

/* Remove all path related items from theme name for security */
$theme_settings = array(
	"enabled_theme" => str_replace ( array(".","/","\\") , "" , $theme_settings["enabled_theme"])
);
$theme = array();

include __DIR__."/themes/{$theme_settings["enabled_theme"]}/config.php";

/* Connect to mysql */
$mysqli = new mysqli($stats_mysql["host"],$stats_mysql["username"],$stats_mysql["password"],$stats_mysql["dbname"]);

/* Set app path (This is to make including other folders and pages easier) */
$app_path = __DIR__;

/* Select page */
if (!isset($_GET["page"])){
	$page = $config["site"]["home"];
}else{
	$page = $_GET["page"];
}

/* Init Server query */
if($server_info["query_enabled"])
	include $app_path."/include/init_query.php";

/* HTTP Headers*/
header("cache-control: private, max-age={$config["cache"]["max-age"]}");

/* Html Header */
include $app_path."/parts/head.php";

/* Nav Bar */
include $app_path."/parts/nav.php";

/* Include page */
if ($page=="highscores"){
	include $app_path."/pages/highscores.php";
}elseif($page=="player"){
	include $app_path."/pages/player.php";
}elseif($page=="allplayers"){
	include $app_path."/pages/all-players.php";
}elseif($page=="pvpstats"){
	include $app_path."/pages/pvp_stats.php";
}elseif($page=="home"){
	include $app_path."/pages/home.php";
}elseif($page=="blocks"){
	include $app_path."/pages/block_stats.php";
}
$time_end = microtime(true);
$execution_time = round($time_end - $time_start,5);

/* Html Header */
include $app_path."/parts/footer.php";
