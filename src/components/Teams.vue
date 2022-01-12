<template>
  <div class="stat titelStatGroup">
    <h4>Mannschaft</h4>
    <div class="choseStatistik row">
      <div class="statistik col selected" @click="choose('AV')" id="AV">
        Spiele
      </div>
      <div class="statistik col" @click="choose('HD')" id="HD">
        Streiche Säulendiagramm
      </div>
      <div class="statistik col" @click="choose('CPOT')" id="CPOT">
        Rangpunkte
      </div>
      <div class="statistik col" @click="choose('ATWCTLY')" id="ATWCTLY">
        Druchschnitt ink. Veränderung
      </div>
      <div class="statistik col" @click="choose('ATA')" id="ATA">
        Durchschnitt alle Daten
      </div>
      <div class="statistik col" @click="choose('ATAT')" id="ATAT">
        Entwicklung Durchschnitt
      </div>
      <div class="statistik col" @click="choose('ATATWD')" id="ATATWD">
        Entwicklung Durchschnitt +
      </div>
      <div class="statistik col" @click="choose('ATOY')" id="ATOY">
        Entwicklung Durchschnitt über 5 Jahre
      </div>
      <div class="statistik col" @click="choose('ATOS')" id="ATOS">
        Entwicklung Durchschnitt Saison
      </div>
      <div class="statistik col" @click="choose('ATLTG')" id="ATLTG">
        Durchschnitt lezte 3 Spiele
      </div>
      <div class="statistik col" @click="choose('ATLTGG')" id="ATLTGG">
        Durchschnitt lezte 3 gespielten Spiele
      </div>
        <div class="statistik col" @click="choose('N')" id="N">
        Nummern übersicht
      </div>
    </div>
    <Avrages :webcode="webcode" v-if="display['AV']" />
    <HitsDiagram :webcode="webcode" v-if="display['HD']" />
    <ChampionschipPointsOfTeam :webcode="webcode" v-if="display['CPOT']" />
    <AvrageTeamWhitChangeToLastYear
      :webcode="webcode"
      v-if="display['ATWCTLY']"
    />
    <AvrageTeamAll :webcode="webcode" v-if="display['ATA']" />
    <AvrageTeamAllTime :webcode="webcode" v-if="display['ATAT']" />
    <AvrageTeamAllTimeWhitDiagram :webcode="webcode" v-if="display['ATATWD']" />
    <AvrageTeamOverYears :webcode="webcode" v-if="display['ATOY']" />
    <AvrageTeamOverSaison :webcode="webcode" v-if="display['ATOS']" />
    <AvrageTeamLastThreeGames :webcode="webcode" v-if="display['ATLTG']" />
    <AvrageTeamLastThreeGamedGames
      :webcode="webcode"
      v-if="display['ATLTGG']"
    />
     <Numbers
      :webcode="webcode"
      v-if="display['N']"
    />
  </div>
</template>

<script lang="ts">
import { ref } from "vue";

import Avrages from "./statistiken/Teams/Avrage.vue";
import HitsDiagram from "./statistiken/Teams/HitsDiagram.vue";
import ChampionschipPointsOfTeam from "./statistiken/Teams/ChampionschipPointsOfTeam.vue";
import AvrageTeamWhitChangeToLastYear from "./statistiken/Teams/AvrageTeamWhitChangeToLastYear.vue";
import AvrageTeamAll from "./statistiken/Teams/AvrageTeamAll.vue";
import AvrageTeamAllTime from "./statistiken/Teams/AvrageTeamAllTime.vue";
import AvrageTeamAllTimeWhitDiagram from "./statistiken/Teams/AvrageTeamAllTimeWhitDiagram.vue";
import AvrageTeamOverYears from "./statistiken/Teams/AvrageTeamOverYears.vue";
import AvrageTeamOverSaison from "./statistiken/Teams/AvrageTeamOverSaison.vue";
import AvrageTeamLastThreeGames from "./statistiken/Teams/AvrageTeamLastThreeGames.vue";
import AvrageTeamLastThreeGamedGames from "./statistiken/Teams/AvrageTeamLastThreeGamedGames.vue";
import Numbers from "./statistiken/Teams/Numbers.vue";

export default {
  name: "Teams",
  props: ["webcode"],
  components: {
    Avrages,
    HitsDiagram,
    ChampionschipPointsOfTeam,
    AvrageTeamWhitChangeToLastYear,
    AvrageTeamAll,
    AvrageTeamAllTime,
    AvrageTeamAllTimeWhitDiagram,
    AvrageTeamOverYears,
    AvrageTeamOverSaison,
    AvrageTeamLastThreeGames,
    AvrageTeamLastThreeGamedGames,
    Numbers
  },
  setup(props: any) {
    var display: any = ref([]);

    var setDisplayValues = (idToSetTrue: string) => {
      display.value["AV"] = false;
      display.value["HD"] = false;
      display.value["CPOT"] = false;
      display.value["ATWCTLY"] = false;
      display.value["ATA"] = false;
      display.value["ATAT"] = false;
      display.value["ATATWD"] = false;
      display.value["ATOY"] = false;
      display.value["ATOS"] = false;
      display.value["ATLTG"] = false;
      display.value["ATLTGG"] = false;
      display.value["N"] = false;

      display.value[idToSetTrue] = true;
    };
    setDisplayValues("AV");

    var choose = (id: string) => {
      var el = document.getElementById(id);
      var oldEl = document.getElementsByClassName("selected")[0];

      if (el != null && oldEl != null) {
        oldEl.classList.remove("selected");
        el.classList.add("selected");
      }
      setDisplayValues(id);
    };

    return {
      choose,
      display,
    };
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.choseStatistik {
  border-bottom: solid 2px rgb(163 163 163);
}
.statistik {
  text-align: center;
  font-weight: bold;
  cursor: pointer;
  border-top: solid 2px rgb(163 163 163);
}
.stat {
  text-align: center;
}
.selected {
  background: rgba(128, 128, 128, 0.5);
}
.titelStatGroup {
  font-weight: bold;
}
</style>
