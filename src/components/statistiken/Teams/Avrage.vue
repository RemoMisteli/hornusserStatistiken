<template>
<select id="hg_teamSelect"></select>
<select id="hg_jahrSelect"></select>
<span id="hg_alle">
	<input type="radio" name="alle" value="1" checked>Alle Spiele
	<input type="radio" name="alle" value="0">Nur Meisterschaft
</span>

<table id="hg_data" style="display: none;">
	<thead>
		<tr>
			<th colspan="3"></th>
			<th colspan="8">Ries</th>
			<th colspan="3">Spiel</th>
			<th colspan="3">Kumuliert</th>
			<th colspan="2">Streich</th>
			<th colspan="3">Total</th>
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
			<th class="sort hg_number" data-sort="laengsterStreich">L&auml;ngster</th>
			<th class="sort hg_number" data-sort="kuerzesterStreich">K&uuml;rzester</th>
			<th class="sort hg_number" data-sort="hoechstesTotal">H&ouml;chstes</th>
			<th class="sort hg_number" data-sort="tiefstesTotal">Tiefstes</th>	
			<th class="sort hg_number" data-sort="punkteTotalSchnitt">Durchschnitt</th>	
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
		<td class="laengsterStreich hg_number"></td>
		<td class="kuerzesterStreich hg_number"></td>
		<td class="hoechstesTotal hg_number"></td>
		<td class="tiefstesTotal hg_number"></td>						
		<td class="punkteTotalSchnitt hg_number"></td>
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
		<td colspan="7"></td>
	</tr>
</table>

</template>

<script lang="js">
import { onMounted,ref,  } from "vue";
import List from "../scripts/List.js";
import hgutil from "../scripts/hgutil.js";


export default {
  name: "Avrages",
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
			var team = document.getElementById('hg_teamSelect').value;
			var alle = document.querySelector('#hg_alle input[name="alle"]:checked').value;

			if (jahr && team) {
				var url = 'https://www.hgverwaltung.ch/api/1/' + club + '/mannschaftsdurchschnitt/' + team + '?alle=' + alle + '&jahr=' + jahr;
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
				if (row.punkteTotalSchnitt) {
					row.punkteTotalSchnitt = row.punkteTotalSchnitt.toFixed(2);
				}

				row.datumDisplay = row.datum.substring(8, 10) + '.' + row.datum.substring(5, 7) + '.' + row.datum.substring(0, 4);
				for (i = 0; i < 8; i++) {
					if (row['ries' + (i + 1)]) {
						totalRies[i] += row['ries' + (i + 1)];
					}
				}
			});
			dataList.add(results);
			dataList.sort('datum', { order: "asc" });

			var totalRow = document.getElementById('hg_total_tr').cloneNode(true);
			for (i = 0; i < 8; i++) {
				if (totalRies[i] > 0) {
					totalRow.querySelector(".total_ries" + (i + 1)).textContent = totalRies[i];
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
	
	#hg_data td {
	    width: 40px;
		white-space: nowrap;
	}	

	#hg_data .hg_number {
		text-align: right;
		padding-right: 5px;
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
