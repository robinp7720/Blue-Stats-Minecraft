<?php
class config{
	public $serverId = 1;
	private $BlueStatsMYQLI;
	private $pluginName;

	function __construct($mysqli,$plugin){
		$this->BlueStatsMYQLI = $mysqli;
		$this->pluginName = $plugin;
	}

	public function configExist($option,$plugin="this"){
		if ($plugin=="this")
			$plugin = $this->pluginName;
		$mysqli = $this->BlueStatsMYQLI;
		$serverId = $this->serverId;
		$stmt =  $mysqli->stmt_init();	
		if ($stmt->prepare("SELECT count(*) FROM BlueStats_config WHERE `server_id`=? AND `option`=? AND `plugin`=?")) {

		    /* bind parameters for markers */
		    $stmt->bind_param("iss", $serverId,$option,$plugin);

		    /* execute query */
		    $stmt->execute();

		    /* bind result variables */
		    $stmt->bind_result($count);

		    /* fetch value */
		    $stmt->fetch();

		    /* close statement */
		    $stmt->close();
		}
		if ($count>0){
			return true;
		}else{
			return false;
		}
	}

	public function set($option,$value,$plugin="this"){
		$value = json_encode($value);
		if ($plugin=="this")
			$plugin = $this->pluginName;
		$mysqli = $this->BlueStatsMYQLI;
		$stmt = $mysqli->stmt_init();

		/* Update or Insert new config? */
		if ($this->configExist($option,$plugin))
			$query = "UPDATE BlueStats_config SET `value`=? WHERE `server_id`=? and `plugin`=? AND `option`=?";
		else
			$query = "INSERT INTO BlueStats_config (`server_id`, `option`, `plugin`, `value`) VALUES (?, ?, ?, ?)";

		if ($stmt->prepare($query)) {
		    /* bind parameters for markers */
		    if ($this->configExist($option))
		    	$stmt->bind_param("siss",$value,$this->serverId,$plugin,$option);
		    else
		   		$stmt->bind_param("isss",$this->serverId,$option,$plugin,$value);

		    /* execute query */
		    $stmt->execute();
		    /* close statement */
		    $stmt->close();
		}
	}

	public function get($option,$plugin="this"){
		if ($plugin=="this")
			$plugin = $this->pluginName;
		$mysqli = $this->BlueStatsMYQLI;
		$stmt =  $mysqli->stmt_init();

		$query = "SELECT value FROM BlueStats_config WHERE `server_id`=? and `plugin`=? AND `option`=?";

		if ($stmt->prepare($query)) {

		    /* bind parameters for markers */
		    $stmt->bind_param("iss", $this->serverId,$plugin,$option);

		    /* execute query */
		    $stmt->execute();

		    /* bind result variables */
		    $stmt->bind_result($output);

		    /* fetch value */
		    $stmt->fetch();

		    /* close statement */
		    $stmt->close();
		    return json_decode($output,true);
		}

	}
}