<div class="container">
	<table class="table table-striped table-bordered" id="all-players">
		<thead>
			<tr>
				<th>Player</th>
				<?php if($config[$serverId]["server"]["query_enabled"]){echo"<th>Status</th>";}?>
				<th><?=$config[$serverId]["stats"]["names"][$config[$serverId]["allPlayers"]["defaultStat"]]; ?></th>
				<th>Value</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>Player</th>
				<?php if($config[$serverId]["server"]["query_enabled"]){echo"<th>Status</th>";}?>
				<th><?=$config[$serverId]["stats"]["names"][$config[$serverId]["allPlayers"]["defaultStat"]]; ?></th>
				<th>Value</th>
			</tr>
		</tfoot>
	</table>
</div>
<script type="text/javascript">
	$(document).ready(function() {
	    $('#all-players').dataTable( {
	    	<?php /* If url rewrites have been disabled */ if ($config[$serverId]["url"]["rewrite"]==false) :?>
	        "ajax": './ajax/call.php?func=allplayers',
	        <?php else: ?>
	        "ajax": '<?=$config[0]["url"]["base"]?>/ajax/?func=allplayers',
	        <?php endif; ?>
	        <?php if ($config[$serverId]["server"]["query_enabled"]):?>
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
