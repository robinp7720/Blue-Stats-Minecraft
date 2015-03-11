<?php
$debug=true;
$serverId=0;

/* Set app path (This is to make including other folders and pages easier) */
$app_path = __DIR__;


if ($debug)
	error_reporting(-1);
else
	error_reporting(0);


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
require __DIR__."/classes/ping.php";
require __DIR__."/classes/pingException.php";
require __DIR__."/classes/main.class.php";
require __DIR__."/classes/player.class.php";

/* Setup BlueStats Core */
$BlueStats = new BlueStats;
$BlueStats->setup($config,$serverId);
$BlueStats->setAppPath($app_path);
$BlueStats->loadLocal($localization);


/* Setup Default pages */
$BlueStats->addPage("home","home.php","Home","left");
$BlueStats->addPage("highscores","highscores.php","High Scores","left");
$BlueStats->addPage("allplayers","all-players.php","All Players","left");
$BlueStats->addPage("pvp","pvp_stats.php","PvP Stats","left");
$BlueStats->addPage("blocks","block_stats.php","Block Stats","left");
$BlueStats->addPage("player","player.php","Player","left",true);

/* Get block names */
$blocks_names = $BlueStats->getBlockNames();

/* Include theme */
include __DIR__."/themes/{$BlueStats->getThemeId()}/config.php";

/* Connect to mysql */
$mysqli = new mysqli(
	$config[$serverId]["mysql"]["stats"]["host"],
	$config[$serverId]["mysql"]["stats"]["username"],
	$config[$serverId]["mysql"]["stats"]["password"],
	$config[$serverId]["mysql"]["stats"]["dbname"]
);

$BlueStats->loadMySQL($mysqli);

/* Select page */
$BlueStats->setCurrentPage((isset($_GET["page"]))? $_GET["page"] : "_HOME_");
$page = $BlueStats->getCurrentPage();

/* Init Server query */
if($config[$serverId]["server"]["query_enabled"]){
	include $app_path."/include/init_query.php";
	$BlueStats->loadOnlinePlayers($Online_Players);
	$BlueStats->loadPing($PingInfo);
}


/* HTTP Headers*/
header("cache-control: private, max-age={$BlueStats->config["cache"]["max-age"]}");

/* Html Header */
include $BlueStats->loadPart("head");

/* Nav Bar */
include $BlueStats->loadPart("nav");
if ($theme["container"]["body"]["fluid"]){
	echo '<div class="container-fluid">';
}else{
	echo '<div class="container">';
}


									/*--------------*/
									/* Include page */

$errorPage = false;

if ($page == "player"){
	if (!$player->playerSet){
		$errorPage = true;
	}
}

if (!$errorPage){
	echo $BlueStats->loadPage();
}

								/* Page include end */
								/*------------------*/

echo '</div>';

/* Html Header */
include $BlueStats->loadPart("footer");
