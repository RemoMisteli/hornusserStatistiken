<template>


<select id="hg_teamSelect" size="3" multiple></select>
<select id="hg_jahrSelect"></select>

<table id="hg_data" style="display: none;">
	<thead>
		<tr>
			<th class="sort" data-sort="datum">Datum</th>
			<th class="sort" data-sort="zeit">Zeit</th>
			<th class="sort" data-sort="art">Anlass</th>
			<th class="sort" data-sort="team">Mannschaft</th>
			<th class="sort" data-sort="gegner">Gegner</th>
			<th class="sort" data-sort="spielort">Ort</th>
			<th class="sort" data-sort="totalNr">Nr</th>
			<th class="sort" data-sort="schlagPunkte">Punkte</th>
			<th class="sort" data-sort="totalNrGegner">Nr Gegner</th>
			<th class="sort" data-sort="schlagPunkteGegner">Punkte Gegner</th>
			<th></th>
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
		</tr>	
	</tfoot>
</table>

<table style="display: none;">
	<tr id="hg_tr_template">
		<td class="datumDisplay"></td>
		<td class="zeit"></td>
		<td class="art"></td>
		<td class="team"></td>
		<td class="gegner"></td>
		<td class="spielort"></td>
		<td class="totalNr hg_number"></td>
		<td class="schlagPunkte hg_number"></td>
		<td class="totalNrGegner hg_number"></td>
		<td class="schlagPunkteGegner hg_number"></td>
		<td>
			<a href="#" class="spiellistelink"></a>
		</td>
	</tr>
</table>



</template>

<script lang="js">
import { onMounted,ref,  } from "vue";
import List from "../scripts/List.js";
import hgutil from "../scripts/hgutil.js";
import tingle from "../scripts/tingle.js";



export default {
  name: "GameDatesSaisonWhitResultOpponentPopUp",
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
			if (tdElements[v].classList.length > 0) {
				valueNames.push(tdElements[v].classList[0]);
			}
		}
		valueNames.push({ data: ['id'] });
		valueNames.push('spiellistelink');

		var options = {
			valueNames: valueNames,
			listClass: 'hg_list',
			item: 'hg_tr_template'
		};

		var dataList = new List('hg_data', options);

		document.getElementById('hg_jahrSelect').addEventListener("change", getData);
		document.getElementById('hg_teamSelect').addEventListener("change", getData);

		function getData() {
			var jahr = document.getElementById('hg_jahrSelect').value;
			var teams = Array.prototype.slice.call(document.querySelectorAll('#hg_teamSelect option:checked'), 0).map(function (v) {
				return v.value;
			});

			if (jahr && teams && teams.length > 0) {
				var url = 'https://www.hgverwaltung.ch/api/1/' + club + '/spiele/' + teams.join(',').replace(/\//g,'--') + '?jahr=' + jahr;
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

			var now = Date.now();

			results.forEach(function (row) {
				row.datumDisplay = row.datum.substring(8, 10) + '.' + row.datum.substring(5, 7) + '.' + row.datum.substring(0, 4);
				row.zeit = row.datum.substring(11);
				var sd = new Date(parseInt(row.datum.substring(0, 4)), parseInt(row.datum.substring(5, 7)) - 1, parseInt(row.datum.substring(8, 10)));

				if (sd.getTime() <= now) {
					row.spiellistelink = 'Spielliste';
				}
			});
			dataList.add(results);

			dataList.sort('datum', { order: "asc" });

			var i = 0;
			var rows = document.getElementById('hg_data').getElementsByTagName('tr');
			for (; i < rows.length; i++) {
				var spielId = rows[i].dataset.id;
				if (spielId) {
					var atags = rows[i].getElementsByTagName('a');
					for (var j = 0; j < atags.length; j++) {
						(function () {
							var atag = atags[j];
							var sid = spielId;
							atag.addEventListener("click", function () {
								var modal = new tingle.modal({
									footer: false,
									stickyFooter: false,
									closeMethods: ['overlay', 'button', 'escape'],
									closeLabel: "Schliessen",
								});

								showDetail(modal, sid);

							});
						})();
					}
				}
			}
		}

		function showDetail(modal, spielId) {
			var url = 'https://www.hgverwaltung.ch/api/1/' + club + '/spiel/' + spielId + '?gegner=1';

			fetch(url).then(function (response) {
				return response.json();
			}).then(function (result) {
				modal.setContent(createDetailHtml(result));
				modal.open();
			});
		}

		function createDetailHtml(result) {
			var html = [];

			var d = result.datum;

			var map = {
				hg_art: result.art,
				hg_datum: d.substring(8, 10) + '.' + d.substring(5, 7) + '.' + d.substring(0, 4) + ' ' + d.substring(11)
			};

			map.hg_mann1 = result.team;
			map.hg_rp1 = result.rangPunkte;
			map.hg_nr1 = result.totalNr;
			map.hg_pu1 = result.schlagPunkte;

			map.hg_mann2 = result.gegner;
			map.hg_rp2 = result.rangPunkteGegner;
			map.hg_nr2 = result.totalNrGegner;
			map.hg_pu2 = result.schlagPunkteGegner;


			map.hg_bericht = result.bericht ? result.bericht : '';

			html.push('<div class="hg_detail">');
			html.push('<h1 id="hg_title">' + map.hg_art + ' vom ' + map.hg_datum + '</h1>');
			html.push('<table id="hg_header">');
			html.push('<tr>');
			html.push('<th class="mannschaft">Mannschaft</th>');
			if (result.meisterschaft) {
				html.push('<th class="hg_number">Rangpunkte</th>');
			}
			html.push('<th class="hg_number">Nummer</th>');
			html.push('<th class="hg_number">Punkte</th>');
			html.push('</tr>');
			html.push('<tr id="hg_first">');

			html.push('<td>' + map.hg_mann1 + '</td>');
			if (result.meisterschaft) {
				html.push('<td class="hg_number">' + (map.hg_rp1 != null ? map.hg_rp1 : '') + '</td>');
			}
			html.push('<td class="hg_number">' + (map.hg_nr1 != null ? map.hg_nr1 : '') + '</td>');
			html.push('<td class="hg_number">' + (map.hg_pu1 != null ? map.hg_pu1 : '') + '</td>');
			html.push('</tr>');
			html.push('<tr id="hg_second">');
			html.push('<td>' + map.hg_mann2 + '</td>');
			if (result.meisterschaft) {
				html.push('<td class="hg_number">' + (map.hg_rp2 != null ? map.hg_rp2 : '') + '</td>');
			}
			html.push('<td class="hg_number">' + (map.hg_nr2 != null ? map.hg_nr2 : '') + '</td>');
			html.push('<td class="hg_number">' + (map.hg_pu2 != null ? map.hg_pu2 : '') + '</td>');
			html.push('</tr>');
			html.push('</table>');

			html.push('<div id="hg_bericht">' + map.hg_bericht + '</div>');

			if (!result.spieler || result.spieler.len === 0) {
				html.push('</div>');
				return html.join('');
			}

			html.push(createPunkte(result, 'spieler', ''));
			if (result.gegnerSpieler) {
				html.push(createPunkte(result, 'gegnerSpieler', '_g'));
			}
			html.push('</div>');


			return html.join('');
		}

		function createPunkte(result, spielerProperty, postfix) {
			var code = [];
			code.push('<table id="hg_spieler' + postfix + '">');
			code.push('<thead>');
			code.push('<tr id="hg_spieler_header' + postfix + '">');


			// Header			
			code.push('<th class="reihenfolge hg_number">#</th>');
			code.push('<th>Name</th>');
			code.push('<th>Vorname</th>');

			for (var r = 0; r < result.anzahlRies; r++) {
				code.push('<th class="hg_number">' + (r + 1) + '</th>');
			}

			code.push('<th class="hg_number">Total</th>');

			if (result.meisterschaft) {
				code.push('<th class="hg_number">RP</th>');
			}
			if (result.fest) {
				code.push('<th>Ausz.</th>');
			}			

			code.push('</tr>');
			code.push('</thead>');
			code.push('<tbody>');

			// Spieler
			var spieler = [];
			result[spielerProperty].forEach(function (row) {
				if (!row.ueberzaehlig) {
					spieler.push(createSpielerRow(result, row));
				}
			});

			Array.prototype.push.apply(code, spieler);

			code.push('</tbody>');
			code.push('<tfoot>');


			// Total Row
			var totals = [0, 0, 0, 0, 0, 0, 0, 0];
			var grandeTotal = 0;

			result[spielerProperty].forEach(function (row) {
				if (!row.ueberzaehlig) {
					for (var l = 0; l < row.ries.length; l++) {
						if (row.ries[l] !== null) {
							totals[l] += row.ries[l];
							grandeTotal += row.ries[l];
						}
					}
				}
			});

			code.push('<tr class="total">');
			code.push('<td colspan="3"></td>');

			for (var row = 0; row < result.anzahlRies; row++) {
				code.push('<td class="hg_number">' + totals[row] + '</td>');
			}
			code.push('<td class="hg_number">' + grandeTotal + '</td>');
			code.push('</tr>');


			code.push('</tfoot>');
			code.push('</table>');


			// Ueberzaehlige Spieler
			code.push('<table id="hg_ueber_spieler">');
			code.push('<tbody>');

			var ueberSpieler = [];
			result[spielerProperty].forEach(function (row) {
				if (row.ueberzaehlig) {
					ueberSpieler.push(createSpielerRow(result, row));
				}
			});

			Array.prototype.push.apply(code, ueberSpieler);

			code.push('</tbody>');
			code.push('</table>');

			return code.join('');
		}

		function createSpielerRow(result, spieler) {
			var len = result.anzahlRies;
			var ms = result.meisterschaft;
			var fest = result.fest;
			
			var rowTotal = 0;

			var row = [
				'<tr>',
				'<td class="reihenfolge hg_number">' + spieler.reihenfolge + '</td>',
				'<td class="nachname">' + spieler.nachname + '</td>',
				'<td class="vorname">' + spieler.vorname + '</td>',
			];

			for (var r = 0; r < len; r++) {
				var rs = '<td class="ries hg_number">';
				var value = spieler.ries[r];
				if (spieler.nr[r]) {
					rs += '<span class="nr">';
				}

				if (value !== null) {
					rowTotal += value;
					if (value < 10) {
						rs += '0';
					}
					rs += value;
				}

				if (spieler.nr[r]) {
					rs += '</span>';
				}

				row.push(rs + '</td>');

			}

			row.push('<td class="total hg_number">' + rowTotal + '</td>');

			if (ms) {
				row.push('<td class="rangpunkt hg_number">' + (spieler.rangpunkte ? spieler.rangpunkte : '') + '</td>');
			}
			if (fest) {
				row.push('<td>' + (spieler.auszeichnung ? spieler.auszeichnung : '') + '</td>');
			}			

			row.push('</tr>');
			return row.join('');
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
	#hg_data {
		font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
	}

	#hg_jahrSelect {
		vertical-align: top;
	}

	#hg_data tbody tr:nth-child(odd) {
		background-color: #ebeff4;
	}

	#hg_data .hg_number {
		text-align: right;
		padding-right: 5px;
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

	#hg_data td {
		white-space: nowrap;
	}

	.spiellistelink {
		color: gray;
		padding-left: 5px;
		padding-right: 5px;
	}

	/* detail css */

	.tingle-modal-box__content {
		padding: 1rem;
	}

	.tingle-modal--overflow {
		padding-top: 3vh;
	}

	.hg_detail {
		font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
		margin-left: 10px;
	}

	.hg_detail h1 {
		font-size: 26px;
		font-weight: bold;
		margin-left: 10px;
	}

	.hg_detail .nr {
		border-bottom-color: black;
		border-bottom-width: 3px;
		border-bottom-style: solid;
	}

	.hg_detail .hg_number {
		text-align: right;
		padding-right: 3px;
	}

	.hg_detail .reihenfolge {
		padding: 0 15px 0 10px !important;
	}

	.hg_detail td.nachname {
		width: 150px;
	}

	.hg_detail td.vorname {
		width: 150px;
	}

	.hg_detail td.ries {
		width: 50px;
	}

	.hg_detail td.total {
		width: 70px;
	}

	.hg_detail td.rangpunkt {
		width: 70px;
	}

	.hg_detail td.total,
	.hg_detail tr.total td {
		font-weight: bold;
	}

	#hg_spieler_header th,
	#hg_header th,
	#hg_spieler_header_g th {
		text-align: left;
	}

	#hg_spieler_header th.hg_number,
	#hg_header th.hg_number,
	#hg_spieler_header_g th.hg_number {
		text-align: right;
		padding-right: 3px;
	}

	#hg_spieler,
	#hg_spieler_g {
		margin-top: 20px;
	}

	#hg_spieler tfoot,
	#hg_spieler_g tfoot {
		line-height: 2.2em;
	}

	#hg_spieler thead,
	#hg_spieler_g thead {
		line-height: 2.2em;
	}

	#hg_bericht {
		margin-top: 15px;
		width: 90%;
		margin-left: 15px;
		font-size: 14px;
	}

	#hg_ueber_spieler {
		margin-top: 5px;
	}

	#hg_header {
		margin-left: 10px;
	}

	#hg_header th {
		text-transform: uppercase;
		font-size: 10px;
		padding: 3px;
	}

	#hg_header .mannschaft {
		width: 200px;
	}

	#hg_header .hg_number {
		width: 100px;
	}

	#hg_first td,
	#hg_second td {
		font-size: 18px;
		padding: 3px;
	}

	#hg_first td {
		font-weight: bold;
	}

	.hg_detail a {
		text-decoration: none;
		color: black;
	}
	/*]]>*/
</style>>
<style >
.tingle-modal *{box-sizing:border-box}.tingle-modal{position:fixed;top:0;right:0;bottom:0;left:0;z-index:1000;display:flex;visibility:hidden;flex-direction:column;align-items:center;overflow:hidden;-webkit-overflow-scrolling:touch;background:rgba(0,0,0,.85);opacity:0;-webkit-user-select:none;-ms-user-select:none;user-select:none;cursor:pointer}.tingle-modal--confirm .tingle-modal-box{text-align:center}.tingle-modal--noOverlayClose{cursor:default}.tingle-modal--noClose .tingle-modal__close{display:none}.tingle-modal__close{position:fixed;top:2rem;right:2rem;z-index:1000;padding:0;width:2rem;height:2rem;border:none;background-color:transparent;color:#fff;cursor:pointer}.tingle-modal__close svg *{fill:currentColor}.tingle-modal__closeLabel{display:none}.tingle-modal__close:hover{color:#fff}.tingle-modal-box{position:relative;flex-shrink:0;margin-top:auto;margin-bottom:auto;width:60%;border-radius:4px;background:#fff;opacity:1;cursor:auto;will-change:transform,opacity}.tingle-modal-box__content{padding:3rem 3rem}.tingle-modal-box__footer{padding:1.5rem 2rem;width:auto;border-bottom-right-radius:4px;border-bottom-left-radius:4px;background-color:#f5f5f5;cursor:auto}.tingle-modal-box__footer::after{display:table;clear:both;content:""}.tingle-modal-box__footer--sticky{position:fixed;bottom:-200px;z-index:10001;opacity:1;transition:bottom .3s ease-in-out .3s}.tingle-enabled{position:fixed;right:0;left:0;overflow:hidden}.tingle-modal--visible .tingle-modal-box__footer{bottom:0}.tingle-enabled .tingle-content-wrapper{filter:blur(8px)}.tingle-modal--visible{visibility:visible;opacity:1}.tingle-modal--visible .tingle-modal-box{animation:scale .2s cubic-bezier(.68,-.55,.265,1.55) forwards}.tingle-modal--overflow{overflow-y:scroll;padding-top:8vh}.tingle-btn{display:inline-block;margin:0 .5rem;padding:1rem 2rem;border:none;background-color:grey;box-shadow:none;color:#fff;vertical-align:middle;text-decoration:none;font-size:inherit;font-family:inherit;line-height:normal;cursor:pointer;transition:background-color .4s ease}.tingle-btn--primary{background-color:#3498db}.tingle-btn--danger{background-color:#e74c3c}.tingle-btn--default{background-color:#34495e}.tingle-btn--pull-left{float:left}.tingle-btn--pull-right{float:right}@media (max-width :540px){.tingle-modal{top:0;display:block;padding-top:60px;width:100%}.tingle-modal-box{width:auto;border-radius:0}.tingle-modal-box__content{overflow-y:scroll}.tingle-modal--noClose{top:0}.tingle-modal--noOverlayClose{padding-top:0}.tingle-modal-box__footer .tingle-btn{display:block;float:none;margin-bottom:1rem;width:100%}.tingle-modal__close{top:0;right:0;left:0;display:block;width:100%;height:60px;border:none;background-color:#2c3e50;box-shadow:none;color:#fff}.tingle-modal__closeLabel{display:inline-block;vertical-align:middle;font-size:1.6rem;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen,Ubuntu,Cantarell,"Fira Sans","Droid Sans","Helvetica Neue",sans-serif}.tingle-modal__closeIcon{display:inline-block;margin-right:.8rem;width:1.6rem;vertical-align:middle;font-size:0}}@supports ((-webkit-backdrop-filter:blur(12px)) or (backdrop-filter:blur(12px))){.tingle-modal:before{position:fixed;top:0;right:0;bottom:0;left:0;content:"";-webkit-backdrop-filter:blur(18px);backdrop-filter:blur(18px)}.tingle-enabled .tingle-content-wrapper{filter:none}}@keyframes scale{0%{opacity:0;transform:scale(.9)}100%{opacity:1;transform:scale(1)}}
</style>