<?php
define('ROOT', dirname(__DIR__));
session_start();

if (isset($_GET["logout"])) {
    $_SESSION["auth"] = FALSE;
}

if (!isset($_SESSION["auth"]) || $_SESSION["auth"] !== TRUE) {
    header('location: login.php');
    die("Not authenticated");
}
else {
    $layout = file_get_contents('layout/layout.html');

    $pages = ["index", "look", "security","query"];

    $page = isset($_GET['page']) ? $_GET['page'] : "index";

    if (in_array($page, $pages)) {

        require_once ROOT . "/classes/config.class.php";

        $dbConf = json_decode(file_get_contents(ROOT . "/config.json"), TRUE);

        $mysqli = new mysqli(
            $dbConf["mysql"]["host"],
            $dbConf["mysql"]["username"],
            $dbConf["mysql"]["password"],
            $dbConf["mysql"]["dbname"]
        );

        $config = new config($mysqli, "BlueStats");

        ob_start();
        include "pages/$page.php";
        $contents = ob_get_contents();
        ob_end_clean();

        $page = str_replace('{ content }', $contents, $layout);

        echo $page;
    }
    else {
        header('location: index.php');
        die("Page does not exist");
    }
}