<?php
$page = "highscores";
$strRepl = array(
	"serverName" => $BlueStats->config["server"]["server_name"],
);

$string = file_get_contents($BlueStats->appPath."/page-templates/$page.html");

foreach ($strRepl as $repl => $new){
	$string = str_replace("{{ text:".$repl." }}", $new, $string);
}

/* Modules */
preg_match_all('/{{ module:([^ ]+) }}/', $string, $matches);
foreach ($matches[1] as $key => $filename) {
    //replace content:
    ob_start();
    include($BlueStats->appPath."/modules/$page/$filename.php");
    $contents = ob_get_contents();
    ob_end_clean();
    $string = str_replace($matches[0][$key], $contents, $string);
}

/* Global Modules */
preg_match_all('/{{ Gmodule:([^ ]+) }}/', $string, $matches);
foreach ($matches[1] as $key => $filename) {
    //replace content:
    ob_start();
    include($BlueStats->appPath."/modules/global/$filename.php");
    $contents = ob_get_contents();
    ob_end_clean();
    $string = str_replace($matches[0][$key], $contents, $string);
}

/* Urls */
preg_match_all('/{{ url:([^ ]+) }}/', $string, $matches);
foreach ($matches[1] as $key => $site) {
	if ($config[$serverId]["url"]["rewrite"]==false){
		$url = "?page=allplayers";
	}else{
		$url = $BlueStats->config["url"]["base"]."/$site/";
	}

    $string = str_replace($matches[0][$key], $url, $string);
}

echo $string;
