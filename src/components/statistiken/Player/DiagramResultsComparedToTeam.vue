<template>
  <select id="hg_spielerSelect"></select>
<select id="hg_jahrSelect"></select>
<span id="hg_alle">
	<input type="radio" name="alle" value="1" checked>Alle Spiele
	<input type="radio" name="alle" value="0">Nur Meisterschaft
</span>
<span id="hg_calc_label">Berechnung:</span>
<span id="hg_calc">
	<input type="radio" name="calc" value="1" checked>Total
	<input type="radio" name="calc" value="0">Pro Ries
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
  name: "DiagramResultsComparedToTeam",
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
var allspiele = [];
		var allspieleloaded = false;

		hgutil.loadSelectFromArray('https://www.hgverwaltung.ch/api/1/' + club + '/spiele/jahre', 'hg_jahrSelect', true, getYearData);
		loadSpielerSelect('https://www.hgverwaltung.ch/api/1/' + club + '/spieler', 'hg_spielerSelect', true, getData);

		document.getElementById('hg_jahrSelect').addEventListener("change", getYearData);
		document.getElementById('hg_spielerSelect').addEventListener("change", getData);
		var allRadios = document.getElementById('hg_alle').querySelectorAll("input");
		allRadios[0].addEventListener("change", getData);
		allRadios[1].addEventListener("change", getData);

		allRadios = document.getElementById('hg_calc').querySelectorAll("input");
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

		function getYearData() {
			allspieleloaded = false;
			var jahr = document.getElementById('hg_jahrSelect').value;
			fetch('https://www.hgverwaltung.ch/api/1/' + club + '/mannschaften?spiele=true')
				.then(function (response) { return response.json(); })
				.then(
				function (teams) {
					var pr = [];
					for (var t = 0; t < teams.length; t++) {
						var url = 'https://www.hgverwaltung.ch/api/1/' + club + '/mannschaftsdurchschnitt/' + teams[t] + '?alle=1' + '&jahr=' + jahr;
						var pro = fetch(url).then(
							function (response) {
								return response.json();
							}
						).then(
							function (spiele) {
								Array.prototype.push.apply(allspiele, spiele);
							}
							);
						pr.push(pro);
					}
					return Promise.all(pr);
				}
				)
				.then(function () { allspieleloaded = true; getData(); })
		}

		function getData() {
			var jahr = document.getElementById('hg_jahrSelect').value;
			var spielerId = document.getElementById('hg_spielerSelect').value;
			var alle = document.querySelector('#hg_alle input[name="alle"]:checked').value;

			if (jahr && spielerId && allspieleloaded) {
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
			var ds = [];
			var high = [];
			var low = [];
			var labels = [];
			var average = [];
			
			var proRies = document.querySelector('#hg_calc input[name="calc"]:checked').value === "0";
			results.forEach(function (row) {

				var total = 0;
				var count = 0;

				for (var i = 0; i < 8; i++) {
					var p = row['ries' + (i + 1)];
					if (p > 0 || p === 0) {
						count++;
						total += p;
					}
				}

				if (count > 0) {
					var spiel = allspiele.find(function (item) {
						return item.id === row.id;
					});
					if (spiel) {
						if (proRies) {
							high.push(spiel.hoechstesTotal / count);
							low.push(spiel.tiefstesTotal / count);
							average.push(spiel.punkteTotalSchnitt / count);
						}
						else {
							high.push(spiel.hoechstesTotal);
							low.push(spiel.tiefstesTotal);
							average.push(spiel.punkteTotalSchnitt);
						}
					}
					else {
						high.push(0);
						low.push(0);
						average.push(0);
					}
					if (proRies) {
						ds.push(total / count);
					}
					else {
						ds.push(total);
					}
					var hdate = row.datum.substr(8, 2) + '.' + row.datum.substr(5, 2) + '.' + row.datum.substr(0, 4);
					labels.push([hdate, row.art, row.gegner]);
				}
			});

			var ctx = document.getElementById("chart").getContext("2d");
		var myChart = new Chart(ctx, {
				type: 'line',
				width: 200,
				height: 200,
				data: {
					labels: labels,
					datasets: [{
						data: ds,
						label: 'Punktetotal',
						fill: false,
						borderWidth: 2,
						pointRadius: 6,
						pointHoverRadius: 7,
						borderColor: 'blue',
						lineTension: 0
					}, {
						data: high,
						label: 'Höchstes Total',
						fill: false,
						borderWidth: 1,
						pointRadius: 6,
						pointHoverRadius: 7,
						borderColor: 'green',
						lineTension: 0,
						pointStyle: 'rect'
					}, {
						data: low,
						label: 'Tiefstes Total',
						fill: false,
						borderWidth: 1,
						pointRadius: 6,
						pointHoverRadius: 7,
						borderColor: 'red',
						lineTension: 0,
						pointStyle: 'triangle'
					}, {
						data: average,
						label: 'Durchschnitt',
						fill: false,
						borderWidth: 1,
						pointRadius: 6,
						pointHoverRadius: 7,
						borderColor: 'orange',
						lineTension: 0,
						pointStyle: 'star'
					}]
				},
				options: {
					tooltips: {
						callbacks: {
							title: function (tooltipItem, data) {
								return data.labels[tooltipItem[0].index];
							}
						}
					},
					animation: {
						duration: 400
					},
					legend: {
						display: true
					},
					scales: {
						xAxes: [{
							display: true,
							gridLines: {
								display: true
							},
							ticks: {
								minRotation: 90,
								maxRotation: 90,
								autoSkip: false,
								callback: function (value, index, values) {
									return [value[0], value[2]];
								}
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
#hg_calc_label,
	#hg_calc,
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

	#hg_calc_label {
		margin-left: 20px;
	}
/*]]>*/
</style>
