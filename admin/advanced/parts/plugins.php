<h2>Plugins</h2>
<div class="list-group">
    <?php
    if (isset($_GET["plugin"])) {
        $plugin = $_GET["plugin"];
    } else {
        $plugin = "";
    }
    $pattern = "/__([^ ]+)___/";
    preg_match($pattern, $plugin, $matches, PREG_OFFSET_CAPTURE, 3);
    if (isset($matches[1][0])) {
        $plugin = $matches[1][0];
    }
    $stmt = $mysqli->stmt_init();
    if ($stmt->prepare("SELECT plugin FROM BlueStats_config WHERE plugin NOT like 'MODULE__%' GROUP BY plugin")) {
        $stmt->execute();
        $result = $stmt->get_result();
        $output = array();
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            ?>
            <a href="?plugin=<?= urlencode($row["plugin"]) ?>"
               class="list-group-item <?php if ($plugin === $row["plugin"]) echo 'active' ?>">
                <?= $row["plugin"] ?>
            </a>
            <?php
        }
        $stmt->close();
    }
    ?>
</div>
<?php if (!empty($plugin)): ?>
    <h3>Modules</h3>
    <div class="list-group">
        <?php

        $stmt = $mysqli->stmt_init();
        if ($stmt->prepare("SELECT plugin FROM BlueStats_config WHERE plugin like ? GROUP BY plugin")) {
            $search = "MODULE__" . $plugin . "___%";
            $stmt->bind_param("s", $search);
            $stmt->execute();
            $result = $stmt->get_result();
            $output = array();
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                ?>
                <a href="?plugin=<?= urlencode($row["plugin"]) ?>"
                   class="list-group-item <?php if ($_GET["plugin"] === $row["plugin"]) echo 'active' ?>">
                    <?= substr($row["plugin"], strlen("MODULE__" . $plugin . "___")) ?>
                </a>
                <?php
            }
            $stmt->close();
        }
        ?>
    </div>
<?php endif ?>