<form action="?step=3" method="post" style="overflow: hidden">
    <div class="row">
        <div class="col-md-6">
            <h2>BlueStats Database
                <br>
                <small>(Not lolmewnStats mysql details)</small>
            </h2>
            <label for="bs-host">Host:</label>
            <input type="text" class="form-control" id="bs-host" placeholder="Host" name="bs-host"
                   value="<?php if (isset($_SESSION["bs-host"])) echo $_SESSION["bs-host"] ?>">

            <label for="bs-username">Username:</label>
            <input type="text" class="form-control" id="bs-username" placeholder="Username" name="bs-username"
                   value="<?php if (isset($_SESSION["bs-username"])) echo $_SESSION["bs-username"] ?>">

            <label for="bs-password">Password:</label>
            <input type="password" class="form-control" id="bs-password" placeholder="Password" name="bs-password"
                   value="">

            <label for="bs-db">Data Base:</label>
            <input type="text" class="form-control" id="bs-db" placeholder="Database name" name="bs-db"
                   value="<?php if (isset($_SESSION["bs-db"])) echo $_SESSION["bs-db"] ?>">
        </div>
        <div class="col-md-6">
            <h2>BlueStats looks <br>
                <small>Edit/Create themes in /themes/</small>
            </h2>
            <label for="theme">Theme: </label>
            <select id="theme" name="theme" class="form-control">
                <option value="material">Material</option>
                <option value="webstatx">Web Stats X</option>
            </select>
            <br>
            <label for="ip">Query IP:</label>
            <br>
            <label for="query-enable">Enable: </label>
            <input type="checkbox" id="query-enable"
                   name="query-enable" <?php if (isset($_SESSION["query-enable"]) && $_SESSION["query-enable"] === "on") echo "checked" ?>>
            <input type="text" class="form-control" id="ip" placeholder="Server Ip" name="ip"
                   value="<?php if (isset($_SESSION["ip"])) echo $_SESSION["ip"] ?>">

            <label for="port">Query Port:</label>
            <input type="text" class="form-control" id="port" placeholder="Server Port" name="port"
                   value="<?php if (isset($_SESSION["port"])) echo $_SESSION["port"] ?>">

        </div>
    </div>

    <div class="row">
        <?php
        $files = scandir(dirname(dirname(__dir__)) . '/plugins');

        // Remove . and .. from array
        array_shift($files);
        array_shift($files);

        foreach ($files as $dir) {
            if (is_dir(dirname(dirname(__dir__)) . '/plugins/' . $dir)) {
                include dirname(dirname(__dir__)) . "/plugins/$dir/$dir.php";
                $pluginClass = "\\BlueStats\\Plugin\\$dir";
                if (!$pluginClass::$isMySQLplugin)
                    break;
                ?>
                <div class="col-md-6">
                    <h2><?= $dir ?> DataBase</h2>
                    <label for="<?= $dir ?>-enable">Enable: </label>
                    <input type="checkbox" id="<?= $dir ?>-enable"
                           name="<?= $dir ?>-enable" <?php if (isset($_SESSION["$dir-enable"]) && $_SESSION["$dir-enable"] === "on") echo "checked" ?>>
                    <br>
                    <label for="<?= $dir ?>-host">Host:</label>
                    <input type="text" class="form-control" id="<?= $dir ?>-host" placeholder="Host"
                           name="<?= $dir ?>-host"
                           value="<?php if (isset($_SESSION["$dir-host"])) echo $_SESSION["$dir-host"] ?>">

                    <label for="<?= $dir ?>-username">Username:</label>
                    <input type="text" class="form-control" id="<?= $dir ?>-username" placeholder="Username"
                           name="<?= $dir ?>-username"
                           value="<?php if (isset($_SESSION["$dir-username"])) echo $_SESSION["$dir-username"] ?>">

                    <label for="<?= $dir ?>-password">Password:</label>
                    <input type="password" class="form-control" id="<?= $dir ?>-password" placeholder="Password"
                           name="<?= $dir ?>-password" value="">

                    <label for="<?= $dir ?>-db">Data Base:</label>
                    <input type="text" class="form-control" id="<?= $dir ?>-db" placeholder="Database name"
                           name="<?= $dir ?>-db"
                           value="<?php if (isset($_SESSION["$dir-db"])) echo $_SESSION["$dir-db"] ?>">

                    <label for="<?= $dir ?>-prefix">Table Prefixes:</label>
                    <input type="text" class="form-control" id="<?= $dir ?>-prefix" placeholder="Table prefixes"
                           name="<?= $dir ?>-prefix"
                           value="<?php if (isset($_SESSION["$dir-prefix"])) echo $_SESSION["$dir-prefix"] ?>">
                </div>
                <?php
            }
        }
        ?>
    </div>
    <button type="submit" class="btn btn-success pull-right">Submit</button>
</form>
