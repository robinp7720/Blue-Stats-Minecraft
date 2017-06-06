<?php
$appPath = __DIR__ . "/..";

/* Classes */
require "$appPath/classes/config.class.php";
require "$appPath/classes/legacyPlugin.class.php";
require "$appPath/classes/player.class.php";
require "$appPath/classes/legacymysqlPlugin.class.php";
require "$appPath/classes/url.class.php";
require_once "$appPath/classes/plugin/plugin.php";
require_once "$appPath/classes/table.class.php";


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

/* Load all plugins */
foreach ($loadablePlugins as $plugin) {

    /* Load in core plugin class*/
    /** @noinspection PhpIncludeInspection */
    include "$appPath/plugins/$plugin/$plugin.php";

    $pluginClass = "\\BlueStats\\Plugin\\$plugin";

    $plugins[$plugin] = new $pluginClass($mysqli);
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
