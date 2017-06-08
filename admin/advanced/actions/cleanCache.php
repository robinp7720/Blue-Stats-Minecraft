<?php
define('ROOT', dirname(dirname(dirname(__DIR__))));

session_start();


if ($_SESSION["auth"] != TRUE) {
    die(json_encode(['code' => 500, 'message' => 'User is not authenticated']));
}

$directory         = ROOT . "/cache/";
$scanned_directory = array_diff(scandir($directory), ['..', '.']);

$deleteSuccess = 0;
$deleteFail    = 0;

foreach ($scanned_directory as $item) {
    if (unlink(ROOT . "/cache/$item")) {
        $deleteSuccess++;
    }
    else {
        $deleteFail++;
    }
}

echo json_encode([
                     'code'    => 200,
                     'success' => $deleteSuccess,
                     'fail'    => $deleteFail,
                 ]);