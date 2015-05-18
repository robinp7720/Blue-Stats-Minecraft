<?php
class BlueStats extends config{
	public $version = "Beta 3.0";
	public $pluginName = "BlueStats";
	public $appPath = "";

	private $page = "home";
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
		if (isset($_GET["page"]))
			$this->page=$_GET["page"];
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

				foreach ($matches[0] as $key => $module) {

					/* Set plugin variable */
					if (isset($this->plugins[$matches[1][$key]]))
						$plugin = $this->plugins[$matches[1][$key]];

				    /* Replace key with module */
				    ob_start();
				    if (file_exists($this->appPath."/plugins/".$matches[1][$key]."/modules/".$matches[2][$key].".php")){
				    	include($this->appPath."/plugins/".$matches[1][$key]."/modules/".$matches[2][$key].".php");
				    }elseif(file_exists($this->appPath."/themes/{$this->theme}/modules/{$matches[1][$key]}/{$matches[2][$key]}.php")){
				    	include($this->appPath."/themes/{$this->theme}/modules/{$matches[1][$key]}/{$matches[2][$key]}.php");
				    }else{

				    }
				    
				    $contents = ob_get_contents();
				    ob_end_clean();
				    $string = str_replace($module, $contents, $string);
				}
			}else{
				$string = $this->fileNotFoundError();
			}
		}else{
			$string = $this->fileNotFoundError();
		}
		return $string;
	}
	public function loadPage(){
		$page = str_replace(array('/','.'), '', $this->page);
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
		    	if (file_exists($this->appPath."/plugins/".$matches[1][$key]."/modules/".$matches[2][$key].".php")){
			    	include($this->appPath."/plugins/".$matches[1][$key]."/modules/".$matches[2][$key].".php");
			    }elseif(file_exists($this->appPath."/themes/{$this->theme}/modules/{$matches[1][$key]}/{$matches[2][$key]}.php")){
			    	include($this->appPath."/themes/{$this->theme}/modules/{$matches[1][$key]}/{$matches[2][$key]}.php");
			    }else{

			    }
			    $contents = ob_get_contents();
			    ob_end_clean();
			    $string = str_replace($module, $contents, $string);
			}
			$string = str_replace("{{ content }}", $this->loadPageTemplate(), $string);
		}else{
			$string = $this->themeError("global.html not found");;
		}
		return $string;
	}

}