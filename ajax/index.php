<?php
$appPath = __DIR__ . "/..";

/* Classes */
require "$appPath/classes/config.class.php";
require "$appPath/classes/plugin.class.php";
require "$appPath/classes/player.class.php";
require "$appPath/classes/mysqlPlugin.class.php";
require "$appPath/classes/url.class.php";

$file_config = json_decode(file_get_contents("$appPath/config.json"), true);

/* Setup MySQL */
$mysqli = new mysqli(
    $file_config["mysql"]["host"],
    $file_config["mysql"]["username"],
    $file_config["mysql"]["password"],
    $file_config["mysql"]["dbname"]
);

/* Setup mysql config class */
$config = new config($mysqli, "BlueStats");

/*  Get enabled plugins list */
$loadablePlugins = $config->get("plugins");

foreach ($loadablePlugins as $plugin) {

    /* Load in core plugin class*/
    /** @noinspection PhpIncludeInspection */
    include "$appPath/plugins/$plugin/core.php";

    $plugins[$plugin] = new $plugin($mysqli);

    if (method_exists($plugins[$plugin], "onLoad")) {
        $plugins[$plugin]->onLoad();
    }
}

$call = $_GET['call'];
$call = str_replace(array('/', '"', "'", '.', '\\'), "", $call);

/*
 * TODO: Containerize actions
 * TODO: Plugin specific ajax modules
 */

/* Run requested action */
if (file_exists($appPath . "/ajax/calls/$call.php"))
    include $appPath . "/ajax/calls/$call.php";

header('Content-Type: application/json');
echo json_encode($output);
