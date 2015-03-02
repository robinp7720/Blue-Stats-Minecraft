<div class="container">
	<div class="jumbotron">
	  <h1><?=$config[$serverId]["server"]["server_name"]; ?> Stats </h1>
	  <p>Powered by blue stats made by _OvErLoRd_</p>
		
		<?php /* If url rewrites have been disabled */ if ($config[$serverId]["url"]["rewrite"]==false) :?>
		 <p><a class="btn btn-primary btn-lg" href="?page=allplayers" role="button">All Players</a></p>
		<?php else: ?>
		 <p><a class="btn btn-primary btn-lg" href="<?=$config[$serverId]["url"]["base"]."/allplayers/"?>" role="button">All Players</a></p>
		<?php endif ?>



	</div>
		<?php $count=1; ?>
		<?php foreach ($config[$serverId]["home"]["stats"] as $stat):?>
			<?php if ($count==1){echo '<div class="row">';} ?>
			<div class="col-sm-6 col-md-3 text-center">
				<h2><?=$config[0]["stats"]["names"][$stat]; ?>:</h2>
				<?php
				if ($stat == "playtime"){
					echo secondsToTime(getStatTotal($stat,$mysqli,$config[$serverId]["mysql"]["stats"]["table_prefix"]));
				}else{
					echo getStatTotal($stat,$mysqli,$config[$serverId]["mysql"]["stats"]["table_prefix"]);
				}
				?>
			</div>
			<?php if ($count==4){echo '</div>';$count=0;} $count++; ?>
		<?php endforeach; ?>
		<?php if ($count!=1){echo '</div>';}?>
		<hr/>
		<?php $count=1; ?>
		<?php foreach ($config[$serverId]["home"]["top"]["stats"] as $stat => $name):?>
			<?php if ($count==1){echo '<div class="row">';} ?>
			<div class="col-sm-6 text-center">
				<h2><?= $name ?>: <small>
				<?php
				echo get_highscore($mysqli,$config[$serverId]["mysql"]["stats"]["table_prefix"],$stat,1)[0]["name"];
				?>
				</small>
				</h2>
			</div>
			<?php if ($count==2){echo '</div>';$count=0;} $count++; ?>
		<?php endforeach; ?>
		<?php if ($count!=1){echo '</div>';}?>
		<hr>
		<div class="text-center">
			<?php foreach($Online_Players as $player):
			$imageUrl = player_face($player,$config[$serverId]["faces"]["home"]["size"],$config[$serverId]["faces"]["home"]["url"]);

			if ($config[$serverId]["url"]["player"]["useName"])
				$player_url = urlencode($player);
			else
				$player_url = getPlayerId($player,$mysqli,$config[$serverId]["mysql"]["stats"]["table_prefix"]);
			
			$player_url = makePlayerUrl($player_url,$config[$serverId]["url"]["base"],$config[$serverId]["url"]["rewrite"],$config[$serverId]["url"]["player"]["useName"]) 
			?>
			<a href="<?=$player_url?>">
				<img src="<?=$imageUrl?>" alt="" title="<?=$player?>" data-toggle="tooltip" data-placement="top">
			</a>
			<?php endforeach; ?>
		</div>
		<br>
</div>
