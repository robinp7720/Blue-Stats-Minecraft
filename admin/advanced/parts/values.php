<table class="table table-hover">
    <thead>
    <tr>
        <th>Option</th>
        <th>Value</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $stmt = $mysqli->stmt_init();
    if ($stmt->prepare("SELECT * FROM BlueStats_config where plugin = ?")) {
        $stmt->bind_param("s", $_GET["plugin"]);
        $stmt->execute();
        $result = $stmt->get_result();
        $output = array();
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            if (is_string(json_decode($row["value"]))) {
                $value = json_decode($row["value"]);
            } else {
                $value = $row["value"];
            }
            ?>
            <tr>
                <td><?= $row["option"] ?></td>
                <form action="?update&plugin=<?= htmlspecialchars($row["plugin"]) ?>" method="post">
                    <td>
                        <?php if (gettype(json_decode($row["value"])) == "array" || gettype(json_decode($row["value"])) == "object"): ?>
                            <textarea name="value" id="" class="form-control"
                                      style="height:100px;"><?= htmlspecialchars($value) ?></textarea>
                            <input type="submit" class="btn btn-success pull-right" style="margin-top:5px">
                        <?php else: ?>
                            <input name="value" type="text" class="form-control" value="<?= htmlspecialchars($value) ?>"
                                   style="width:100%;max-width:100%;">
                        <?php endif; ?>
                    </td>
                    <input type="hidden" name="option" value="<?= htmlspecialchars($row["option"]) ?>">
                    <input type="hidden" name="plugin" value="<?= htmlspecialchars($row["plugin"]) ?>">
                    <input type="hidden" name="type"
                           value="<?= htmlspecialchars(gettype(json_decode($row["value"]))) ?>">
                </form>
            </tr>
        <?php
        }
        $stmt->close();
    }
    ?>

    </tbody>
</table>