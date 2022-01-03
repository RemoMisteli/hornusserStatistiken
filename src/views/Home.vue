<template>
  <StatistikenHeader @change="haderUpdate()" ref="header" ></StatistikenHeader>
<div class="stats">
 <div class="container stat titelStatGroup">
  
    <div class="choseStatistik row">
      <div class="statistik col selectedH" @click="choose('GameOverview')" id="GameOverview">
        Übersicht Spiele
      </div>
   <div class="statistik col" @click="choose('Teams')" id="Teams">
        Mannschaft
      </div>
    <div class="statistik col" @click="choose('Maps')" id="Maps">
        Karten
      </div>
    </div>
  <GameOverview class="statGruppe" :webcode="webcode"  v-if="display['GameOverview']"/>
   <Teams class="statGruppe" :webcode="webcode"  v-if="display['Teams']"/>
    <Maps class="statGruppe"  v-if="display['Maps']"/>


   
 </div>
</div>

</template>

<script lang="ts">
import { defineComponent } from "vue";
import StatistikenHeader from "@/components/StatistikenHeader.vue"; // @ is an alias to /src
import GameOverview from "@/components/GameOverview.vue";
import Teams from "@/components/Teams.vue";
import Maps from "@/components/Maps.vue";

import { onMounted, ref } from "vue";

export default defineComponent({
  name: "Home",
  components: {
    StatistikenHeader,
    GameOverview,
    Teams,
    Maps
  },

  setup() {
    const header = ref(ref<InstanceType<typeof StatistikenHeader>>());
    var oldWebcode = "test";
    var webcode = ref();

    onMounted(() => {
      webcode.value = oldWebcode;
    });
    const haderUpdate = () => {
      console.log(header.value?.getSeclectet());
      var newWebcode = header.value?.getSeclectet();
      if (newWebcode !== oldWebcode) {
        oldWebcode = newWebcode;
        webcode.value = newWebcode;
      }
    };

    var display: any = ref([]);

    var setDisplayValues = (idToSetTrue: string) => {
      display.value["Teams"] = false;
      display.value["GameOverview"] = false;
      display.value["Maps"] = false;

      display.value[idToSetTrue] = true;
    };
    setDisplayValues("GameOverview");

    var choose = (id: string) => {
      var el = document.getElementById(id);
      var oldEl = document.getElementsByClassName("selectedH")[0];

      if (el != null && oldEl != null) {
        oldEl.classList.remove("selectedH");
        el.classList.add("selectedH");
      }
      setDisplayValues(id);
    };

    return {
      haderUpdate,
      header,
      webcode,
      choose,
      display,
    };
  },
});
</script>
<style scoped>
.statGruppe {
  margin-top: 30px;
}
.stats {
}
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
.selectedH {
  background: rgba(128, 128, 128, 0.5);
}
.titelStatGroup{
  font-weight: bold;

  
}
</style>
