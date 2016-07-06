<?php
define('ROOT', dirname(dirname(__DIR__)));

require ROOT."/classes/config.class.php";

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
	`row_id` int(11) NOT NULL,
	  `server_id` int(11) NOT NULL,
	  `option` varchar(64) NOT NULL,
	  `plugin` varchar(64) NOT NULL,
	  `value` text NOT NULL
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1');

/* Table indexes */
/* Config */
$mysqli->query('ALTER TABLE `BlueStats_config`
	 ADD PRIMARY KEY (`row_id`)');

/* Auto Increment */
$mysqli->query('ALTER TABLE `BlueStats_config`
	MODIFY `row_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1');

/* Make config file */
$configFile = json_encode(array(
	"mysql" => array(
		"username" => $_SESSION["bs-username"],
		"password" => $_SESSION["bs-password"],
		"dbname"   => $_SESSION["bs-db"],
		"host"     => $_SESSION["bs-host"]
	)
));

if (!file_put_contents(ROOT . "/config.json", $configFile)) {
	$configFile = htmlspecialchars($configFile);
    echo 'Please create a config.json file in the root directory of BlueStats with the following contents: <pre>'.$configFile.'</pre>';

} else {
    echo 'BlueStats config file has been created<br>';
}

/* Set up config class
-------------------------------------*/
$config = new config($mysqli,"BlueStats");

/* Set theme option
-------------------------------------*/
if ($config->set("theme",$_SESSION["theme"])){
	echo '<i class="fa fa-check text-success"></i>Set theme<br>';
}else{
	echo '<i class="fa fa-times text-danger"></i>Failed to set theme<br>';
}


/* Set misc options
-------------------------------------*/
$config->setDefault("server-name", "A Minecraft Server");
$config->setDefault("view_path", ROOT . "/themes/{THEME}/");
$config->setDefault("homepage", "home");

/* Enable plugins
-------------------------------------*/

$plugins = array("themeText", "nameHistory");

// Enable query only if ip and port has been set
if (isset($_SESSION["ip"]) && !empty($_SESSION["ip"]) && isset($_SESSION["port"]) && !empty($_SESSION["port"])) {
    array_push($plugins, "query");
}

if (isset($_SESSION["lolstats-enable"])&&$_SESSION["lolstats-enable"]==="on"){
	array_push($plugins,"lolmewnStats");
}
if (isset($_SESSION["mcmmo-enable"])&&$_SESSION["mcmmo-enable"]==="on"){
	array_push($plugins,"mcmmo");
}

if ($config->set("plugins",$plugins)){
	echo '<i class="fa fa-check text-success"></i>Enabled plugins<br>';
}else{
	echo '<i class="fa fa-times text-danger"></i>Unable to enable plugins<br>';
}

/* Set MySQL details
-------------------------------------*/

if (isset($_SESSION["lolstats-enable"])&&$_SESSION["lolstats-enable"]==="on"){
	$config->set("MYSQL_host",$_SESSION["lolstats-host"],"lolmewnStats");
	$config->set("MYSQL_username",$_SESSION["lolstats-username"],"lolmewnStats");
	$config->set("MYSQL_password",$_SESSION["lolstats-password"],"lolmewnStats");
	$config->set("MYSQL_database",$_SESSION["lolstats-db"],"lolmewnStats");
	$config->set("MYSQL_prefix",$_SESSION["lolstats-prefix"],"lolmewnStats");
    $config->setDefault("base_plugin", "lolmewnStats");
}

if (isset($_SESSION["mcmmo-enable"])&&$_SESSION["mcmmo-enable"]==="on"){
	$config->set("MYSQL_host",$_SESSION["mcmmo-host"],"mcmmo");
	$config->set("MYSQL_username",$_SESSION["mcmmo-username"],"mcmmo");
	$config->set("MYSQL_password",$_SESSION["mcmmo-password"],"mcmmo");
	$config->set("MYSQL_database",$_SESSION["mcmmo-db"],"mcmmo");
	$config->set("MYSQL_prefix",$_SESSION["mcmmo-prefix"],"mcmmo");
    $config->setDefault("base_plugin", "mcmmo");
}

if ($config->set("ip",$_SESSION["ip"],"query")){
	echo '<i class="fa fa-check text-success"></i>Set query ip<br>';
}else{
	echo '<i class="fa fa-times text-danger"></i>Unable to set query ip<br>';
}

if ($config->set("port",$_SESSION["port"],"query")){
	echo '<i class="fa fa-check text-success"></i>Set query port<br>';
}else{
	echo '<i class="fa fa-times text-danger"></i>Unable to set query port<br>';
}

/* Update theme assets
-------------------------------------*/
$theme = $_SESSION["theme"];
$directory = ROOT . "/themes/" . $theme . "/assets";
$scanned_directory = array_diff(scandir($directory), array('..', '.'));
if (is_writeable(ROOT . "/assets")) {
	$success = true;
	foreach ($scanned_directory as $item) {
		if (!copy(ROOT . "/themes/$theme/assets/$item", dirname(dirname(__DIR__)) . "/assets/$item")) {
			echo '<i class="fa fa-times text-danger"></i>Could not copy ' . ROOT . "/themes/$theme/assets/$item to " . dirname(dirname(__DIR__)) . "/assets/$item <br>";
			$success = false;
		}
	}
	if ($success)
		echo '<i class="fa fa-check text-success"></i>Successfully copied theme assets to assets directory<br>';
} else {
	echo "<i class=\"fa fa-times text-danger\"></i> Cannot copy theme assets to " . dirname(dirname(__DIR__)) . "/assets/ <br>";
}

echo '<a href="../admin">Admin Panel</a><br>';
echo '<a href="../?page=home">BlueStats</a>';
