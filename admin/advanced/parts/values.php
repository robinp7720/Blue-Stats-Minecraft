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
                            <button type="submit" class="btn btn-success pull-right" style="margin-top:5px">Set</button>
                        <?php else: ?>
                            <div class="row">
                                <div class="col-md-11">
                                    <input name="value" type="text" class="form-control"
                                           value="<?= htmlspecialchars($value) ?>"
                                           style="width:100%;max-width:100%;">
                                </div>
                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-success" style="margin-top:5px">Set</button>
                                </div>
                            </div>
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