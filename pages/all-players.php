<div class="container">
	<div class="box">
		<div class="container-head">
			<a class="title">All Players</a>
		</div>
		<table class="display" id="all-players">
			<thead>
				<tr>
					<th>Player</th>
					<?php if($server_info["query_enabled"]){echo"<th>Status</th>";}?>
					<th><?=$stats_names[$allPlayers_default_stat_displayed]; ?></th>
					<th>Value</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>Player</th>
					<?php if($server_info["query_enabled"]){echo"<th>Status</th>";}?>
					<th><?=$stats_names[$allPlayers_default_stat_displayed]; ?></th>
					<th>Value</th>
				</tr>
			</tfoot>
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
	        <?php if ($server_info["query_enabled"]):?>
	        "aoColumnDefs": [
		      { "iDataSort": 3, "aTargets": [ 2 ] },
		      { "bVisible": false, "aTargets": [ 3 ] }
		    ]
		    <?php else: ?>
		    "aoColumnDefs": [
		      { "iDataSort": 2, "aTargets": [ 1 ] },
		      { "bVisible": false, "aTargets": [ 2 ] }
		    ]
		    <?php endif; ?>
	    } );
	} );	
</script>
