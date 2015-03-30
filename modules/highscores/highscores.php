<?php
$mysqli = $this->mysqli->get("BlueStats");
?>
<div class="row">
<?php
foreach ($this->config["highscores"]["highscores"] as $highscores_index => $highscores_item) :
	$highscore = get_highscore($mysqli,$this->config["mysql"]["stats"]["table_prefix"],$highscores_item["stat"],$highscores_item["amount"]);
	$title = str_replace ('{AMOUNT}',$highscores_item["amount"],$this->config["highscores"]["title"]);
	$title = str_replace ('{STAT}',$this->config["stats"]["names"][$highscores_item["stat"]],$title);
	?>


	<section class="col-md-6">
		<h2><?=$title; ?></h2>

		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>Place</th>
					<th>Player</th>
					<?php if ($this->config["server"]["query_enabled"]):?><th>Status</th><?php endif; ?>
					<th><?=$this->config["stats"]["names"][$highscores_item["stat"]]; ?></th>
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

				$image_url = player_face($player["name"],$this->config["faces"]["highscores"]["size"],$this->config["faces"]["highscores"]["url"]);
				?>
				<tr>
					<td class="highscore-place"><?=$item+1; ?></td>
					<td>
						<a href="<?=$this->makePlayerUrl($player["player_id"])?>">
							<img src="<?=$image_url?>" alt="<?=$player["name"]?>"/><?=$player["name"]?>
						</a>
					</td>
					<?php if (isset($this->onlinePlayers)): ?>
					<td>
						<?php if (playerOnline($player["name"], $this->onlinePlayers)): ?>
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