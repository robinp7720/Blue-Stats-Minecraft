<?php

define('DEBUG', true);


// If the config file does not exist assume the installer has not yet been executed and thus show a link to the install page.
if (!file_exists("./config.json")) {
	include 'NewInstall.html';
	die();
}

// Before allow the page to be rendered, check if the install page is still there. This is because the install script can change configs and be a sever security flaw when still there.
if (!DEBUG){
    if (file_exists("./install")) {
        die("Please remove /install after installation");
    }
}

// Turn off error reporting to prevent security leaks
if (DEBUG) {
    error_reporting(-1);
    ini_set("display_errors", 'On');
} else {
    error_reporting(0);
    ini_set("display_errors", 0);
}

// Make reference of the root path of BlueStats. This is used in other parts of the webapp to get theme files and others.
$appPath = __DIR__;

/* Classes */
require_once "$appPath/classes/config.class.php";
require_once "$appPath/classes/cache.class.php";

// Load config file. This file stores the BlueStats mysql settings.
// It is used to establish the connection the to config database.
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
    require_once "$appPath/classes/bluestats.class.php";
    require_once "$appPath/classes/module.class.php";
    require_once "$appPath/classes/view.class.php";
    require_once "$appPath/classes/player.class.php";
    require_once "$appPath/classes/url.class.php";
    require_once "$appPath/classes/chart.class.php";
    require_once "$appPath/classes/plugin/plugin.php";
    require_once "$appPath/classes/table.class.php";

    /* Functions */
    require_once "$appPath/functions/utils.func.php";
    require_once "$appPath/functions/blocks.func.php";

    // Start the BlueStats core
    $BlueStats = new BlueStats($mysqli, $appPath);

    $plugins = [];

    /* Load all plugins */
    foreach ($BlueStats->getPluginList() as $plugin) {
        /* Load in core plugin class*/
        /** @noinspection PhpIncludeInspection */
        include "$appPath/plugins/$plugin/$plugin.php";
        $pluginClass = "\\BlueStats\\Plugin\\$plugin";
        $plugins[$plugin] = new $pluginClass($mysqli);
    }

    $BlueStats->loadPlugins($plugins);

    $content = $BlueStats->loadPage();

    // Add the copyright statements
    // I don't trust theme creators to include my copyright after all :)
    // Because I (The Author) do like attribution for what I make.
    $credits = '
	<!--
	Copyright Zeyphros (robinp7720) 2015
	BlueStats 3 is released under the Apache 2 license.
	Removal of this copyright notice is an infringement of the license.

	Developed by Zeyphros (robinp7720)
	-->
	';

    $copyrightMeta = '<meta name="dcterms.rightsHolder" content="Zeyphros (robinp7720)"><meta name="dcterms.rights" content="Released under Apache 2.0 license"><meta name="dcterms.dateCopyrighted" content="2015"><meta name="dc.license" content="Apache 2.0"><meta name="web_author" content="Zeyphros (robinp7720)">';

    // Add the copyright stuff to the head tag
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
