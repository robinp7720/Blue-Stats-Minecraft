<table class="table table-striped table-bordered" id="PvP">
	<thead>
		<th>Killer</th>
		<?php if($this->config["server"]["query_enabled"]){echo"<th>Killer Status</th>";}?>
		<th>Victim</th>
		<?php if($this->config["server"]["query_enabled"]){echo"<th>Victim Status</th>";}?>
		<th>Weapon</th>
		<th>Amount</th>
	</thead>
	<tfoot>
		<th>Killer</th>
		<?php if($this->config["server"]["query_enabled"]){echo"<th>Killer Status</th>";}?>
		<th>Victim</th>
		<?php if($this->config["server"]["query_enabled"]){echo"<th>Victim Status</th>";}?>
		<th>Weapon</th>
		<th>Amount</th>
	</foot>
</table>
<script type="text/javascript">
	$(document).ready(function() {
	    $('#PvP').dataTable( {
	    	<?php /* If url rewrites have been disabled */ if ($this->config["url"]["rewrite"]==false) :?>
	        "ajax": './ajax/call.php?func=pvp',
	        <?php else: ?>
	        "ajax": '<?=$this->config["url"]["base"]?>/ajax/?func=pvp',
	        <?php endif; ?>
	         responsive: true
	    } );
	} );		
</script>