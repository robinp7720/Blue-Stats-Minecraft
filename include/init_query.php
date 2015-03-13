<?php

use xPaw\MinecraftPing;
use xPaw\MinecraftPingException;

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
}