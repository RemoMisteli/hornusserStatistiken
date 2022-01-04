<template>

<select id="hg_spielerSelect"></select>
<select id="hg_jahrSelect"></select>
<span id="hg_alle">
	<input type="radio" name="alle" value="1" checked>Alle Spiele
	<input type="radio" name="alle" value="0">Nur Meisterschaft
</span>

<button style="margin-left:100px;" id="punkteButton">Punkte</button>
<button id="punkteSchnittButton">Punkte Schnitt</button>
<button id="punkteTotalButton">Punkte Total</button>
<button id="rangpunkteButton">Rangpunkte</button>
<button id="streicheButton">Streiche</button>

<table id="hg_data" style="display: none;margin-top:20px;">
	<thead>
		<tr>
			<th colspan="3"></th>
			<th colspan="8">Ries</th>
			<th colspan="3">Spiel</th>
			<th colspan="3">Kumuliert</th>
			<th></th>
		</tr>
		<tr>
			<th class="sort" data-sort="datum">Datum</th>
			<th class="sort" data-sort="art">Art</th>
			<th class="sort" data-sort="gegner">Gegner</th>
			<th class="sort hg_number" data-sort="ries1">1</th>
			<th class="sort hg_number" data-sort="ries2">2</th>
			<th class="sort hg_number" data-sort="ries3">3</th>
			<th class="sort hg_number" data-sort="ries4">4</th>
			<th class="sort hg_number" data-sort="ries5">5</th>
			<th class="sort hg_number" data-sort="ries6">6</th>
			<th class="sort hg_number" data-sort="ries7">7</th>
			<th class="sort hg_number" data-sort="ries8">8</th>
			<th class="sort hg_number" data-sort="punkte">Punkte</th>
			<th class="sort hg_number" data-sort="streiche">Streiche</th>
			<th class="sort hg_number" data-sort="schnitt">Durchschnitt</th>
			<th class="sort hg_number" data-sort="punkteKumuliert">Punkte</th>
			<th class="sort hg_number" data-sort="streicheKumuliert">Streiche</th>
			<th class="sort hg_number" data-sort="schnittKumuliert">Durchschnitt</th>
			<th class="sort hg_number" data-sort="rangpunkte">Rangpunkte</th>
		</tr>
	</thead>
	<tbody class="hg_list">
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>	
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>	
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>	
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>	
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>	
	</tfoot>
</table>

<table style="display: none;">
	<tr id="hg_tr_template">
		<td class="datumDisplay"></td>
		<td class="art"></td>
		<td class="gegner"></td>
		<td class="ries1 hg_number"></td>
		<td class="ries2 hg_number"></td>
		<td class="ries3 hg_number"></td>
		<td class="ries4 hg_number"></td>
		<td class="ries5 hg_number"></td>
		<td class="ries6 hg_number"></td>
		<td class="ries7 hg_number"></td>
		<td class="ries8 hg_number"></td>
		<td class="punkte hg_number"></td>
		<td class="streiche hg_number"></td>
		<td class="schnitt hg_number"></td>
		<td class="punkteKumuliert hg_number"></td>
		<td class="streicheKumuliert hg_number"></td>
		<td class="schnittKumuliert hg_number"></td>
		<td class="rangpunkte hg_number"></td>
	</tr>
	<tr id="hg_total_tr">
		<td colspan="3" class="total_label"></td>
		<td class="total_ries1 hg_number"></td>
		<td class="total_ries2 hg_number"></td>
		<td class="total_ries3 hg_number"></td>
		<td class="total_ries4 hg_number"></td>
		<td class="total_ries5 hg_number"></td>
		<td class="total_ries6 hg_number"></td>
		<td class="total_ries7 hg_number"></td>
		<td class="total_ries8 hg_number"></td>
		<td class="total_punkte hg_number"></td>
		<td class="total_streiche hg_number"></td>
		<td class="total_schnitt hg_number"></td>
		<td colspan="4"></td>
	</tr>
</table>
</template>

<script lang="js">
import { onMounted,ref,  } from "vue";
import List from "../scripts/List.js";
import hgutil from "../scripts/hgutil.js";
import Chart from 'chart.js' 
import tingle from "../scripts/tingle.js";

export default {
  name: "OverviewPointsPlayer2",
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
	var displayedResults;
function loadStatistik(){
	var club =props.webcode;
		if (!club) {
		  club = 'test';
		}var allspiele = [];
		var allspieleloaded = false;

		hgutil.loadSelectFromArray('https://www.hgverwaltung.ch/api/1/' + club + '/spiele/jahre', 'hg_jahrSelect', true, getYearData);
		loadSpielerSelect('https://www.hgverwaltung.ch/api/1/' + club + '/spieler', 'hg_spielerSelect', true, getData);

		var hgDataTable = document.getElementById("hg_data");
		hgDataTable.createTFoot();

		var valueNames = [];
		var tdElements = document.getElementById('hg_tr_template').getElementsByTagName('td');
		for (var v = 0; v < tdElements.length; v++) {
			valueNames.push(tdElements[v].classList[0]);
		}

		var options = {
			valueNames: valueNames,
			listClass: 'hg_list',
			item: 'hg_tr_template'
		};

		var dataList = new List('hg_data', options);

		document.getElementById('hg_jahrSelect').addEventListener("change", getYearData);
		document.getElementById('hg_spielerSelect').addEventListener("change", getData);
		var allRadios = document.getElementById('hg_alle').querySelectorAll("input");

		allRadios[0].addEventListener("change", getData);
		allRadios[1].addEventListener("change", getData);

		document.getElementById('punkteButton').addEventListener('click', onPunkteButtonClick);
		document.getElementById('punkteSchnittButton').addEventListener('click', onPunkteSchnittButtonClick);
		document.getElementById('punkteTotalButton').addEventListener('click', onPunkteTotalButtonClick);
		document.getElementById('rangpunkteButton').addEventListener('click', onRangpunkteButtonClick);
		document.getElementById('streicheButton').addEventListener('click', onStreicheButtonClick);

		function onPunkteButtonClick() {
			showDiagram(displayedResults, drawPunkteChart);
		}

		function onPunkteSchnittButtonClick() {
			showDiagram(displayedResults, drawPunkteSchnittChart);
		}

		function onPunkteTotalButtonClick() {
			var modal = new tingle.modal({
				footer: false,
				stickyFooter: false,
				closeMethods: ['overlay', 'button', 'escape'],
				closeLabel: "Schliessen",
			});

			var html = [];
			html.push('<span id="hg_calc_label">Berechnung:</span>');
			html.push('<span id="hg_calc">');
			html.push('<input type="radio" name="calc" value="1" checked>Total');
			html.push('<input type="radio" name="calc" value="0">Pro Ries');
			html.push('</span>');
			html.push('<div id="chart-container" style="position: relative; width:100%">');
			html.push('<canvas id="chart"></canvas>');
			html.push('</div>');

			modal.setContent(html.join(''));
			modal.open();
			drawPunkteTotalChart(displayedResults);


			var allRadios = document.getElementById('hg_calc').querySelectorAll("input");
			allRadios[0].addEventListener("change", function () { drawPunkteTotalChart(displayedResults); });
			allRadios[1].addEventListener("change", function () { drawPunkteTotalChart(displayedResults); });
		}

		function onRangpunkteButtonClick() {
			var modal = new tingle.modal({
				footer: false,
				stickyFooter: false,
				closeMethods: ['overlay', 'button', 'escape'],
				closeLabel: "Schliessen",
			});

			var html = [];
			html.push('<div id="chart-container" style="position: relative; width:100%">');
			html.push('<canvas id="chart"></canvas>');
			html.push('</div>');

			modal.setContent(html.join(''));
			modal.open();
			drawRangpunkteChart(displayedResults);
		}

		function onStreicheButtonClick() {
			showDiagram(displayedResults, drawStreicheChart);
		}

		function showDiagram(results, drawFunction) {
			var modal = new tingle.modal({
				footer: false,
				stickyFooter: false,
				closeMethods: ['overlay', 'button', 'escape'],
				closeLabel: "Schliessen",
			});
			modal.setContent(createDiagramHtml(results));
			modal.open();
			drawFunction(results);
		}

		function createDiagramHtml(results) {
			var html = [];

			html.push('<div id="chart-container" style="position: relative; width:100%">');
			html.push('<canvas id="chart"></canvas>');
			html.push('</div>');

			return html.join('');
		}

		function drawPunkteTotalChart(results) {

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
									return value[0];
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

		function drawRangpunkteChart(results) {
			var labels = [];
            var ds = [];
			var rp = [];

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
					ds.push(total);
                    rp.push(row.rangpunkte || 0);
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
						label: 'Punkte',
						fill: true,
						borderWidth: 2,
						pointRadius: 6,
						pointHoverRadius: 7,
						borderColor: 'green',
						lineTension: 0
					}, {
						data: rp,
						label: 'Rangpunkte',
						fill: true,
						borderWidth: 1,
						pointRadius: 6,
						pointHoverRadius: 7,
						borderColor: 'red',
						lineTension: 0,
						pointStyle: 'rect'
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
									return value[0];
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

		function drawPunkteSchnittChart(results) {
			var ds = [];
			var high = [];
			var low = [];
			var labels = [];

			results.forEach(function (row) {
				var total = 0;
				var count = 0;
				var h = 0;
				var l = 100;

				for (var i = 0; i < 8; i++) {
					var p = row['ries' + (i + 1)];
					if (p > 0 || p === 0) {
						count++;
						total += p;
						h = Math.max(h, p);
						l = Math.min(l, p);
					}
				}

				if (count > 0) {
					ds.push(total / count);
					high.push(h);
					low.push(l);
					var hdate = row.datum.substr(8, 2) + '.' + row.datum.substr(5, 2) + '.' + row.datum.substr(0, 4);
					labels.push([hdate, row.art, row.gegner]);
				}
			})

			var ctx = document.getElementById("chart").getContext("2d");
	var myChart = new Chart(ctx, {
				type: 'line',
				width: 200,
				height: 200,
				data: {
					labels: labels,
					datasets: [{
						data: ds,
						label: 'Punktedurchschnitt',
						fill: false,
						borderWidth: 1,
						pointRadius: 6,
						pointHoverRadius: 7,
						borderColor: 'blue',
						lineTension: 0
					}, {
						data: high,
						label: 'Längster Streich',
						fill: false,
						borderWidth: 1,
						pointRadius: 6,
						pointHoverRadius: 7,
						borderColor: 'green',
						lineTension: 0,
						pointStyle: 'rect'
					}, {
						data: low,
						label: 'Kürzester Streich',
						fill: false,
						borderWidth: 1,
						pointRadius: 6,
						pointHoverRadius: 7,
						borderColor: 'red',
						lineTension: 0,
						pointStyle: 'triangle'
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
									return value[0];
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
								max: 30,
								stepSize: 5
							}
						}]
					}
				}
			});
		}

		function drawStreicheChart(results) {

			var data = [];
			var labels = [];
			var i, r;

			for (i = 0; i <= 30; i++) {
				data.push(0);
				labels.push(i);
			}

			for (i = 0; i < results.length; i++) {
				for (r = 1; r <= 8; r++) {
					var ries = results[i]['ries' + r];
					if (ries > 0 || ries === 0) {
						data[ries]++;
					}
				}
			}


			var ctx = document.getElementById("chart").getContext("2d");
	var myChart = new Chart(ctx, {
				type: 'bar',
				width: 200,
				height: 200,
				data: {
					labels: labels,
					datasets: [{
						data: data,
						backgroundColor: '#AAAAAA'
					}]
				},
				options: {
					legend: {
						display: false
					},
					scales: {
						xAxes: [{
							gridLines: {
								display: false
							},
							scaleLabel: {
								display: true,
								labelString: 'Punkte'
							}
						}],
						yAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Anzahl'
							},
							ticks: {
								min: 0,
								suggestedMax: 30,
								stepSize: 5
							}
						}]
					}
				}
			});
		}

		function drawPunkteChart(results) {
			var data = [];
			var labels = [];

			results.forEach(function (row) {
				for (var i = 0; i < 8; i++) {
					var p = row['ries' + (i + 1)];
					if (p > 0 || p === 0) {
						data.push(p);
						var hdate = row.datum.substr(8, 2) + '.' + row.datum.substr(5, 2) + '.' + row.datum.substr(0, 4);
						labels.push([hdate, row.art, row.gegner, (i + 1) + '. Ries']);
					}
				}
			})

			var ctx = document.getElementById("chart").getContext("2d");
	var myChart = new Chart(ctx, {
				type: 'line',
				width: 200,
				height: 200,
				data: {
					labels: labels,
					datasets: [{
						data: data,
						fill: false,
						pointRadius: 6,
						pointHoverRadius: 8,
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
					displayedResults = results;
					showData(results);
				});
			}
			else {
				showData([]);
			}
		}

		function showData(results) {
			dataList.clear();

			//remove total rows
			var tfoot = document.getElementById('hg_data').getElementsByTagName('tfoot')[0];
			while (tfoot.firstChild) {
				tfoot.removeChild(tfoot.firstChild);
			}

			if (results.length === 0) {
				document.getElementById('hg_data').style.display = 'none';
				return;
			}
			document.getElementById('hg_data').style.display = '';

			var totalRies = [];
			var totalPunkte = 0;
			var totalStreiche = 0;
			var i;
			for (i = 0; i < 8; i++) {
				totalRies.push(0);
			}

			results.forEach(function (row) {
				if (row.punkte) {
					totalPunkte += row.punkte;
				}
				if (row.streiche) {
					totalStreiche += row.streiche;
				}
				if (row.schnitt) {
					row.schnitt = row.schnitt.toFixed(2);
				}
				if (row.schnittKumuliert) {
					row.schnittKumuliert = row.schnittKumuliert.toFixed(2);
				}
				row.datumDisplay = row.datum.substring(8, 10) + '.' + row.datum.substring(5, 7) + '.' + row.datum.substring(0, 4);
				for (var i = 0; i < 8; i++) {
					if (row['ries' + (i + 1)]) {
						totalRies[i] += row['ries' + (i + 1)];
					}
				}
			});
			dataList.add(results);
			dataList.sort('datum', { order: "asc" });

			var totalRow = document.getElementById('hg_total_tr').cloneNode(true);
			for (var ie = 0; ie < 8; ie++) {
				if (totalRies[ie] > 0) {
					totalRow.querySelector(".total_ries" + (ie + 1)).textContent = totalRies[ie];
				}
			}
			totalRow.querySelector(".total_punkte").textContent = totalPunkte;
			totalRow.querySelector(".total_streiche").textContent = totalStreiche;

			if (totalPunkte && totalStreiche) {
				var schnitt = (totalPunkte / totalStreiche).toFixed(2);
				totalRow.querySelector(".total_schnitt").textContent = schnitt;
			}

			tfoot.appendChild(totalRow);
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

	#hg_calc_label {
		margin-left: 55px;
	}

	#hg_jahrSelect,
	#hg_spielerSelect,
	#hg_alle,
	#hg_alle input {
		vertical-align: top;
	}

	#hg_data tbody tr:nth-child(odd) {
		background-color: #ebeff4;
	}

	#hg_data tr {
		text-align: left;
	}

	#hg_data th {
		cursor: default;
	}

	#hg_data .hg_number {
		text-align: right;
		padding-right: 5px;
	}

	#hg_data td {
		width: 40px;
		white-space: nowrap;
	}

	#hg_data td.art {
		width: 200px;
	}

	#hg_data td.gegner {
		width: 200px;
	}

	#hg_data .sort.asc::after {
		content: "\25b2";
	}

	#hg_data .sort.desc::after {
		content: "\25bc";
	}

	#hg_total_tr td {
		font-weight: bold;
	}
/*]]>*/
</style>
