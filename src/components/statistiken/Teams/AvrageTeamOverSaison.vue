<template>

<select id="hg_teamSelect" size="3" multiple></select>
<select id="hg_jahrSelect"></select>
<span id="hg_alle">
	<input type="radio" name="alle" value="1" checked>Alle Spiele
	<input type="radio" name="alle" value="0">Nur Meisterschaft
</span>
<span id="hg_fortlaufend">
	<input type="checkbox" checked>Fortlaufende Berechnung
</span>
<span id="hg_anzahl">
	Anzahl Spiele:
	<input type="hg_number" min="1" max="999">
</span>

<table id="hg_data" style="display: none;">
	<thead>
		<tr>
			<th>&nbsp;</th>
		</tr>		
	</thead>
	<tbody class="hg_list" id="hg_list">
		<tr>
			<td>&nbsp;</td>
		</tr>		
	</tbody>
</table>

<table style="display: none;">
	<tr id="hg_tr_template">
	</tr>
</table>
</template>

<script lang="js">
import { onMounted,ref,  } from "vue";
import List from "../scripts/List.js";
import hgutil from "../scripts/hgutil.js";


export default {
  name: "AvrageTeamOverSaison",
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
		hgDataTable.createTHead();

		document.getElementById('hg_jahrSelect').addEventListener("change", getData);
		document.getElementById('hg_teamSelect').addEventListener("change", getData);
		var allRadios = document.getElementById('hg_alle').querySelectorAll("input");
		allRadios[0].addEventListener("change", getData);
		allRadios[1].addEventListener("change", getData);

		var fortlaufendCB = document.getElementById('hg_fortlaufend').querySelectorAll("input");
		fortlaufendCB[0].addEventListener("change", getData);

		var anzahlTf = document.getElementById('hg_anzahl').querySelectorAll("input");
		anzahlTf[0].addEventListener("change", getData);

		function getData() {
			var jahr = document.getElementById('hg_jahrSelect').value;
			var teams = Array.prototype.slice.call(document.querySelectorAll('#hg_teamSelect option:checked'), 0).map(function (v) {
				return v.value;
			});
			var alle = document.querySelector('#hg_alle input[name="alle"]:checked').value;
			var fortlaufend = document.querySelector('#hg_fortlaufend input:checked') !== null;
			var anzahl = document.querySelector('#hg_anzahl input').value;

			if (jahr && teams && teams.length > 0) {
				var url = 'https://www.hgverwaltung.ch/api/1/' + club + '/saisondurchschnitt/' + teams.join(',').replace(/\//g,'--') + '?alle=' + alle + '&jahr=' + jahr + '&fortlaufend=' + fortlaufend;
				if (anzahl) {
					url += '&limite=' + anzahl;
				}
				fetch(url).then(function (response) {
					return response.json();
				}).then(function (results) {
					showData(results);
				});
			}
			else {
				showData({ spieler: [], spielInfos: [] });
			}
		}

		function getHeader(spielInfos) {
			var code = [];

			code.push('<tr>');
			code.push('<th class="sort" data-sort="nachname">Nachname</th>');
			code.push('<th class="sort" data-sort="vorname">Vorname</th>');
			for (var i = 0; i < spielInfos.length; i++) {
				code.push('<th class="sort hg_number" data-sort="spiel_' + (i + 1) + '"><span class="hint--top" aria-label="' + spielInfos[i].gegner + '">' + spielInfos[i].datum + '</span></th>');
			}
			code.push('</tr>');

			return code.join('');
		}

		function getTemplateRow(len) {
			var code = [];
			code.push('<td class="nachname"></td>');
			code.push('<td class="vorname"></td>');

			for (var i = 0; i < len; i++) {
				code.push('<td class="spiel_' + (i + 1) + ' hg_number"></td>');
			}

			return code.join('');
		}

		function showData(results) {
			//remove datatable content
			var thead = document.getElementById('hg_data').getElementsByTagName('thead')[0];
			while (thead.firstChild) {
				thead.removeChild(thead.firstChild);
			}
			var tbody = document.getElementById('hg_data').getElementsByTagName('tbody')[0];
			while (tbody.firstChild) {
				tbody.removeChild(tbody.firstChild);
			}

			if (results.spielInfos.length === 0) {
				document.getElementById('hg_data').style.display = 'none';
				return;
			}
			document.getElementById('hg_data').style.display = '';

			thead.innerHTML = getHeader(results.spielInfos);

			var templateRow = document.getElementById('hg_tr_template');
			templateRow.innerHTML = getTemplateRow(results.spielInfos.length);

			results.spieler.forEach(function (row) {
				for (var i = 0; i < results.spielInfos.length; i++) {
					if (row.schnitt && row.schnitt[i]) {
						var schnitt = row.schnitt[i];
						if (schnitt) {
							row['spiel_' + (i + 1)] = schnitt.toFixed(2);
						}
					}
				}
			});


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
			dataList.add(results.spieler);

			// css class 'minus' und 'plus' hinzufügen
			var i = 0;
			var srows = document.getElementById('hg_list').querySelectorAll('tr');
			for (; i < srows.length; i++) {
				var srow = srows[i];
				var tds = srow.querySelectorAll('.hg_number');
				var lastValue, value;
				if (tds.length >= 1) {
					lastValue = parseFloat(tds[0].textContent);
				}
				for (var j = 1; j < tds.length; j++) {
					if (tds[j].textContent !== '') {
						value = parseFloat(tds[j].textContent);
						if (value >= lastValue) {
							tds[j].classList.add('plus');
						}
						else if (value < lastValue) {
							tds[j].classList.add('minus');
						}
						lastValue = value;
					}
				}
			}

			//sortierung nach letzer column
			dataList.sort('spiel_' + results.spielInfos.length, { order: "desc" });

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
	#hg_fortlaufend,
	#hg_anzahl,
	#hg_alle {
		width: 100%;
		font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
	}

	#hg_jahrSelect,
	#hg_alle,
	#hg_anzahl,
	#hg_anzahl input,
	#hg_fortlaufend,
	#hg_fortlaufend input,
	#hg_alle input {
		vertical-align: top;
	}

	#hg_fortlaufend {
		margin-left: 20px;
	}

	#hg_anzahl {
		margin-left: 20px;
	}

	#hg_data tbody tr:nth-child(odd) {
		background-color: #ebeff4;
	}

	#hg_data td.hg_number.plus {
		background-color: lightgreen;
	}

	#hg_data td.hg_number.minus {
		background-color: lightcoral;
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

	#hg_data td.nachname {
		width: 200px;
	}

	#hg_data td.vorname {
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
