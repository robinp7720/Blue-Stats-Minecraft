<?php
$debug=true;
$serverId=0;


$time_start = microtime(true);

if ($debug){
	ini_set('display_errors', 'On');
	error_reporting(E_ALL);
}else{
	ini_set('display_errors', 'Off');
	error_reporting(E_NONE);
}

/* Configs */
require __DIR__."/configs/mysql.php";
require __DIR__."/configs/player.php";
require __DIR__."/configs/highscores.php";
require __DIR__."/configs/blocknames.php";
require __DIR__."/configs/faces.php";
require __DIR__."/configs/all-players.php";
require __DIR__."/configs/general.php";
require __DIR__."/configs/server.php";
require __DIR__."/configs/home.php";
require __DIR__."/configs/local.php";

/* Functions */
require __DIR__."/functions/general.php";
require __DIR__."/functions/player.php";
require __DIR__."/functions/global_stats.php";
require __DIR__."/functions/image.php";

/* Classes */
require __DIR__."/classes/query.php";
require __DIR__."/classes/queryException.php";

/* Themes */
require __DIR__."/themes/theme_settings.php";

/* Localization */
//require __DIR__."/local/german.local.php";

if (isset($localization["stats"]["names"])){
	$stats_names = $localization["stats"]["names"];
}

/* Get block names */
if (file_exists(__DIR__."/cache/items.json")&&$config[$serverId]["blocks"]["cache"]){
	$blocks_names = json_decode(file_get_contents(__DIR__."/cache/items.json"),true);
}else{
	if ($config["blocks"]["cache"]){
		$blocks_names = file_get_contents($config["blocks"]["url"]);
		file_put_contents(__DIR__."/cache/items.json", $blocks_names);
	}else{
		$blocks_names = json_decode(file_get_contents($config[$serverId]["blocks"]["url"]),true);
	}
}

/* Remove all path related items from theme name for security */
$theme_settings = array(
	"enabled_theme" => str_replace ( array(".","/","\\") , "" , $theme_settings["enabled_theme"])
);
$theme = array();

include __DIR__."/themes/{$theme_settings["enabled_theme"]}/config.php";

/* Connect to mysql */
$mysqli = new mysqli(
	$config[$serverId]["mysql"]["stats"]["host"],
	$config[$serverId]["mysql"]["stats"]["username"],
	$config[$serverId]["mysql"]["stats"]["password"],
	$config[$serverId]["mysql"]["stats"]["dbname"]
);

/* Set app path (This is to make including other folders and pages easier) */
$app_path = __DIR__;

/* Select page */
if (!isset($_GET["page"])){
	$page = $config[$serverId]["site"]["home"];
}else{
	$page = $_GET["page"];
}

/* Init Server query */
if($config[0]["server"]["query_enabled"])
	include $app_path."/include/init_query.php";

/* HTTP Headers*/
header("cache-control: private, max-age={$config[$serverId]["cache"]["max-age"]}");

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
