<template>
  <div class="container stat titelStatGroup">
    <h4>Karten</h4>
    <div class="choseStatistik row">
      <div class="statistik col selected" @click="choose('MSML')" id="MSML">
        Karte
      </div>
      
    </div>
    <!--<MapLocationsOrderLiga :webcode="webcode" v-if="display['MSML']" />-->
    



  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import { onMounted, ref } from "vue";
import MapLocationsOrderLiga from "./statistiken/Maps/MapLocationsOrderLiga.vue";


export default {
  name: "Map",
  props: ["webcode"],
  components: { /*MapLocationsOrderLiga*/ },
  setup(props: any) {
    var display: any = ref([]);

    var setDisplayValues = (idToSetTrue: string) => {
      display.value["MSML"] = false;
     





      display.value[idToSetTrue] = true;
    };
    setDisplayValues("MSML");

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
