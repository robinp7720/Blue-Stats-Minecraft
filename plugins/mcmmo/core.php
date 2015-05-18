<?php
class mcmmo extends MySQLplugin{
	public $pluginName = "mcmmo";
	public $plugin = array(
		"idColumn"=>"user_id",
		"idColumnInIndex"=>"id",
		"playerNameColum"=>"user",
		"UUIDcolumn"=>"uuid",
		"indexTable"=>"users",
		"UUIDisID"=>false,
	);

	function __construct($mysqli){
		parent::__construct($mysqli);
	}

}