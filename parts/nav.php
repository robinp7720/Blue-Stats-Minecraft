<?php
/* Create custom nav html */
$custom_nav_html = "";
foreach ($BlueStats->config["nav"]["tabs"]["custom"] as $item)
{
	$custom_nav_html .= '<li><a href="'.$item["url"].'">'.$item["text"].'</a></li>';
}
?>


<nav class="navbar navbar-default">
  <?php
  if ($theme["container"]["nav"]["fluid"]){
    echo '<div class="container-fluid">';
  }else{
    echo '<div class="container">';
  }
  ?>
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><?php if(isset($BlueStats->config["server"]["server_name"]))echo $BlueStats->config["server"]["server_name"]?> Stats</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <?=$BlueStats->makeNavTabs()?>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <?= $custom_nav_html ?>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
