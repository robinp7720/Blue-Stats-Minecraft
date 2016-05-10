<table class="table table-hover table-sorted" id="blocks">
    <thead>
    <tr>
        <th>Block</th>
        <th>World</th>
        <th>Amount Broken</th>
        <th>Amount Placed</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($plugin->getPlayerBlock($player->uuid) as $id => $value): ?>
        <tr>
            <td>
                <!--<img src="http://blocks.fishbans.com/" alt="">-->
                <?= ucfirst(strtolower(str_replace("_", " ", $value["name"]))) ?>
            </td>
            <td>
                <?= $value["world"] ?>
            </td>
            <td>
                <?= $value["broken"] ?>
            </td>
            <td>
                <?= $value["placed"] ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>