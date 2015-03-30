<form method="get">
	<div class="input-group">
		<select name="stat" class="form-control">
			<?php
			foreach($this->config["stats"]["names"] as $statId => $statName){
				echo '<option value="'.$statId.'">'.$statName.'</option>';
			}
			?>
		</select>
		<span class="input-group-btn">
			<button class="form-control" type="submit">Go</button>
		</span>
	</div>
</form>
