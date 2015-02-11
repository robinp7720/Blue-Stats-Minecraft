<?php

$config["cache"]["max-age"] = 0;
$config["cache"]["ajax"]["max-age"] = 0;

/* Site animations Set to false to have a faster user experience*/
$global_animations = "false";

/* Enter in the stats site base url Eg: http://www.example.com/stats */
$site_base_url = "http://games.mysunland.org/stats";
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
