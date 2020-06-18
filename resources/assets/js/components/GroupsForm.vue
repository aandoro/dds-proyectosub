<template>
  <div>
    <div>
      <v-breadcrumbs :items="items" divider=">"></v-breadcrumbs>
    </div>
    <v-toolbar flat color="white">
      <v-toolbar-title>Grupos</v-toolbar-title>
      <v-divider class="mx-2" inset vertical></v-divider>
      <v-spacer></v-spacer>
      <v-btn color="primary" dark class="mb-2" to="/group/new">Nuevo</v-btn>
    </v-toolbar>
    <v-data-table :headers="headers" :items="groups" class="elevation-1">
      <template v-slot:items="props">
        <td>{{ props.item.name }}</td>
        <td class="justify-center">
          <router-link :to="'/group/view/' + props.item.id">
            <v-tooltip top>
              <template v-slot:activator="{ on }">
                <v-btn icon v-on="on">
                  <v-icon small class="mr-2">remove_red_eye</v-icon>
                </v-btn>
              </template>
              <span>Visualizar</span>
            </v-tooltip>
          </router-link>
          <router-link :to="'/group/' + props.item.id">
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
                <v-icon small @click="OpenDialog(props.item.id,props.item)">delete</v-icon>
              </v-btn>
            </template>
            <span>borrar</span>
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
            <v-card-text>Al eliminar este grupo todas sus especies relacionadas también se eliminaran.</v-card-text>
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
        text: "Lista de grupos",
        disabled: true,
        href: "#/groups"
      }
    ],
    headers: [
      { text: "Nombres", value: "name" },
      { text: "Actiones", value: "name", sortable: false }
    ],
    groups: [],
    groupId: null,
    dialog: false,
    pageCount: 1,
    group: {}
  }),
  created() {
    this.initialize();
  },
  methods: {
    initialize() {
      firebase
        .database()
        .ref("Groups")
        .on("value", snapshot => {
          let groups = snapshot.val();
          for (let group in groups) {
            this.groups.unshift({
              id: group,
              name: groups[group].name,
              description: groups[group].description
            });
          }
        });
    },
    OpenDialog(id, item) {
      this.dialog = true;
      this.group = item;
      this.groupId = id;
    },
    deleteItem() {
      this.deleteSpecies();
      this.dialog = false;
      firebase
        .database()
        .ref("Groups")
        .child(this.groupId)
        .remove()
        .then(() => {
          this.$notify({
            group: "success",
            type: "success",
            title: "BORRADO:",
            text: "El grupo se borro exitosamente"
          });
          this.groups = [];
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
    },
    deleteSpecies() {
      firebase
        .database()
        .ref("Species")
        .orderByChild("group_id")
        .equalTo(this.group.name)
        .on("value", snapshot => {
          var species = snapshot.val();
          for (var specie in species) {
            firebase
              .database()
              .ref("Species")
              .child(specie)
              .remove();
          }
        });
    }
  }
};
</script>