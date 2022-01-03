<template>
  <select id="hg_jahrSelect"></select>
  <span id="hg_inklSpiele">
    <input type="radio" name="inklSpiele" value="0" checked />Nur Anl&auml;sse
    <input type="radio" name="inklSpiele" value="1" />Anl&auml;sse + Spiele
  </span>
  <table id="hg_data" style="display: none">
    <thead>
      <tr>
        <th class="sort" data-sort="datum">Start</th>
        <th class="sort" data-sort="zeit">Zeit</th>
        <th class="sort" data-sort="ende">Ende</th>
        <th class="sort" data-sort="endeZeit">Zeit</th>
        <th class="sort" data-sort="art">Anlass</th>
        <th class="sort" data-sort="team">Mann.</th>
        <th class="sort" data-sort="ort">Ort</th>
        <th class="sort" data-sort="ha">H/A</th>
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
      </tr>
    </tfoot>
  </table>

  <table style="display: none">
    <tr id="hg_tr_template">
      <td class="datumDisplay"></td>
      <td class="zeit"></td>
      <td class="endeDisplay"></td>
      <td class="endeZeit"></td>
      <td class="anlass"></td>
      <td class="team"></td>
      <td class="ort"></td>
      <td class="ha"></td>
    </tr>
  </table>
</template>

<script lang="js">
import { onMounted,ref,  } from "vue";
import List from "../scripts/List.js";
import hgutil from "../scripts/hgutil.js";


export default {
  name: "DatesSaison",
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
		var aktuellesJahr = (new Date()).getFullYear();
		var jahrSelect = document.getElementById('hg_jahrSelect');
	//Remo Delete alredy existing options
	var oldOptions = document.getElementsByClassName('option');
	
	if(oldOptions.length>0){
		oldOptions.forEach(option => {
			option.innerHTML='';
		});
	}
//
		var	option = document.createElement("option");
		option.text = aktuellesJahr -1;
		option.value = aktuellesJahr -1;
		option.classList.add('option');
		jahrSelect.appendChild(option);

		option = document.createElement("option");
		option.text = aktuellesJahr;
		option.value = aktuellesJahr;
		option.classList.add('option');
		jahrSelect.appendChild(option);

		option = document.createElement("option");
		option.text = aktuellesJahr + 1;
		option.value = aktuellesJahr + 1;
		option.classList.add('option');
		jahrSelect.appendChild(option);

	


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

		var allRadios = document.getElementById('hg_inklSpiele').querySelectorAll("input");
		allRadios[0].addEventListener("change", getData);
		allRadios[1].addEventListener("change", getData);

		getData();

		function getData() {
			var jahr = document.getElementById('hg_jahrSelect').value;
			var inklSpiele = document.querySelector('#hg_inklSpiele input[name="inklSpiele"]:checked').value;

			if (jahr) {
				var url = 'https://www.hgverwaltung.ch/api/1/' + club + '/anlaesse/?jahr=' + jahr + '&inklSpiele=' + inklSpiele;
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

			if (results.length === 0) {
				document.getElementById('hg_data').style.display = 'none';
				return;
			}
			document.getElementById('hg_data').style.display = '';

			results.forEach(function (row) {
				row.datumDisplay = row.datum.substring(8, 10) + '.' + row.datum.substring(5, 7) + '.' + row.datum.substring(0, 4);
				var z = row.datum.substring(11);
				if (!row.ganzerTag) {
					row.zeit = z;
				}
				else {
					row.zeit = null;
				}
				if (row.ende) {
					row.endeDisplay = row.ende.substring(8, 10) + '.' + row.ende.substring(5, 7) + '.' + row.ende.substring(0, 4);
					var ze = row.ende.substring(11);
					if (!row.ganzerTag) {
						row.endeZeit = ze;
					}
					else {
						row.endeZeit = null;
					}
				}
			});
			dataList.add(results);

			dataList.sort('datum', { order: "asc" });
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
#hg_inklSpiele,
#hg_data {
  width: 100%;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica,
    Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
}

#hg_jahrSelect,
#hg_inklSpiele {
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

#hg_data td,
#hg_data th {
  padding-left: 3px;
  padding-right: 10px;
}

#hg_data .sort.asc::after {
  content: "\25b2";
}

#hg_data .sort.desc::after {
  content: "\25bc";
}
/*]]>*/
</style>
