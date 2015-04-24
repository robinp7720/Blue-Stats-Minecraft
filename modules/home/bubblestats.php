<?php
/*
Html and css for this module was copied from here: http://bootdey.com/snippets/view/Dashboard-user-128 and is released under the MIT licanse
Copyright (c) 2014 bootdey.com

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/
$mysqli = $this->mysqli->get("BlueStats");
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
		$server_total =  getStatTotal($statName,$mysqli,$this->config["mysql"]["stats"]["table_prefix"]);
	}else{
		$server_total="";
	}

	if ($statName!="lastjoin"&&$statName!="lastleave"){
		$server_average = round($server_total / getPlayerCount($mysqli,$this->config["mysql"]["stats"]["table_prefix"])[0]["count(*)"]);
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
