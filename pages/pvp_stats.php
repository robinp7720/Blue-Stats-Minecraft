<div class="container">
	<h2>PvP Stats</h2>
	<table class="table table-striped table-bordered" id="PvP">
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

			<h2>Deaths</h2>
			<table class="table table-striped table-bordered"  id="deaths">
				<thead>
					<tr>
						<th>Victim</th>
						<?php if($server_info["query_enabled"]){echo"<th>Status</th>";}?>
						<th>World</th>
						<th>Cause</th>
						<th>Amount</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>Victim</th>
						<?php if($server_info["query_enabled"]){echo"<th>Status</th>";}?>
						<th>World</th>
						<th>Cause</th>
						<th>Amount</th>
					</tr>
				</tfoot>
			</table>
	
			<h2>Kills</h2>
			<table class="table table-striped table-bordered" id="kills">
				<thead>
					<tr>
						<th>Killer</th>
						<?php if($server_info["query_enabled"]){echo"<th>Status</th>";}?>
						<th>World</th>
						<th>Killed</th>
						<th>Amount</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>Killer</th>
						<?php if($server_info["query_enabled"]){echo"<th>Status</th>";}?>
						<th>World</th>
						<th>Killed</th>
						<th>Amount</th>
					</tr>
				</tfoot>
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
	    var deaths = $('#deaths').dataTable( {
	    	<?php /* If url rewrites have been disabled */ if ($enable_url_rewrite==false) :?>
	        "ajax": './ajax/?func=deaths',
	        <?php else: ?>
	        "ajax": '<?=$site_base_url?>/ajax/?func=deaths',
	        <?php endif; ?>
	    } );
	    $('#kills').dataTable( {
	    	<?php /* If url rewrites have been disabled */ if ($enable_url_rewrite==false) :?>
	        "ajax": './ajax/?func=kills',
	        <?php else: ?>
	        "ajax": '<?=$site_base_url?>/ajax/?func=kills',
	        <?php endif; ?>
	         responsive: true
	    } );
	} );		
</script>

