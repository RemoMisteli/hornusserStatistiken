<template>
  <div class="container stat titelStatGroup maps">
    <h4>Karten</h4>
    <div class="choseStatistik row">
      <div class="statistik col selected" @click="choose('MSML')" id="MSML">
        Karte
      </div>
      <div
        class="statistik col "
        @click="choose('MSMLOMV')"
        id="MSMLOMV"
      >
        Karte 2
      </div>
       <div
        class="statistik col "
        @click="choose('MOVPV')"
        id="MOVPV"
      >
        Karte nach Verband
      </div>
    </div>
    <iframe
      src="https://hgverwaltung.ch/embed/1/map.html"
      style="width: 100%; height: 400px"
      v-if="display['MSML']"
    ></iframe>
    <iframe
      src="https://hgverwaltung.ch/embed/1/mapopen.html"
      style="width: 100%; height: 400px"
      v-if="display['MSMLOMV']"
    ></iframe>
    <iframe
      src="https://hgverwaltung.ch/embed/1/mapverbaende.html"
      style="width: 100%; height: 400px"
      v-if="display['MOVPV']"
    ></iframe>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import { onMounted, ref } from "vue";

export default {
  name: "Map",
  props: ["webcode"],
  components: {
  },
  setup(props: any) {
    var display: any = ref([]);

    var setDisplayValues = (idToSetTrue: string) => {
      display.value["MSML"] = false;
      display.value["MSMLOMV"] = false;
      display.value["MOVPV"] = false;

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
.titelStatGroup {
  font-weight: bold;
}
.maps {
  min-height: 250px;
}
</style>
