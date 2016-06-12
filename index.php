<?php
$debug = false;

if (file_exists("./install")) {
    die("Please remove /install after installation");
}

// Turn of error reporting to prevent security leaks
if ($debug) {
    error_reporting(-1);
    ini_set("display_errors", 'On');
}else{
    error_reporting(0);
    ini_set("display_errors", 0);
}

$appPath = __DIR__;

/* Classes */
require "$appPath/classes/config.class.php";
require "$appPath/classes/cache.class.php";


$config = json_decode(file_get_contents("config.json"), true);

$mysqli = new mysqli(
    $config["mysql"]["host"],
    $config["mysql"]["username"],
    $config["mysql"]["password"],
    $config["mysql"]["dbname"]
);
$cache = new cache($mysqli, $appPath);

// Replace remove ?recache from url
$uri = $_SERVER["REQUEST_URI"];
$uri = str_replace("?recache&", "?", $uri);
$uri = str_replace("&recache", "", $uri);
$uri = str_replace("?recache", "", $uri);

if ($cache->reCache($uri)) {
    /* Include all classes and api if a new cache has to be created */
    require "$appPath/classes/plugin.class.php";
    require "$appPath/classes/bluestats.class.php";
    require "$appPath/classes/modules.class.php";
    require "$appPath/classes/view.class.php";
    require "$appPath/classes/player.class.php";
    require "$appPath/classes/mysqlPlugin.class.php";
    require "$appPath/classes/url.class.php";


    /* Functions */
    require "$appPath/functions/utils.func.php";

    $BlueStats = new BlueStats($mysqli, $appPath);

    $loadablePlugins = $BlueStats->getPluginList();
    $plugins = array();

    /* Load all plugins */
    foreach ($loadablePlugins as $plugin) {

        /* Load in core plugin class*/
        /** @noinspection PhpIncludeInspection */
        include "$appPath/plugins/$plugin/core.php";

        $plugins[$plugin] = new $plugin($mysqli);

        /* Avoid errors on first install */
        if (isset($plugins[$plugin]->firstInstall)) {
            if ($plugins[$plugin]->firstInstall === true) {
                unset($plugins[$plugin]);
            }
        }

        // Call plugin load function
        if (method_exists($plugins[$plugin], "onLoad")) {
            $plugins[$plugin]->onLoad();
        }
    }
    $BlueStats->loadPlugins($plugins);

    $content = $BlueStats->loadPage();

    $credits = '
	<!--
	Copyright Zeyphros (robinp7720) 2015
	BlueStats 3 is released under the Apache 2 license.
	Removal of this copyright notice is an infringement of the license.

	Developed by Zeyphros (robinp7720)
	-->
	';

    $copyrightMeta = '
	<meta name="dcterms.rightsHolder" content="Zeyphros (robinp7720)">
	<meta name="dcterms.rights" content="Released under Apache 2.0 license">
	<meta name="dcterms.dateCopyrighted" content="2015">
	<meta name="dc.license" content="Apache 2.0">
	<meta name="web_author" content="Zeyphros (robinp7720)">	';
    $content = str_replace("<head>", "<head>" . $copyrightMeta, $content);

    // Compress html
    $content = trim(preg_replace('/\s\s+/', ' ', $content));
    $content = str_replace("\lf", '', $content);

    // Add credits into head
    $content = str_replace("<head>", "<head>" . $credits, $content);

    echo $content;
    $cache->cache($content, $uri);
} else {
    echo $cache->getCache($uri);
}
