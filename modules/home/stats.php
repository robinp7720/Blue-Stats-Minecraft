	<?php $count=1; ?>
	<?php foreach ($this->config["home"]["stats"] as $stat):?>
		<?php if ($count==1){echo '<div class="row">';} ?>
		<div class="col-sm-6 col-md-3 text-center">
			<h2><?=$this->config["stats"]["names"][$stat]; ?>:</h2>
			<?php
			if ($stat == "playtime"){
				echo secondsToTime(getStatTotal($stat,$this->mysqli,$this->config["mysql"]["stats"]["table_prefix"]));
			}else{
				echo getStatTotal($stat,$this->mysqli,$this->config["mysql"]["stats"]["table_prefix"]);
			}
			?>
		</div>
		<?php if ($count==4){echo '</div>';$count=0;} $count++; ?>
	<?php endforeach; ?>
	<?php if ($count!=1){echo '</div>';}?>