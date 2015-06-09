<?php
class lolmewnStats extends MySQLplugin{
	public $pluginName = "lolmewnStats";
	public $plugin = array(
		"idColumn"=>"uuid",
		"playerNameColum"=>"name",
		"UUIDcolumn"=>"uuid",
		"indexTable"=>"players",
		"UUIDisID"=>true,
	);
	public $stats = array();

	function __construct($mysqli){
		parent::__construct($mysqli);
		if ($this->installed())
			$this->setUp();
	}
	function setUp(){
		if (!$this->config->configExist("stats")){
			$this->config->set("stats",array(
				"arrows" => "Arrows Shot",
				"beds_entered" => "Beds Entered",
				"blocks_broken" => "Blocks Broken",
				"blocks_placed" => "Blocks Placed",
				"buckets_emptied" => "Buckets Emptied",
				"buckets_filled" => "Buckets Filled",
				"commands_done" => "Commands Done",
				"damage_taken" => "Damage Taken",
				"death" => "Times Died",
				"eggs_thrown" => "Eggs Thrown",
				"fish_caught" => "Fish Caught",
				"items_crafted" => "Items Crafted",
				"items_dropped" => "Items Dropped",
				"items_picked_up" => "Items Picked Up",
				"joins" => "Joins",
				"kill" => "Kills",
				"last_join" => "Last Joined",
				"last_seen" => "Last Seen",
				"move" => "Blocks Traversed",
				"omnomnom" => "Food Eaten",
				"playtime" => "Play Time",
				"pvp" => "PvP Kills",
				"shears" => "Times striped a sheep",
				"teleports" => "Teleports",
				"times_changed_world" => "Worlds Changed",
				"times_kicked" => "Times Kicked",
				"tools_broken" => "Tools Broken",
				"trades" => "Trades",
				"votes" => "Votes",
				"words_said" => "Words Said",
				"xp_gained" => "Xp Gained",
			));
		}
		$this->stats = $this->config->get("stats");
	}

	public function statName($stat){
		if (isset($this->stats[$stat]))
			return $this->stats[$stat];
		else
			return $stat;
	}

	public function getAllPlayerStats($stat,$limit=0){

		$stmt = $this->mysqli->stmt_init();

		if ($stat == "last_join"||$stat == "last_seen"){
			$sql = "SELECT *, min(value) as value FROM {$this->prefix}{$stat} INNER JOIN `{$this->prefix}players` on {$this->prefix}{$stat}.UUID = {$this->prefix}players.UUID GROUP BY {$this->prefix}{$stat}.UUID ORDER BY value Desc";
		}else{
			$sql = "SELECT *, sum(value) as value FROM {$this->prefix}{$stat} INNER JOIN `{$this->prefix}players` on {$this->prefix}{$stat}.UUID = {$this->prefix}players.UUID GROUP BY {$this->prefix}{$stat}.UUID ORDER BY value Desc";
		}

		
		if (!$limit==0){
			$sql = $sql." LIMIT $limit";
		}

		if ($stmt->prepare($sql)) {

		    /* execute query */
		    $stmt->execute();

		    $output = array();

		    /* fetch value */
		    $res = $stmt->get_result();
		    while ($row = $res->fetch_assoc()){
		    	$output[] = $row;
		    }

		    /* close statement */
		    $stmt->close();
		    return $output;
		}
	}
	public function getStat($stat,$player){

		$stmt =  $this->mysqli->stmt_init();
		if ($stat == "last_join"||$stat == "last_seen"){
			$sql = "SELECT min(value) as value FROM {$this->prefix}{$stat} WHERE uuid=? GROUP BY uuid";
		}else{
			$sql = "SELECT sum(value) as value FROM {$this->prefix}{$stat} WHERE uuid=? GROUP BY uuid";
		}

		if ($stmt->prepare($sql)) {
		    $stmt->bind_param("s", $player);
		    $stmt->execute();
		    $stmt->bind_result($output);
		    $stmt->fetch();
		    $stmt->close();
		    if ($stat == "last_join"||$stat == "last_seen"){ 
		    	if (!empty($output)){
			    		$time = time() - ($output/1000);
			    	$output = secondsToTime(round($time))." ago";
			    }else{
			    	$output="Never";
			    }
		    }elseif($stat=="playtime"){
		    	$output=secondsToTime($output);
		    }
		    return $output;
		}
	}
}