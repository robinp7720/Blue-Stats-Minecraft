<article>
	<h2>PvP Stats</h2>
	<table class="table table-striped table-bordered" id="PvP">
		<thead>
			<th>Killer</th>
			<?php if($config[$serverId]["server"]["query_enabled"]){echo"<th>Killer Status</th>";}?>
			<th>Victim</th>
			<?php if($config[$serverId]["server"]["query_enabled"]){echo"<th>Victim Status</th>";}?>
			<th>Weapon</th>
			<th>Amount</th>
		</thead>
		<tfoot>
			<th>Killer</th>
			<?php if($config[$serverId]["server"]["query_enabled"]){echo"<th>Killer Status</th>";}?>
			<th>Victim</th>
			<?php if($config[$serverId]["server"]["query_enabled"]){echo"<th>Victim Status</th>";}?>
			<th>Weapon</th>
			<th>Amount</th>
		</foot>
	</table>
</article>
<script type="text/javascript">
	$(document).ready(function() {
	    $('#PvP').dataTable( {
	    	<?php /* If url rewrites have been disabled */ if ($config[$serverId]["url"]["rewrite"]==false) :?>
	        "ajax": './ajax/call.php?func=pvp',
	        <?php else: ?>
	        "ajax": '<?=$config[$serverId]["url"]["base"]?>/ajax/?func=pvp',
	        <?php endif; ?>
	         responsive: true
	    } );
	} );		
</script>