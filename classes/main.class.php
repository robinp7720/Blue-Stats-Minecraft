<?php
class BlueStats {
	public $config  = array();
	public $pages   = array();
	public $appPath = "";
	public $mysqli = "";
	public $home = "";
	public $serverId = 0;
	public $page = "";
	public $player = 0;

	public function loadConfigs($config){
		$this->config = $config;
	}
	public function setup($configs,$serverId){
		$this->serverId = $serverId;
		$this->loadConfigs($configs[$serverId]);
		$this->home = $configs[$serverId]["site"]["home"];
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

	public function loadPage($page="_SELECTED_"){
		$pages = $this->pages;
		if (isset($pages[$page])){
			$pageDetails = $pages[$page];
			$pagePath    = $pageDetails["file"];
			return $this->appPath."/pages/".$pagePath;
		}elseif($page=="_SELECTED_"){
			if (isset($pages[$this->getCurrentPage()])){
				$pageDetails = $pages[$this->getCurrentPage()];
				$pagePath    = $pageDetails["file"];
				return $this->appPath."/pages/".$pagePath;
			}else{
				return $this->appPath."/pages/error.php";
			}
		}else{
			return $this->appPath."/pages/error.php";
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
}