<template>

<select id="hg_teamSelect" size="3" multiple></select>
<select id="hg_jahrSelect"></select>
<span id="hg_alle">
	<input type="radio" name="alle" value="1" checked>Alle Spiele
	<input type="radio" name="alle" value="0">Nur Meisterschaft
</span>

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
  name: "TeamData",
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


		var template = [];
		template.push('<div class="rowSpieler">');
		template.push(' <img class="foto" src="">');
		template.push(' <div class="info">');
		template.push('   <h6><span class="nachname"></span>&nbsp;<span class="vorname"></span>&nbsp;<span class="jahrgang"></span></h6>');
		template.push('   <div class="detail">');
		template.push('     <div class="col">');
		template.push('        <span class="coldetail" style="width: 55px;">Punkte:</span><br><b class="punkte"></b>');		
		template.push('        <br>');
		template.push('        <span class="coldetail" style="width: 55px;">Streiche:</span><br><b class="streiche"></b>');
		template.push('     </div>');
		template.push('     <div class="col">');
		template.push('        <span class="coldetail" style="width: 90px;">Durchschnitt:</span><br><b class="schnitt"></b>');
		template.push('        <br>');
		template.push('        <span class="coldetail" style="width: 90px;">Vorjahr:</span><br><b class="schnittVorjahr"></b>');
		template.push('        <br>');
		template.push('        <span class="coldetail" style="width: 90px;">Ver&auml;nderung:</span><br><b class="diff"></b>');
		template.push('     </div>');
		template.push('     <div class="col">');
		template.push('        <span class="coldetail" style="width: 110px;">Std. Abw.:</span><br><b class="stdAbw"></b>');
		template.push('        <br>');		
		template.push('        <span class="coldetail" style="width: 110px;">L&auml;ngster&nbsp;Streich:</span><br><b class="laengsterStreich"></b>');
		template.push('        <br>');
		template.push('        <span class="coldetail" style="width: 110px;">K&uuml;rzester&nbsp;Streich:</span><br><b class="kuerzesterStreich"></b>');
		template.push('     </div>');
		template.push('     <div class="col">');
		template.push('        <span class="coldetail" style="width: 170px;">H&ouml;chster&nbsp;Spieldurchschnitt:</span><br><b class="hoechsterSpielSchnitt"></b>');
		template.push('        <br>');
		template.push('        <span class="coldetail" style="width: 170px;">Tiefster&nbsp;Spieldurchschnitt:</span><br><b class="tiefsterSpielSchnitt"></b>');
		template.push('     </div>');
		template.push('     <div class="col">');
		template.push('        <span class="coldetail" style="width: 80px;">Rangpunkte:</span><br><b class="rangpunkte"></b>');
		template.push('        <br>');
		template.push('        <span class="coldetail" style="width: 80px;">Vorjahr:</span><br><b class="rangpunkteVorjahr"></b>');
		template.push('     </div>');
		template.push('   </div>');
		template.push(' </div>');
		template.push('</div>');
		var options = {
			valueNames: ['nachname', 'vorname', 'jahrgang', 'punkte', 'streiche',
				'schnitt', 'schnittVorjahr', 'diff', 'laengsterStreich', 'kuerzesterStreich',
				'hoechsterSpielSchnitt', 'tiefsterSpielSchnitt', 'stdAbw',
				'rangpunkte', 'rangpunkteVorjahr',
				{ attr: 'src', name: 'foto' }],
			item: template.join('')
		};

		var dataList = new List('spielerListe', options);

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
				var url = 'https://www.hgverwaltung.ch/api/1/' + club + '/durchschnitt/' + teams.join(',').replace(/\//g,'--') + '?inklFoto=true&alle=' + alle + '&jahr=' + jahr;
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
				if (row.foto) {
					row.foto = 'https://www.hgverwaltung.ch/api/1/' + club + '/spielerfoto/' + row.foto;
				}
				else {
					row.foto = 'data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=';
				}

				if (row.jahrgang) {
					row.jahrgang = '(' + row.jahrgang + ')';
				}

				if (row.schnitt && row.schnittVorjahr) {
					row.diff = (parseFloat(row.schnitt) - parseFloat(row.schnittVorjahr)).toFixed(2);
				}

				if (row.schnitt) {
					row.schnitt = row.schnitt.toFixed(2);
				}

				if (row.schnittVorjahr) {
					row.schnittVorjahr = row.schnittVorjahr.toFixed(2);
				}

				if (row.stdAbw) {
					row.stdAbw = row.stdAbw.toFixed(3);
				}				

				if (row.hoechsterSpielSchnitt) {
					row.hoechsterSpielSchnitt = row.hoechsterSpielSchnitt.toFixed(2);
				}

				if (row.tiefsterSpielSchnitt) {
					row.tiefsterSpielSchnitt = row.tiefsterSpielSchnitt.toFixed(2);
				}
			});

			dataList.add(results);
			//sortierung nach schnitt
			dataList.sort('schnitt', { order: "desc" });
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
/* <![CDATA[ */
	body,
	#hg_jahrSelect,
	#hg_teamSelect,
	#hg_alle {
		width: 100%;
		font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
	}

	#hg_jahrSelect,
	#hg_alle,
	#hg_alle input {
		vertical-align: top;
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
		margin-right: 40px;
	}

	.coldetail {
		display: inline-block;
		color: #777;
		width: 110px;
	}
/*]]>*/
</style>
