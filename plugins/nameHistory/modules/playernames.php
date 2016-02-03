<table class="table">
    <thead>
    <tr>
        <th>Name</th>
        <th>Changed</th>
    </tr>
    </thead>
    <tbody>
<?php
foreach ($plugin->getNames($player->uuid) as $name){
    echo "<tr>";
    echo "<td>{$name["name"]}</td>";
    if (isset($name["changedToAt"])){
        $timeago = (time()*1000) - $name["changedToAt"];
        $timeago = secondsToTime($timeago/1000);
        echo "<td>Changed {$timeago} ago</td>";
    }else{
        echo "<td>Original</td>";
    }
    echo "</tr>";
}
?>
    </tbody>
</table>