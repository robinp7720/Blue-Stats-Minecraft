<?php
/* High Scores to show */
$config[0]["highscores"]["highscores"] = array(
	array(
		"stat" => "joins",
		"amount" => 10
	),
	array(
		"stat" => "playtime",
		"amount" => 10
	),
	array(
		"stat" => "money",
		"amount" => 10
	),
	array(
		"stat" => "votes",
		"amount" => 10
	),
	array(
		"stat" => "wordssaid",
		"amount" => 10
	),
	array(
		"stat" => "commandsdone",
		"amount" => 10
	),
	array(
		"stat" => "trades",
		"amount" => 10
	),
	array(
		"stat" => "itemscrafted",
		"amount" => 10
	),
	array(
		"stat" => "arrows",
		"amount" => 10
	),
	array(
		"stat" => "lastleave",
		"amount" => 10
	),
);

/* Text to show above each high score table */
$config[0]["highscores"]["title"]="Top {AMOUNT} by {STAT}"; /* {AMOUNT} will be replaced with the amount of peoples shown and {STAT} is the stat name */