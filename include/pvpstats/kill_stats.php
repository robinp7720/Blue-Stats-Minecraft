
	<div class="box-half">
		<div class="container-head">
			<a class="title">Kills</a>
		</div>
		<table class="display" id="kills">
			<thead>
				<th>Killer</th>
				<?php if($server_info["query_enabled"]){echo"<th>Status</th>";}?>
				<th>World</th>
				<th>Killed</th>
				<th>Amount</th>
			</thead>
			<tfoot>
				<th>Killer</th>
				<?php if($server_info["query_enabled"]){echo"<th>Status</th>";}?>
				<th>World</th>
				<th>Killed</th>
				<th>Amount</th>
			</foot>
		</table>
	</div>

<script type="text/javascript">
	$(document).ready(function() {
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
