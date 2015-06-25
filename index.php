<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

$appPath = __DIR__;

/* Classes */
require "$appPath/classes/config.class.php";
require "$appPath/classes/mysql.class.php";
require "$appPath/classes/plugin.class.php";
require "$appPath/classes/bluestats.class.php";
require "$appPath/classes/modules.class.php";
require "$appPath/classes/cache.class.php";
require "$appPath/classes/error.class.php";
require "$appPath/classes/view.class.php";

/* Configs */
require "$appPath/config.php";

/* Functions */
require "$appPath/functions/utils.func.php";

$mysqlMan = new mysqlMan;
$mysqlMan->connect(
	"BlueStats",
	$config["mysql"]["username"],
	$config["mysql"]["password"],
	$config["mysql"]["host"],
	$config["mysql"]["dbname"]
);
$cache = new cache($mysqlMan->get("BlueStats"),$appPath);

if ($cache->reCache($_SERVER["REQUEST_URI"])||isset($_GET["recache"])){
	$BlueStats = new BlueStats($mysqlMan->get("BlueStats"),$appPath);
	if (file_exists('themes/'.$BlueStats->theme.'/style.css')){
		file_put_contents("style.css", file_get_contents('themes/'.$BlueStats->theme.'/style.css'));
	}
	$loadablePlugins = $BlueStats->getPluginList();
	$plugins = array();

	/* Load all plugins */
	foreach ($loadablePlugins as $plugin){

		/* Load in core plugin class*/
		include "$appPath/plugins/$plugin/core.php";

		/* Load in plugin init script */
		include "$appPath/plugins/$plugin/init.php";
	}
	$BlueStats->loadPlugins($plugins);

	$content = $BlueStats->loadPage();

	$credits = '
	<!--
	Copyright Robin Decker 2015
	BlueStats 3 is released under the Apache 2 license.
	Removal of this copyright notice is an infringement of the license.

	Developed by _OvErLoRd_ (robinp7720) and MySunland
	-->
	';
	
	$copyrightMeta = '
	<link rel="schema.dc" href="http://purl.org/dc/elements/1.1/">
	<meta name="dcterms.rightsHolder" content="Robin Decker, MySunland">
	<meta name="dcterms.rights" content="Released under apache 2.0 license">
	<meta name="dcterms.dateCopyrighted" content="2015">
	<meta name="dc.license" content="apache 2.0">
	<meta name="web_author" content="Robin Decker">
	<meta name="author" content="Robin Decker">
	';
	$content = str_replace("<head>","<head>".$copyrightMeta, $content);

	echo $credits.trim($content);
	$cache->cache($credits.trim($content),$_SERVER["REQUEST_URI"]);
}else{
	echo $cache->getCache($_SERVER["REQUEST_URI"]);
}
