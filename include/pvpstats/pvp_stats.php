
<div class="box">
	<div class="container-head">
		<a class="title">PvP Stats</a>
	</div>
	<table class="display" id="PvP">
		<thead>
			<th>Killer</th>
			<?php if($server_info["query_enabled"]){echo"<th>Killer Status</th>";}?>
			<th>Victim</th>
			<?php if($server_info["query_enabled"]){echo"<th>Victim Status</th>";}?>
			<th>Weapon</th>
			<th>Amount</th>
		</thead>
		<tfoot>
			<th>Killer</th>
			<?php if($server_info["query_enabled"]){echo"<th>Killer Status</th>";}?>
			<th>Victim</th>
			<?php if($server_info["query_enabled"]){echo"<th>Victim Status</th>";}?>
			<th>Weapon</th>
			<th>Amount</th>
		</foot>
	</table>
</div>
<script type="text/javascript">
	$(document).ready(function() {
	    $('#PvP').dataTable( {
	    	<?php /* If url rewrites have been disabled */ if ($enable_url_rewrite==false) :?>
	        "ajax": './ajax/?func=pvp',
	        <?php else: ?>
	        "ajax": '<?=$site_base_url?>/ajax/?func=pvp',
	        <?php endif; ?>
	         responsive: true
	    } );
	} );	
</script>
