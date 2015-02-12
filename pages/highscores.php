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

<div class="box-half">
	<div class="container-head">
		<a class="title"><?=$title; ?></a>
	</div>
	<table class="display noborder dataTable no-footer dtr-inline">
		<thead>
			<tr>
				<th class="highscore-place no-mobile">Place</th>
				<th>Player</th>
				<th class="no-mobile">Status</th>
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
				<?php /* If url rewrites have been disabled */ if ($enable_url_rewrite==false) :?>
					<a href="?page=player&player=<?=$player["player_id"] ?>"><?='<img class="player-head-player_page" src="'.$image_url.'" alt="'.$player["name"].'"/> '.$player["name"]; ?></a></td>
				<?php endif ?>
				<?php /* If url rewrites have been enabled */ if ($enable_url_rewrite==true) :?>
					<a href="<?= $site_base_url.'/player/'.$player["player_id"]."/" ?>"><?='<img class="player-head-player_page" src="'.$image_url.'" alt="'.$player["name"].'"/> '.$player["name"]; ?></a></td>
				<?php endif ?>
				<?php if (isset($Online_Players)): ?>
				<td class="no-mobile">
				<?php if (playerOnline($player["name"], $Online_Players)): ?>
					<a class="tag-online">Online</a>
				<?php else: ?>
					<a class="tag-offline">Offline</a>
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
