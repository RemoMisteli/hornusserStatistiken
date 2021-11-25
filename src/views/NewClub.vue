<template>
  <router-link to="/">zurück</router-link>
  <div>
    <h1 class="titel">Neuen Verein Hinzufügen</h1>
    <div>
      <table class="login">
        <tr>
          <td>Vereinsname:</td>
          <td>
            <input
              type="text"
              name="name"
              v-model="fieldVereinsname"
              id="vereinsname"
            />
          </td>
        </tr>
        <tr>
          <td>Webcode:</td>
          <td>
            <input
              type="text"
              name="webcode"
              v-model="fieldWebcode"
              id="webcode"
            />
          </td>
        </tr>
      </table>
    </div>
    <div class="agrement">
      <input
        class="checkbox"
        type="checkbox"
        v-model="checkbox"
        id="checkbox"
      />Ich erkläremich damit einverstanden das andere die Statistiken meines
      Vereines sehen dürfen
    </div>
    <div class="center">
      <a
        href="https://wiki.hgverwaltung.ch/articles/AH-A-1180000/HTML#einbindung-in-eure-vereinshomepage"
        >Was ist der Webcode</a
      >
    </div>
    <div class="center">
      <button @click="send()">Oke</button>
      <button @click="cleanInputFields()">Abbrechen</button>
    </div>
  </div>
</template>
<script lang="ts">
import { defineComponent } from "vue";
import { ref } from "vue";
import axios from "axios";

export default defineComponent({
  name: "newClub",
  components: {},
  setup() {
    const http = axios.create({
      baseURL: "http://localhost:8080/api/",
      headers: { "Content-Type": "application/json" },
    });
    let fieldVereinsname = ref("");
    let fieldWebcode = ref("");
    let checkbox = ref(false);

    var send = async () => {
      console.log(checkbox.value);
      if (validateForm()) {
        const response = await http.post(
          "/webcodes/?webcode=" +
            fieldWebcode.value +
            "&vereinsname=" +
            fieldVereinsname.value
        );
        console.log(response); //TODO check if dublicatet
        //todo visual response
        if (response.data == "Done") {
          cleanInputFields();
        } else {
          if (response.data.includes("Duplicate entry")) {
            if (response.data.includes("for key 'vereinsname'")) {
                popup("Dieser Vereinsname wurde schon hinzugefügt")
            } else if (response.data.includes("for key 'webcode'")) {
                popup("Dieser Webcode wurde schon hinzugefügt")

            } else {
              popup(
                "Es ist ein Fehler aufgetreten der Verein konnte nicht hinzugefügt werden"
              );
            }
          } else {
            popup(
              "Es ist ein Fehler aufgetreten der Verein konnte nicht hinzugefügt werden"
            );
          }
        }
      }
    };

    var cleanInputFields = () => {
      fieldVereinsname.value = "";
      fieldWebcode.value = "";
      checkbox.value = false;
    };

    var validateForm = () => {
      let message = "";
      if (fieldVereinsname.value == "") {
        message += "Der Veriname muss ausgefült sein\n";
      }
      if (fieldWebcode.value == "") {
        message += "Du must einen Webcode angeben\n";
      }
      if (!checkbox.value) {
        message +=
          "Du mussst einverstanden sein dass ander die Statistiken deines Vereines sehen können um einen Verein hinzuzufügen";
      }
      if (message == "") {
        console.log("df");
        return true;
      }
      popup(message);
      return false;
    };

    var popup = (message: string) => {
      window.alert(message);
    };
    return {
      send,
      cleanInputFields,
      fieldVereinsname,
      fieldWebcode,
      checkbox,
    };
  },
});
</script>
<style scoped>
.form {
  margin: auto;
  width: 50%;
  padding: 10px;
  width: 100%;
}
.login {
  margin-left: auto;
  margin-right: auto;
}
tr {
  width: 100%;
}
input {
  display: block;
  font-size: 16px;
  width: 100%;
  padding: 10px 10px;
  border-radius: 20px;
}
.checkbox {
  width: auto;
}
.agrement {
  display: flex;
  margin: auto;
  width: 50%;
  padding: 10px;
}
.titel {
  text-align: center;
}
.center {
  display: flex;
  justify-content: center;
  align-items: center;
}
button {
  margin-top: 10px;
  margin-left: 5px;
  margin-right: 5px;
  height: 40px;
  min-width: 100px;
  border-radius: 20px;
  background: rgb(40, 26, 233);
  color: white;
  border: none;
}
</style>