<template>
  <div class="container stat titelStatGroup">
    <h4>Übersicht Spiele</h4>
    <div class="choseStatistik row">
      <div class="statistik col selected" @click="choose('GOGDS')" id="GOGDS">
        Spiele
      </div>
      <div class="statistik col" @click="choose('GOGDSWR')" id="GOGDSWR">
        Spiele mit Resultaten
      </div>
       <div class="statistik col" @click="choose(' GOGDSWRNOPU')" id=" GOGDSWRNOPU">
        Spiele mit Resultaten Pop Up
      </div>
    </div>
    <GameDatesSaison :webcode="webcode" v-if="display['GOGDS']" />
    <GameDatesSaisonWhitResults :webcode="webcode" v-if="display['GOGDSWR']" />
    <GameDatesSaisonWhitResultNoOpponentPopUp :webcode="webcode" v-if="display[' GOGDSWRNOPU']" />

  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import { onMounted, ref } from "vue";

import GameDatesSaison from "./statistiken/GameDates/GameDatesSaison.vue";
import GameDatesSaisonWhitResults from "./statistiken/GameDates/GameDatesSaisonWhitResult.vue";
import GameDatesSaisonWhitResultNoOpponentPopUp from "./statistiken/GameDates/GameDatesSaisonWhitResultNoOpponentPopUp.vue";
export default {
  name: "GameOverview",
  props: ["webcode"],
  components: { GameDatesSaison, GameDatesSaisonWhitResults,GameDatesSaisonWhitResultNoOpponentPopUp },
  setup(props: any) {
    var display: any = ref([]);

    var setDisplayValues = (idToSetTrue: string) => {
      display.value["GOGDS"] = false;
      display.value["GOGDSWR"] = false;
      display.value[" GOGDSWRNOPU"] = false;


      display.value[idToSetTrue] = true;
    };
    setDisplayValues("GOGDS");

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
.titelStatGroup{
  font-weight: bold;

  
}
</style>
