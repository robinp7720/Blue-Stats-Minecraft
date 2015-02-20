<?php

$config["cache"]["max-age"] = 0;
$config["cache"]["ajax"]["max-age"] = 0;

/* User player name instead of player id for urls */
$config["url"]["player"]["useName"]=true;
$config["site"]["home"]="home";

/* Enter in the stats site base url Eg: http://www.example.com/stats */
$site_base_url = "http://stats.mysunland.org";
$enable_url_rewrite = true;

/* Material Design Date format Guide Lines */
$play_time_contract = true;

/* Custom navigation bar urls */
$nav_bar_url = array(
	array(
		"text" => "Our Site",
		"url" => "http://minecraft.mysunland.org",
	) ,
	array(
		"text" => "Our Twitter",
		"url" => "https://twitter.com/MySunland_MC",
	) ,
);
