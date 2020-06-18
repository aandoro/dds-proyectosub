<template>
  <div>
    <div>
      <h2>{{title}}</h2>
    </div>
    <div>
      <v-breadcrumbs :items="items" divider=">"></v-breadcrumbs>
    </div>
    <v-text-field
      v-model="level.name"
      :rules="nameRules"
      label="Nombre"
      required
      :disabled="varUpdate"
    ></v-text-field>
    <v-layout>
      <v-flex xs12 md8>
        <v-slider
          v-model="level.scoreRequired"
          color="orange"
          label="Puntos"
          min="1"
          :max="level.scoreRequired"
          thumb-label
          :disabled="varShow"
        ></v-slider>
      </v-flex>
      <v-flex xs12 md2></v-flex>
      <v-flex xs12 md3>
        <v-text-field v-model="level.scoreRequired" :disabled="varShow"></v-text-field>
      </v-flex>
    </v-layout>
    <div>
      <v-btn @click="submit" v-show="!varShow">Guardar</v-btn>
      <v-btn to="/levels" v-show="varShow">Volver</v-btn>
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
              <v-btn color="green darken-1" flat to="/levels">Confirmar</v-btn>
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
        disabled: false,
        href: "#/levels"
      }
    ],
    varShow: false,
    varUpdate: false,
    level: {
      id: null,
      name: "",
      scoreRequired: 0,
      number: 0
    },
    nameRules: [v => !!v || "El nombre es obligatorio"],
    error: "",
    editedIndex: null,
    dialogBack: false,
    title: "",
    levels: []
  }),
  created() {
    this.allLevels();
    this.edit();
    this.formTitle();
  },
  methods: {
    allLevels() {
      firebase
        .database()
        .ref("Levels")
        .on("value", snapshot => {
          let levels = snapshot.val();
          for (let level in levels) {
            this.levels.push({
              id: level,
              name: levels[level].name,
              number: levels[level].number,
              scoreRequired: levels[level].scoreRequired
            });
          }
        });
    },
    formTitle() {
      if (this.editedIndex == null) {
        this.title = "Nuevo Nivel";
        this.varShow = false;
        this.items.push({
          text: "Nuevo Nivel",
          disabled: true,
          href: "#/level/new"
        });
      } else {
        this.title = "Editando " + this.level.name;
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
        this.title = "Visualizando " + this.level.name;
        this.items.push({
          text: "Visualizando Nivel",
          disabled: true,
          href: "#/level/view/" + this.$route.params.id
        });
      } else {
        this.varShow = false;
        this.items.push({
          text: "Editando Nivel",
          disabled: true,
          href: "#/level/" + this.$route.params.id
        });
      }
      firebase
        .database()
        .ref("Levels")
        .child(this.$route.params.id)
        .on("value", snapshot => {
          this.level = snapshot.val();
          this.level.id = this.$route.params.id;
          let level = this.levels.pop(this.user.id);
        });
    },
    submit() {
      if (this.levels.some(lvl => lvl.name.toLowerCase() === this.level.name.toLowerCase())) {
        this.$notify({
          group: "error",
          type: "error",
          title: "ERROR:",
          text: "nombre de nivel ya existe"
        });
      } else {
        if (this.$route.params.id != null) {
          firebase
            .database()
            .ref("Levels")
            .child(this.level.id)
            .update(this.level)
            .then(() => {
              this.setSuccessUpdate();
            })
            .catch(error => {
              this.setErrors(error);
            });
        } else {
          firebase
            .database()
            .ref("Levels")
            .push(this.level)
            .then(() => {
              this.setSuccessNew();
            })
            .catch(error => {
              this.setErrors(error);
            });
        }
      }
    },
    setSuccessNew() {
      this.$notify({
        group: "success",
        type: "success",
        title: "GUARDADO:",
        text: "La usuario se guardo exitosamente"
      });
      window.location.replace("#/levels");
    },
    setSuccessUpdate() {
      this.$notify({
        group: "success",
        type: "success",
        title: "ACTUALIZACION:",
        text: "La usuario se actualizo exitosamente"
      });
      window.location.replace("#/levels");
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
