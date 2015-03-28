
function getDeathData(id,url){
	$.ajax({
		// the URL for the request
		url: url,

		// the data to send (will be converted to a query string)
		data: {
			id:id
		},

		// whether this is a POST or GET request
		type: "GET",

		// the type of data we expect back
		dataType : "json",

		// code to run if the request succeeds;
		// the response is passed to the function
		success: function( json ) {
			var ctx = $("#deathsChart").get(0).getContext("2d");
			var killStats = new Chart(ctx).Pie(json);
		},

		// code to run if the request fails; the raw request and
		// status codes are passed to the function
		error: function( xhr, status, errorThrown ) {
			alert( "Sorry, there was a problem!" );
			console.log( "Error: " + errorThrown );
			console.log( "Status: " + status );
			console.dir( xhr );
		},

		// code to run regardless of success or failure
		complete: function( xhr, status ) {
		}
	});
}