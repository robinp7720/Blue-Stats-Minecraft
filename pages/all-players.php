<div class="container">
	<div class="box">
		<div class="container-head">
			<a class="title">All Players</a>
		</div>
		<table class="display" id="all-players">
			<thead>
				<th>Player</th>
				<?php if($server_info["query_enabled"]){echo"<th>Status</th>";}?>
				<th><?=$stats_names[$allPlayers_default_stat_displayed]; ?></th>
				<th>Value</th>
			</thead>
			<tfoot>
				<th>Player</th>
				<?php if($server_info["query_enabled"]){echo"<th>Status</th>";}?>
				<th><?=$stats_names[$allPlayers_default_stat_displayed]; ?></th>
				<th>Value</th>
			</foot>
		</table>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
	    $('#all-players').dataTable( {
	    	<?php /* If url rewrites have been disabled */ if ($enable_url_rewrite==false) :?>
	        "ajax": './ajax/?func=allplayers',
	        <?php else: ?>
	        "ajax": '<?=$site_base_url?>/ajax/?func=allplayers',
	        <?php endif; ?>
	        "aoColumnDefs": [
		      { "iDataSort": 3, "aTargets": [ 2 ] },
		      { "bVisible": false, "aTargets": [ 3 ] }
		    ]
	    } );
	} );	
</script>
