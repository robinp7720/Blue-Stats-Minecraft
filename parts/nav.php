<?php
/* Create custom nav html */
$custom_nav_html = '<div class="nav-right">';
foreach ($nav_bar_url as $item)
{
	$custom_nav_html .= '<a href="'.$item["url"].'" class="nav-item">'.$item["text"].'</a>';
}
$custom_nav_html .= '</div>';

?>


<?php /* If url rewrites have been disabled */ if ($enable_url_rewrite==false) :?>
<nav>
	<a class="nav-logo">Blue Stats</a>
	<a class="nav-item" href="?page=highscores">High Scores</a>
	<a class="nav-item" href="?page=allplayers">All Players</a>
	<a class="nav-item" href="?page=pvpstats">PvP Stats</a>
	<?=$custom_nav_html?>
</nav>
<?php endif ?>
<?php /* If url rewrites have been enabled */ if ($enable_url_rewrite==true) :?>
<nav>
	<a class="nav-logo">Blue Stats</a>
	<a class="nav-item" href="<?= $site_base_url."/highscores/" ?>">High Scores</a>
	<a class="nav-item" href="<?= $site_base_url."/allplayers/"?>">All Players</a>
	<a class="nav-item" href="<?= $site_base_url."/pvpstats/"?>">PvP Stats</a>
	<?=$custom_nav_html?>
</nav>
<?php endif ?>