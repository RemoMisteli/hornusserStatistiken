<template>
  <div>
    <h3>{{webcode}}</h3>
  <GameDatesSaison :webcode="webcode"></GameDatesSaison>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import { onMounted, ref } from "vue";
import GameDatesSaison from "./statistiken/GameDatesSaison.vue"
export default {
  name: "GameOverview",
  props: ["webcode"],
  components: {GameDatesSaison},
  setup(props: any) {
  

    return{
    };
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
