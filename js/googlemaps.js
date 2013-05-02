$(document).ready(
		function() {
			var mapOptions = {
				center : new google.maps.LatLng(mapsconf.lat, mapsconf.lon),
				zoom : 8,
				mapTypeId : google.maps.MapTypeId.ROADMAP
			};
			var map = new google.maps.Map(
					document.getElementById("googlemapsdiv"), mapOptions);
		});