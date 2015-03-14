<?php
$blocks_names = $this->getBlockNames();
?>
<article>
<h2>Block Stats</h2>
<table class="table table-striped table-bordered" id="blockstats">
	<thead>
		<tr>
			<th>Block</th>
			<th>Amount of times placed</th>
			<th>Amount of times broken</th>
		</tr>
	</thead>
	<tbody>
		<?php
			/* Get all block stats from player */
			$blocks_raw = globalBlockStats($this->mysqli,$this->config["mysql"]["stats"]["table_prefix"]);
			$blocks= array();

			/* If no blocks have been placed, ignore this */
			if (!empty($blocks_raw)){
				/* Loop through all blocks to make it use-able. */
				foreach ($blocks_raw as $item => $value){
					if ($value["break"]==1){
						/* Block Broken */
						if (isset($blocks[$value["blockID"]]["broken"])){
							$blocks[$value["blockID"]]["broken"]+=$value["amount"];
						}else{
							$blocks[$value["blockID"]]["broken"]=$value["amount"];
						}
						if (!isset($blocks[$value["blockID"]]["placed"])){
							$blocks[$value["blockID"]]["placed"]=0;
						}
					}else{
						/* block Placed */
						if (isset($blocks[$value["blockID"]]["placed"])){
							$blocks[$value["blockID"]]["placed"]+=$value["amount"];
						}else{
							$blocks[$value["blockID"]]["placed"]=$value["amount"];
						}
						if (!isset($blocks[$value["blockID"]]["broken"])){
							$blocks[$value["blockID"]]["broken"]=0;
						}
					}
				}
			}

			foreach ($blocks as $item => $value) :
				$block_name = strtolower(getMaterialFromId($item,0,$blocks_names)); 
			?>
			<tr>
			<td>
			<?php 
				/* If block icons are turned on add them to the html here */
				if ($this->config["blocks"]["displayIcons"]==true){
					echo '<img class="block-icon" src="'."images/blocks/".$item.'-0.png" alt="Block image"/> ';
				}

				echo $block_name;
			?>
			</td>
			<td><?=$value["placed"] ?></td>
			<td><?=$value["broken"] ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
</article>
<script>
	$(document).ready(function() {
		$('#blockstats').dataTable({
			responsive: true
		});
	} );
</script>
