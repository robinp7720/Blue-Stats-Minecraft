<?php
$processUser = posix_getpwuid(posix_geteuid());
$secure = true;
?>

<?php if ($processUser['name'] == "root"): ?>
    <div class="alert alert-danger" role="alert">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <span class="sr-only">Danger:</span>
        Webserver is running as root. This is a major security risk
    </div>
    <?php $secure = false; ?>
<?php endif; ?>

<?php if ($processUser['gecos'] == "root"): ?>
    <div class="alert alert-danger" role="alert">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <span class="sr-only">Danger:</span>
        Webserver is user is part of superuser group. This is a major security risk
    </div>
    <?php $secure = false; ?>
<?php endif; ?>

<?php if ($secure): ?>
    <div class="alert alert-success" role="alert">
        <span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true"></span>
        No security threats detected
    </div>
<?php endif; ?>
