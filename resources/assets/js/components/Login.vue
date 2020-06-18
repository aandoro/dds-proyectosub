<template>
  <div id="app">
    <v-app id="inspire">
      <v-content>
        <v-container fluid fill-height>
          <v-layout align-center justify-center>
            <v-flex xs12 sm8 md4>
              <v-card class="elevation-12">
                <v-toolbar dark color="primary">
                  <v-toolbar-title>Iniciar Sesion</v-toolbar-title>
                </v-toolbar>
                <v-card-text>
                  <v-form>
                    <v-text-field
                      v-model="input.email"
                      prepend-icon="person"
                      name="login"
                      label="Email de usuario"
                      type="email"
                      required
                    ></v-text-field>
                    <v-text-field
                      v-model="input.password"
                      prepend-icon="lock"
                      name="password"
                      label="Password"
                      id="password"
                      type="password"
                      required
                    ></v-text-field>
                  </v-form>
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="primary" v-on:click="login()">Login</v-btn>
                </v-card-actions>
              </v-card>
            </v-flex>
          </v-layout>
        </v-container>
      </v-content>
    </v-app>
  </div>
</template>

<script>
import firebase from "firebase/app";
import "firebase/auth";

export default {
  name: "Login",
  data() {
    return {
      input: {
        email: "",
        password: ""
      }
    };
  },
  created() {},
  methods: {
    login() {
      if (this.input.email != "" && this.input.password != "") {
        firebase
          .auth()
          .signInWithEmailAndPassword(this.input.email, this.input.password)
          .then(user => {
            this.$notify({
              group: "success",
              type: "success",
              title: "Inicio Sesion:",
              text: "Bienvenido " + this.input.email
            });
            window.location.replace("#/home");
          })
          .catch(error => {
            if (this.isUserAdd()) {
              this.registerIt();
            } else {
              this.$notify({
                group: "error",
                type: "error",
                title: "ERROR:",
                text: "Los campos usuario y contraseña deben completarse"
              });
            }
          });
      } else {
        this.$notify({
          group: "error",
          type: "error",
          title: "ERROR:",
          text: "Los campos usuario y contraseña deben completarse"
        });
      }
    },
    isUserAdd() {
      console.log("entre a is user");

      firebase
        .database()
        .ref("UsersWeb")
        .child("email")
        .equalTo(this.input.email)
        .on("value", snapshot => {
          console.log(snapshot.val() !== null);

          if (snapshot.val() !== null) return false;
          return true;
        });
    },
    registerIt() {
      firebase
        .auth()
        .createUserWithEmailAndPassword(this.input.email, this.input.password)
        .then(user => {
          this.$notify({
            group: "success",
            type: "success",
            title: "Inicio Sesion:",
            text: "Bienvenido " + this.input.email
          });
          window.location.replace("#/home");
        })
        .catch(error => {
          this.$notify({
            group: "error",
            type: "error",
            title: "ERROR:",
            text: "Usuario / contraseña incorrecta"
          });
        });
    }
  }
};
</script>