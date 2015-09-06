<table class="table">
<?php
foreach ($plugin->getNames($player->uuid) as $name){
    echo "<tr>";
    echo "<td>{$name["name"]}</td>";
    if (isset($name["changedToAt"])){
        $timeago = (time()*1000) - $name["changedToAt"];
        $timeago = secondsToTime($timeago/1000);
        echo "<td>{$timeago} ago</td>";
    }else{
        echo "<td>Original</td>";
    }
    echo "</tr>";
}
?>
</table>