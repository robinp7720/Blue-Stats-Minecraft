
	<table class="table">
		<thead>
			<tr>
				<th>Name</th>
				<th>Playtime</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($plugin->getStats("playtime") as $stat){
				echo "
				<tr>
					<td>
						{$stat["name"]}
					</td>
					<td>
						{$stat["value"]}
					</td>
				</tr>";
			}
			?>
		</tbody>
	</table>
