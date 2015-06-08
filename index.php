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
<!-----------------------------------------
Copyright Robin Decker 2015
BlueStats 3 is released under the Apache 2 license.
Removal of this copyright notice is an infringement of the license.

Developed by _OvErLoRd_ (robinp7720) and MySunland
-------------------------------------------->
';

echo $credits.$content;
