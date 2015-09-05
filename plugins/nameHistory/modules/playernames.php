<table class="table">
<?php
foreach ($plugin->getNames($player->uuid) as $name){
  echo "<tr>";
    echo "<td>{$name["name"]}</td>";
    echo "</tr>";
}
?>
</table>