<table class="table" id="mcmmoListPlayers">
	<thead>
		<tr>
			<th>Name</th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ($plugin->getUsers() as $stat){
			echo "
			<tr>
				<td>
					<a href=\"?page=player&amp;id={$stat["uuid"]}\"><img src=\"https://minotar.net/helm/{$stat["user"]}/32.png\" alt=\"\"> {$stat["user"]}</a>
				</td>
			</tr>";
		}
		?>
	</tbody>
</table>
<script>
	$(document).ready(function() {
	    $('#mcmmoListPlayers').DataTable();
	} );
</script>
