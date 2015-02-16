<div class="container">
<?php

//$Global_players = getPlayers($mysqli,$stats_mysql["table_prefix"]);
foreach ($highscores as $highscores_index => $highscores_item) :

?>
<?php
$highscore = get_highscore($mysqli,$stats_mysql["table_prefix"],$highscores_item["stat"],$highscores_item["amount"]);

$title = str_replace ('{AMOUNT}',$highscores_item["amount"],$highscore_title);
$title = str_replace ('{STAT}',$stats_names[$highscores_item["stat"]],$title);
?>


<div class="col-md-6">
<h2><?=$title; ?></h3>

	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th class="highscore-place no-mobile">Place</th>
				<th>Player</th>
				<?php if ($server_info["query_enabled"]):?><th class="no-mobile">Status</th><?php endif; ?>
				<th><?=$stats_names[$highscores_item["stat"]]; ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($highscore as $item => $player) :?>
			<?php 
			if ($highscores_item["stat"]=="playtime"){
			$stat = secondsToTime($player[$highscores_item["stat"]],$play_time_contract);
			}else{
			$stat= $player[$highscores_item["stat"]];
			}
			?>
			<?php
			$image_url = player_face($player["name"],$config["faces"]["highscores"]["size"],$config["faces"]["highscores"]["url"]);
			?>
			<tr>
			<td class="highscore-place no-mobile"><?=$item+1; ?></td>
			<td>
			<?php
			if ($config["url"]["player"]["useName"])
			$player_url = urlencode($player["name"]);
			else
			$player_url = $player["player_id"];
			?>
			<a href="<?= makePlayerUrl($player_url,$site_base_url,$enable_url_rewrite,$config["url"]["player"]["useName"]) ?>"><img class="player-head-player_page" src="<?=$image_url?>" alt="<?=$player["name"]?>"/> <?=$player["name"]?></a></td>


			<?php if (isset($Online_Players)): ?>
			<td>
			<?php if (playerOnline($player["name"], $Online_Players)): ?>
			<span class="label label-success">Online</span>
			<?php else: ?>
			<span class="label label-danger">Offline</span>
			<?php endif; ?>
			</td>
			<?php endif; ?>
			<td><?=$stat; ?></td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	</div>

<?php endforeach ?>
</div>
