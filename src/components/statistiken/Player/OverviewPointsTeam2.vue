<template>
 
<select id="hg_teamSelect" size="3" multiple></select>
<select id="hg_jahrSelect"></select>
<span id="hg_alle">
	<input type="radio" name="alle" value="1" checked>Alle Spiele
	<input type="radio" name="alle" value="0">Nur Meisterschaft
</span>

<table id="hg_data" style="display: none;">
	<thead>
		<tr>
			<th class="sort" data-sort="nachname">Nachname</th>
			<th class="sort" data-sort="vorname">Vorname</th>
			<th class="sort hg_number" data-sort="s0">0</th>
			<th class="sort hg_number" data-sort="s1">1</th>
			<th class="sort hg_number" data-sort="s2">2</th>
			<th class="sort hg_number" data-sort="s3">3</th>
			<th class="sort hg_number" data-sort="s4">4</th>
			<th class="sort hg_number" data-sort="s5">5</th>
			<th class="sort hg_number" data-sort="s6">6</th>
			<th class="sort hg_number" data-sort="s7">7</th>
			<th class="sort hg_number" data-sort="s8">8</th>
			<th class="sort hg_number" data-sort="s9">9</th>
			<th class="sort hg_number" data-sort="s10">10</th>
			<th class="sort hg_number" data-sort="s11">11</th>
			<th class="sort hg_number" data-sort="s12">12</th>
			<th class="sort hg_number" data-sort="s13">13</th>
			<th class="sort hg_number" data-sort="s14">14</th>
			<th class="sort hg_number" data-sort="s15">15</th>
			<th class="sort hg_number" data-sort="s16">16</th>
			<th class="sort hg_number" data-sort="s17">17</th>
			<th class="sort hg_number" data-sort="s18">18</th>
			<th class="sort hg_number" data-sort="s19">19</th>
			<th class="sort hg_number" data-sort="s20">20</th>
			<th class="sort hg_number" data-sort="s21">21</th>
			<th class="sort hg_number" data-sort="s22">22</th>
			<th class="sort hg_number" data-sort="s23">23</th>
			<th class="sort hg_number" data-sort="s24">24</th>
			<th class="sort hg_number" data-sort="s25">25</th>
			<th class="sort hg_number" data-sort="s26">26</th>
			<th class="sort hg_number" data-sort="s27">27</th>
			<th class="sort hg_number" data-sort="s28">28</th>
			<th class="sort hg_number" data-sort="s29">29</th>
			<th class="sort hg_number" data-sort="s30">30</th>
			<th class="sort hg_number" data-sort="streiche">Streiche</th>
			<th class="sort hg_number" data-sort="punkte">Punkte</th>
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
		<td class="nachname"></td>
		<td class="vorname"></td>
		<td class="s0 hg_number"></td>
		<td class="s1 hg_number"></td>
		<td class="s2 hg_number"></td>
		<td class="s3 hg_number"></td>
		<td class="s4 hg_number"></td>
		<td class="s5 hg_number"></td>
		<td class="s6 hg_number"></td>
		<td class="s7 hg_number"></td>
		<td class="s8 hg_number"></td>
		<td class="s9 hg_number"></td>
		<td class="s10 hg_number"></td>
		<td class="s11 hg_number"></td>
		<td class="s12 hg_number"></td>
		<td class="s13 hg_number"></td>
		<td class="s14 hg_number"></td>
		<td class="s15 hg_number"></td>
		<td class="s16 hg_number"></td>
		<td class="s17 hg_number"></td>
		<td class="s18 hg_number"></td>
		<td class="s19 hg_number"></td>
		<td class="s20 hg_number"></td>
		<td class="s21 hg_number"></td>
		<td class="s22 hg_number"></td>
		<td class="s23 hg_number"></td>
		<td class="s24 hg_number"></td>
		<td class="s25 hg_number"></td>
		<td class="s26 hg_number"></td>
		<td class="s27 hg_number"></td>
		<td class="s28 hg_number"></td>
		<td class="s29 hg_number"></td>
		<td class="s30 hg_number"></td>
		<td class="streiche hg_number"></td>
		<td class="punkte hg_number"></td>
	</tr>
	<tr id="hg_total_tr">
		<td colspan="2" class="total_label"></td>
		<td class="total_s0 hg_number"></td>
		<td class="total_s1 hg_number"></td>
		<td class="total_s2 hg_number"></td>
		<td class="total_s3 hg_number"></td>
		<td class="total_s4 hg_number"></td>
		<td class="total_s5 hg_number"></td>
		<td class="total_s6 hg_number"></td>
		<td class="total_s7 hg_number"></td>
		<td class="total_s8 hg_number"></td>
		<td class="total_s9 hg_number"></td>
		<td class="total_s10 hg_number"></td>
		<td class="total_s11 hg_number"></td>
		<td class="total_s12 hg_number"></td>
		<td class="total_s13 hg_number"></td>
		<td class="total_s14 hg_number"></td>
		<td class="total_s15 hg_number"></td>
		<td class="total_s16 hg_number"></td>
		<td class="total_s17 hg_number"></td>
		<td class="total_s18 hg_number"></td>
		<td class="total_s19 hg_number"></td>
		<td class="total_s20 hg_number"></td>
		<td class="total_s21 hg_number"></td>
		<td class="total_s22 hg_number"></td>
		<td class="total_s23 hg_number"></td>
		<td class="total_s24 hg_number"></td>
		<td class="total_s25 hg_number"></td>
		<td class="total_s26 hg_number"></td>
		<td class="total_s27 hg_number"></td>
		<td class="total_s28 hg_number"></td>
		<td class="total_s29 hg_number"></td>
		<td class="total_s30 hg_number"></td>
		<td></td>
		<td></td>
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
  name: "OverviewPointsTeam2",
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
		hgutil.loadSelectFromArray('https://www.hgverwaltung.ch/api/1/' + club + '/mannschaften?spiele=true', 'hg_teamSelect', true, getData);

		var hgDataTable = document.getElementById("hg_data");
		hgDataTable.createTFoot();

		document.getElementById('hg_jahrSelect').addEventListener("change", getData);
		document.getElementById('hg_teamSelect').addEventListener("change", getData);

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

		document.getElementById('hg_jahrSelect').addEventListener("change", getData);
		document.getElementById('hg_teamSelect').addEventListener("change", getData);
		var allRadios = document.getElementById('hg_alle').querySelectorAll("input");

		allRadios[0].addEventListener("change", getData);
		allRadios[1].addEventListener("change", getData);

		function getData() {
			var jahr = document.getElementById('hg_jahrSelect').value;
			var teams = Array.prototype.slice.call(document.querySelectorAll('#hg_teamSelect option:checked'), 0).map(function (v) {
				return v.value;
			});
			var alle = document.querySelector('#hg_alle input[name="alle"]:checked').value;

			if (jahr && teams && teams.length > 0) {
				var url = 'https://www.hgverwaltung.ch/api/1/' + club + '/durchschnitt/' + teams.join(',').replace(/\//g,'--') + '?alle=' + alle + '&streicheDetail=true&jahr=' + jahr;
				fetch(url).then(function (response) {
					return response.json();
				}).then(function (results) {
					var i = 0;
					for (var res of results) {
						res.id = i;
						i++;
					}
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

			var totals = [];
			for (var j = 0; j < 31; j++) {
				totals.push(0);
			}

			results.forEach(function (row) {
				for (var s = 0; s < 31; s++) {
					if (row.streicheDetail) {
						var sd = row.streicheDetail[s];
						if (sd !== 0) {
							row['s' + s] = sd;
							totals[s] += sd;
						}
					}
				}
			});
			dataList.add(results);

			//sortierung nach punkte
			dataList.sort('punkte', { order: "desc" });

			// total
			var totalRow = document.getElementById('hg_total_tr').cloneNode(true);
			totalRow.querySelector(".total_label").textContent = 'Total';
			for (var i = 0; i < totals.length; i++) {
				totalRow.querySelector(".total_s" + i).textContent = totals[i];
			}
			tfoot.appendChild(totalRow);


			addClicklistener('nachname');
			addClicklistener('vorname');

		}

		function addClicklistener(field) {
			var names = document.getElementsByClassName(field);
			var n = 0;
			for (; n < names.length; n++) {
				(function () {
					var row = n;
					if (dataList.items[row]) {
						var id = dataList.items[row]._values.id;
						names[n].addEventListener('click', function () {
							onSpielerClick(id)
						}, false);
					}
				})();
			}
		}

		function onSpielerClick(id) {
			showDiagram(dataList.get("id", id)[0]._values);
		}

		function showDiagram(result) {
			var modal = new tingle.modal({
				footer: false,
				stickyFooter: false,
				closeMethods: ['overlay', 'button', 'escape'],
				closeLabel: "Schliessen",
			});
			modal.setContent(createDiagramHtml(result));
			modal.open();
			drawChart(result);
		}

		function drawChart(results) {
			var data = results.streicheDetail;
			var labels = [];
			var i;

			for (i = 0; i <= 30; i++) {
				labels.push(i);
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
					title: {
						display: true,
						text: results.nachname + ' ' + results.vorname,
						fontSize: 14
					},
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

		function createDiagramHtml(result) {
			var html = [];

			html.push('<div id="chart-container" style="position: relative; width:100%">');
			html.push('<canvas id="chart"></canvas>');
			html.push('</div>');

			return html.join('');
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
	#hg_teamSelect,
	#hg_data,
	#hg_alle {
		width: 100%;
		font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
	}

	#hg_jahrSelect,
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
		width: 20px;
		white-space: nowrap;
	}

	#hg_data td.nachname {
		width: 200px;
		text-decoration: underline;
		text-decoration-color: gray;
	}

	#hg_data td.vorname {
		width: 200px;
		text-decoration: underline;
		text-decoration-color: gray;
	}

	#hg_data td.punkte {
		font-weight: bold;
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
