<template>
  <div>
    <div>
      <v-breadcrumbs :items="items" divider=">"></v-breadcrumbs>
    </div>
    <v-toolbar flat color="white">
      <v-toolbar-title>Trivias</v-toolbar-title>
      <v-divider class="mx-2" inset vertical></v-divider>
      <v-spacer></v-spacer>
      <v-btn color="primary" dark class="mb-2" to="/trivia/new">Nuevo</v-btn>
    </v-toolbar>
    <v-data-table :headers="headers" :items="trivias" class="elevation-1">
      <template v-slot:items="props">
        <td>{{ props.item.name }}</td>
        <td class="text-xs-right">{{ props.item.level_id }}</td>
        <td class="text-xs-right">{{ props.item.category_id }}</td>
        <td class="justify-center">
          <router-link :to="'/trivia/view/' + props.item.id">
            <v-tooltip top>
              <template v-slot:activator="{ on }">
                <v-btn icon v-on="on">
                  <v-icon small class="mr-2">remove_red_eye</v-icon>
                </v-btn>
              </template>
              <span>Visualizar</span>
            </v-tooltip>
          </router-link>
          <router-link :to="'/trivia/' + props.item.id">
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
            <v-card-title class="headline">¿Esta seguro que desea borrar?</v-card-title>
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
        text: "Lista de trivias",
        disabled: true,
        href: "#/trivias"
      }
    ],
    headers: [
      { text: "Nombres", value: "name" },
      { text: "Niveles", value: "level_id" },
      { text: "Categorias", value: "category_id" },
      { text: "Actiones", value: "name", sortable: false }
    ],
    trivias: [],
    triviaId: null,
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
        .ref("Trivias")
        .on("value", snapshot => {
          let trivias = snapshot.val();
          for (let trivia in trivias) {
            this.trivias.unshift({
              id: trivia,
              name: trivias[trivia].name,
              description: trivias[trivia].description,
              point: trivias[trivia].point,
              question: trivias[trivia].question,
              optCorrect: trivias[trivia].optCorrect,
              level_id: trivias[trivia].level_id,
              category_id: trivias[trivia].category_id
            });
          }
        });
    },
    saveItems() {
      this.trivias.forEach(item => {
        this.leveles.forEach(level => {
          if (item.level_id == level.id) {
            item.level_id = level.name;
          }
        });
        this.categories.forEach(category => {
          if (item.category_id == category.id) {
            item.category_id = category.name;
          }
        });
      });
    },
    OpenDialog(id) {
      this.dialog = true;
      this.triviaId = id;
    },
    deleteItem() {
      this.dialog = false;
      firebase
        .database()
        .ref("Trivias")
        .child(this.triviaId)
        .remove()
        .then(() => {
          this.$notify({
            group: "success",
            type: "success",
            title: "BORRADO:",
            text: "La trivia se borro exitosamente"
          });
          this.trivias = [];
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