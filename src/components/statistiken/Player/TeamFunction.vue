<template>
  
<select id="hg_teamSelect"></select>

<div id="spielerListe">
	<div class="list"></div>
</div>

</template>

<script lang="js">
import { onMounted,ref,  } from "vue";
import List from "../scripts/List.js";
import hgutil from "../scripts/hgutil.js";
import Chart from 'chart.js' 

export default {
  name: "TeamFunction",
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
		
		hgutil.loadSelectFromArray('https://www.hgverwaltung.ch/api/1/' + club + '/mannschaften?spiele=null', 'hg_teamSelect', true, getData);

		var template = [];
		template.push('<div class="rowSpieler">');
		template.push(' <img class="foto" src="">');
		template.push(' <div class="info">');
		template.push('   <h6><span class="nachname"></span>&nbsp;<span class="vorname"></span>&nbsp;<span class="jahrgang"></span></h6>');
		template.push('   <div class="detail">');
		template.push('     <div class="col">');
		template.push('        <span class="coldetail" style="width: 200px;">Position:</span><br><b class="position"></b>');
		template.push('        <br>');
		template.push('        <span class="coldetail" style="width: 200px;">Funktionen:</span><br><b class="funktionen"></b>');
		template.push('     </div>');
		template.push('     <div class="col">');
		template.push('        <span class="coldetail" style="width: 90px;">Ehrenmitglied:</span><br><b class="ehrenmitglied"></b>');
		template.push('        <br>');
		template.push('        <span class="coldetail" style="width: 90px;">Vorstand:</span><br><b class="vorstand"></b>');
		template.push('        <br>');
		template.push('        <span class="coldetail" style="width: 90px;">Schiedsrichter:</span><br><b class="schiedsrichter"></b>');
		template.push('     </div>');
		template.push('     <div class="col">');
		template.push('        <span class="coldetail" style="width: 90px;">Fremdspieler:</span><br><b class="fremdspieler"></b>');
		template.push('        <br>');
		template.push('        <span class="coldetail" style="width: 90px;">Aufgestellt:</span><br><b class="aufgestellt"></b>');
		template.push('     </div>');
		template.push('   </div>');
		template.push(' </div>');
		template.push('</div>');
		var options = {
			valueNames: ['nachname', 'vorname', 'jahrgang', 'position', 'funktionen',
				'ehrenmitglied', 'vorstand', 'schiedsrichter', 'fremdspieler', 'aufgestellt',
				{ attr: 'src', name: 'foto' }],
			item: template.join('')
		};

		var dataList = new List('spielerListe', options);

		document.getElementById('hg_teamSelect').addEventListener("change", getData);

		function getData() {
			var teams = Array.prototype.slice.call(document.querySelectorAll('#hg_teamSelect option:checked'), 0).map(function (v) {
				return v.value;
			});

			if (teams && teams.length > 0) {
				var url = 'https://www.hgverwaltung.ch/api/1/' + club + '/spieler?inklDetail=true&aufgestellteSpieler=false&mannschaft=' + teams.join(',').replace(/\//g,'--');
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
				document.getElementById('spielerListe').style.display = 'none';
				return;
			}
			document.getElementById('spielerListe').style.display = '';

			results.forEach(function (row) {
				if (row.funktionen) {
					row.funktionen = row.funktionen.replace(/, /g, '<br>');
				}
				
				if (row.foto) {
					row.foto = 'https://www.hgverwaltung.ch/api/1/' + club + '/spielerfoto/' + row.foto;
				}
				else {
					row.foto = 'data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=';
				}

				if (row.jahrgang) {
					row.jahrgang = '(' + row.jahrgang + ')';
				}
				
				
				if (row.ehrenmitglied) {
					row.ehrenmitglied = 'JA';
				}

				if (row.vorstand) {
					row.vorstand = 'JA';
				}

				if (row.schiedsrichter) {
					row.schiedsrichter = 'JA';
				}

				if (row.fremdspieler) {
					row.fremdspieler = 'JA';
				}

				if (row.aufgestellt) {
					row.aufgestellt = 'JA';
				}
				
			});

			dataList.add(results);
			dataList.sort('nachname', { order: "asc" });
		}

	

}


    return{
		loadStatistik,
    };
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style >
/* <![CDATA[ */body,
	#hg_teamSelect {
		width: 100%;
		font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
	}

	.rowSpieler h6 {
		font-size: 18px;
		margin-top: 2px;
		margin-left: 10px;
		margin-bottom: 0px;
		margin-right: 0px;
	}

	.rowSpieler h6 .jahrgang {
		font-size: 14px;
	}

	.rowSpieler {
		margin-top: 10px;
		margin-left: 5px;
		padding-bottom: 10px;
		display: flex;
		flex-direction: row;
		border-bottom: 1px dashed #ccc;
	}

	.rowSpieler img {
		align-self: flex-end;
		width: 100px;
	}

	.rowSpieler .info {
		align-self: flex-start;
	}

	.info .detail {
		font-size: 14px;
		display: flex;
		margin-top: 8px;
		margin-left: 10px;
	}

	.info .col {
		margin-right: 50px;
	}

	.coldetail {
		display: inline-block;
		color: #777;
		width: 110px;
	}
/*]]>*/
</style>
