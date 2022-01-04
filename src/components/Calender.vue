<template>
  <div class=" stat titelStatGroup">
    
    <iframe
      :src="link"
      style="width: 100%; height: 850px"
    
    ></iframe>

  </div>
</template>

<script lang="js">
import { defineComponent } from "vue";
import { onMounted, ref } from "vue";

export default {
  name: "Calender",
  props: ["webcode"],
    watch: { 
      	webcode: function(newVal, oldVal) { // watch it 
         		 console.log('Prop changed: ', newVal, ' | was: ', oldVal);
		      	var club =newVal;
		if (!club) {
		  club = 'test';
		}
		      this.link= 'https://hgverwaltung.ch/static/calendar/calendar.html?club='+club;
          

        }
  },
  components: {
  },
  
  setup(props) {
    var display = ref([]);
        var link = ref("");

 

    
    

 

    var setup =()=>{
      	var club =props.webcode;
		if (!club) {
		  club = 'test';
		}
    
  link= 'https://hgverwaltung.ch/static/calendar/calendar.html?club='+club;
    }
    
    setup();
    
    return {

     setup,
      link,
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
.maps {
  min-height: 250px;
}
</style>
