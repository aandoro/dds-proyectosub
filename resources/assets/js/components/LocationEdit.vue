<template>
  <div>
    <div>
      <h2>{{title}}</h2>
    </div>
    <div>
      <v-breadcrumbs :items="items" divider=">"></v-breadcrumbs>
    </div>
    <v-autocomplete
      v-model="location"
      :items="locations"
      hide-selected
      item-text="nombre"
      item-value="nombre"
      label="Selecione una localidad"
      return-object
    ></v-autocomplete>
    <div>
      <v-btn @click="submit" v-show="!varShow">Guardar</v-btn>
      <v-btn to="/locations" v-show="varShow">Volver</v-btn>
      <v-btn @click="OpenDialogBack()" v-show="!varShow">Volver</v-btn>
    </div>
    <div>
      <v-layout row justify-center>
        <v-dialog v-model="dialogBack" persistent max-width="290">
          <v-card>
            <v-card-title class="headline">¿Esta seguro que desea volver?</v-card-title>
            <v-card-text></v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="green darken-1" flat @click="dialogBack = false">Cancelar</v-btn>
              <v-btn color="green darken-1" flat to="/locations">Confirmar</v-btn>
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
        disabled: false,
        href: "#/locations"
      }
    ],
    varShow: false,
    varUpdate: false,
    location: {},
    locations: [],
    nameRules: [v => !!v || "La localidad es obligatoria"],
    error: "",
    editedIndex: null,
    dialogBack: false,
    title: "",
    locationFirebase: []
  }),
  created() {
    this.allLocations();
    this.fetch();
    this.edit();
    this.formTitle();
  },
  methods: {
    allLocations() {
      firebase
        .database()
        .ref("Locations")
        .on("value", snapshot => {
          let locations = snapshot.val();
          for (let location in locations) {
            this.locationFirebase.push({
              id: location,
              name: locations[location].name,
              longitud: locations[location].longitud,
              latitud: locations[location].latitud,
              weather: locations[location].weather
            });
          }
        });
    },
    fetch() {
      axios
        .get("https://apis.datos.gob.ar/georef/api/localidades?max=5000")
        .then(data => {
          this.locations = data.data.localidades;
        })
        .catch(error => {
          console.log(error.message);
        });
    },
    formTitle() {
      if (this.editedIndex == null) {
        this.title = "Nueva localidad";
        this.varShow = false;
        this.items.push({
          text: "Nueva localidad",
          disabled: true,
          href: "#/location/new"
        });
      } else {
        this.title = "Editando " + this.location.name;
      }
    },
    OpenDialogBack() {
      this.dialogBack = true;
    },
    edit() {
      this.editedIndex = this.$route.params.id;
      if (this.$route.params.id == null) {
        return;
      }
      if (this.$route.path.includes("view")) {
        this.varUpdate = true;
        this.varShow = true;
        this.title = "Visualizando " + this.location.name;
        this.items.push({
          text: "Visualizando Localidad",
          disabled: true,
          href: "#/location/view/" + this.$route.params.id
        });
      } else {
        this.varShow = false;
        this.items.push({
          text: "Editando Localidad",
          disabled: true,
          href: "#/location/" + this.$route.params.id
        });
      }
    },
    submit() {
      let location = {};
      let nametlc = this.location.nombre.toLowerCase();
      console.log(nametlc);

      if (
        this.locationFirebase.some(loc => loc.name.toLowerCase() === nametlc)
      ) {
        this.$notify({
          group: "error",
          type: "error",
          title: "ERROR:",
          text: "la localidad ya existe"
        });
      } else {
        location.name = this.location.nombre.toLowerCase();
        location.latitud = this.location.centroide.lat;
        location.longitud = this.location.centroide.lon;
        location.weather = true;
        firebase
          .database()
          .ref("Locations")
          .push(location)
          .then(() => {
            this.setSuccessNew();
          })
          .catch(error => {
            this.setErrors(error);
          });
      }
    },
    setSuccessNew() {
      this.$notify({
        group: "success",
        type: "success",
        title: "GUARDADO:",
        text: "La localidad se guardo exitosamente"
      });
      window.location.replace("#/locations");
    },
    setSuccessUpdate() {
      this.$notify({
        group: "success",
        type: "success",
        title: "ACTUALIZACION:",
        text: "La localidad se actualizo exitosamente"
      });
      window.location.replace("#/locations");
    },
    setErrors(response) {
      this.error = response;
      this.$notify({
        group: "error",
        type: "error",
        title: "ERROR:",
        text: "Ocurrio un error al querer guardarlo"
      });
    }
  }
};
</script>
