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
require "$appPath/classes/player.class.php";
require "$appPath/classes/mysqlPlugin.class.php";
require "$appPath/classes/url.class.php";

/* Functions */
require "$appPath/functions/utils.func.php";

$config = json_decode(file_get_contents("config.json"),true);

$mysqlMan = new mysqlMan;
$mysqlMan->connect(
    "BlueStats",
    $config["mysql"]["username"],
    $config["mysql"]["password"],
    $config["mysql"]["host"],
    $config["mysql"]["dbname"]
);
$cache = new cache($mysqlMan->get("BlueStats"), $appPath);

// Replace remove ?recache from url
$uri = $_SERVER["REQUEST_URI"];
$uri = str_replace("?recache&","?",$uri);
$uri = str_replace("&recache","",$uri);
$uri = str_replace("?recache","",$uri);

if ($cache->reCache($uri)) {
    $BlueStats = new BlueStats($mysqlMan->get("BlueStats"), $appPath);

    $loadablePlugins = $BlueStats->getPluginList();
    $plugins = array();

    /* Load all plugins */
    foreach ($loadablePlugins as $plugin) {

        /* Load in core plugin class*/
        /** @noinspection PhpIncludeInspection */
        include "$appPath/plugins/$plugin/core.php";

        $plugins[$plugin] = new $plugin($mysqlMan->get("BlueStats"));

        /* Avoid errors on first install */
        if (isset($plugins[$plugin]->firstInstall)) {
            if ($plugins[$plugin]->firstInstall === true) {
                unset($plugins[$plugin]);
            }
        }

        if (method_exists($plugins[$plugin], "onLoad")) {
            $plugins[$plugin]->onLoad();
        }
    }
    $BlueStats->loadPlugins($plugins);

    $content = $BlueStats->loadPage();

    $credits = '
	<!--
	Copyright _OvErLoRd_ (robinp7720) 2015
	BlueStats 3 is released under the Apache 2 license.
	Removal of this copyright notice is an infringement of the license.

	Developed by _OvErLoRd_ (robinp7720)
	-->
	';

    $copyrightMeta = '
	<link rel="schema.dc" href="http://purl.org/dc/elements/1.1/">
	<meta name="dcterms.rightsHolder" content="_OvErLoRd_ (robinp7720)">
	<meta name="dcterms.rights" content="Released under apache 2.0 license">
	<meta name="dcterms.dateCopyrighted" content="2015">
	<meta name="dc.license" content="apache 2.0">
	<meta name="web_author" content="_OvErLoRd_ (robinp7720)">
	<meta name="author" content="_OvErLoRd_ (robinp7720)">
	';
    $content = str_replace("<head>", "<head>" . $copyrightMeta, $content);

    echo $credits . trim($content);
    $cache->cache($credits . trim($content), $uri);
} else {
    echo $cache->getCache($_SERVER["REQUEST_URI"]);
}
