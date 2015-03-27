<?php
if (isset($_GET["stat"])){
	if (in_array($_GET["stat"],$this->config["stats"]["id"])){
		$statId = $_GET["stat"];
	}else{
		$statId = $this->config["allPlayers"]["defaultStat"];
	}
}else{
	$statId = $this->config["allPlayers"]["defaultStat"];
}
?>
<table class="table table-striped table-bordered" id="all-players">
	<thead>
		<tr>
			<th>Player</th>
			<?php if($this->config["server"]["query_enabled"]){echo"<th>Status</th>";}?>
			<th><?=$this->config["stats"]["names"][$statId]; ?></th>
			<th>Value</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th>Player</th>
			<?php if($this->config["server"]["query_enabled"]){echo"<th>Status</th>";}?>
			<th><?=$this->config["stats"]["names"][$statId]; ?></th>
			<th>Value</th>
		</tr>
	</tfoot>
</table>
<?php
if (isset($_GET["stat"])){
	$stat = "&d=".$_GET["stat"];
}else{
	$stat = "";
}
?>
<script type="text/javascript">
	$(document).ready(function() {
	    $('#all-players').dataTable( {
	    	<?php /* If url rewrites have been disabled */ if ($this->config["url"]["rewrite"]==false) :?>
	        "ajax": './ajax/call.php?func=allplayers<?=$stat?>',
	        <?php else: ?>
	        "ajax": '<?=$this->config["url"]["base"]?>/ajax/?func=allplayers<?=$stat?>',
	        <?php endif; ?>
	        <?php if ($this->config["server"]["query_enabled"]):?>
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
