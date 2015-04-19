<?php
class BlueStats extends config{
	public $version = "Beta 3.0";
	public $pluginName = "BlueStats";
	public $appPath = "";

	private $page = "";
	private $theme;
	private $plugins;

	function __construct($mysqli,$appPath){
		parent::__construct($mysqli);
		if ($this->configExist("theme")){

		}else{
			$this->set("theme","default");
		}
		$this->theme = $this->get("theme");
		$this->appPath = $appPath;
	}
	public function loadPlugins( array $plugins){
		$this->plugins = $plugins;
	}
	private function loadTemplate(){
		$page = str_replace(array('/','.'), '', $_GET["page"]);
		if (file_exists($this->appPath."/themes/".$this->theme."/templates/$page.html")){
			/* Load template file */
			$string = file_get_contents($this->appPath."/themes/".$this->theme."/templates/$page.html");

			/* Modules */
			preg_match_all('/{{ ([^ ]+):([^ ]+) }}/', $string, $matches);

			foreach ($matches[0] as $key => $module) {

				/* Set plugin variable */
				$plugin = $this->plugins[$matches[1][$key]];

			    /* Replace key with module */
			    ob_start();
			    include($this->appPath."/plugins/".$matches[1][$key]."/modules/".$matches[2][$key].".php");
			    $contents = ob_get_contents();
			    ob_end_clean();
			    $string = str_replace($module, $contents, $string);
			}
		}else{
			$string = "404 page does not exist";
		}
		return $string;
	}
	public function loadPage(){
		$page = str_replace(array('/','.'), '', $_GET["page"]);
		if (file_exists($this->appPath."/themes/".$this->theme."/global.html")){
			/* Load template file */
			$string = file_get_contents($this->appPath."/themes/".$this->theme."/global.html");

			/* Modules */
			preg_match_all('/{{ ([^ ]+):([^ ]+) }}/', $string, $matches);

			foreach ($matches[0] as $key => $module) {

				/* Set plugin variable */
				$plugin = $this->plugins[$matches[1][$key]];

			    /* Replace key with module */
			    ob_start();
			    include($this->appPath."/plugins/".$matches[1][$key]."/modules/".$matches[2][$key].".php");
			    $contents = ob_get_contents();
			    ob_end_clean();
			    $string = str_replace($module, $contents, $string);
			}
			$string = str_replace("{{ content }}", $this->loadTemplate(), $string);
		}else{
			$string = "404 page does not exist";
		}
		return $string;
	}

}