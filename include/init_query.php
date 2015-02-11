<?php
	
use xPaw\MinecraftQuery;
use xPaw\MinecraftQueryException;
	/* Init server query */
	$Query = new MinecraftQuery( );

	try
	{
		$Query->Connect( $server_info["ip"], $server_info["port"] );
		$Info = $Query->GetInfo();
		$Online_Players = $Query->GetPlayers();
		if (empty($Online_Players))
			$Online_Players = array();
	}
	catch( MinecraftQueryException $e )
	{
	    echo $e->getMessage( );
	}
