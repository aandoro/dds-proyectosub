<template>
  <div>
    <div>
      <v-breadcrumbs :items="items" divider=">"></v-breadcrumbs>
    </div>
    <v-toolbar flat color="white">
      <v-toolbar-title>Especies</v-toolbar-title>
      <v-divider class="mx-2" inset vertical></v-divider>
      <v-spacer></v-spacer>
      <v-btn color="primary" dark class="mb-2" to="/specie/new">Nuevo</v-btn>
    </v-toolbar>
    <v-data-table :headers="headers" :items="species" class="elevation-1">
      <template v-slot:items="props">
        <td>{{ props.item.name }}</td>
        <td>{{ props.item.scientificName }}</td>
        <td>{{ props.item.group_id }}</td>
        <td class="justify-center">
          <router-link :to="'/specie/view/' + props.item.id">
            <v-tooltip top>
              <template v-slot:activator="{ on }">
                <v-btn icon v-on="on">
                  <v-icon small class="mr-2">remove_red_eye</v-icon>
                </v-btn>
              </template>
              <span>Visualizar</span>
            </v-tooltip>
          </router-link>
          <router-link :to="'/specie/' + props.item.id">
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
import "firebase/storage";

export default {
  data: () => ({
    items: [
      {
        text: "Inicio",
        disabled: false,
        href: "#/home"
      },
      {
        text: "Lista de especies",
        disabled: true,
        href: "#/species"
      }
    ],
    headers: [
      { text: "Nombres", value: "name" },
      { text: "Nombres cientifico", value: "scientificName" },
      { text: "Grupo que pertenece", value: "group_id" },
      { text: "Actiones", value: "name", sortable: false }
    ],
    species: [],
    groups: [],
    specieId: null,
    dialog: false,
    pageCount: 1
  }),
  created() {
    this.initialize();
  },
  mounted() {},
  methods: {
    initialize() {
      firebase
        .database()
        .ref("Species")
        .on("value", snapshot => {
          let species = snapshot.val();
          for (let specie in species) {
            this.species.unshift({
              id: specie,
              name: species[specie].name,
              scientificName: species[specie].scientificName,
              description: species[specie].description,
              diet: species[specie].diet,
              habitat: species[specie].habitat,
              reproduction: species[specie].reproduction,
              group_id: species[specie].group_id
            });
          }
        });
    },
    OpenDialog(id) {
      this.dialog = true;
      this.specieId = id;
    },
    deleteItem() {
      this.dialog = false;
      firebase
        .database()
        .ref("Species")
        .child(this.specieId)
        .remove()
        .then(() => {
          this.$notify({
            group: "success",
            type: "success",
            title: "BORRADO:",
            text: "La especie se borro exitosamente"
          });
          this.species = [];
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