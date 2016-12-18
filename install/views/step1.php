<?php $allowInstall = true;
$processUser = posix_getpwuid(posix_geteuid());
?>
Minimum PHP version: 5.2.0
<?php
if (version_compare(PHP_VERSION, '5.2.0', '>=')) {
    echo '<i class="fa fa-check text-success"></i> (PHP version ' . PHP_VERSION . ' is installed)';
} else {
    echo '<i class="fa fa-times text-warning"></i> (PHP version ' . PHP_VERSION . ' is installed)';
    $allowInstall = false;
}
?>

<h2>Php modules:</h2>
<?php
if (function_exists('fsockopen')) {
    echo 'fsockopen is installed <i class="fa fa-check text-success"></i>';
} else {
    echo 'fsockopen is not installed <i class="fa fa-times text-warning"></i> (MC query will be disabled)';
}

if (function_exists('fsockopen')) {
    echo 'MySQLnd is installed <i class="fa fa-check text-success"></i>';
} else {
    echo 'MySQLnd is not installed <i class="fa fa-times text-warning"></i> (Install or activate MySQLnd before continuing))';
    $allowInstall = false;
}
?>

<h2>File permissions:</h2>
<?php
if (is_writable('../')) {
    echo 'Can write to BlueStats root <i class="fa fa-check text-success"></i>';
} else {
    echo 'Can not write to BlueStats root <i class="fa fa-times text-warning"></i> (Must create config files manually)';
}
?>

<br>

<?php
if (is_writable('../assets/')) {
    echo 'Can write to assets folder <i class="fa fa-check text-success"></i>';
} else {
    echo 'Can not write to assets folder <i class="fa fa-times text-warning"></i> (Themes will not work as expected)';
    echo "<br>To fix, run<br>
<pre>sudo chown {$processUser['name']} " . dirname(dirname(__DIR__)) . "/assets -R
sudo chmod 755 " . dirname(dirname(__DIR__)) . "/assets -R</pre>";
    $allowInstall = false;
}


?>

<br>

<?php
if (is_writable('../cache/')) {
    echo 'Can write to cache folder <i class="fa fa-check text-success"></i>';
} else {
    echo 'Can not write to cache folder <i class="fa fa-times text-warning"></i> (Cache will not work)';
    echo "<br>To fix, run<br>
<pre>sudo chown {$processUser['name']} " . dirname(dirname(__DIR__)) . "/cache -R
sudo chmod 755 " . dirname(dirname(__DIR__)) . "/cache -R</pre>";
    $allowInstall = false;
}
?>


<?php
if ($allowInstall === true) {
    echo '<a class="btn btn-success pull-right" href="?step=2">Next Step</a>';
}
?>
