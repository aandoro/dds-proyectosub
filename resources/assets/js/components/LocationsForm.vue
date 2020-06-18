<template>
  <div>
    <div>
      <v-breadcrumbs :items="items" divider=">"></v-breadcrumbs>
    </div>
    <v-toolbar flat color="white">
      <v-toolbar-title>Localidades</v-toolbar-title>
      <v-divider class="mx-2" inset vertical></v-divider>
      <v-spacer></v-spacer>
      <v-btn color="primary" dark class="mb-2" to="/location/new">Nuevo</v-btn>
    </v-toolbar>
    <v-data-table :headers="headers" :items="locations" class="elevation-1">
      <template v-slot:items="props">
        <td>{{ props.item.name }}</td>
        <td class="justify-center">
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
        text: "Lista de localidades",
        disabled: true,
        href: "#/locations"
      }
    ],
    headers: [
      { text: "Nombres", value: "name" },
      { text: "Actiones", value: "name", sortable: false }
    ],
    locations: [],
    dialog: false,
    locationId: null
  }),
  created() {
    this.initialize();
  },
  methods: {
    initialize() {
      firebase
        .database()
        .ref("Locations")
        .on("value", snapshot => {
          let index = 1;
          let locations = snapshot.val();
          for (let location in locations) {
            this.locations.unshift({
              id: location,
              name: locations[location].name
            });
          }
        });
    },
    OpenDialog(id) {
      this.dialog = true;
      this.locationId = id;
    },
    deleteItem() {
      this.dialog = false;
      firebase
        .database()
        .ref("Locations")
        .child(this.locationId)
        .remove()
        .then(() => {
          this.$notify({
            group: "success",
            type: "success",
            title: "BORRADO:",
            text: "La localidad se borro exitosamente"
          });
          this.locations = [];
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