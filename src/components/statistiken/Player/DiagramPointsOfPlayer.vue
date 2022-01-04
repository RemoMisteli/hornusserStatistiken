<template>
<select id="hg_spielerSelect"></select>
<select id="hg_jahrSelect"></select>
<span id="hg_alle">
	<input type="radio" name="alle" value="1" checked>Alle Spiele
	<input type="radio" name="alle" value="0">Nur Meisterschaft
</span>

<div id="chart-container" style="position: relative; height:95vh; width:95vw">
	<canvas id="chart"></canvas>
</div>


</template>

<script lang="js">
import { onMounted,ref,  } from "vue";
import List from "../scripts/List.js";
import hgutil from "../scripts/hgutil.js";
import Chart from 'chart.js' 

export default {
  name: "DiagramPointsOfPlayer",
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
	var club =props.webcode;
		if (!club) {
		  club = 'test';
		}
		hgutil.loadSelectFromArray('https://www.hgverwaltung.ch/api/1/' + club + '/spiele/jahre', 'hg_jahrSelect', true, getData);
		loadSpielerSelect('https://www.hgverwaltung.ch/api/1/' + club + '/spieler', 'hg_spielerSelect', true, getData);

		document.getElementById('hg_jahrSelect').addEventListener("change", getData);
		document.getElementById('hg_spielerSelect').addEventListener("change", getData);
		var allRadios = document.getElementById('hg_alle').querySelectorAll("input");
		allRadios[0].addEventListener("change", getData);
		allRadios[1].addEventListener("change", getData);

		function loadSpielerSelect(url, elementId, selectFirst, callback) {
			fetch(url)
				.then(function (response) {
					return response.json();
				})
				.then(function (objects) {
					var el = document.getElementById(elementId);

					objects.forEach(function (o) {
						var option = document.createElement("option");
						var jg = o.jahrgang;
						option.text = o.nachname + ' ' + o.vorname + (jg ? ', ' : '') + (jg ? jg : '');
						option.value = o.id;
						el.appendChild(option);
					});

					if (selectFirst) {
						el.selectedIndex = 0;
					}

					if (callback) {
						callback();
					}
				});
		}

		function getData() {
			var jahr = document.getElementById('hg_jahrSelect').value;
			var spielerId = document.getElementById('hg_spielerSelect').value;
			var alle = document.querySelector('#hg_alle input[name="alle"]:checked').value;

			if (jahr && spielerId) {
				var url = 'https://www.hgverwaltung.ch/api/1/' + club + '/spielerdurchschnitt/' + spielerId + '?alle=' + alle + '&jahr=' + jahr;
				fetch(url).then(function (response) {
					return response.json();
				}).then(function (results) {
					drawChart(results);
				});
			}
			else {
				drawChart([]);
			}
		}

		function drawChart(results) {
			var data = [];
			var labels = [];

			results.forEach(function (row) {
				for (let i = 0; i < 8; i++) {
				    var p = row['ries' + (i + 1)];
					if (p > 0 || p === 0) {
						data.push(p);
						var hdate = row.datum.substr(8, 2) + '.' + row.datum.substr(5, 2) + '.' + row.datum.substr(0, 4);
						labels.push([hdate, row.art, row.gegner, (i + 1) + '. Ries']);
					}
				}
			})

			var ctx = document.getElementById("chart").getContext("2d");
		/*	if (this.myChart) {
				this.myChart.destroy();
			}*/
			var myChart = new Chart(ctx, {
				type: 'line',
				width: 200,
				height: 200,
				data: {
					labels: labels,
					datasets: [{
						data: data,
						fill: false,
						pointRadius: 10,
						pointHoverRadius: 12,
						pointBackgroundColor: 'lightblue',
						showLine: false
					}]
				},
				options: {
					legend: {
						display: false
					},
					scales: {
						xAxes: [{
							display: false,
							gridLines: {
								display: false
							}
						}],
						yAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Punkte'
							},
							ticks: {
								min: 0,
								max: 30,
								stepSize: 5
							}
						}]
					}
				}
			});

		}

	

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
	#hg_jahrSelect,
	#hg_spielerSelect,
	#hg_data,
	#hg_alle {
		width: 100%;
		font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
	}

	#hg_jahrSelect,
	#hg_spielerSelect,
	#hg_alle,
	#hg_alle input {
		vertical-align: top;
	}

	#chart-container {
		margin-top: 20px;
	}
	/*]]>*/
</style>
