<?php
$stats = array(
	"playtime" => "clock-o",
	"joins" => "sign-in",
	"money" => "money",
	"arrows" => "long-arrow-right",
	"xpgained" => "flask",
	"fishcatched" => "ship",
	"damagetaken" => "heart",
	"timeskicked" => "user-times",
	"toolsbroken" => "unlink",
	"eggsthrown" => "asterisk",
	"itemscrafted" => "plus-circle",
	"omnomnom" => "cutlery",
	"onfire" => "fire",
	"wordssaid" => "comment",
	"commandsdone" => "terminal",
	"votes" => "thumbs-o-up",
	"teleports" => "bolt",
	"itempickups" => "plus-square-o",
	"itemdrops" => "minus-square-o",
	"bedenter" => "bed",
	"bucketfill" => "bitbucket",
	"bucketempty" => "bitbucket",
	"worldchange" => "bolt",
	"shear" => "scissors",
	"pvpstreak" => "medkit",
	"pvptopstreak" => "hospital-o",
	"trades" => "exchange",
)
?>
<div class="row">
<?php foreach ($stats as $statName => $iconName) : ?>
	<?php $statTitle = $this->config["stats"]["names"][$statName];
	if ($statName!="lastjoin"&&$statName!="lastleave"){
		$server_total =  getStatTotal($statName,$this->mysqli,$this->config["mysql"]["stats"]["table_prefix"]);
	}else{
		$server_total="";
	}

	if ($statName!="lastjoin"&&$statName!="lastleave"){
		$server_average = round($server_total / getPlayerCount($this->mysqli,$this->config["mysql"]["stats"]["table_prefix"])[0]["count(*)"]);
	}else{
		$server_average="";
	}
	if ($statName == "playtime"){
		$server_total=secondsToTime($server_total,false);
		$server_average=secondsToTime($server_average,false);
	}

	?>
	<div class="col-lg-4 col-sm-6">
		<div class="circle-tile ">
			<a>
				<div class="circle-tile-heading bg-primary">
					<i class="fa fa-<?=$iconName?> fa-fw fa-3x"></i>
				</div>
			</a>
			<div class="circle-tile-content bg-primary">
			<div class="circle-tile-description text-faded"> <?=$statTitle?></div>
			<div class="circle-tile-number text-faded "><?=$server_total?></div>
			<a class="circle-tile-footer">Server Average: <?=$server_average?></a>
			</div>
		</div>
	</div>
<?php endforeach ?>
</div>