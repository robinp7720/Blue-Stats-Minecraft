<div class="container">
	<div class="jumbotron">
	  <h1><?=$server_info["server_name"]; ?> Stats </h1>
	  <p>Powered by blue stats made by _OvErLoRd_</p>
		
		<?php /* If url rewrites have been disabled */ if ($enable_url_rewrite==false) :?>
		 <p><a class="btn btn-primary btn-lg" href="?page=allplayers" role="button">All Players</a></p>
		<?php else: ?>
		 <p><a class="btn btn-primary btn-lg" href="<?=$site_base_url."/allplayers/"?>" role="button">All Players</a></p>
		<?php endif ?>



	</div>
		<?php $count=1; ?>
		<?php foreach ($config["home"]["stats"] as $stat):?>
			<?php if ($count==1){echo '<div class="row">';} ?>
			<div class="col-md-3 text-center">
				<h2><?=$stats_names[$stat]; ?>:</h2>
				<?php
				if ($stat == "playtime"){
					echo secondsToTime(getStatTotal($stat,$mysqli,$stats_mysql["table_prefix"]),$play_time_contract);
				}else{
					echo getStatTotal($stat,$mysqli,$stats_mysql["table_prefix"]);
				}
				?>
			</div>
			<?php if ($count==4){echo '</div>';$count=0;} $count++; ?>
		<?php endforeach; ?>
		<?php if ($count!=1){echo '</div>';}?>
		<hr/>
		<?php $count=1; ?>
		<?php foreach ($config["home"]["top"]["stats"] as $stat => $name):?>
			<?php if ($count==1){echo '<div class="row">';} ?>
			<div class="col-md-6 text-center">
				<h2><?= $name ?>: <small>
				<?php
				echo get_highscore($mysqli,$stats_mysql["table_prefix"],$stat,1)[0]["name"];
				?>
				</small>
				</h2>
			</div>
			<?php if ($count==2){echo '</div>';$count=0;} $count++; ?>
		<?php endforeach; ?>
		<?php if ($count!=1){echo '</div>';}?>
		<hr>
		<div class="online-player text-center">
			<?php foreach($Online_Players as $player): ?>
			<img src="<?=player_face($player,$config["faces"]["home"]["size"],$config["faces"]["home"]["url"]);?>" alt="">
			<?php endforeach; ?>
		</div>
</div>
