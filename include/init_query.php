<?php

use xPaw\MinecraftPing;
use xPaw\MinecraftPingException;

if ($BlueStats->config["ping"]["cache"]){
	if (!file_exists($BlueStats->appPath."/cache/")){
		mkdir($BlueStats->appPath."/cache/");
	}
	if (file_exists($BlueStats->appPath."/cache/ping.json")){
		$pingJson = file_get_contents($BlueStats->appPath."/cache/ping.json");
		$ping = json_decode($pingJson,true);
		if (time()>$ping["time"]+500){
			$ping = ping();
			$time = time();
			$PingInfo = $ping["PingInfo"];
			$Online_Players = $ping["Online_Players"];
			$array["PingInfo"] = $PingInfo;
			$array["Online_Players"] = $Online_Players;
			$array["time"] = $time;
			$jsonOut = json_encode($array);
			file_put_contents($BlueStats->appPath."/cache/ping.json", $jsonOut);
		}
		$PingInfo = $ping["PingInfo"];
		$Online_Players = $ping["Online_Players"];
	}else{
		$ping = ping();
		$time = time();
		$PingInfo = $ping["PingInfo"];
		$Online_Players = $ping["Online_Players"];
		$array["PingInfo"] = $PingInfo;
		$array["Online_Players"] = $Online_Players;
		$array["time"] = $time;
		$jsonOut = json_encode($array);
		file_put_contents($BlueStats->appPath."/cache/ping.json", $jsonOut);
	}
}else{
	$ping = ping();
	$PingInfo = $ping["PingInfo"];
	$Online_Players = $ping["Online_Players"];
}
function ping(){
	global $BlueStats;
	try
	{
		$Ping = new MinecraftPing($BlueStats->config["server"]["ip"], $BlueStats->config["server"]["port"], 10 );
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
	    $Online_Players[]=$value["name"];
	}
	$output["PingInfo"] = $PingInfo;
	$output["Online_Players"] = $Online_Players;
	return $output;
}