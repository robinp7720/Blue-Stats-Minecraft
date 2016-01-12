<?php
session_start();

if (isset($_GET["logout"])) {
    $_SESSION["auth"] = false;
}

if (!isset($_SESSION["auth"])||$_SESSION["auth"]!== true){
    header('location: login.php');
    die("Not authenticated");
}else{
    $layout = file_get_contents('layout/layout.html');

    ob_start();
    include "pages/index.php";
    $contents = ob_get_contents();
    ob_end_clean();

    $page = str_replace('{ content }',$contents,$layout);

    echo $page;

}