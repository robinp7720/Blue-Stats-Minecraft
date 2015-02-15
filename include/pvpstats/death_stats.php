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
