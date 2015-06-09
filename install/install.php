<html>
	<head>
		<title>BlueStats 3 Install</title>
		<!-- Latest compiled and minified CSS & JS -->
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootswatch/3.3.4/paper/bootstrap.min.css">
		<style>
			.input-group{
				margin-bottom:10px;
			}
			.label{
				font-size:14px;
				margin:5px;
				margin-left:0;
			}
		</style>
	</head>
	<body class="container">
<?php
if (isset($_POST["bs-host"])&&isset($_POST["bs-username"])&&isset($_POST["bs-password"])&&isset($_POST["bs-db"])){
	/* Connect to MySQL */
	$mysqli = new mysqli(
		$_POST["bs-host"],	
		$_POST["bs-username"],
		$_POST["bs-password"],
		$_POST["bs-db"]
	);

	/* Create BlueStats DataBase structure */

	/* Basic mysql configs */
	/* Set MySQL mode */
	$mysqli->query('SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO"');

	/* Set Time Zone */
	$mysqli->query('SET time_zone = "+00:00"');

	/* Create Tables */
	/* Create Config table */
	$mysqli->query('CREATE TABLE IF NOT EXISTS `BlueStats_config` (
	`row_id` int(11) NOT NULL,
	  `server_id` int(11) NOT NULL,
	  `option` varchar(64) NOT NULL,
	  `plugin` varchar(64) NOT NULL,
	  `value` text NOT NULL
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1');

	/* Create players table */
	$mysqli->query('CREATE TABLE IF NOT EXISTS `BlueStats_players` (
	`row_id` int(11) NOT NULL,
	  `server_id` int(11) NOT NULL,
	  `uuid` varchar(128) NOT NULL,
	  `name` varchar(128) NOT NULL,
	  `plugin` varchar(64) NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1');

	/* Create server info table */
	$mysqli->query('CREATE TABLE IF NOT EXISTS `BlueStats_server` (
	`row_id` int(11) NOT NULL,
	  `server_id` int(11) NOT NULL,
	  `option` varchar(64) NOT NULL,
	  `value` varchar(64) NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1');

	/* Table indexes */
	/* Config */
	$mysqli->query('ALTER TABLE `BlueStats_config`
	 ADD PRIMARY KEY (`row_id`)');

	/* Players */
	$mysqli->query('ALTER TABLE `BlueStats_players`
	 ADD PRIMARY KEY (`row_id`)');

	/* server info */
	$mysqli->query('ALTER TABLE `BlueStats_server`
	 ADD PRIMARY KEY (`row_id`)');

	/* Auto Increment */
	$mysqli->query('ALTER TABLE `BlueStats_config`
	MODIFY `row_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1');

	$mysqli->query('ALTER TABLE `BlueStats_players`
	MODIFY `row_id` int(11) NOT NULL AUTO_INCREMENT');

	$mysqli->query('ALTER TABLE `BlueStats_server`
	MODIFY `row_id` int(11) NOT NULL AUTO_INCREMENT');

	/* Make config file */
	$config =
	'<?php
	$config["mysql"]=array(
		"username" => "'.$_POST["bs-username"].'",
		"password" => "'.$_POST["bs-password"].'",
		"dbname"   => "'.$_POST["bs-db"].'",
		"host"     => "'.$_POST["bs-host"].'"
	);';

	if (!file_put_contents("../config.php",$config)){
		$config = htmlspecialchars($config);
		echo "Please create a config.php file in the root directory of BlueStats with the following contents: <pre>$config</pre>";

	}else{
		echo "BlueStats has been installed!";
	}
	echo '<a href="../admin">Admin Panel</a>';
}else{
	echo "Please enter all fields";
}
?>
</body>
</html>