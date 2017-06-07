<?php
use xPaw\MinecraftQuery;
use xPaw\MinecraftQueryException;

$success = true;

if (isset($_POST["bs-host"]) && isset($_POST["bs-username"]) && isset($_POST["bs-password"]) && isset($_POST["bs-db"])) {
    /* Connect to MySQL */
    $mysqli = new mysqli(
        $_POST["bs-host"],
        $_POST["bs-username"],
        $_POST["bs-password"],
        $_POST["bs-db"]
    );

    if ($mysqli->connect_error) {
        echo "<i class=\"fa fa-times text-warning\"></i> <b>BlueStats database connetion error:</b> " . $mysqli->connect_error . "<br>";
        $success = false;
    } else {
        echo "<i class=\"fa fa-check text-success\"></i> BlueStats database success!<br>";
    }

} else {
    echo "<i class=\"fa fa-times text-warning\"></i> BlueStats database details missing<br>";
    $success = false;
}

$files = scandir(dirname(dirname(__dir__)).'/plugins');

// Remove . and .. from array
array_shift($files);
array_shift($files);

foreach ($files as $dir) {
    if (is_dir(dirname(dirname(__dir__)).'/plugins/'.$dir)) {
        require_once dirname(dirname(__dir__))."/plugins/$dir/$dir.php";
        $pluginClass = "\\BlueStats\\Plugin\\$dir";
        if (!$pluginClass::$isMySQLplugin)
            break;
        if (isset($_POST["$dir-enable"]) && $_POST["$dir-enable"] == "on") {
            if (isset($_POST["$dir-host"]) && isset($_POST["$dir-username"]) && isset($_POST["$dir-password"]) && isset($_POST["$dir-db"])) {
                /* Connect to MySQL */
                $mysqli = new mysqli(
                    $_POST["$dir-host"],
                    $_POST["$dir-username"],
                    $_POST["$dir-password"],
                    $_POST["$dir-db"]
                );

                if ($mysqli->connect_error) {
                    echo "<i class=\"fa fa-times text-warning\"></i> <b>$dir database connetion error:</b> " . $mysqli->connect_error . "<br>";
                    $success = false;
                } else {
                    echo "<i class=\"fa fa-check text-success\"></i> $dir success!<br>";
                }

            } else {
                echo "<i class=\"fa fa-times text-warning\"></i> $dir database details missing<br>";
                $success = false;
            }
        }
    }
}


$query = new MinecraftQuery();
if (function_exists('fsockopen')) {
    if (isset($_POST['ip']) && isset($_POST['port'])) {
        if (isset($_POST['query-enable'])) {
            if ($_POST['query-enable'] == "on") {
                try {
                    $query->Connect($_POST['ip'], $_POST['port']);
                    echo "<i class=\"fa fa-check text-success\"></i> Successfully queried server<br>";
                } catch (MinecraftQueryException $e) {
                    echo "<i class=\"fa fa-times text-warning\"></i> Server query failed<br>";
                    $success = false;
                }
            }
        }
    }
}

if (isset($_POST["theme"])) {
    if (in_array($_POST["theme"], ["webstatsx","material"])) {
        $_SESSION["theme"] = $_POST["theme"];
    }
}


$_SESSION = $_POST;

if ($success) {
    echo '<a class="btn btn-success pull-right" href="?step=4">Install</a>';
} else {
    echo '<a class="btn btn-danger pull-left"  href="?step=2">Back</a>';
}
