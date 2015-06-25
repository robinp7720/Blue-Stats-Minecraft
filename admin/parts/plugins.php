<h2 style="margin-top:0;">Plugins</h2>
<div class="list-group">
    <?php
    $stmt = $mysqli->stmt_init();
    if ($stmt->prepare("SELECT plugin FROM BlueStats_config WHERE plugin NOT like 'MODULE__%' GROUP BY plugin")) {
        $stmt->execute();
        $result = $stmt->get_result();
        $output = array();
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            ?>
            <a href="?plugin=<?= urlencode($row["plugin"]) ?>"
               class="list-group-item <?php if ($_GET["plugin"] === $row["plugin"]) echo 'active'?>">
                <?= $row["plugin"] ?>
            </a>
        <?php
        }
        $stmt->close();
    }
    ?>
</div>
<h2>Modules</h2>
<div class="list-group">
    <?php
    $stmt = $mysqli->stmt_init();
    if ($stmt->prepare("SELECT plugin FROM BlueStats_config WHERE plugin like 'MODULE__%' GROUP BY plugin")) {
        $stmt->execute();
        $result = $stmt->get_result();
        $output = array();
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            ?>
            <a href="?plugin=<?= urlencode($row["plugin"]) ?>"
               class="list-group-item <?php if ($_GET["plugin"] === $row["plugin"]) echo 'active'?>">
                <?= substr($row["plugin"], 8) ?>
            </a>
        <?php
        }
        $stmt->close();
    }
    ?>
</div>