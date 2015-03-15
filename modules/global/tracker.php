<?php if ($this->page!="tracker"):?>
<script>
		<?php /* If url rewrites have been disabled */ if ($this->config["url"]["rewrite"]==false) :?>
		var url = './ajax/call.php?func=dump';
		<?php else: ?>
		var url = '<?=$this->config["url"]["base"]?>/ajax/?func=dump';
		<?php endif; ?>
		var players = [];
		var oldPlayers = [];
		var stats = {
			"joins":"{NAME} Joined",
			"money":"{NAME} earned {AMOUNT} Dollars",
			"arrows":"{NAME} shot {AMOUNT} arrows",
			"xpgained":"{NAME} gained {AMOUNT} XP",
			"fishcatched":"{NAME} caught {AMOUNT} fish",
			"damagetaken":"{NAME} took {AMOUNT} damage",
			"timeskicked":"{NAME} was kicked {AMOUNT} times",
			"toolsbroken":"{NAME} broke {AMOUNT} tools",
			"eggsthrown":"{NAME} threw {AMOUNT} eggs",
			"itemscrafted":"{NAME} crafted {AMOUNT} items",
			"omnomnom":"{NAME} ate {AMOUNT} items",
			"onfire":"{NAME} caught on fire {AMOUNT} times",
			"wordssaid":"{NAME} said {AMOUNT} words",
			"commandsdone":"{NAME} commanded {AMOUNT} commands",
			"votes":"{NAME} voted {AMOUNT} times",
			"teleports":"{NAME} teleported {AMOUNT} times",
			"itempickups":"{NAME} picked up {AMOUNT} items",
			"bedenter":"{NAME} entered {AMOUNT} bed",
			"bucketfill":"{NAME} filled {AMOUNT} buckets",
			"bucketempty":"{NAME} emptied {AMOUNT} buckets",
			"worldchange":"{NAME} change world {AMOUNT} times",
			"itemdrops":"{NAME} dropped {AMOUNT} items",
			"shear":"{NAME} sheared {AMOUNT} sheep",
			"pvpstreak":"{NAME} streaked {AMOUNT} times",
			"pvptopstreak":"{NAME} streeecked {AMOUNT} reals",
			"trades":"{NAME} trades {AMOUNT} times",
			"lastjoin":"{NAME} Joined",
			"lastleave":"{NAME} Left"
		};



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
		                jQuery.each(stats, function(stat, statreplace) {
		                	if (oldPlayer[stat]!=val[stat]){
		                		change = true;
		                		if (stat=="lastleave"){
		                			$( ".tracker" ).prepend( "<b>" + val.name + "</b> Disconnected<br>");
		                			oldPlayers[val.name][stat]=val[stat];
		                		}else if(stat=="lastjoin"){
		                			$( ".tracker" ).prepend( "<b>" + val.name + "</b> Joined<br>");
		                			oldPlayers[val.name][stat]=val[stat];
		                		}else{
			                		var diffrence = val[stat] - oldPlayer[stat];
			                		var string = statreplace.replace("{NAME}","<b>" + val.name + "</b>");
			                		string = string.replace("{AMOUNT}",diffrence);
			                		console.log(diffrence);
			                   		$( ".tracker" ).prepend(string+"<br>");
			                   		oldPlayers[val.name][stat]=val[stat];
		                   		}
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

		var tracker = setInterval(track, 5000);

		function track( )
		{
			console.log("refresh");
			getDiffernce();
		}
		</script>

		<div class="tracker noscrollbars" style="width:100%; height:30vh; overflow:scroll;">
			
		</div>
		<?php endif; ?>