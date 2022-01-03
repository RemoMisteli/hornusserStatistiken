<template>
  <div class="container stat titelStatGroup">
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
    AvrageTeamAllTimeWhitDiagram
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
  border: solid 2px rgb(163 163 163);
}
.selected {
  background: rgba(128, 128, 128, 0.5);
}
.titelStatGroup {
  font-weight: bold;
}
</style>
