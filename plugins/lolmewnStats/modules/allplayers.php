<?php
if (!$config->configExist("stat")){
	$config->set("stat","playtime");
}
?>
<table class="table" id="allPlayers">
	<thead>
		<tr>
			<th>Name</th>
			<th><?=$plugin->statName($config->get("stat"));?></th>
			<th>Sortable</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$statName = $config->get("stat");
		foreach ($plugin->getAllPlayerStats($statName) as $stat){
			$sorted = $stat["value"];
			if ($statName=="playtime"){
				$statDisplay = secondsToTime($stat["value"],$contract=true);
			}else{
				if ($statName == "last_join"||$statName == "last_seen"){ 
					if (!empty($stat["value"])){
						$time = time() - ($stat["value"]/1000);
						$statDisplay  = secondsToTime(round($time))." ago";
						$sorted = $time;
					}else{
						$statDisplay ="Never";
					}
				}else{
					$statDisplay = $stat["value"];
				}
			}
			
			echo "
			<tr>
				<td>
					<a href=\"?page=player&amp;id={$stat["uuid"]}\"><img src=\"https://minotar.net/helm/{$stat["name"]}/32.png\" alt=\"\"> {$stat["name"]}</a>
				</td>
				<td>
					".$statDisplay."
				</td>
				<td>
					{$sorted}
				</td>
			</tr>";
		}
		?>
	</tbody>
</table>
<script>
	$(document).ready(function() {
	    $('#allPlayers').DataTable({
		    "aoColumnDefs": [
		      { "iDataSort": 2, "aTargets": [ 1 ] },
		      { "bVisible": false, "aTargets": [ 2 ] }
		    ],
	    });
	} );
</script>
