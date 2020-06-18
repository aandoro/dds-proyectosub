<template>
  <div>
    <div>
      <v-breadcrumbs :items="items" divider=">"></v-breadcrumbs>
    </div>
    <v-toolbar flat color="white">
      <v-toolbar-title>Usuarios</v-toolbar-title>
      <v-divider class="mx-2" inset vertical></v-divider>
      <v-spacer></v-spacer>
      <v-btn color="primary" dark class="mb-2" to="/user/new">Nuevo</v-btn>
    </v-toolbar>
    <v-data-table :headers="headers" :items="users" class="elevation-1">
      <template v-slot:items="props">
        <td>{{ props.item.name }}</td>
        <td>{{ props.item.surname }}</td>
        <td>{{ props.item.username }}</td>
        <td class="justify-center">
          <router-link :to="'/user/view/' + props.item.id">
            <v-tooltip top>
              <template v-slot:activator="{ on }">
                <v-btn icon v-on="on">
                  <v-icon small class="mr-2">remove_red_eye</v-icon>
                </v-btn>
              </template>
              <span>Visualizar</span>
            </v-tooltip>
          </router-link>
          <router-link :to="'/user/' + props.item.id">
            <v-tooltip top>
              <template v-slot:activator="{ on }">
                <v-btn icon v-on="on">
                  <v-icon small class="mr-2">edit</v-icon>
                </v-btn>
              </template>
              <span>Editar</span>
            </v-tooltip>
          </router-link>
          <v-tooltip top>
            <template v-slot:activator="{ on }">
              <v-btn icon v-on="on">
                <v-icon small @click="OpenDialog(props.item)">delete</v-icon>
              </v-btn>
            </template>
            <span>Borrar</span>
          </v-tooltip>
        </td>
      </template>
      <template v-slot:no-data>
        <v-btn color="primary" @click="initialize">Recargar</v-btn>
      </template>
    </v-data-table>

    <div>
      <v-layout row justify-center>
        <v-dialog v-model="dialog" persistent max-width="290">
          <v-card>
            <v-card-title class="headline">¿Esta seguro que desea borrarlo?</v-card-title>
            <v-card-text></v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="green darken-1" flat @click="dialog = false">Cancelar</v-btn>
              <v-btn color="green darken-1" flat @click="deleteItem()">Confirmar</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-layout>
    </div>
  </div>
</template>

<script>
import firebase from "firebase/app";
import "firebase/database";

export default {
  data: () => ({
    items: [
      {
        text: "Inicio",
        disabled: false,
        href: "#/home"
      },
      {
        text: "Lista de usuarios",
        disabled: true,
        href: "#/users"
      }
    ],
    headers: [
      { text: "Nombres", value: "name" },
      { text: "Apellidos", value: "surname" },
      { text: "Usuarios", value: "username" },
      { text: "Actiones", value: "name", sortable: false }
    ],
    users: [],
    userId: null,
    dialog: false,
    pageCount: 1
  }),
  created() {
    this.initialize();
  },
  methods: {
    initialize() {
      firebase
        .database()
        .ref("UsersWeb")
        .on("value", snapshot => {
          let users = snapshot.val();
          for (let user in users) {
            this.users.unshift({
              id: user,
              email: users[user].email,
              name: users[user].name,
              surname: users[user].surname,
              username: users[user].username,
              role: users[user].role
            });
          }
        });
    },
    OpenDialog(user) {
      this.dialog = true;
      this.userId = user;
    },
    deleteItem(id) {
      this.dialog = false;
      if (this.userId.role === "admin") {
        this.$notify({
          group: "error",
          type: "error",
          title: "BORRADO:",
          text: "No se puede borrar el admin"
        });
      } else {
        firebase
          .database()
          .ref("UsersWeb")
          .child(this.userId)
          .remove()
          .then(() => {
            this.$notify({
              group: "success",
              type: "success",
              title: "BORRADO:",
              text: "La user se borro exitosamente"
            });
            this.users = [];
            this.initialize();
          })
          .catch(() => {
            this.$notify({
              group: "error",
              type: "error",
              title: "BORRADO:",
              text: "Ocurrio un error al querer borrarlo"
            });
          });
      }
    }
  }
};
</script>