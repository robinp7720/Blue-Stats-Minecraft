<?php
class BlueStats{
	public $version = "Beta 3.0";
	public $pluginName = "BlueStats";
	public $appPath = "";

	private $page = "home";
	private $theme;
	private $plugins;

	private $config;
	private $mysqli;

	function __construct($mysqli,$appPath){
		$this->mysqli = $mysqli;
		$this->config = new config($mysqli,$this->pluginName);
		if (!$this->config->configExist("theme")){
			$this->config->set("theme","default");
		}
		$this->theme = $this->config->get("theme");
		$this->appPath = $appPath;
		if (isset($_GET["page"]))
			$this->page=$_GET["page"];
	}

	public function getPluginList(){
		if ($this->config->configExist("plugins")){

		}else{
			$this->config->set("plugins",array("lolmewnStats"));
		}
		return $this->config->get("plugins");
	}

	public function loadPlugins( array $plugins){
		$this->plugins = $plugins;
	}
	private function themeError($error){
		return "There is an error with your theme: $error";
	}

	private function fileNotFoundError(){
		http_response_code(404);
		if (file_exists($this->appPath."/themes/".$this->theme."/404.html")){
			return file_get_contents($this->appPath."/themes/".$this->theme."/404.html");
		}else{
			return $this->themeError("404.html not found");
		}
	}

	public function loadPage(){
		$page = str_replace(array('/','.'), '', $this->page);
		if (file_exists($this->appPath."/themes/".$this->theme."/global.html")){
			/* Load template file */
			$string = file_get_contents($this->appPath."/themes/".$this->theme."/global.html");

			/* Modules */
			preg_match_all('/{{ ([^ ]+):([^ ]+) }}/', $string, $matches);

			foreach ($matches[0] as $key => $replaceStr) {

				/* Set plugin variable */
				if (isset($this->plugins[$matches[1][$key]])){
					$plugin = $this->plugins[$matches[1][$key]];

					$module = new module($this->mysqli,$matches[1][$key],$matches[2][$key],$plugin,$this->theme,$this->appPath);
				    $output = $module->render();

				    $string = str_replace($replaceStr, $output, $string);
				}
			}
			$string = str_replace("{{ content }}", $this->loadPageTemplate(), $string);
		}else{
			$string = $this->themeError("global.html not found");;
		}
		return $string;
	}
	
	private function loadPageTemplate(){
		$page = str_replace(array('/','.'), '', $this->page);
		if (file_exists($this->appPath."/themes/".$this->theme."/templates/$page.html")){
			/* Load template file */
			$string = file_get_contents($this->appPath."/themes/".$this->theme."/templates/$page.html");
			$newstring = str_replace("{{ dieifnotid }}", "", $string);
			if (($string==$newstring)||isset($_GET["id"])){
				$string = $newstring;
				/* Modules */
				preg_match_all('/{{ ([^ ]+):([^ ]+) }}/', $string, $matches);

				foreach ($matches[0] as $key => $replaceStr) {

					/* Set plugin variable */
					if (isset($this->plugins[$matches[1][$key]])){
						$plugin = $this->plugins[$matches[1][$key]];

						$module = new module($this->mysqli,$matches[1][$key],$matches[2][$key],$plugin,$this->theme,$this->appPath);
						$output = $module->render();

					    $string = str_replace($replaceStr,$output, $string);
					}
				}
			}else{
				$string = $this->fileNotFoundError();
			}
		}else{
			$string = $this->fileNotFoundError();
		}
		return $string;
	}


}