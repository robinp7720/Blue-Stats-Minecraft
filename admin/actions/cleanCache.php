<?php
session_start();

if ($_SESSION["auth"] != true)
    die("Not authenticated");

$directory = "../../cache/";
$scanned_directory = array_diff(scandir($directory), array('..', '.'));

foreach ($scanned_directory as $item){
    unlink("../../cache/$item");
}