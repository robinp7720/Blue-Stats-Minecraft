<?php
/* Create custom nav html */
$custom_nav_html = "";
foreach ($nav_bar_url as $item)
{
	$custom_nav_html .= '<li><a href="'.$item["url"].'">'.$item["text"].'</a></li>';
}

?>


<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Blue Stats</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	<?php /* If url rewrites have been disabled */ if ($enable_url_rewrite==false) :?>
		<ul class="nav navbar-nav">
          <li <?php if ($page=="home"):?>class="active"<?php endif; ?>><a href="?page=home">Home</a></li>
	        <li <?php if ($page=="highscores"):?>class="active"<?php endif; ?>><a href="?page=highscores">High Scores</a></li>
	        <li <?php if ($page=="allplayers"):?>class="active"<?php endif; ?>><a href="?page=allplayers">All Players</a></li>
	        <li <?php if ($page=="pvpstats"):?>class="active"<?php endif; ?>><a href="?page=pvpstats">PvP Stats</a></li>
    	</ul>
	<?php else: ?>
	   <ul class="nav navbar-nav">
        <li <?php if ($page=="home"):?>class="active"<?php endif; ?>><a href="<?= $site_base_url."/home/" ?>">Home</a></li>
        <li <?php if ($page=="highscores"):?>class="active"<?php endif; ?>><a href="<?= $site_base_url."/highscores/" ?>">High Scores</a></li>
        <li <?php if ($page=="allplayers"):?>class="active"<?php endif; ?>><a href="<?= $site_base_url."/allplayers/"?>">All Players</a></li>
        <li <?php if ($page=="pvpstats"):?>class="active"<?php endif; ?>><a href="<?= $site_base_url."/pvpstats/"?>">PvP Stats</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
      	<?= $custom_nav_html ?>
      </ul>
	<?php endif ?>

    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
