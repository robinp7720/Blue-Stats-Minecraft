<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?=$server_info["server_name"]?> Server statistics Powered by BlueStats and BukkitStats by lolmewn and">
	<meta name="author" content="_OvErLoRd_">
	
	<meta name='HandheldFriendly' content='True'>
	<meta name='subtitle' content='A good looking statistics'>
	<meta name='coverage' content='Worldwide'>
	<meta name='distribution' content='Global'>
	<meta name='rating' content='General'>
	
	<meta http-equiv='Page-Enter' content='RevealTrans(Duration=2.0,Transition=2)'>
	<meta http-equiv='Page-Exit' content='RevealTrans(Duration=3.0,Transition=12)'>

	<title><?=$config[$serverId]["server"]["server_name"]?> - BlueStats</title>
	
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
	<link href="//maxcdn.bootstrapcdn.com/bootswatch/3.3.2/flatly/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="//cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.css">

	<link href='css/custom.css' rel='stylesheet' type='text/css'>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
	<script src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="//cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.js"></script>
	<script src="js/Chart.js"></script>

	<script>
		$(document).ready(function() {
			$('[data-toggle="tooltip"]').tooltip()
		} );
	</script>
	
	<?php
	/* If player page get color and name*/
	if ($page=="player"&&isset($_GET["player"])){
		/* Initialize new player */
		$player = new player;
		$player->loadBlueStats($BlueStats);

		/* Get player id and name */
		if (!is_numeric($_GET["player"])){
			if ($config[$serverId]["url"]["player"]["useName"]){
				$player->setPlayerName($_GET["player"]);
			}
		}else{
			$player->setPlayerName($_GET["player"]);
		}
	
		/* Get player face */
		$image_url = player_face($player->playerName,1,$BlueStats->config["faces"]["head_colour"]["url"] );
		if ($player->playerSet){
			/* Get colour */
			if ($config[$serverId]["player"]["playerTheme"]&&$theme["nav"]["youtube"]){
				$theme["nav"]["color"] = get_main_colour($image_url);
				$theme["headers"]["color"] = $theme["nav"]["color"];
				$theme["pager"]["color"] = $theme["nav"]["color"];
			}
		}

	}
	$hex = HexfromRGB($theme["nav"]["color"]["red"], $theme["nav"]["color"]["green"], $theme["nav"]["color"]["blue"]);
	?>

	<meta name="theme-color" content="<?=HexfromRGB($theme["nav"]["color"]["red"], $theme["nav"]["color"]["green"], $theme["nav"]["color"]["blue"])?>">
	
	<meta name="application-name" content="<?=$config[$serverId]["server"]["server_name"]?> Server statistics" />
	<meta name="msapplication-TileColor" content="<?=$hex?>" />
	<meta name='msapplication-navbutton-color' content='<?=$hex?>'>


	<style type="text/css">
		body{
			background-color:rgb(<?=$theme["background"]["color"]["red"]?>,<?=$theme["background"]["color"]["green"]?>,<?=$theme["background"]["color"]["blue"]?>) !important;
		}
		.navbar{
			background:rgb(<?=$theme["nav"]["color"]["red"]?>,<?=$theme["nav"]["color"]["green"]?>,<?=$theme["nav"]["color"]["blue"]?>);
		}
		.navbar-inverse .navbar-nav>.active>a, .navbar-inverse .navbar-nav>.active>a:hover, .navbar-inverse .navbar-nav>.active>a:focus{
			background:rgb(<?=$theme["nav"]["color"]["red"]+10?>,<?=$theme["nav"]["color"]["green"]+10?>,<?=$theme["nav"]["color"]["blue"]+10?>);
		}

		.pagination>.disabled>span, .pagination>.disabled>span:hover, .pagination>.disabled>span:focus, .pagination>.disabled>a, .pagination>.disabled>a:hover, .pagination>.disabled>a:focus{
			background:rgb(<?=$theme["pager"]["color"]["red"]+10?>,<?=$theme["pager"]["color"]["green"]+10?>,<?=$theme["pager"]["color"]["blue"]+10?>);
		}
		.pagination>li>a, .pagination>li>span{
			background:rgb(<?=$theme["pager"]["color"]["red"]-5?>,<?=$theme["pager"]["color"]["green"]-5?>,<?=$theme["pager"]["color"]["blue"]-5?>);
		}
		.pagination>.active>a, .pagination>.active>span, .pagination>.active>a:hover, .pagination>.active>span:hover, .pagination>.active>a:focus, .pagination>.active>span:focus{
			background:rgb(<?=$theme["pager"]["color"]["red"]-20?>,<?=$theme["pager"]["color"]["green"]-20?>,<?=$theme["pager"]["color"]["blue"]-20?>);
		}
		.pagination>li>a:hover, .pagination>li>span:hover, .pagination>li>a:focus, .pagination>li>span:focus{
			background:rgb(<?=$theme["pager"]["color"]["red"]-20?>,<?=$theme["pager"]["color"]["green"]-20?>,<?=$theme["pager"]["color"]["blue"]-20?>);
		}
	</style>
</head>
<body>
