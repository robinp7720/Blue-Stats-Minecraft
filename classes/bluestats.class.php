<?php
class BlueStats{
	public $version = "Beta 3.0";
	public $pluginName = "BlueStats";
	public $appPath = "";
	public $theme;
	public $page = "home";
	public $plugins;
	public $config;
	public $mysqli;

	function __construct($mysqli,$appPath){
		$this->mysqli = $mysqli;

		$this->config = new config($mysqli,$this->pluginName);
		$this->config->setDefault("theme","default");
		$this->config->setDefault("base_plugin","lolmewnStats");
		$this->config->setDefault("view_path","$appPath/themes/{THEME}/");
		$this->theme = $this->config->get("theme");

		$this->appPath = $appPath;

		if (isset($_GET["page"]))
			$this->page=$_GET["page"];
	}

	public function getPluginList(){
		$this->config->setDefault("plugins",array("lolmewnStats"));
		return $this->config->get("plugins");
	}

	public function loadPlugins( array $plugins){
		$this->plugins = $plugins;
	}
	private function error($code){
		$error = new error($code);
	}


	public function loadPage(){
		$view = new view($this,$this->config->get("view_path"),$this->appPath);
		return $view->render();
	}

}