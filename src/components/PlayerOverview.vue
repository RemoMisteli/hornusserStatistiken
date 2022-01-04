<template>
  <div class="stat titelStatGroup">
    <h4>Spieler</h4>
    <div class="choseStatistik row">
      <div class="statistik col selected" @click="choose('DPOP')" id="DPOP">
        Spiele
      </div>
      <div class="statistik col" @click="choose('DPOP2')" id="DPOP2">
        Spiele 2
      </div>
      <div class="statistik col" @click="choose('DASL')" id="DASL">
        Streiche im Spiele
      </div>
         <div class="statistik col" @click="choose('DRCTT')" id="DRCTT">
        Resultat im Vergleich zur Mannschaft
      </div>
       <div class="statistik col" @click="choose('OPT')" id="OPT">
        Übersicht Streiche einer Mannschaft
      </div>
         <div class="statistik col" @click="choose('OPT2')" id="OPT2">
        Übersicht Streiche einer Mannschaft +
      </div>
         <div class="statistik col" @click="choose('OPP')" id="OPP">
        Übersicht Streiche und Durchschnitt
      </div>
       <div class="statistik col" @click="choose('OPP2')" id="OPP2">
        Übersicht Streiche und Durchschnitt +
      </div>
        <div class="statistik col" @click="choose('TD')" id="TD">
        Mannschaft
      </div>
          <div class="statistik col" @click="choose('TF')" id="TF">
        Mannschaft 2
      </div>
    </div>
    <DiagramPointsOfPlayer :webcode="webcode" v-if="display['DPOP']" />
    <DiagramPointsOfPlayer2 :webcode="webcode" v-if="display['DPOP2']" />
    <DiagramAvrageShortLong :webcode="webcode" v-if="display['DASL']" />
    <DiagramResultsComparedToTeam :webcode="webcode" v-if="display['DRCTT']" />
    <OverviewPointsTeam :webcode="webcode" v-if="display['OPT']" />
    <OverviewPointsTeam2 :webcode="webcode" v-if="display['OPT2']" />
    <OverviewPointsPlayer :webcode="webcode" v-if="display['OPP']" />
    <OverviewPointsPlayer2 :webcode="webcode" v-if="display['OPP2']" />
    <TeamData :webcode="webcode" v-if="display['TD']" /> <!-- css isent scoped-->
    <TeamFunction :webcode="webcode" v-if="display['TF']" /><!-- css isent scoped-->
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import { onMounted, ref } from "vue";

import DiagramPointsOfPlayer from "./statistiken/Player/DiagramPointsOfPlayer.vue";
import DiagramPointsOfPlayer2 from "./statistiken/Player/DiagramPointsOfPlayer2.vue";
import DiagramAvrageShortLong from "./statistiken/Player/DiagramAvrageShortLong.vue";
import DiagramResultsComparedToTeam from "./statistiken/Player/DiagramResultsComparedToTeam.vue";
import OverviewPointsTeam from "./statistiken/Player/OverviewPointsTeam.vue";
import OverviewPointsTeam2 from "./statistiken/Player/OverviewPointsTeam2.vue";
import OverviewPointsPlayer from "./statistiken/Player/OverviewPointsPlayer.vue";
import OverviewPointsPlayer2 from "./statistiken/Player/OverviewPointsPlayer2.vue";
import TeamData from "./statistiken/Player/TeamData.vue";
import TeamFunction from "./statistiken/Player/TeamFunction.vue";

export default {
  name: "PlayerOverview",
  props: ["webcode"],
  components: {
    DiagramPointsOfPlayer,
    DiagramPointsOfPlayer2,
    DiagramAvrageShortLong,
    DiagramResultsComparedToTeam,
    OverviewPointsTeam,
    OverviewPointsTeam2,
    OverviewPointsPlayer,
    OverviewPointsPlayer2,
    TeamData,
    TeamFunction
  },
  setup(props: any) {
    var display: any = ref([]);

    var setDisplayValues = (idToSetTrue: string) => {
      display.value["DPOP"] = false;
      display.value["DPOP2"] = false;
      display.value["DASL"] = false;
      display.value["DRCTT"] = false;
      display.value["OPT"] = false;
      display.value["OPT2"] = false;
      display.value["OPP"] = false;
      display.value["OPP2"] = false;
      display.value["TD"] = false;
      display.value["TF"] = false;

      display.value[idToSetTrue] = true;
    };
    setDisplayValues("DPOP");

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
