<?php
class BlueStats {
	public $config  = array();
	public $pages   = array();
	public $appPath = "";
	public $mysqli = "";
	public $home = "";
	public $serverId = 0;
	public $page = "";
	public $onlinePlayers = array();
	public $localization = array();
	public $pingInfo = "";

	public function pageName(){
		return $this->pages[$this->getCurrentPage()]["name"];
	}

	public function loadPing($ping){
		$this->pingInfo = $ping;
	}

	public function loadConfigs($config){
		$this->config = $config;
	}

	public function loadLocal($local){
		$this->localization = $local;
	}
	
	public function setup($configs,$serverId){
		$this->serverId = $serverId;
		$this->loadConfigs($configs[$serverId]);
		$this->home = $configs[$serverId]["site"]["home"];
	}
	
	public function getThemeId(){
		/* Remove all path related items from theme name for security */
		$themeId = $this->config["themes"]["id"];
		$themeId = str_replace ( array(".","/","\\") , "" , $themeId);
		
		return $themeId;
	}

	public function loadMySQL($mysqli){
		$this->mysqli = $mysqli;
	}

	public function getHome(){
		if (!empty($this->home)){
			return $this->home;
		}else{
			return false;
		}
	}

	public function setAppPath($path){
		$this->appPath = $path;
	}

	public function setCurrentPage($page = "_HOME_"){
		if (isset($this->pages[$page])){
			$this->page = $page;
			return true;
		}else{
			if ($page=="_HOME_"){
				$this->page = $this->home;
			}else{
				return false;
			}
		}
	}

	public function addPage($id,$file,$name,$rightOrLeft,$hidden=false){
		if (isset($id)&&isset($file)&&isset($name)&&isset($rightOrLeft)){
			if (!empty($id)&&!empty($file)&&!empty($name)&&!empty($rightOrLeft)){
				if ($rightOrLeft=="right"||$rightOrLeft=="left"){
					if (!isset($this->pages[$id])){
						$this->pages[$id]=array(
							"file" => $file,
							"name" => $name,
							"side" => $rightOrLeft,
							"hidden" => $hidden
						);
						return true;
					}else{
						return false;
					}
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	public function getPages(){
		return $this->pages;
	}
	
	public function getCurrentPage(){
		return $this->page;
	}

	private function getPageContents($page){
		$strRepl = array(
			"serverName" => $this->config["server"]["server_name"],
		);

		$string = file_get_contents($this->appPath."/page-templates/$page.html");

		foreach ($strRepl as $repl => $new){
			$string = str_replace("{{ text:".$repl." }}", $new, $string);
		}

		/* Modules */
		preg_match_all('/{{ module:([^ ]+) }}/', $string, $matches);
		foreach ($matches[1] as $key => $filename) {
		    //replace content:
		    ob_start();
		    include($this->appPath."/modules/$page/$filename.php");
		    $contents = ob_get_contents();
		    ob_end_clean();
		    $string = str_replace($matches[0][$key], $contents, $string);
		}

		/* Global Modules */
		preg_match_all('/{{ Gmodule:([^ ]+) }}/', $string, $matches);
		foreach ($matches[1] as $key => $filename) {
		    //replace content:
		    ob_start();
		    include($this->appPath."/modules/global/$filename.php");
		    $contents = ob_get_contents();
		    ob_end_clean();
		    $string = str_replace($matches[0][$key], $contents, $string);
		}

		/* Urls */
		preg_match_all('/{{ url:([^ ]+) }}/', $string, $matches);
		foreach ($matches[1] as $key => $site) {
			if ($this->config["url"]["rewrite"]==false){
				$url = "?page=allplayers";
			}else{
				$url = $this->config["url"]["base"]."/$site/";
			}

		    $string = str_replace($matches[0][$key], $url, $string);
		}

		return $string;
	}

	private function createPage($page){
		$strRepl = array(
			"serverName" => $this->config["server"]["server_name"],
			"pageTitle" => $this->pageName()
		);
		/* Build theme site */
		$pageContent = file_get_contents($this->appPath."/themes/{$this->getThemeId()}/theme.html");
		
		/* Global Modules */
		preg_match_all('/{{ Gmodule:([^ ]+) }}/', $pageContent, $matches);
		foreach ($matches[1] as $key => $filename) {
		    //replace content:
		    ob_start();
		    include($this->appPath."/modules/global/$filename.php");
		    $contents = ob_get_contents();
		    ob_end_clean();
		    $pageContent = str_replace($matches[0][$key], $contents, $pageContent);
		}

		foreach ($strRepl as $repl => $new){
			$pageContent = str_replace("{{ text:".$repl." }}", $new, $pageContent);
		}

		$pageContent = str_replace("{{ serverIcon }}", Str_Replace( "\n", "", $this->pingInfo[ 'favicon' ] ), $pageContent);
		$pageContent = str_replace("{{ content }}", $this->getPageContents($page), $pageContent);

		return $pageContent;
	}

	public function loadPage($page="_SELECTED_"){
		$pages = $this->pages;
		if (isset($pages[$page])){
			return $this->createPage($page);
		}elseif($page=="_SELECTED_"){
			if (isset($pages[$this->getCurrentPage()])){
				return $this->createPage($this->getCurrentPage());
			}else{
				return "";
			}
		}else{
			return "";
		}
	}

	public function loadPart($part){
		if ($part == "head"){
			return $this->appPath."/parts/head.php";
		}elseif ($part == "footer"){
			return $this->appPath."/parts/footer.php";
		}elseif ($part="nav"){
			return $this->appPath."/parts/nav.php";
		}
	}

	public function getBlockNames(){
		if ($this->config["blocks"]["cache"]&&file_exists($this->appPath."/cache/items.json")){
				$blocks_names = json_decode(file_get_contents($this->appPath."/cache/items.json"),true);
		}else{
			if ($this->config["blocks"]["cache"]){
				$blocks_names = file_get_contents($this->config["blocks"]["url"]);
				file_put_contents($this->appPath."/cache/items.json", $blocks_names);
			}else{
				$blocks_names = json_decode(file_get_contents($this->config["blocks"]["url"]),true);
			}
		}
		return $blocks_names;
	}
	
	public function makeNavTabs(){
		$nav = "";
		if ($this->config["url"]["rewrite"]==false){
			/* if url rewrite is disabled */
			foreach ($this->pages as $pageId => $pageData){
				if ($this->page == $pageId){
					$active = 'class="active"';
				}else{
					$active = "";
				}
				if ($pageData["hidden"]==false)
					$nav .= "<li $active><a href=\"?page=$pageId\">{$pageData["name"]}</a></li>";
			}
		}else{
			/* if url rewrite is enabled */
			foreach ($this->pages as $pageId => $pageData){
				if ($this->page == $pageId){
					$active = 'class="active"';
				}else{
					$active = "";
				}
				if ($pageData["hidden"]==false)
					$nav .= "<li $active><a href=\"{$this->config["url"]["base"]}/$pageId/\">{$pageData["name"]}</a></li>";
			}
		}
		return $nav;
	}
	
	public function makePlayerUrl($id){
		if ($this->config["url"]["player"]["useName"]){
			$display = getPlayersName($id,$this->mysqli,$this->config["mysql"]["stats"]["table_prefix"]);
		}else{
			$display = $id;
		}
		if ($this->config["url"]["rewrite"]){
			return $this->config["url"]["base"]."/player/".$display."/";
		}else{
			return "?player=".$display;
		}
	}
	public function loadOnlinePlayers($Online_Players){
		$this->onlinePlayers = $Online_Players;
	}
}