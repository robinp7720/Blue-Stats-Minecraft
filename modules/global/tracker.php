<script>
		<?php /* If url rewrites have been disabled */ if ($this->config["url"]["rewrite"]==false) :?>
		var url = './ajax/call.php?func=dump';
		<?php else: ?>
		var url = '<?=$this->config["url"]["base"]?>/ajax/?func=dump';
		<?php endif; ?>
		var players = [];
		var oldPlayers = [];
		var stats = [
			"joins",
			"money",
			"arrows",
			"xpgained",
			"fishcatched",
			"damagetaken",
			"timeskicked",
			"toolsbroken",
			"eggsthrown",
			"itemscrafted",
			"omnomnom",
			"onfire",
			"wordssaid",
			"commandsdone",
			"votes",
			"teleports",
			"itempickups",
			"bedenter",
			"bucketfill",
			"bucketempty",
			"worldchange",
			"itemdrops",
			"shear",
			"pvpstreak",
			"pvptopstreak",
			"trades",
			"lastjoin",
			"lastleave"
		]

		$.ajax({
	        // the URL for the request
	        url: url,
	        type: "GET",
	        dataType : "json",
	        success: function( json ) {
	            jQuery.each(json.data, function(i, val) {
	                oldPlayers[val.name]=val;
	            });
	            //console.log(players);
	        }
		});
		function getDiffernce(){
		    $.ajax({
		        // the URL for the request
		        url: url,
		        type: "GET",
		        dataType : "json",
		        success: function( json ) {
		        	var change = false;
		            jQuery.each(json.data, function(i, val) {
		                players[val.name]=val;
		                var oldPlayer = oldPlayers[val.name];
		                jQuery.each(stats, function(statcount, stat) {
		                	if (oldPlayer[stat]!=val[stat]){
		                		change = true;
		                		var diffrence = val[stat] - oldPlayer[stat];
		                   		//console.log(val.name + " : " + stat + ": " + diffrence);
		                   		$( ".tracker" ).prepend( val.name + " : " + stat + ": " + diffrence + "<br>");
		                   		oldPlayers[val.name][stat]=val[stat];
		               		}
		                });
		            });
		            if (change){
			            $( ".tracker" ).prepend("<hr>");
			        }
		            
		        }
			});
		}
		getDiffernce();

		setInterval(track, 5000);

		function track( )
		{
			console.log("refresh");
			getDiffernce();
		}
		</script>

		<div class="tracker" style="width:100%; height:300px; overflow:hidden;">
			
		</div>