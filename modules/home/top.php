	<?php $count=1; ?>
	<?php foreach ($this->config["home"]["top"]["stats"] as $stat => $name):?>
		<?php if ($count==1){echo '<div class="row">';} ?>
		<div class="col-sm-6 text-center">
			<h2><?= $name ?>: <small>
			<?php
			echo get_highscore($this->mysqli,$this->config["mysql"]["stats"]["table_prefix"],$stat,1)[0]["name"];
			?>
			</small>
			</h2>
		</div>
		<?php if ($count==2){echo '</div>';$count=0;} $count++; ?>
	<?php endforeach; ?>
	<?php if ($count!=1){echo '</div>';}?>