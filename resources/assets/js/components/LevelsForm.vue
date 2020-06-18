<template>
  <div>
    <div>
      <v-breadcrumbs :items="items" divider=">"></v-breadcrumbs>
    </div>
    <v-toolbar flat color="white">
      <v-toolbar-title>Niveles</v-toolbar-title>
      <v-divider class="mx-2" inset vertical></v-divider>
      <v-spacer></v-spacer>
      <v-btn color="primary" dark class="mb-2" to="/level/new">Nuevo</v-btn>
    </v-toolbar>
    <v-data-table :headers="headers" :items="levels" class="elevation-1">
      <template v-slot:items="props">
        <td>{{props.item.number}}</td>
        <td>{{ props.item.name }}</td>
        <td>{{ props.item.scoreRequired }}</td>
        <td class="justify-center">
          <router-link :to="'/level/view/' + props.item.id">
            <v-tooltip top>
              <template v-slot:activator="{ on }">
                <v-btn icon v-on="on">
                  <v-icon small class="mr-2">remove_red_eye</v-icon>
                </v-btn>
              </template>
              <span>Visualizar</span>
            </v-tooltip>
          </router-link>
          <router-link :to="'/level/' + props.item.id">
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
                <v-icon small @click="OpenDialog(props.item.id)">delete</v-icon>
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
        text: "Lista de niveles",
        disabled: true,
        href: "#/levels"
      }
    ],
    headers: [
      { text: "Numeros", value: "number" },
      { text: "Nombres", value: "name" },
      { text: "Puntajes", value: "scoreRequired" },
      { text: "Actiones", value: "name", sortable: false }
    ],
    levels: [],
    levelId: null,
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
        .ref("Levels")
        .on("value", snapshot => {
          let index = 1
          let levels = snapshot.val();
          for (let level in levels) {
            this.levels.unshift({
              id: level,
              name: levels[level].name,
              number: index++,
              scoreRequired: levels[level].scoreRequired
            });
          }
        });
    },
    OpenDialog(id) {
      this.dialog = true;
      this.levelId = id;
    },
    deleteItem() {
      this.dialog = false;
      firebase
        .database()
        .ref("Levels")
        .child(this.levelId)
        .remove()
        .then(() => {
          this.$notify({
            group: "success",
            type: "success",
            title: "BORRADO:",
            text: "El nivel se borro exitosamente"
          });
          this.levels = [];
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
};
</script>