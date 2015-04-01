<?php
class BlueStats {
	public $mysqli; /* MySQL manager */

	public $config  = array();
	public $pages   = array();
	public $appPath = "";
	public $home = "";
	public $serverId = 0;
	public $page = "";
	public $onlinePlayers = array();
	public $localization = array();
	public $pingInfo = "";

	function __construct($configs,$serverId,$appPath){
		$this->serverId = $serverId;
		$this->config = $configs[$serverId];
		$this->home = $configs[$serverId]["site"]["home"];
		$this->appPath = $appPath;

		/* Connect to mysql */
		$this->mysqli = new mysqlManager;
		$this->mysqli->connect(
			"BlueStats",
			$this->config["mysql"]["stats"]["username"],
			$this->config["mysql"]["stats"]["password"],
			$this->config["mysql"]["stats"]["host"],
			$this->config["mysql"]["stats"]["dbname"]
		);

		$this->getServerInfo();
	}
	private function getServerInfo(){

		function ping($_this){
			try
			{
				$Ping = new MinecraftPing($_this->config["server"]["ip"], $_this->config["server"]["port"], 10 );
				$PingInfo = $Ping->Query( );
				//echo "<pre>".print_r($PingInfo,2)."</pre>";
				$Online_Players = array();
				if (!isset($PingInfo["players"]["sample"]))
					$PingInfo["players"]["sample"]=array();
				foreach ($PingInfo["players"]["sample"] as $key=>$value){
					$Online_Players[]=$value["name"];
				}
			}
			catch( MinecraftPingException $e )
			{
			    $errors[] = $e->getMessage( );
			    $PingInfo["players"]["sample"]=array();
			    $Online_Players[]=array();;
			}
			$output["PingInfo"] = $PingInfo;

			if (!$_this->config["server"]["useQuery"])
				$output["Online_Players"] = $Online_Players;

			return $output;
		}

		function query($_this){
		    $Query = new MinecraftQuery( );

		    try
		    {
		        $Query->Connect($_this->config["server"]["ip"],$_this->config["server"]["QueryPort"]);

		        $output["info"] = $Query->GetInfo( );
		        $output["players"] = $Query->GetPlayers( );
		    }
		    catch( MinecraftQueryException $e )
		    {
		    	$output["info"]    = array();
		    	$output["players"] = array();
		    }

			return $output;
		}

		/* Ping Cache */
		if ($this->config["ping"]["cache"]){

			if (file_exists($this->appPath."/cache/ping.json")){
				$pingJson = file_get_contents($this->appPath."/cache/ping.json");
				$ping = json_decode($pingJson,true);
				if (time()>$ping["time"]+$this->config["ping"]["time"]){
					$ping = ping($this);
					$time = time();
					$PingInfo = $ping["PingInfo"];
					$Online_Players = $ping["Online_Players"];
					$array["PingInfo"] = $PingInfo;

					if (!$this->config["server"]["useQuery"])
						$array["Online_Players"] = $Online_Players;

					$array["time"] = $time;
					$jsonOut = json_encode($array);
					file_put_contents($this->appPath."/cache/ping.json", $jsonOut);
				}
				$PingInfo = $ping["PingInfo"];
				if (!$this->config["server"]["useQuery"])
					$Online_Players = $ping["Online_Players"];
			}else{
				$ping = ping($this);
				$time = time();
				$PingInfo = $ping["PingInfo"];
				$Online_Players = $ping["Online_Players"];
				$array["PingInfo"] = $PingInfo;

				if (!$this->config["server"]["useQuery"])
					$array["Online_Players"] = $Online_Players;

				$array["time"] = $time;
				$jsonOut = json_encode($array);
				file_put_contents($this->appPath."/cache/ping.json", $jsonOut);
			}
		}else{
			$ping = ping($this);
			$PingInfo = $ping["PingInfo"];
			if (!$this->config["server"]["useQuery"])
				$Online_Players = $ping["Online_Players"];
		}
		/* Ping and ping cache end */

		$this->pingInfo = $PingInfo;
		if (!$this->config["server"]["useQuery"]){
			$this->onlinePlayers = $Online_Players;

		}else{
			/* MC query cache */
			if ($this->config["query"]["cache"]){
				if (file_exists($this->appPath."/cache/query.json")){
					$queryJson = file_get_contents($this->appPath."/cache/query.json");
					$query = json_decode($queryJson,true);
					if (time()>$ping["time"]+$this->config["query"]["time"]){
						$query = query($this);
						$time = time();

						$QueryInfo = $query["info"];
						$Online_Players = $query["players"];

						$array["time"] = $time;
						$jsonOut = json_encode($query);
						file_put_contents($this->appPath."/cache/query.json", $jsonOut);
					}
					$PingInfo = $query["info"];
					$Online_Players = $query["players"];
				}else{
					$query= query($this);
					$time = time();
					$QueryInfo = $query["info"];
					$Online_Players = $query["players"];

					$array["QueryInfo"] = $QueryInfo;
					$array["Online_Players"] = $Online_Players;

					$array["time"] = $time;
					$jsonOut = json_encode($array);
					file_put_contents($this->appPath."/cache/query.json", $jsonOut);
				}
			}else{
				$ping = query($this);
				$PingInfo = $ping["PingInfo"];
				$Online_Players = $ping["Online_Players"];
			}
			if ($Online_Players==false){
				$this->onlinePlayers = array();
			}else{
				$this->onlinePlayers = $Online_Players;
			}
		}

	}





	public function pageName(){
		return $this->pages[$this->getCurrentPage()]["name"];
	}
	
	public function getThemeId(){
		/* Remove all path related items from theme name for security */
		$themeId = $this->config["themes"]["id"];
		$themeId = str_replace ( array(".","/","\\") , "" , $themeId);
		
		return $themeId;
	}

	public function getHome(){
		if (!empty($this->home)){
			return $this->home;
		}else{
			return false;
		}
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

	public function addPage($id,$name,$rightOrLeft,$hidden=false){
		if (isset($id)&&isset($name)&&isset($rightOrLeft)){
			if (!empty($id)&&!empty($name)&&!empty($rightOrLeft)){
				if ($rightOrLeft=="right"||$rightOrLeft=="left"){
					if (!isset($this->pages[$id])){
						$this->pages[$id]=array(
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
		if ($page=="player"){
			/* Initialize new player */
			$player = new player($this);

			/* Get player id and name */
			if (!is_numeric($_GET["player"])){
			  if ($this->config["url"]["player"]["useName"]){
			    $player->setPlayerName($_GET["player"]);
			  }
			}else{
			  $player->setPlayerName($_GET["player"]);
			}
		}
		$strRepl = array(
			"serverName" => $this->config["server"]["server_name"],
		);
		if (file_exists($this->appPath."/themes/{$this->getThemeId()}/templates/$page.html")){
			$string = file_get_contents($this->appPath."/themes/{$this->getThemeId()}/templates/$page.html");
		}else{
			$string = file_get_contents($this->appPath."/page-templates/$page.html");
		}

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
		    $time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
			$string .= "<script>console.log('$filename load time: {$time} Seconds')</script>";
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

		/* Urls */
		preg_match_all('/{{ url:([^ ]+) }}/', $pageContent, $matches);
		foreach ($matches[1] as $key => $site) {
			if ($this->config["url"]["rewrite"]==false){
				$url = "?page=allplayers";
			}else{
				$url = $this->config["url"]["base"]."/$site/";
			}

		    $pageContent = str_replace($matches[0][$key], $url, $pageContent);
		}

		foreach ($strRepl as $repl => $new){
			$pageContent = str_replace("{{ text:".$repl." }}", $new, $pageContent);
		}

		if (isset($this->pingInfo[ 'favicon' ]))$pageContent = str_replace("{{ serverIcon }}", Str_Replace( "\n", "", $this->pingInfo[ 'favicon' ] ), $pageContent);
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
				if (!file_exists($this->appPath."/cache/")){
					mkdir($this->appPath."/cache/");
				}
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
		$mysqli = $this->mysqli->get("BlueStats");
		if ($this->config["url"]["player"]["useName"]){
			$display = getPlayersName($id,$mysqli,$this->config["mysql"]["stats"]["table_prefix"]);
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