<template>
  <div>
    <router-link to="/newClub">Verein Hinzufügen</router-link>
    <div class="center">
      <h1>Hornusser Statistiken</h1>
      <p>Vereinsname</p>
      <select class="select" v-model="club" @change="onChange()">
        <option
          v-for="option in options"
          :value="option.webcode"
          :key="option.webcode"
        >
          {{ option.vereinsname }}
        </option>
      </select>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import axios from "axios";
import { onMounted, ref } from "vue";

export default defineComponent({
  name: "StatistikenHeader",
  props: {},
  components: {},
  setup() {
    let options: any = ref([]);
    let club: any = ref();
    let selected: any = ref();

    const http = axios.create({
      baseURL: "http://localhost:8080/api/",
      headers: { "Content-Type": "application/json" },
    });
    onMounted(() => {
      getClubs();
    });

    var getClubs = async () => {
   //   const response = await http.get("/webcodes/");
     // options.value = response.data;
     // console.log(options.value);
     options.value=[{"webcode":"biel","vereinsname":"Biel"},{"webcode":"obergerlafingen","vereinsname":"Obergerlafingen"},{"webcode":"test","vereinsname":"Test"}];
    };
    var onChange = () => {
      selected.value = club.value;
    };

    const getSeclectet = () => {
      return selected.value;
    };

    return {
      options,
      onChange,
      club,
      getSeclectet,
    };
  },
});
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.center {
  text-align: center;
}
h1 {
  font-size: 40px;
}
.select {
  margin-bottom: 10px;
}
</style>
