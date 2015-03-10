<article>
	<h2>Deaths</h2>
	<table class="table table-striped table-bordered"  id="deaths">
		<thead>
			<tr>
				<th>Victim</th>
				<?php if($config[$serverId]["server"]["query_enabled"]){echo"<th>Status</th>";}?>
				<th>World</th>
				<th>Cause</th>
				<th>Amount</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>Victim</th>
				<?php if($config[$serverId]["server"]["query_enabled"]){echo"<th>Status</th>";}?>
				<th>World</th>
				<th>Cause</th>
				<th>Amount</th>
			</tr>
		</tfoot>
	</table>
</article>
<script type="text/javascript">
	$(document).ready(function() {
		$('#deaths').dataTable( {
	    	<?php /* If url rewrites have been disabled */ if ($config[$serverId]["url"]["rewrite"]==false) :?>
	        "ajax": './ajax/call.php?func=deaths',
	        <?php else: ?>
	        "ajax": '<?=$config[$serverId]["url"]["base"]?>/ajax/?func=deaths',
	        <?php endif; ?>
	    } );
	} );		
</script>