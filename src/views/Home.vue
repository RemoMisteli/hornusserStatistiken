<template>
  <StatistikenHeader @change="haderUpdate()" ref="header" />

  <GameOverview class="statGrupe" :webcode="webcode"/>
  <Maps class="statGrupe" />
</template>

<script lang="ts">
import { defineComponent } from "vue";
import StatistikenHeader from "@/components/StatistikenHeader.vue"; // @ is an alias to /src
import GameOverview from "@/components/GameOverview.vue";
import Maps from "@/components/Maps.vue";

import { onMounted, ref } from "vue";

export default defineComponent({
  name: "Home",
  components: {
    StatistikenHeader,
    GameOverview,
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
      if(newWebcode !== oldWebcode){
        oldWebcode=newWebcode;
        webcode.value=newWebcode;

      }
    };

    return {
      haderUpdate,
      header,
      webcode,
    };
  },
});
</script>
<style scoped>
.statGrupe{
  margin-top: 30px;
}
</style>
