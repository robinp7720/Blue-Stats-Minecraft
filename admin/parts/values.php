<table class="table table-hover">
  <thead>
    <tr>
      <th>Option</th>
      <th>Value</th>
    </tr>
  </thead>
  <tbody>
<?php
$stmt =  $mysqli->stmt_init();
if ($stmt->prepare("SELECT * FROM BlueStats_config where plugin = ?")) {
  $stmt->bind_param("s", $_GET["plugin"]);
  $stmt->execute();
  $result = $stmt->get_result();
  $output=array();
  while ($row = $result->fetch_array(MYSQLI_ASSOC)){
    ?>
      <tr>
        <td><?=$row["option"]?></td>
        <form action="?update&plugin=<?=htmlspecialchars($row["plugin"])?>" method="post">
        <td><input name="value" type="text" class="form-control" value="<?=htmlspecialchars($row["value"])?>" style="width:100%;max-width:100%;"></td>
        <input type="hidden" name="option" value="<?=htmlspecialchars($row["option"])?>">
        <input type="hidden" name="plugin" value="<?=htmlspecialchars($row["plugin"])?>">

        </form>
      </tr>
    <?php
  }
  $stmt->close();
  }
?>

  </tbody>
</table>