<?php
class lolmewnStats extends plugin{
	public $pluginName = "lolmewnStats";
	public $plugin = array(
		"idColumn"=>"uuid",
		"playNameColum"=>"username",
		"indexTable"=>"players",
	);
	public $prefix = "";

	public $defaultStats=array(
		"playtime"
	);

	function __construct($mysqli){
		parent::__construct($mysqli);
		if ($this->installed())
			$this->setUp();
	}
	function setUp(){
		$this->set("stats",json_encode($this->defaultStats));
	}
	public function getStats($stat){

		$stmt =  $this->mysqli->stmt_init();

		$sql = "SELECT *, sum(value) as value FROM {$this->prefix}{$stat} INNER JOIN `{$this->prefix}players` on {$this->prefix}{$stat}.UUID = {$this->prefix}players.UUID GROUP BY {$this->prefix}{$stat}.UUID ORDER BY value Desc;";


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
	public function dump(){
		$output = array();
		foreach (json_decode($this->get("stats"),true) as $stat){
			$output[$stat] = $this->getStats($stat);
		}
		return $output;
	}
}