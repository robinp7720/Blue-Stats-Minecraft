<?php
$checkFailed = false;
if (!extension_loaded("mysqlnd")){
	echo "Please install mysqlnd! <br>";
	$checkFailed = true;
}
if (!extension_loaded("curl")){
	echo "Please install curl! <br>";
	$checkFailed = true;
}


if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    echo 'BlueStats is not compatible with windows!';
    $checkFailed = true;
} else {
	if (get_current_user()=="root"){
		echo "Please dont run your webserver as root <br>";
		$checkFailed = true;
	}
}

if ($checkFailed==true){
	die("Terminating for security reasons");
}