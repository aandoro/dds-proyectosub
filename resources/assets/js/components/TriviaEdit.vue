<template>
  <div>
    <div>
      <h2>{{title}}</h2>
    </div>
    <div>
      <v-breadcrumbs :items="items" divider=">"></v-breadcrumbs>
    </div>
    <v-text-field
      v-model="trivia.name"
      :rules="nameRules"
      label="Nombre"
      required
      :disabled="varShow"
    ></v-text-field>
    <v-textarea
      v-model="trivia.description"
      :rules="descriptionRules"
      label="Descripcion"
      required
      :disabled="varShow"
      :auto-grow="true"
    ></v-textarea>
    <v-text-field
      v-model="trivia.question"
      :rules="questionRules"
      label="Pregunta"
      required
      :disabled="varShow"
    ></v-text-field>
    <v-select
      v-model="trivia.level_id"
      :items="levels"
      item-value="name"
      item-text="name"
      :rules="levelRules"
      label="Selecione un nivel"
      required
      :disabled="varShow"
    ></v-select>
    <v-select
      v-model="trivia.category_id"
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
          v-model="trivia.point"
          color="orange"
          label="Puntos"
          min="1"
          :max="trivia.point"
          thumb-label
          :disabled="varShow"
        ></v-slider>
      </v-flex>
      <v-flex xs12 md2></v-flex>
      <v-flex xs12 md3>
        <v-text-field v-model="trivia.point" :disabled="varShow"></v-text-field>
      </v-flex>
    </v-layout>
    <v-layout wrap>
      <v-flex xs12 sm6>
        <v-text-field v-model="option" label="opcion" required :disabled="varShow"></v-text-field>
      </v-flex>
      <v-flex xs12 sm6>
        <v-btn @click="addOption" :disabled="varShow">Agregar</v-btn>
        <!--<v-btn @click="selectOptCorrect" :disabled="varShow">Listo</v-btn>-->
      </v-flex>
    </v-layout>

    <!--<b-form-group v-if="selectCorrect" label="Marque una unica opcion correcta">
      <b-form-radio-group
        v-model="trivia.optCorrect"
        :options="trivia.options"
        text-field="option"
        :disabled="varShow"
        name="radio-inline"
      ></b-form-radio-group>
    </b-form-group>-->
    <v-radio-group
      v-model="trivia.optCorrect"
      v-if="selectCorrect"
      label="Marque una unica opcion correcta"
    >
      <v-radio v-for="n in trivia.options" :key="n" :label="n.option" :value="n.option"></v-radio>
    </v-radio-group>
    <div>
      <v-btn @click="submit" v-show="!varShow">Guardar</v-btn>
      <v-btn to="/trivias" v-show="varShow">Volver</v-btn>
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
              <v-btn color="green darken-1" flat to="/trivias">Confirmar</v-btn>
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
        disabled: false,
        href: "#/trivias"
      }
    ],
    varShow: false,
    trivia: {
      name: "",
      description: "",
      level_id: "",
      question: "",
      category_id: "",
      point: "",
      optCorrect: "",
      options: []
    },
    nameRules: [v => !!v || "El nombre es obligatorio"],
    descriptionRules: [v => !!v || "La descripcion es obligatorio"],
    questionRules: [v => !!v || "La pregunta es obligatorio"],
    levelRules: [v => !!v || "El nivel es obligatorio"],
    categoryRules: [v => !!v || "La categoria es obligatorio"],
    categories: [],
    levels: [],
    options: [],
    option: "",
    selectCorrect: false,

    error: "",
    editedIndex: null,
    dialogBack: false,
    title: "",
    trivias: []
  }),
  mounted() {
    this.allTrivias();
    this.fetch();
    this.edit();
  },
  methods: {
    allTrivias() {
      firebase
        .database()
        .ref("Trivias")
        .on("value", snapshot => {
          let trivias = snapshot.val();
          for (let trivia in trivias) {
            this.trivias.push({
              id: trivia,
              name: trivias[trivia].name,
              level_id: trivias[trivia].level_id,
              question: trivias[trivia].question,
              category_id: trivias[trivia].category_id,
              point: trivias[trivia].point,
              optCorrect: trivias[trivia].optCorrect,
              options: trivias[trivia].options
            });
          }
        });
    },
    formTitle() {
      if (this.editedIndex == null) {
        this.selectCorrect = false;
        this.title = "Nueva Trivia";
        this.items.push({
          text: "Nueva trivia",
          disabled: true,
          href: "#/trivia/new"
        });
      } else {
        this.title = "Editando " + this.trivia.name;
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
      this.selectOptCorrect();
      if (this.$route.params.id == null) {
        return;
      }
      if (this.$route.path.includes("view")) {
        this.selectCorrect = true;
        this.varShow = true;
        this.title = "Visualizando " + this.trivia.name;
        this.items.push({
          text: "Visualizando trivia",
          disabled: true,
          href: "#/trivia/view/" + this.$route.params.id
        });
      } else {
        this.varShow = false;
        this.items.push({
          text: "Editando trivia",
          disabled: true,
          href: "#/trivia/" + this.$route.params.id
        });
      }
      firebase
        .database()
        .ref("Trivias")
        .child(this.$route.params.id)
        .on("value", snapshot => {
          this.trivia = snapshot.val();
          this.trivia.id = this.$route.params.id;
          var triviaRemoved = this.trivias.pop(this.trivia.id);
        });
    },
    submit() {
      console.log(this.trivia);

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
            .ref("Trivias")
            .child(this.trivia.id)
            .update(this.trivia)
            .then(() => {
              this.setSuccessUpdate();
            })
            .catch(error => {
              this.setErrors(error);
            });
        } else {
          if (this.triviaExist()) {
            this.$notify({
              group: "error",
              type: "error",
              title: "ERROR:",
              text: "La trivia ya existe"
            });
          } else {
            if (this.trivia.optCorrect === "") {
              this.$notify({
                group: "error",
                type: "error",
                title: "ERROR:",
                text: "Necesita seleccionar una opcion correcta"
              });
            } else {
              firebase
                .database()
                .ref("Trivias")
                .push(this.trivia)
                .then(trivia => {
                  this.setSuccessNew();
                })
                .catch(error => {
                  this.setErrors(error);
                });
            }
          }
        }
      }
    },
    requiredField() {
      if (
        this.trivia.name === "" ||
        this.trivia.description === "" ||
        this.trivia.level_id === "" ||
        this.trivia.question === "" ||
        this.trivia.category_id === "" ||
        this.trivia.point === "" ||
        this.trivia.options === []
      )
        return true;
      return false;
    },
    triviaExist() {
      if (
        this.trivias.some(
          sp => sp.name.toLowerCase() === this.trivia.name.toLowerCase()
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
        text: "La trivia se guardo exitosamente"
      });
      window.location.replace("#/trivias");
    },
    setSuccessUpdate() {
      this.$notify({
        group: "success",
        type: "success",
        title: "ACTUALIZACION:",
        text: "La trivia se actualizo exitosamente"
      });
      window.location.replace("#/trivias");
    },
    setErrors(response) {
      this.error = response;
      this.$notify({
        group: "error",
        type: "error",
        title: "ERROR:",
        text: "Ocurrio un error al querer guardarlo"
      });
    },
    addOption() {
      this.selectOptCorrect();
      if (this.trivia.options.some(e => e.option === this.option)) {
        this.$notify({
          group: "error",
          type: "error",
          title: "ERROR:",
          text: "La opcion ya fue agregada"
        });
      } else {
        this.trivia.options.push({
          option: this.option
        });
        this.option = "";
      }
    },
    selectOptCorrect() {
      this.selectCorrect = true;
    }
  }
};
</script>
