<template>
<body style="height: 100%;">

	<select id="ligaSelection">
		<option value="alle">Alle</option>
		<option value="nla">NLA</option>
		<optgroup label="NLB">
			<option value="nlb1">Gruppe 1</option>
			<option value="nlb2">Gruppe 2</option>
		</optgroup>
		<optgroup label="1. Liga">
			<option value="1l1">Gruppe 1</option>
			<option value="1l2">Gruppe 2</option>
			<option value="1l3">Gruppe 3</option>
			<option value="1l4">Gruppe 4</option>
		</optgroup>
		<optgroup label="2. Liga">
			<option value="2l1">Gruppe 1</option>
			<option value="2l2">Gruppe 2</option>
			<option value="2l3">Gruppe 3</option>
			<option value="2l4">Gruppe 4</option>
		</optgroup>
		<optgroup label="3. Liga">
			<option value="3l1">Gruppe 1</option>
			<option value="3l2">Gruppe 2</option>
			<option value="3l3">Gruppe 3</option>
			<option value="3l4">Gruppe 4</option>
		</optgroup>
		<optgroup label="4. Liga">
			<option value="4l1">Gruppe 1</option>
			<option value="4l2">Gruppe 2</option>
			<option value="4l3">Gruppe 3</option>
			<option value="4l4">Gruppe 4</option>
		</optgroup>
		<optgroup label="5. Liga">
			<option value="5l1">Gruppe 1</option>
			<option value="5l2">Gruppe 2</option>
			<option value="5l3">Gruppe 3</option>
		</optgroup>
	</select>
	<input id="nameFilterInput" type="text" placeholder="Name" width="100">

	<div id="map" style="margin-top:10px; height: 100%;"></div>
</body>
</template>

<script lang="js">
import { onMounted,ref,  } from "vue";
import List from "../scripts/List.js";
import hgutil from "../scripts/hgutil.js";
import google from "../scripts/google.js";


export default {
  name: "MapLocationsOrderLiga",
  props: ["webcode"],
  watch: { 
      	webcode: function(newVal, oldVal) { // watch it 
         		 console.log('Prop changed: ', newVal, ' | was: ', oldVal);
		 this.loadStatistik();
        }
  },
  components: {},
  setup(props) {

      onMounted(() => {
      loadStatistik();
  
    });
function loadStatistik(){
	var map;
			var locations = [];
			var index;
			var mapMarkers;
			var infoWindow = new google.maps.InfoWindow();
			function initialize() {
				var latLng = new google.maps.LatLng(46.8770593, 8.0429356);
				var mapOptions = {
					zoom: 8,
					center: latLng,
					mapTypeId: google.maps.MapTypeId.HYBRID
				};
				map = new google.maps.Map(document.getElementById('map'), mapOptions);
				var ligaSelection = document.getElementById('ligaSelection');
				ligaSelection.addEventListener('change', onLigaChange);

				var nameFilterInput = document.getElementById('nameFilterInput');
				nameFilterInput.addEventListener('keyup', onNameFilterInputChange);

				getLocations('alle').then(function (data) {
					index = lunr(function () {
						this.ref('id');
						this.field('ort');
						this.field('name');

						var i = 0;
						for (; i < data.length; i++) {
							locations[i] = data[i];
							data[i].id = i;
							this.add(data[i]);
						}
					});
				});
			}
			function onLigaChange(e) {
				document.getElementById('nameFilterInput').value = '';
				getLocations(e.target.value);
			}
			function debounce(func, interval) {
				var lastCall = -1;
				return function () {
					clearTimeout(lastCall);
					var args = arguments;
					var self = this;
					lastCall = setTimeout(function () {
						func.apply(self, args);
					}, interval);
				};
			}
			function onNameFilterInputChange(e) {
				document.getElementById('ligaSelection').value = 'alle';
				debounce(function () {
					if (!e.target.value) {
						showData(locations);
					}
					else {
						var matches = index.search(e.target.value + '*');
						var data = matches.map(function (r) {
							return locations[r.ref];
						});
						showData(data);
					}
				}, 200)();
			}
			function getLocations(liga) {
				var clubs = liga === 'alle';
				return fetch("https://www.hgverwaltung.ch/api/1/clubs/locations/" + liga + "?clubs="+clubs)
					.then(function (response) {
						return response.json();
					}).then(function (results) {
						showData(results);
						return results;
					});
			}
			function showData(data) {
				if (mapMarkers) {
					for (var i = 0; i < mapMarkers.length; i++) {
						mapMarkers[i].setMap(null);
					}
				}
				mapMarkers = [];
				var boundary = new google.maps.LatLngBounds();
				for (var i = 0; i < data.length; i++) {
					var markerLatLng = new google.maps.LatLng(data[i].lat, data[i].lng);
					boundary.extend(markerLatLng);
					var marker = new google.maps.Marker({
						map: map,
						info: data[i],
						title: data[i].name,
						position: markerLatLng
					});
					marker.addListener('click', function () {
						infoWindow.close();
						var info = '';
						var hp = this.info.homepage;
						if (hp) {
							if (!hp.startsWith('http')) {
								hp = 'http://' + hp;
							}
							info = '<a href="' + hp + '" target="_blank"><h3>' + this.info.name + '</h3></a>'
						} else {
							info = '<h3>' + this.info.name + '</h3>';
						}
						info += '<p>';
						info += '<a href="https://maps.google.com/?daddr=' + this.info.lat + ',' + this.info.lng + '" target="_blank">Google Routenplaner</a>';
						info += '</p>';
						infoWindow.setContent(info);
						infoWindow.open(map, this);
					});
					mapMarkers.push(marker);
				}
				map.fitBounds(boundary);
			}
			google.maps.event.addDomListener(window, 'load', initialize);


}


    return{
		loadStatistik,
    };
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
/* <![CDATA[ */
body {
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica,
    Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
}
/*]]>*/
</style>
