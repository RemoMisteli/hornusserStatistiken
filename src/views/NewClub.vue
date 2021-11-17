<template>
  <div class="form">
    <router-link to="/">zurück</router-link>
    <div>
      <h1 class="titel">Neuen Verein Hinzufügen</h1>
      <div>
        <table class="login">
          <tr>
            <td>Vereinsname:</td>
            <td><input type="text" name="name" /></td>
          </tr>
          <tr>
            <td>Webcode:</td>
            <td><input type="text" name="webcode" /></td>
          </tr>
        </table>
      </div>
      <div class="agrement">
        <input class="checkbox" type="checkbox" />Ich erkläremich damit
        einverstanden das andere die Statistiken meines Vereines sehen dürfen
      </div>
      <div class="center">
        <a
          href="https://wiki.hgverwaltung.ch/articles/AH-A-1180000/HTML#einbindung-in-eure-vereinshomepage"
          >Was ist der Webcode</a>
      </div>
      <div class="center" >
        <button>Oke</button>
        <button>Abbrechen</button>
      </div>
    </div>
  </div>
</template>
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
button{
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