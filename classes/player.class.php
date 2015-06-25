<?php
class player{
	private $config;
	private $mysqli;
    private $base_plugin;
    private $bluestats;

    public $exist = false;
    public $uuid = "";
    public $name = "";


	public function __Construct($bluestats,$uuid)
	{
		$this->mysqli = $bluestats->mysqli;
        $this->bluestats = $bluestats;

		$this->config = new config($this->mysqli,"Player");

        $this->base_plugin = $this->bluestats->base_plugin;
        $this->name = $this->base_plugin->getUserName($uuid);
        if (!empty($this->name)){
            $this->uuid = $uuid;
            $this->exist = true;
        }else{
            $this->name = "";
        }
	}

    /* TODO: Universal player stats method here */
}