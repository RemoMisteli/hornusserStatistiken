<template>
  <table id="hg_data" style="display: none">
    <thead>
      <tr>
        <th class="sort" data-sort="nachname">Nachname</th>
        <th class="sort" data-sort="vorname">Vorname</th>
        <th class="sort" data-sort="last3">
          Durchschnitt der letzten 3 <b>gespielten</b> Spiele
        </th>
      </tr>
    </thead>
    <tbody class="hg_list">
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </tbody>
  </table>

  <table style="display: none">
    <tr id="hg_tr_template">
      <td class="nachname"></td>
      <td class="vorname"></td>
      <td class="last3 hg_number"></td>
    </tr>
  </table>
</template>

<script lang="js">
import { onMounted,ref,  } from "vue";
import List from "../scripts/List.js";
import hgutil from "../scripts/hgutil.js";


export default {
  name: "AvrageTeamLastThreeGamedGames",
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
	var valueNames = [];
		var tdElements = document.getElementById('hg_tr_template').getElementsByTagName('td');
		for (var v = 0; v < tdElements.length; v++) {
			if (tdElements[v].classList.length > 0) {
				valueNames.push(tdElements[v].classList[0]);
			}
		}

		var options = {
			valueNames: valueNames,
			listClass: 'hg_list',
			item: 'hg_tr_template'
		};

		var dataList = new List('hg_data', options);

		getData();

		function getData(jahr=new Date().getFullYear()) {
			//var jahr = new Date().getFullYear();
			var url = 'https://www.hgverwaltung.ch/api/1/' + club + '/saisondurchschnittgespielt/A?alle=1&jahr=' + jahr + '&limite=3';

			fetch(url).then(function (response) {
				return response.json();
			}).then(function (results) {
				showData(results,jahr);
			});
		}

		function showData(results,jahr) {
			dataList.clear();

			if (results.spieler.length === 0) {
				document.getElementById('hg_data').style.display = 'none';
				getData(jahr-1);
				return;
			}
			document.getElementById('hg_data').style.display = '';

			results.spieler.forEach(function (row) {
				if (row.schnitt[0]) {
					row.last3 = row.schnitt[0].toFixed(2);
				}
			});
			dataList.add(results.spieler);

			//sortierung nach letzer column
			dataList.sort('last3', { order: "desc" });
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
#hg_data {
  width: 100%;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica,
    Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
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
