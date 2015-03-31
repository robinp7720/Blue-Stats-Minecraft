<?php

$debug=true;
$serverId=0;
$errors = array();

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
require __DIR__."/classes/mysqli.class.php";
require __DIR__."/classes/plugins.class.php";

set_error_handler("ErrorHandler");

/* Setup BlueStats Core */
$BlueStats = new BlueStats($config,$serverId,$app_path);

/* Setup Default pages */
$BlueStats->addPage("home","Home","left");
$BlueStats->addPage("highscores","High Scores","left");
$BlueStats->addPage("allplayers","All Players","left");
$BlueStats->addPage("pvp","PvP Stats","left");
$BlueStats->addPage("blocks","Block Stats","left");
$BlueStats->addPage("tracker","Live Tracker","left");
$BlueStats->addPage("player","Player","left",true);

/* Include theme */
include __DIR__."/themes/{$BlueStats->getThemeId()}/config.php";

/* Select page */
$BlueStats->setCurrentPage((isset($_GET["page"]))? $_GET["page"] : "_HOME_");
$page = $BlueStats->getCurrentPage();

/* If player page get color and name*/
if ($page=="player"&&isset($_GET["player"])){
	/* Initialize new player */
	$player = new player($BlueStats);

	/* Get player id and name */
	if (!is_numeric($_GET["player"])){
		if ($BlueStats->config["url"]["player"]["useName"]){
			$player->setPlayerName($_GET["player"]);
		}
	}else{
		$player->setPlayerName($_GET["player"]);
	}

	/* Get player face */
	$image_url = player_face($player->playerName,1,$BlueStats->config["faces"]["head_colour"]["url"] );
	if ($player->playerSet){
		/* Get colour */
		if ($BlueStats->config["player"]["playerTheme"]&&$theme["nav"]["youtube"]){
			$theme["nav"]["color"] = get_main_colour($image_url);
			$theme["headers"]["color"] = $theme["nav"]["color"];
			$theme["pager"]["color"] = $theme["nav"]["color"];
		}
	}
}

/* Html Header */
include $BlueStats->loadPart("head");

/* Nav Bar */
if ($theme["nav"]["enable"])
	include $BlueStats->loadPart("nav");
if ($theme["container"]["body"]["container"]){
	if ($theme["container"]["body"]["fluid"]){
		echo '<div class="container-fluid">';
	}else{
		echo '<div class="container">';
	}
}

$errorPage = false;

if ($page == "player"){
	if (!isset($player)){
		$errorPage = true;
	}else{
		if (!$player->playerSet){
			$errorPage = true;
		}
	}
}

if (!$errorPage){
	echo $BlueStats->loadPage();
}else{
	echo '<div class="alert alert-danger" role="alert">Error! This page does not exist!</div>';
}

/* Errors */
foreach ($errors as $error){
	echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
}
if ($theme["container"]["body"]["container"])
	echo '</div>';


/* Html Header */
include $BlueStats->loadPart("footer");
