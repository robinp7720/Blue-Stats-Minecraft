<div class="list-group">
<?php
$stmt =  $mysqli->stmt_init();
if ($stmt->prepare("SELECT plugin FROM BlueStats_config GROUP BY plugin")) {
	$stmt->execute();
	$result = $stmt->get_result();
	$output=array();
	while ($row = $result->fetch_array(MYSQLI_ASSOC)){
		?>
		<a href="?plugin=<?=$row["plugin"]?>" class="list-group-item <?php if ($_GET["plugin"]===$row["plugin"])echo 'active'?>">
			<?=$row["plugin"]?>
		</a>
		<?php
	}
	$stmt->close();
	}
?>
</div>