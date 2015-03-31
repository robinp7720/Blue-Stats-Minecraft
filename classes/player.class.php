<?php
class player{
	public $playerName = "";
	public $playerId = 0;
	public $playerUUID = "";
	public $playerSet = false;
	
	private $BlueStats = "";
	private $mysqli = "";
	private $config = "";


	function __construct($BlueStats){
		$this->BlueStats = $BlueStats;
		$this->mysqli =  $BlueStats->mysqli;
		$this->config = $BlueStats->config;
	}

	public function setPlayerId($id){
		$playerName = $this->getPlayerName($id);
		if (!empty($playerName)){
			$this->playerId = $id;
			$this->playerName = $playerName;
			$this->playerUUID = $this->getPlayerUUID($id);
			$this->playerSet=true;
		}else{
			$this->playerSet=false;
		}
	}

	public function setPlayerName($name){
		$playerId = $this->getPlayerId($name);
		if (!empty($playerId)){
			$this->playerName = $name;
			$this->playerId = $playerId;
			$this->playerUUID = $this->getPlayerUUID($playerId);
			$this->playerSet=true;
		}else{
			$this->playerSet=false;
		}
	}

	public function playerFaceUrl($page="_THIS"){
		if ($page==="_THIS_"){
			$page=$this->BlueStats->page;
		}
		$size = $this->config["faces"][$page]["size"];
		$url = $this->config["faces"][$page]["url"];

		$image_player_url = str_replace ('{USERNAME}',$this->playerName,$url);
		$image_player_url = str_replace ('{SIZE}',$size,$image_player_url);
		return $image_player_url;
	}

	public function getPlayerName($id){
		$prefix = $this->config["mysql"]["stats"]["table_prefix"];
		if ($stmt = $this->mysqli->prepare("SELECT name FROM `{$prefix}players` where player_id=?")) {
			$stmt->bind_param("i", $id);
			$stmt->execute();
			/* bind result variables */
			$stmt->bind_result($output);
			/* fetch value */
			$stmt->fetch();
			return $output;
		}else{
			return false;
		}
	}
	public function getPlayerId($name){
		$prefix = $this->BlueStats->config["mysql"]["stats"]["table_prefix"];
		$mysqli = $this->mysqli->get("BlueStats");
		if ($stmt = $mysqli->prepare("SELECT player_id FROM `{$prefix}players` where name=?")) {
			$stmt->bind_param("s", $name);
			$stmt->execute();
			/* bind result variables */
			$stmt->bind_result($output);
			/* fetch value */
			$stmt->fetch();
			return $output;
		}else{
			return false;
		}
	}
	public function getPlayerUUID($id){
		$prefix = $this->BlueStats->config["mysql"]["stats"]["table_prefix"];
		$mysqli = $this->mysqli->get("BlueStats");
		if ($stmt = $mysqli->prepare("SELECT UUID FROM `{$prefix}players` where player_id=?")) {
			$stmt->bind_param("i", $id);
			$stmt->execute();
			/* bind result variables */
			$stmt->bind_result($output);
			/* fetch value */
			$stmt->fetch();
			return $output;
		}
	}

	public function getUserNames(){
		// Get player usernames
		$uuid=str_replace('-', '', $this->playerUUID);
		$ch = curl_init();
	    // set url 
	    curl_setopt($ch, CURLOPT_URL, "https://api.mojang.com/user/profiles/{$uuid}/names"); 
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    $output = curl_exec($ch); 
	    curl_close($ch); 
	    return json_decode($output,true);
	}
	
	public function getStat($stat){
		$prefix = $this->BlueStats->config["mysql"]["stats"]["table_prefix"];
		$mysqli = $this->mysqli->get("BlueStats");
		if ($stat=="lastleave"||$stat=="lastjoin"){
			/* Get Latest date */
			if ($stmt = $mysqli->prepare("SELECT {$stat} FROM `{$prefix}player` WHERE `player_id` = ? ORDER BY {$stat} DESC LIMIT 1")) {
				$stmt->bind_param("i",$this->playerId);
				$stmt->execute();

				/* bind result variables */
				 $stmt->bind_result($output);

				/* fetch value */
				 $stmt->fetch();

				 return $output;
			}	
		}else{
			/* Get total of all stats if not Last left or last joined */
			if ($stmt = $mysqli->prepare("SELECT sum({$stat}) FROM `{$prefix}player` WHERE `player_id` = ?")) {
				$stmt->bind_param("i",$this->playerId);
				$stmt->execute();

				/* bind result variables */
				 $stmt->bind_result($output);

				/* fetch value */
				 $stmt->fetch();

				 return $output;
			}	
		}
	}

}