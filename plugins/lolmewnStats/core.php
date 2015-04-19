<?php
class lolmewnStats extends plugin{
	public $pluginName = "lolmewnStats";
	public $plugin = array(
		"idColumn"=>"uuid",
		"playNameColum"=>"username",
		"indexTable"=>"players",
	);
	public $prefix = "";
	public $stats = array();

	function __construct($mysqli){
		parent::__construct($mysqli);
		if ($this->installed())
			$this->setUp();
	}
	function setUp(){
		if (!$this->configExist("stats")){
			$this->set("stats",json_encode(array(
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
				"pvp" => "PvP Deaths",
				"shears" => "Times striped a sheep",
				"teleports" => "Teleports",
				"times_changed_world" => "Worlds Changed",
				"times_kicked" => "Times Kicked",
				"tools_broken" => "Tools Broken",
				"trades" => "Trades",
				"votes" => "Votes",
				"words_said" => "Words Said",
				"xp_gained" => "Xp Gained",
			)));
		}
		$this->stats = json_decode($this->get("stats"),true);
	}

	public function statName($stat){
		return $this->stats[$stat];
	}

	public function getStats($stat,$limit=0){

		$stmt =  $this->mysqli->stmt_init();

		$sql = "SELECT *, sum(value) as value FROM {$this->prefix}{$stat} INNER JOIN `{$this->prefix}players` on {$this->prefix}{$stat}.UUID = {$this->prefix}players.UUID GROUP BY {$this->prefix}{$stat}.UUID ORDER BY value Desc";
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
}