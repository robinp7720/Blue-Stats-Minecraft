<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Blue Stats - <?=$server_info["server_name"]?></title>
	
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript" src="http://ricostacruz.com/jquery.transit/jquery.transit.min.js"></script>

	<!-- Data Tabels -->
	<script src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
	<link href="//cdn.datatables.net/1.10.4/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
	<script src="//cdn.datatables.net/responsive/1.0.4/js/dataTables.responsive.js"></script>
	<link href="//cdn.datatables.net/responsive/1.0.4/css/dataTables.responsive.css" rel="stylesheet" type="text/css">
		
	<!-- Load site css last to overwrite any other styles -->
	<link href='css/main.css' rel='stylesheet' type='text/css'>
	<link href='css/colors.css' rel='stylesheet' type='text/css'>
	
	<!-- Initialize Data Tabels -->
	<script>
		$(document).ready(function() {
			$('#sorted').dataTable({
				responsive: true
			});
			$('#sorted2').dataTable({
				responsive: true
			});
			$('#sorted3').dataTable({
				responsive: true
			});
			<?php if ($global_animations=="true") : /* if animations are enabled enable js link animations */?>
			$('a').click(function(){
				event.preventDefault();
				var link = $(this).attr('href');
				var height = $(document).height();
				if (link){
					console.log("true");
					$('.box, .box-half, .player-head-player_page').transition({ y: height+"px" },1000,function(){window.location = link;});
				}
			});
			<?php endif; ?>
		} );
	</script>
	<?php if ($global_animations=="true") :?>
	<style>
		div.box, div.box-half{
			-webkit-animation:slide-in 1s;
			-moz-animation:slide-in 1s;
			-ms-animation:slide-in 1s;
			-o-animation:slide-in 1s;
			animation:slide-in 1s;

		}
	</style>
	<?php endif; ?>

	<?php
	/* If player page get color and name*/
	if ($page=="player"){
		/* Get player id and name */
		$player_id = (int) $_GET["player"];
		$player_name = htmlentities(getPlayersName($_GET["player"],$mysqli,$stats_mysql["table_prefix"]));
	
		/* Get player face */
		$image_url = player_face($player_name,1,$config["faces"]["head_colour"]["url"] );

		/* Get colour */
		if ($youtube_like_page_theme){
			$theme["colour"]["nav"] = get_main_colour($image_url);
		}
	}
	?>

	<?php if (isset($theme["colour"])): ?>
	<!-- Only for player pages -->
	<style>
		nav{
			background-color:rgb(<?=$theme["colour"]["nav"]["red"]?>,<?=$theme["colour"]["nav"]["green"]?>,<?=$theme["colour"]["nav"]["blue"]?>)
		}
		nav a.nav-item:hover{
			background-color:rgb(<?=$theme["colour"]["nav"]["red"]+10?>,<?=$theme["colour"]["nav"]["green"]+10?>,<?=$theme["colour"]["nav"]["blue"]+10?>)
		}
		nav a.nav-logo{
			background-color:rgb(<?=$theme["colour"]["nav"]["red"]-20?>,<?=$theme["colour"]["nav"]["green"]-20?>,<?=$theme["colour"]["nav"]["blue"]-20?>)
		}
		div.container-head{
			background-color:rgb(<?=$theme["colour"]["nav"]["red"]?>,<?=$theme["colour"]["nav"]["green"]?>,<?=$theme["colour"]["nav"]["blue"]?>)
		}
		body{
			background-color:rgb(<?=$theme["colour"]["background"]["red"]?>,<?=$theme["colour"]["background"]["green"]?>,<?=$theme["colour"]["background"]["blue"]?>)
		}
	</style>
	<?php endif ?>
</head>
<body>