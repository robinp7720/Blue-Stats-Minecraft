<?php $allowInstall = true ?>
Minimum PHP version: 5.2.0
<?php
if (version_compare(PHP_VERSION, '5.2.0', '>=')) {
    echo '<i class="fa fa-check text-success"></i> (PHP version ' . PHP_VERSION . ' is installed)';
} else {
    echo '<i class="fa fa-times text-warning"></i> (PHP version ' . PHP_VERSION . ' is installed)';
    $allowInstall = false;
}
?>

<br>
mysqlnd
<?php
if (function_exists('mysqli_fetch_all')) {
    echo '<i class="fa fa-check text-success"></i>';
} else {
    echo '<i class="fa fa-times text-warning"></i> (Please install mysqlnd)';
    $allowInstall = false;
}
?>

<br>
Can write to BlueStats root
<?php
if (is_writable('../')) {
    echo '<i class="fa fa-check text-success"></i>';
} else {
    echo '<i class="fa fa-times text-warning"></i> (Must create config files manualy)';
}
?>

<br>
Can write to assets folder
<?php
if (is_writable('../assets/')) {
    echo '<i class="fa fa-check text-success"></i>';
} else {
    echo '<i class="fa fa-times text-warning"></i> (Themes will not work as expected)';
}
?>

<br>
Can write to cache folder
<?php
if (is_writable('../cache/')) {
    echo '<i class="fa fa-check text-success"></i>';
} else {
    echo '<i class="fa fa-times text-warning"></i> (Cache will not work)';
}
?>


<?php
if ($allowInstall === true) {
    echo '<a class="btn btn-success pull-right" href="?step=2">Next Step</a>';
}
?>
