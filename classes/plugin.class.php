<?php
class plugin extends config{
	public $mysqli;
	public $prefix = "";
	function installed(){
		$verfy = array();
		$verfy["host"] = $this->configExist("MYSQL_host",$this->pluginName);
		$verfy["username"] = $this->configExist("MYSQL_host",$this->pluginName);
		$verfy["password"] = $this->configExist("MYSQL_host",$this->pluginName);
		$verfy["prefix"] = $this->configExist("MYSQL_host",$this->pluginName);
		$verfy["database"] = $this->configExist("MYSQL_database",$this->pluginName);
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

	public function getUserName($id){
		$mysqli = $this->mysqli;
		$stmt = $mysqli->stmt_init();

		$query = "SELECT {$this->plugin["playerNameColum"]} FROM {$this->prefix}{$this->plugin["indexTable"]} WHERE {$this->plugin["idColumn"]} = ?";
		if ($stmt->prepare($query)) {
		   	$stmt->bind_param("s",$id);
		    $stmt->execute();
		    $stmt->bind_result($output);
		    $stmt->fetch();
		    $stmt->close();
			return $output;
		}
	}
}