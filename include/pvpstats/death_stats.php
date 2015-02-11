
	<div class="box-half">
		<div class="container-head">
			<a class="title">Deaths</a>
		</div>
		<table class="display" id="deaths">
			<thead>
				<th>Victim</th>
				<?php if($server_info["query_enabled"]){echo"<th>Status</th>";}?>
				<th>World</th>
				<th>Cause</th>
				<th>Amount</th>
			</thead>
			<tfoot>
				<th>Victim</th>
				<?php if($server_info["query_enabled"]){echo"<th>Status</th>";}?>
				<th>World</th>
				<th>Cause</th>
				<th>Amount</th>
			</foot>
		</table>
	</div>

<script type="text/javascript">
	$(document).ready(function() {
	    $('#deaths').dataTable( {
	    	<?php /* If url rewrites have been disabled */ if ($enable_url_rewrite==false) :?>
	        "ajax": './ajax/?func=deaths',
	        <?php else: ?>
	        "ajax": '<?=$site_base_url?>/ajax/?func=deaths',
	        <?php endif; ?>
	         responsive: true
	    } );
	} );	
</script>
