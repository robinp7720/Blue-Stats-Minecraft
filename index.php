<?php
error_reporting(-1);
$appPath = __DIR__;

$loadablePlugins = array("lolmewnStats","mcmmo");
$plugins = array();

/* Classes */
require "$appPath/classes/config.class.php";
require "$appPath/classes/mysql.class.php";
require "$appPath/classes/plugin.class.php";
require "$appPath/classes/bluestats.class.php";

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

$BlueStats = new BlueStats($mysqlMan->get("BlueStats"),$appPath);

/* Load all plugins */
foreach ($loadablePlugins as $plugin){

	/* Load in core plugin class*/
	include "$appPath/plugins/$plugin/core.php";

	/* Load in plugin init script */
	include "$appPath/plugins/$plugin/init.php";
}
$BlueStats->loadPlugins($plugins);

/* Themes Inclusion */
echo $BlueStats->loadPage("home");
