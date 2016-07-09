<?php

require dirname(dirname(__DIR__)) . "/plugins/query/minecraftQuery.php";

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

    if ($mysqli->connect_error){
        echo "<b>BlueStats database connetion error:</b> ".$mysqli->connect_error."<br>";
        $success = false;
    }else{
        echo "BlueStats database success!<br>";
    }

}else{
    echo "BlueStats database details missing<br>";
    $success = false;
}
if (isset($_POST["lolstats-enable"])&&$_POST["lolstats-enable"]=="on") {
    if (isset($_POST["lolstats-host"]) && isset($_POST["lolstats-username"]) && isset($_POST["lolstats-password"]) && isset($_POST["lolstats-db"])) {
        /* Connect to MySQL */
        $mysqli = new mysqli(
            $_POST["lolstats-host"],
            $_POST["lolstats-username"],
            $_POST["lolstats-password"],
            $_POST["lolstats-db"]
        );

        if ($mysqli->connect_error) {
            echo "<b>Lolmewn Stats database connetion error:</b> " . $mysqli->connect_error . "<br>";
            $success = false;
        } else {
            echo "Lolmewn Stats success!<br>";
        }

    }else{
        echo "Lolmewn Stats database details missing<br>";
        $success = false;
    }
}

if (isset($_POST["mcmmo-enable"])&&$_POST["mcmmo-enable"]=="on") {
    if (isset($_POST["mcmmo-host"]) && isset($_POST["mcmmo-username"]) && isset($_POST["mcmmo-password"]) && isset($_POST["mcmmo-db"])) {
        /* Connect to MySQL */
        $mysqli = new mysqli(
            $_POST["mcmmo-host"],
            $_POST["mcmmo-username"],
            $_POST["mcmmo-password"],
            $_POST["mcmmo-db"]
        );

        if ($mysqli->connect_error) {
            echo "<b>Mcmmo database connetion error:</b> " . $mysqli->connect_error . "<br>";
            $success = false;
        } else {
            echo "Mcmmo success!<br>";
        }

    }else{
        echo "Mcmmo database details missing<br>";
        $success = false;
    }
}

$query = new MinecraftQuery();

if (isset($_POST['ip']) && isset( $_POST['port'])) {
    try {
        $query->Connect($_POST['ip'], $_POST['port']);
        echo "Successfully queried server<br>";
    } catch (MinecraftQueryException $e) {
        echo "Server query failed<br>";
        $success = false;
    }
}

$_SESSION = $_POST;

if ($success) {
    echo '<a class="btn btn-success pull-right" href="?step=4">Install</a>';
}else{
    echo '<a class="btn btn-danger pull-left"  href="?step=2">Back</a>';
}
