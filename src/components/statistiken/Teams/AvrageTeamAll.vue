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
			<th colspan="2"></th>
			<th colspan="8">Ries</th>
			<th colspan="2"></th>
			<th colspan="3">Durchschnitt</th>
			<th></th>
			<th colspan="2">Streich</th>
			<th colspan="2">Spieldurchschnitt</th>
			<th colspan="2" id="hg_rangpunkte_title">Rangpunkte</th>
		</tr>
		<tr>
			<th class="sort" data-sort="nachname">Nachname</th>
			<th class="sort" data-sort="vorname">Vorname</th>
			<th class="sort hg_number" data-sort="ries1Total">1</th>
			<th class="sort hg_number" data-sort="ries2Total">2</th>
			<th class="sort hg_number" data-sort="ries3Total">3</th>
			<th class="sort hg_number" data-sort="ries4Total">4</th>
			<th class="sort hg_number" data-sort="ries5Total">5</th>
			<th class="sort hg_number" data-sort="ries6Total">6</th>
			<th class="sort hg_number" data-sort="ries7Total">7</th>
			<th class="sort hg_number" data-sort="ries8Total">8</th>
			<th class="sort hg_number" data-sort="punkte">Punkte</th>
			<th class="sort hg_number" data-sort="streiche">Streiche</th>
			<th class="sort hg_number" data-sort="schnitt">Selektiertes&nbsp;Jahr</th>
			<th class="sort hg_number" data-sort="schnittVorjahr">Vorjahr</th>
			<th class="sort hg_number" data-sort="diff">Ver&auml;nderung</th>
			<th class="sort hg_number" data-sort="stdAbw">Std.&nbsp;Abw.</th>
			<th class="sort hg_number" data-sort="laengsterStreich">L&auml;ngster</th>
			<th class="sort hg_number" data-sort="kuerzesterStreich">K&uuml;rzester</th>
			<th class="sort hg_number" data-sort="hoechsterSpielSchnitt">H&ouml;chster</th>
			<th class="sort hg_number" data-sort="tiefsterSpielSchnitt">Tiefster</th>
			<th id="hg_rangpunkte_header" class="sort hg_number" data-sort="rangpunkte">Selektiertes&nbsp;Jahr</th>
			<th id="hg_rangpunktevorjahr_header" class="sort hg_number" data-sort="rangpunkteVorjahr">Vorjahr</th>
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
		</tr>
	</tfoot>
</table>

<table style="display: none;">
	<tr id="hg_tr_template">
		<td class="nachname"></td>
		<td class="vorname"></td>
		<td class="ries1Total hg_number"></td>
		<td class="ries2Total hg_number"></td>
		<td class="ries3Total hg_number"></td>
		<td class="ries4Total hg_number"></td>
		<td class="ries5Total hg_number"></td>
		<td class="ries6Total hg_number"></td>
		<td class="ries7Total hg_number"></td>
		<td class="ries8Total hg_number"></td>
		<td class="punkte hg_number"></td>
		<td class="streiche hg_number"></td>
		<td class="schnitt hg_number"></td>
		<td class="schnittVorjahr hg_number"></td>
		<td class="diff hg_number"></td>
		<td class="stdAbw hg_number"></td>
		<td class="laengsterStreich hg_number"></td>
		<td class="kuerzesterStreich hg_number"></td>
		<td class="hoechsterSpielSchnitt hg_number"></td>
		<td class="tiefsterSpielSchnitt hg_number"></td>
		<td class="rangpunkte hg_number"></td>
		<td class="rangpunkteVorjahr hg_number"></td>
	</tr>
	<tr id="hg_total_tr">
		<td colspan="2" class="total_label"></td>
		<td class="total_ries1Total hg_number"></td>
		<td class="total_ries2Total hg_number"></td>
		<td class="total_ries3Total hg_number"></td>
		<td class="total_ries4Total hg_number"></td>
		<td class="total_ries5Total hg_number"></td>
		<td class="total_ries6Total hg_number"></td>
		<td class="total_ries7Total hg_number"></td>
		<td class="total_ries8Total hg_number"></td>
		<td class="total_punkte hg_number"></td>
		<td class="total_streiche hg_number"></td>
		<td class="total_schnitt hg_number"></td>
		<td colspan="6"></td>
		<td class="total_rangpunkte hg_number" id="hg_rangpunkte_footer"></td>
		<td class="total_rangpunkteVorjahr hg_number" id="hg_rangpunktevorjahr_footer"></td>
	</tr>
</table>

</template>

<script lang="js">
import { onMounted,ref,  } from "vue";
import List from "../scripts/List.js";
import hgutil from "../scripts/hgutil.js";


export default {
  name: "AvrageTeamAll",
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

		var valueNames = [];
		var tdElements = document.getElementById('hg_tr_template').getElementsByTagName('td');
		for (var v = 0; v < tdElements.length; v++) {
			valueNames.push(tdElements[v].classList[0]);
		}
		
		var options = {
			valueNames: valueNames,
			listClass: 'hg_list',
			item: 'hg_tr_template',
			sortFunction: hgutil.sortFunction
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
				var url = 'https://www.hgverwaltung.ch/api/1/' + club + '/durchschnitt/' + teams.join(',').replace(/\//g,'--') + '?alle=' + alle + '&jahr=' + jahr;
				fetch(url).then(function (response) {
					return response.json();
				}).then(function (results) {
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

			var totalPunkte = 0;
			var totalStreiche = 0;
			var totalRp = 0;
			var totalRpVorjahr = 0;
			var totalRies = [];
			for (i = 0; i < 8; i++) {
				totalRies.push(0);
			}

			results.forEach(function (row) {
				if (row.schnitt && row.schnittVorjahr) {
					row.diff = (parseFloat(row.schnitt) - parseFloat(row.schnittVorjahr)).toFixed(2);
				}

				if (row.schnitt) {
					row.schnitt = row.schnitt.toFixed(2);
				}

				if (row.schnittVorjahr) {
					row.schnittVorjahr = row.schnittVorjahr.toFixed(2);
				}

				if (row.hoechsterSpielSchnitt) {
					row.hoechsterSpielSchnitt = row.hoechsterSpielSchnitt.toFixed(2);
				}

				if (row.tiefsterSpielSchnitt) {
					row.tiefsterSpielSchnitt = row.tiefsterSpielSchnitt.toFixed(2);
				}

				if (row.stdAbw) {
					row.stdAbw = row.stdAbw.toFixed(3);
				}

				if (row.streiche) {
					totalStreiche += row.streiche;
				}

				if (row.punkte) {
					totalPunkte += row.punkte;
				}

				if (row.rangpunkte) {
					totalRp += row.rangpunkte;
				}

				if (row.rangpunkteVorjahr) {
					totalRpVorjahr += row.rangpunkteVorjahr;
				}

				for (i = 0; i < 8; i++) {
					if (row['ries' + (i + 1) + 'Total']) {
						totalRies[i] += row['ries' + (i + 1) + 'Total'];
					}
				}
			});
			dataList.add(results);

			// css class 'negative' und 'positive' in der diff spalte hinzufügen
			var i = 0;
			var diffTds = document.getElementById('hg_data').querySelectorAll('td.diff');
			for (; i < diffTds.length; i++) {
				var diffTd = diffTds[i];
				var value = parseFloat(diffTd.textContent);
				if (value >= 0) {
					diffTd.classList.add('positive');
				}
				else if (value < 0) {
					diffTd.classList.add('negative');
				}
			}

			//sortierung nach schnitt
			dataList.sort('schnitt', { order: "desc" });

			// mannschaftstotal
			if (totalStreiche > 0) {
				var totalRow = document.getElementById('hg_total_tr').cloneNode(true);
				totalRow.querySelector(".total_label").textContent = 'Mannschaftstotal';
				totalRow.querySelector(".total_punkte").textContent = totalPunkte;
				totalRow.querySelector(".total_streiche").textContent = totalStreiche;
				totalRow.querySelector(".total_schnitt").textContent = (totalPunkte / totalStreiche).toFixed(2);
				totalRow.querySelector(".total_rangpunkte").textContent = totalRp;
				totalRow.querySelector(".total_rangpunkteVorjahr").textContent = totalRpVorjahr;

				for (i = 0; i < 8; i++) {
					if (totalRies[i] > 0) {
						totalRow.querySelector(".total_ries" + (i + 1) + "Total").textContent = totalRies[i];
					}
				}

				tfoot.appendChild(totalRow);
			}

			// rangpunkte verstecken wenn nachwuchs
			var teams = Array.prototype.slice.call(document.querySelectorAll('#hg_teamSelect option:checked'), 0).map(function (v) {
				return v.value;
			});
			if (teams.length === 1 && teams[0] === 'NW') {
				document.getElementById('hg_rangpunkte_header').style.display = 'none';
				document.getElementById('hg_rangpunktevorjahr_header').style.display = 'none';
				document.getElementById('hg_rangpunkte_footer').style.display = 'none';
				document.getElementById('hg_rangpunktevorjahr_footer').style.display = 'none';
				document.getElementById('hg_rangpunkte_title').style.display = 'none';

				var rangpunkteTds = document.getElementById('hg_data').querySelectorAll("td.rangpunkte");
				for (i = 0; i < rangpunkteTds.length; i++) {
					rangpunkteTds[i].style.display = 'none';
				}

				rangpunkteTds = document.getElementById('hg_data').querySelectorAll("td.rangpunkteVorjahr");
				for (i = 0; i < rangpunkteTds.length; i++) {
					rangpunkteTds[i].style.display = 'none';
				}
			}
			else {
				document.getElementById('hg_rangpunkte_header').style.display = '';
				document.getElementById('hg_rangpunktevorjahr_header').style.display = '';
				document.getElementById('hg_rangpunkte_footer').style.display = '';
				document.getElementById('hg_rangpunktevorjahr_footer').style.display = '';
				document.getElementById('hg_rangpunkte_title').style.display = '';
			}
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
		width: 40px;
		white-space: nowrap;
	}

	#hg_data td.nachname {
		width: 200px;
	}

	#hg_data td.vorname {
		width: 200px;
	}

	#hg_data td.diff.positive {
		background-color: lightgreen;
	}

	#hg_data td.diff.negative {
		background-color: lightcoral;
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
