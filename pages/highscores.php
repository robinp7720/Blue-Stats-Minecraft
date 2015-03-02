<div class="container">
<?php

//$Global_players = getPlayers($mysqli,$stats_mysql["table_prefix"]);
foreach ($config[$serverId]["highscores"]["highscores"] as $highscores_index => $highscores_item) :

?>
<?php
$highscore = get_highscore($mysqli,$config[0]["mysql"]["stats"]["table_prefix"],$highscores_item["stat"],$highscores_item["amount"]);

$title = str_replace ('{AMOUNT}',$highscores_item["amount"],$config[$serverId]["highscores"]["title"]);
$title = str_replace ('{STAT}',$config[$serverId]["stats"]["names"][$highscores_item["stat"]],$title);
?>


<section class="col-md-6">
<h2><?=$title; ?></h2>

	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th><?=$localization["highscores"]["place"]?></th>
				<th><?=$localization["highscores"]["player"]?></th>
				<?php if ($config[$serverId]["server"]["query_enabled"]):?><th><?=$localization["highscores"]["status"]?></th><?php endif; ?>
				<th><?=$config[$serverId]["stats"]["names"][$highscores_item["stat"]]; ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($highscore as $item => $player) :?>
			<?php 
			if ($highscores_item["stat"]=="playtime"){
			$stat = secondsToTime($player[$highscores_item["stat"]]);
			}else{
			$stat= $player[$highscores_item["stat"]];
			}
			?>
			<?php
			$image_url = player_face($player["name"],$config[$serverId]["faces"]["highscores"]["size"],$config[$serverId]["faces"]["highscores"]["url"]);
			?>
			<tr>
			<td class="highscore-place no-mobile"><?=$item+1; ?></td>
			<td>
			<?php
			if ($config[$serverId]["url"]["player"]["useName"])
			$player_url = urlencode($player["name"]);
			else
			$player_url = $player["player_id"];
			?>
			<a href="<?= makePlayerUrl($player_url,$config[$serverId]["url"]["base"],$config[$serverId]["url"]["rewrite"],$config[$serverId]["url"]["player"]["useName"]) ?>"><img class="player-head-player_page" src="<?=$image_url?>" alt="<?=$player["name"]?>"/> <?=$player["name"]?></a></td>


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
	</section>


<?php endforeach ?>
</div>
