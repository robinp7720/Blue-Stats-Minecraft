<?php
define('ROOT', dirname(dirname(__DIR__)));

require ROOT . "/classes/config.class.php";

/* Connect to MySQL */
$mysqli = new mysqli(
    $_SESSION["bs-host"],
    $_SESSION["bs-username"],
    $_SESSION["bs-password"],
    $_SESSION["bs-db"]
);

/* Create BlueStats DataBase structure */

/* Basic mysql configs */
/* Set MySQL mode */
$mysqli->query('SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO"');

/* Create Tables */
/* Create Config table */
$mysqli->query('CREATE TABLE IF NOT EXISTS `BlueStats_config` (
	`row_id` INT(11) NOT NULL,
	  `server_id` INT(11) NOT NULL,
	  `option` VARCHAR(64) NOT NULL,
	  `plugin` VARCHAR(64) NOT NULL,
	  `value` TEXT NOT NULL
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1');

/* Table indexes */
/* Config */
$mysqli->query('ALTER TABLE `BlueStats_config`
	 ADD PRIMARY KEY (`row_id`)');

/* Auto Increment */
$mysqli->query('ALTER TABLE `BlueStats_config`
	MODIFY `row_id` INT(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1');

/* Make config file */
$configFile = json_encode([
                              "mysql" => [
                                  "username" => $_SESSION["bs-username"],
                                  "password" => $_SESSION["bs-password"],
                                  "dbname"   => $_SESSION["bs-db"],
                                  "host"     => $_SESSION["bs-host"],
                              ],
                          ]);

if (!file_put_contents(ROOT . "/config.json", $configFile)) {
    $configFile = htmlspecialchars($configFile);
    echo 'Please create a config.json file in the root directory of BlueStats with the following contents: <pre>' . $configFile . '</pre>';

}
else {
    echo 'BlueStats config file has been created<br>';
}

/* Set up config class
-------------------------------------*/
$config = new config($mysqli, "BlueStats");

/* Set theme option
-------------------------------------*/
if ($config->set("theme", $_SESSION["theme"])) {
    echo '<i class="fa fa-check text-success"></i>Set theme<br>';
}
else {
    echo '<i class="fa fa-times text-danger"></i>Failed to set theme<br>';
}


/* Set misc options
-------------------------------------*/
$config->setDefault("server-name", "A Minecraft Server");
$config->setDefault("view_path", ROOT . "/themes/{THEME}/");
$config->setDefault("homepage", "home");

/* Enable plugins
-------------------------------------*/

$plugins = [];

// Enable query only if ip and port has been set
if (function_exists('fsockopen')) {
    if (isset($_SESSION["ip"]) && !empty($_SESSION["ip"]) && isset($_SESSION["port"]) && !empty($_SESSION["port"])) {
        if (!in_array("query", $plugins))
            array_push($plugins, "query");

        // Set query settings
        if (function_exists('fsockopen')) {
            if ($config->set("ip", $_SESSION["ip"], "query")) {
                echo '<i class="fa fa-check text-success"></i>Set query ip<br>';
            }
            else {
                echo '<i class="fa fa-times text-danger"></i>Unable to set query ip<br>';
            }

            if ($config->set("port", $_SESSION["port"], "query")) {
                echo '<i class="fa fa-check text-success"></i>Set query port<br>';
            }
            else {
                echo '<i class="fa fa-times text-danger"></i>Unable to set query port<br>';
            }
        }
        else {
            echo '<i class="fa fa-times text-danger"></i>Query port and ip not set due to dependency missing<br>';
        }
    }
}


// Scan for all available plugins in the plugins folder
$files = $scanned_directory = array_diff(scandir(ROOT . '/plugins'), ['..', '.']);

foreach ($files as $dir) {
    if (is_dir(ROOT . '/plugins/' . $dir)) {
        if (isset($_SESSION["$dir-enable"]) && $_SESSION["$dir-enable"] === "on") {
            if (!in_array($dir, $plugins))
                array_push($plugins, $dir);
        }
    }
}

if ($config->set("plugins", $plugins)) {
    echo '<i class="fa fa-check text-success"></i>Enabled plugins:<br>';
    echo '<ul>';
    foreach ($plugins as $plugin) {
        echo '<li><i class="fa fa-check text-success"></i>' . $plugin . '<br></li>';
    }
    echo '</ul>';
}
else {
    echo '<i class="fa fa-times text-danger"></i>Unable to enable plugins<br>';
}

/* Set MySQL details
-------------------------------------*/
$basePlugin = "";

foreach ($plugins as $dir) {
    if (is_dir(ROOT . '/plugins/' . $dir)) {
        include ROOT . "/plugins/$dir/$dir.php";
        $pluginClass = "\\BlueStats\\Plugin\\$dir";
        if (!$pluginClass::$isMySQLplugin)
            break;

        $config->set("MYSQL_host", $_SESSION["$dir-host"], $dir);
        $config->set("MYSQL_username", $_SESSION["$dir-username"], $dir);
        $config->set("MYSQL_password", $_SESSION["$dir-password"], $dir);
        $config->set("MYSQL_database", $_SESSION["$dir-db"], $dir);
        $config->set("MYSQL_prefix", $_SESSION["$dir-prefix"], $dir);

        $basePlugin = $dir;

    }
}

if ($config->setDefault("base_plugin", $basePlugin)) {
    echo '<i class="fa fa-check text-success"></i>Set base plugin to ' . $basePlugin . '<br>';
}

/* Update theme assets
-------------------------------------*/
$theme             = $_SESSION["theme"];
$directory         = ROOT . "/themes/" . $theme . "/assets";
$scanned_directory = array_diff(scandir($directory), ['..', '.']);
if (is_writeable(ROOT . "/assets")) {
    $success = TRUE;
    foreach ($scanned_directory as $item) {
        if (!copy(ROOT . "/themes/$theme/assets/$item", ROOT . "/assets/$item")) {
            echo '<i class="fa fa-times text-danger"></i>Could not copy ' . ROOT . "/themes/$theme/assets/$item to " . ROOT . "/assets/$item <br>";
            $success = FALSE;
        }
    }
    if ($success)
        echo '<i class="fa fa-check text-success"></i>Successfully copied theme assets to assets directory<br>';
}
else {
    echo "<i class=\"fa fa-times text-danger\"></i> Cannot copy theme assets to " . ROOT . "/assets/ <br>";
}

echo '<a href="../admin">Admin Panel</a><br>';
echo '<a href="../?page=home">BlueStats</a>';
