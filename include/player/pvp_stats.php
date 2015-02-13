<div class="box">
	<div class="container-head">
		<a class="title">PvP Stats</a>
	</div>
	<table class="display" id="sorted3">
		<thead>
			<tr>
				<th>Player Killed</th>
				<th>Weapons used</th>
				<th>Amount Killed</th>
			</tr>
		</thead>
		<tbody>
			<?php $pvp_stats = pvp_stats($player_id,$mysqli,$stats_mysql["table_prefix"]); ?>
			<?php if (!empty($pvp_stats)): ?>
			<?php foreach ($pvp_stats as $id => $value) :?>
			<?php
				$killed = htmlentities(getPlayersName($value["killed"],$mysqli,$stats_mysql["table_prefix"]));
				$image_killed_url = player_face($killed,$config["faces"]["pvp"]["size"],$config["faces"]["pvp"]["url"]);
			?>
			<tr>
				<td>
					<?php /* If url rewrites have been disabled */ if ($enable_url_rewrite==false) :?>
						<a href="?page=player&player=<?=$value["killed"] ?>"><?='<img class="player-head-player_page" src="'.$image_killed_url.'"/> '.$killed; ?></a>
					<?php endif ?>
					<?php /* If url rewrites have been enabled */ if ($enable_url_rewrite==true) :?>
						<a href="<?= $site_base_url.'/player/'.$value["killed"]."/" ?>"><?='<img class="player-head-player_page" src="'.$image_killed_url.'"/> '.$killed; ?></a>
					<?php endif ?>
				</td>
				<td><?=$value["weapon"];?></td>
				<td><?=$value["amount"];?></td>
			</tr>
			<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
</div>
