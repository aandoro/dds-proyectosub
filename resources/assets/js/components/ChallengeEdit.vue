<template>
  <div>
    <div>
      <h2>{{title}}</h2>
    </div>
    <div>
      <v-breadcrumbs :items="items" divider=">"></v-breadcrumbs>
    </div>
    <v-text-field
      v-model="challenge.name"
      :rules="nameRules"
      label="Nombre"
      required
      :disabled="varShow"
    ></v-text-field>
    <v-textarea
      v-model="challenge.description"
      :rules="descriptionRules"
      label="Descripcion"
      required
      :disabled="varShow"
      :auto-grow="true"
    ></v-textarea>
    <v-select
      v-model="challenge.level_id"
      :items="levels"
      item-value="name"
      item-text="name"
      :rules="levelRules"
      label="Selecione un nivel"
      required
      :disabled="varShow"
    ></v-select>
    <v-select
      v-model="challenge.category_id"
      :items="categories"
      item-value="name"
      item-text="name"
      :rules="categoryRules"
      label="Selecione una categoria"
      required
      :disabled="varShow"
    ></v-select>
    <v-layout>
      <v-flex xs12 md8>
        <v-slider
          v-model="challenge.picCount"
          color="orange"
          label="Cantidad de fotos"
          min="1"
          max="5"
          thumb-label
          :disabled="varShow"
        ></v-slider>
      </v-flex>
      <v-flex xs12 md2></v-flex>
      <v-flex xs12 md3>
        <v-text-field v-model="challenge.picCount" :disabled="true"></v-text-field>
      </v-flex>
    </v-layout>
    <v-layout>
      <v-flex xs12 md8>
        <v-slider
          v-model="challenge.point"
          color="orange"
          label="Puntos"
          min="1"
          :max="challenge.point"
          thumb-label
          :disabled="varShow"
        ></v-slider>
      </v-flex>
      <v-flex xs12 md2></v-flex>
      <v-flex xs12 md3>
        <v-text-field v-model="challenge.point" :disabled="varShow"></v-text-field>
      </v-flex>
    </v-layout>
    <div>
      <v-btn @click="submit" v-show="!varShow">Guardar</v-btn>
      <v-btn to="/challenges" v-show="varShow">Volver</v-btn>
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
              <v-btn color="green darken-1" flat to="/challenges">Confirmar</v-btn>
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
        text: "Lista de desafios",
        disabled: false,
        href: "#/challenges"
      }
    ],
    varShow: false,
    challenge: {
      name: "",
      description: "",
      category_id: "",
      level_id: "",
      point: "",
      picCount: ""
    },
    nameRules: [v => !!v || "El nombre es obligatorio"],
    descriptionRules: [v => !!v || "La descripcion es obligatorio"],
    questionRules: [v => !!v || "La pregunta es obligatorio"],
    levelRules: [v => !!v || "El nivel es obligatorio"],
    categoryRules: [v => !!v || "La categoria es obligatorio"],
    categories: [],
    levels: [],
    error: "",
    editedIndex: null,
    dialogBack: false,
    title: "",
    challenges: []
  }),
  created() {
    this.allChallenges();
    this.fetch();
    this.edit();
  },
  methods: {
    allChallenges() {
      firebase
        .database()
        .ref("Challenges")
        .on("value", snapshot => {
          let challenges = snapshot.val();
          for (let challenge in challenges) {
            this.challenges.push({
              id: challenge,
              name: challenges[challenge].name,
              description: challenges[challenge].description,
              category_id: challenges[challenge].category_id,
              picCount: challenges[challenge].picCount,
              point: challenges[challenge].point,
              level_id: challenges[challenge].level_id
            });
          }
        });
    },
    formTitle() {
      if (this.editedIndex == null) {
        this.title = "Nuevo Desafio";
        this.items.push({
          text: "Nuevo desafio",
          disabled: true,
          href: "#/challenge/new"
        });
      } else {
        this.title = "Editando " + this.challenge.name;
      }
    },
    OpenDialogBack() {
      this.dialogBack = true;
    },
    fetch() {
      this.editedIndex = this.$route.params.id;
      firebase
        .database()
        .ref("Levels")
        .on("value", snapshot => {
          let index = 1;
          let levels = snapshot.val();
          for (let level in levels) {
            this.levels.unshift({
              id: level,
              name: levels[level].name,
              number: index++,
              scoreRequired: levels[level].scoreRequired
            });
          }
          this.levels.reverse();
        });
      firebase
        .database()
        .ref("Categories")
        .on("value", snapshot => {
          let categories = snapshot.val();
          for (let category in categories) {
            this.categories.unshift({
              id: category,
              name: categories[category].name
            });
          }
          this.categories.reverse();
        });
      this.formTitle();
    },
    edit() {
      if (this.$route.params.id == null) {
        return;
      }
      if (this.$route.path.includes("view")) {
        this.varShow = true;
        this.title = "Visualizando " + this.challenge.name;
        this.items.push({
          text: "Visualizando desafio",
          disabled: true,
          href: "#/challenge/view/" + this.$route.params.id
        });
      } else {
        this.varShow = false;
        this.items.push({
          text: "Editando desafio",
          disabled: true,
          href: "#/challenge/" + this.$route.params.id
        });
      }
      firebase
        .database()
        .ref("Challenges")
        .child(this.$route.params.id)
        .on("value", snapshot => {
          this.challenge = snapshot.val();
          this.challenge.id = this.$route.params.id;
          let challengeRemoved = this.challenges.pop(this.challenge.id);
        });
    },
    submit() {
      if (this.requiredField()) {
        this.$notify({
          group: "error",
          type: "error",
          title: "ERROR:",
          text: "Completar campos obligatorios"
        });
      } else {
        if (this.$route.params.id != null) {
          firebase
            .database()
            .ref("Challenges")
            .child(this.challenge.id)
            .update(this.challenge)
            .then(() => {
              this.setSuccessUpdate();
            })
            .catch(error => {
              this.setErrors(error);
            });
        } else {
          if (this.challengeExist()) {
            this.$notify({
              group: "error",
              type: "error",
              title: "ERROR:",
              text: "El desafio ya existe"
            });
          } else {
            firebase
              .database()
              .ref("Challenges")
              .push(this.challenge)
              .then(() => {
                this.setSuccessNew();
              })
              .catch(error => {
                this.setErrors(error);
              });
          }
        }
      }
    },
    requiredField() {
      if (
        this.challenge.name === "" ||
        this.challenge.description === "" ||
        this.challenge.category_id === "" ||
        this.challenge.level_id === "" ||
        this.challenge.point === "" ||
        this.challenge.picCount === ""
      )
        return true;
      return false;
    },
    challengeExist() {
      if (
        this.challenges.some(
          sp => sp.name.toLowerCase() === this.challenge.name.toLowerCase()
        )
      ) {
        return true;
      }
      return false;
    },
    setSuccessNew() {
      this.$notify({
        group: "success",
        type: "success",
        title: "GUARDADO:",
        text: "El desafio se guardo exitosamente"
      });
      window.location.replace("#/challenges");
    },
    setSuccessUpdate() {
      this.$notify({
        group: "success",
        type: "success",
        title: "ACTUALIZACION:",
        text: "El desafio se actualizo exitosamente"
      });
      window.location.replace("#/challenges");
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