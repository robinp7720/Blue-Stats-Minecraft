<?php
	
use xPaw\MinecraftQuery;
use xPaw\MinecraftQueryException;
use xPaw\MinecraftPing;
use xPaw\MinecraftPingException;

/* Init server query */
$Query = new MinecraftQuery( );

try
{
	$Query->Connect( $BlueStats->config["server"]["ip"], $BlueStats->config["server"]["port"] );
	$Info = $Query->GetInfo();
	$Online_Players = $Query->GetPlayers();
	if (empty($Online_Players))
		$Online_Players = array();
}
catch( MinecraftQueryException $e )
{
    echo $e->getMessage( );
}

$Ping = new MinecraftPing($BlueStats->config["server"]["ip"], $BlueStats->config["server"]["port"], 10 );
$PingInfo = $Ping->Query( );