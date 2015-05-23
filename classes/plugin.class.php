<?php
class plugin extends config{
	function __construct($mysqli) {
		parent::__construct($mysqli);
	}
}
class MySQLplugin extends plugin{
	public $mysqli;
	public $prefix = "";
	function installed(){
		$verfy = array();
		$verfy["host"] = $this->configExist("MYSQL_host");
		$verfy["username"] = $this->configExist("MYSQL_host");
		$verfy["password"] = $this->configExist("MYSQL_host");
		$verfy["prefix"] = $this->configExist("MYSQL_host");
		$verfy["database"] = $this->configExist("MYSQL_database");
		if ($verfy["host"]==true && $verfy["username"]==true && $verfy["password"]==true && $verfy["prefix"]==true && $verfy["database"]==true){
			return true;
		}else{
			return false;
		}
	}

	function install(){
		$this->set("MYSQL_host","127.0.0.1");
		$this->set("MYSQL_username","minecraft");
		$this->set("MYSQL_password","password");
		$this->set("MYSQL_prefix","");
		$this->set("MYSQL_database","minecraft");
	}

	function __construct($mysqli) {
		parent::__construct($mysqli);
		$installed = $this->installed();
		if ($installed){
			$this->prefix = $this->get("MYSQL_prefix");
			$this->mysqli = new mysqli(
				$this->get("MYSQL_host"),
				$this->get("MYSQL_username"),
				$this->get("MYSQL_password"),
				$this->get("MYSQL_database")
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
}
