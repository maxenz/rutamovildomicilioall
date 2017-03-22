<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7,8,9" />
<title>Recorrido Móvil - Domicilio</title>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCgGOZyoyPNYnpqnmUR4NbLsRDowF-sYG8"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/googlemaps/v3-utility-library/master/infobox/src/infobox.js"></script>
<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>

<script type="text/javascript">

var rendererOptions;
var ib;
var directionsService = new google.maps.DirectionsService();
var map;
var marker,marker2;
var rendererOptions;
var h = obtP('H');
var w = obtP('W');
var pId = obtP('pId');

var markers = [];
var latlng = new google.maps.LatLng(-34.603365,-58.379416);
var directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);

$(document).ready(function(e) {

	var myOptions = {
		zoom: 13,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};

   map = new google.maps.Map(document.getElementById("map"),myOptions);
   $('#map').css("width",w+"px").css("height",h+"px");
   $('#map').css("margin-top","-15px");
   $('#map').css("margin-left","-9px");
   $('#map').css("overflow","hidden");

	rendererOptions = {
		map: map,
		suppressMarkers : true
	};

	getDataMovil();
	directionsDisplay.setMap(map);
});

function calcRoute(latMov,lngMov,latDom,lngDom,distancia,tiempo) {

	var start = new google.maps.LatLng(latMov,lngMov);
	var end = new google.maps.LatLng(latDom,lngDom);

	var request = {
		origin:start,
		destination:end,
		travelMode: google.maps.TravelMode.DRIVING
	};

  	directionsService.route(request, function(result, status) {
		if (status === google.maps.DirectionsStatus.OK) {
			directionsDisplay.setDirections(result);
    	}
  	});

  	showDistanceTime(latMov,lngMov,latDom,lngDom,distancia,tiempo);

}

function clearMarkers() {

	if ((marker != undefined) & (marker2 != undefined)) {

		marker.setMap(null);
		marker2.setMap(null);

	}

}

function getDataMovil() {

	clearMarkers();

	 var numMov = obtP('numMov');
	 var latDom = obtP('latDom');
	 var lngDom = obtP('lngDom');
	 var latMov = obtP('latMov');
	 var lngMov = obtP('lngMov');
	 var distancia = obtP('distancia');
	 var tiempo = obtP('tiempo');

	 calcRoute(latMov,lngMov,latDom,lngDom,distancia,tiempo);

}


function obtP( name ){
	var regexS = "[\\?&]"+name+"=([^&#]*)";
	var regex = new RegExp ( regexS );
	var tmpURL = window.location.href;
	var results = regex.exec( tmpURL );
	if( results === null ) {
		return "";
	} else {
		return results[1];	
	}
}

function showDistanceTime(latMov,lngMov,latDom,lngDom,distancia,tiempo) {

	var boxText = document.createElement("div");
	boxText.style.cssText = "border: 2px solid black; margin-top: 8px; background: white; text-align:center ;font-weight:bold; height:60px; padding: 5px;";
	boxText.innerHTML = "M&oacute;vil: "+ obtP('numMov')+"<br> Distancia Faltante: "+distancia+"<br> Tiempo Faltante: "+tiempo;

	var myOptions = {
			 content: boxText
			,disableAutoPan: false
			,maxWidth: 0
			,pixelOffset: new google.maps.Size(-140, 0)
			,zIndex: null
			,boxStyle: {opacity: 0.75,width: "280px"}
			,closeBoxMargin: "10px 2px 2px 2px"
			,closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif"
			,infoBoxClearance: new google.maps.Size(1, 1)
			,isHidden: false
			,pane: "floatPane"
			,enableEventPropagation: false
		};

	marker2 = createMarker(latDom,lngDom,1);
	marker = createMarker(latMov,lngMov,0);

	if (ib === undefined) {

		ib = new InfoBox(myOptions);
		ib.open(map,marker);

	} else {

		ib.close();
		ib = new InfoBox(myOptions);
		ib.open(map,marker);

	}
}

function createMarker(lat,lng,pIcon) {

	var shape = {
		coord: [1, 1, 1, 20, 18, 20, 18 , 1],
		type: 'poly'
	};

    var myLatLng = new google.maps.LatLng(lat,lng);

	if (pIcon === 0) {

	 	var marker = new google.maps.Marker({
			position: myLatLng,
			icon: 'ambulance.png',
			map: map,
			shape: shape,
			zIndex: 1
    	});

	}
	else {

	 	var marker = new google.maps.Marker({
			position: myLatLng,
			icon: 'domicilio.png',
			map: map,
			shape: shape,
			zIndex: 1
    	});

	}

	return marker;

}

</script>
</head>

<body>
	<div id="map">
	</div>
</body>
</html>