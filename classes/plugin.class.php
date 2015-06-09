<?php
class plugin{
	protected $config;
	function __construct($mysqli) {
		$this->BlueStatsMYQLI = $mysqli;
		$this->config = new config($mysqli,$this->pluginName);
	}
}
class MySQLplugin extends plugin{
	public $mysqli;
	public $prefix = "";

	protected $installed = "";

	function installed(){
		$verfy = array();
		$verfy["host"] = $this->config->configExist("MYSQL_host");
		$verfy["username"] = $this->config->configExist("MYSQL_username");
		$verfy["password"] = $this->config->configExist("MYSQL_password");
		$verfy["prefix"] = $this->config->configExist("MYSQL_prefix");
		$verfy["database"] = $this->config->configExist("MYSQL_database");
		if ($verfy["host"]==true && $verfy["username"]==true && $verfy["password"]==true && $verfy["prefix"]==true && $verfy["database"]==true){
			return true;
		}else{
			return false;
		}
	}

	function install(){
		$this->config->set("MYSQL_host","127.0.0.1");
		$this->config->set("MYSQL_username","minecraft");
		$this->config->set("MYSQL_password","password");
		$this->config->set("MYSQL_prefix","");
		$this->config->set("MYSQL_database","minecraft");
	}

	function __construct($mysqli) {
		parent::__construct($mysqli);
		$this->installed = $this->installed();
		if ($this->installed){
			$this->prefix = $this->config->get("MYSQL_prefix");
			$this->mysqli = new mysqli(
				$this->config->get("MYSQL_host"),
				$this->config->get("MYSQL_username"),
				$this->config->get("MYSQL_password"),
				$this->config->get("MYSQL_database")
			);
		}else{
			$this->install();
		}
	}

	public function getId($uuid){
		if ($this->plugin["UUIDisID"]){
			$id=$uuid;
		}else{
			$mysqli = $this->mysqli;
			$stmt = $mysqli->stmt_init();
			$query = "SELECT {$this->plugin["idColumnInIndex"]} FROM {$this->prefix}{$this->plugin["indexTable"]} WHERE {$this->plugin["UUIDcolumn"]} = ?";
			if ($stmt->prepare($query)) {
			   	$stmt->bind_param("s",$uuid);
			    $stmt->execute();
			    $stmt->bind_result($id);
			    $stmt->fetch();
			    $stmt->close();
			}
		}
		return $id;
	}

	public function getUserName($uuid){
		$mysqli = $this->mysqli;
		$stmt = $mysqli->stmt_init();
		$id = $this->getId($uuid);
		$query = "SELECT {$this->plugin["playerNameColum"]} FROM {$this->prefix}{$this->plugin["indexTable"]} WHERE {$this->plugin["idColumn"]} = ?";
		if ($stmt->prepare($query)) {
		   	$stmt->bind_param("s",$id);
		    $result = $stmt->execute();
		    $stmt->bind_result($output);
		    $stmt->fetch();
		    $stmt->close();
			return $output;
		}
	}

	public function getStat($column,$uuid){

		$stmt =  $this->mysqli->stmt_init();

		$sql = "SELECT * FROM {$this->prefix}{$column} WHERE {$this->plugin["idColumn"]}=? GROUP BY {$this->plugin["idColumn"]}";
		$id = $this->getId($uuid);
		if ($stmt->prepare($sql)) {
		    $stmt->bind_param("i", $id);
		    $stmt->execute();
		    $result = $stmt->get_result();
		    $output=array();
			while ($row = $result->fetch_array(MYSQLI_ASSOC)){
				$output[]=$row;
			}
		    $stmt->close();

		    return $output;
		}
	}
	public function getStats($column){

		$stmt =  $this->mysqli->stmt_init();

		$sql = "SELECT * FROM {$this->prefix}{$column} WHERE {$this->plugin["idColumn"]} IS NOT NULL GROUP BY {$this->plugin["idColumn"]}";
		if ($stmt->prepare($sql)) {
		    $stmt->execute();
		    $result = $stmt->get_result();
		    $output=array();
			while ($row = $result->fetch_array(MYSQLI_ASSOC)){
				$output[]=$row;
			}
		    $stmt->close();

		    return $output;
		}
	}
	public function getUsers(){

		$stmt =  $this->mysqli->stmt_init();

		$sql = "SELECT * FROM {$this->prefix}{$this->plugin["indexTable"]} WHERE {$this->plugin["UUIDcolumn"]} IS NOT NULL GROUP BY {$this->plugin["UUIDcolumn"]}";
		if ($stmt->prepare($sql)) {
		    $stmt->execute();
		    $result = $stmt->get_result();
		    $output=array();
			while ($row = $result->fetch_array(MYSQLI_ASSOC)){
				$output[]=$row;
			}
		    $stmt->close();

		    return $output;
		}
	}

	public function saveStat($uuid,$stat,$value){
		$plugin = $this->pluginName;
		$mysqli = $this->BlueStatsMYQLI;
		$stmt = $mysqli->stmt_init();

		/* Update or Insert new config? */
		if ($this->statValExist($stat))
			$query = "UPDATE BlueStats_stats SET `value`=? WHERE `server_id`=? and `plugin`=? AND `stat_name`=?";
		else
			$query = "INSERT INTO BlueStats_stats (`server_id`, `stat_name`, `plugin`, `value`) VALUES (?, ?, ?, ?)";

		if ($stmt->prepare($query)) {

		    /* bind parameters for markers */
		    if ($this->configExist($option))
		    	$stmt->bind_param("siss",$value,$this->serverId,$plugin,$stat);
		    else
		   		$stmt->bind_param("isss",$this->serverId,$stat,$plugin,$value);

		    /* execute query */
		    $stmt->execute();

		    /* close statement */
		    $stmt->close();
		}
	}
}
