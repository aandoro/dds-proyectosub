<template>
  <div>
    <div>
      <h2>{{title}}</h2>
    </div>
    <div>
      <v-breadcrumbs :items="items" divider=">"></v-breadcrumbs>
    </div>
    <v-text-field
      v-model="specie.name"
      :rules="nameRules"
      label="Nombre"
      required
      :disabled="varShow"
    ></v-text-field>
    <v-text-field v-model="specie.scientificName" label="Nombre cientifico" :disabled="varShow"></v-text-field>
    <v-textarea
      v-model="specie.description"
      :rules="descriptionRules"
      label="Descripcion"
      required
      :disabled="varShow"
      :auto-grow="true"
    ></v-textarea>
    <v-textarea
      v-model="specie.diet"
      :rules="dietRules"
      label="dieta"
      required
      :disabled="varShow"
      :auto-grow="true"
    ></v-textarea>
    <v-textarea
      v-model="specie.habitat"
      :rules="habitatRules"
      label="habitat"
      required
      :disabled="varShow"
      :auto-grow="true"
    ></v-textarea>
    <v-textarea
      v-model="specie.reproduction"
      :rules="reproductionRules"
      label="reproduccion"
      required
      :disabled="varShow"
      :auto-grow="true"
    ></v-textarea>
    <v-select
      v-model="specie.group_id"
      :items="groups"
      item-value="name"
      item-text="name"
      :rules="groupRules"
      label="Selecione un grupo"
      required
      :disabled="varShow"
    ></v-select>
    <div v-show="!varShow">
      <b-form-file
        v-model="file"
        :state="Boolean(file)"
        placeholder="seleccione una foto..."
        @change="fieldChange"
      ></b-form-file>
      <div class="mt-3">Selected file: {{file && file.name}}</div>
      <div v-show="file !== null">
        <img id="previsualizacion" src="#" height="200" width="200" />
      </div>
    </div>
    <div v-show="specie.image !== ''" class="col-sm mt-3 mt-sm-0">
      <v-carousel>
        <v-carousel-item v-for="(image,i) in images" :key="i" :src="image.src"></v-carousel-item>
      </v-carousel>
    </div>
    <div>
      <v-btn @click="submit" v-show="!varShow">Guardar</v-btn>
      <v-btn to="/species" v-show="varShow">Volver</v-btn>
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
              <v-btn color="green darken-1" flat to="/species">Confirmar</v-btn>
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
        disabled: false,
        href: "#/species"
      }
    ],
    varShow: false,
    specie: {
      name: "",
      scientificName: "",
      description: "",
      diet: "",
      habitat: "",
      reproduction: "",
      group_id: "",
      image: ""
    },
    nameRules: [v => !!v || "El nombre es obligatorio"],
    descriptionRules: [v => !!v || "La descripcion es obligatorio"],
    dietRules: [v => !!v || "La dieta es obligatorio"],
    habitatRules: [v => !!v || "El habitat es obligatorio"],
    reproductionRules: [v => !!v || "La reproduccion es obligatorio"],
    groupRules: [v => !!v || "El grupo es obligatorio"],
    groups: [],
    error: "",
    file: null,
    editedIndex: null,
    dialogBack: false,
    title: "",
    images: [],
    species: [],
    specieRemoved: {}
  }),
  created() {
    this.allSpecies();
    this.fetch();
    this.edit();
    this.formTitle();
  },
  methods: {
    allSpecies() {
      firebase
        .database()
        .ref("Species")
        .on("value", snapshot => {
          let levels = snapshot.val();
          for (let level in levels) {
            let species = snapshot.val();
            for (let specie in species) {
              this.species.push({
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
          }
        });
    },
    formTitle() {
      if (this.editedIndex == null) {
        this.title = "Nueva Especie";
        this.items.push({
          text: "Nueva especie",
          disabled: true,
          href: "#/specie/new"
        });
      } else {
        this.title = "Editando " + this.specie.name;
      }
    },
    fetch() {
      this.editedIndex = this.$route.params.id;
      firebase
        .database()
        .ref("Groups")
        .on("value", snapshot => {
          let index = 1;
          let groups = snapshot.val();
          for (let group in groups) {
            this.groups.push({
              id: group,
              name: groups[group].name,
              description: groups[group].description
            });
          }
        });
    },
    OpenDialogBack() {
      this.dialogBack = true;
    },
    fieldChange(e) {
      this.file = e.target.files[0];
      this.createImage(this.file);
    },
    createImage(file) {
      this.specie.image = file.name;
      let reader = new FileReader();
      reader.onload = e => {
        $("#previsualizacion").attr("src", e.target.result);
      };
      reader.readAsDataURL(file);
    },
    edit() {
      if (this.$route.params.id == null) {
        return;
      }
      if (this.$route.path.includes("view")) {
        this.varShow = true;
        this.title = "Visualizando " + this.specie.name;
        this.items.push({
          text: "Visualizando especie",
          disabled: true,
          href: "#/specie/view/" + this.$route.params.id
        });
      } else {
        this.varShow = false;
        this.items.push({
          text: "Editando especie",
          disabled: true,
          href: "#/specie/" + this.$route.params.id
        });
      }
      firebase
        .database()
        .ref("Species")
        .child(this.$route.params.id)
        .on("value", snapshot => {
          this.specie = snapshot.val();
          this.specie.id = this.$route.params.id;
          this.specieRemoved = this.species.pop(this.specie.id);

          firebase
            .storage()
            .ref("Species/" + this.specie.image)
            .getDownloadURL()
            .then(url => {
              this.images.push({ src: url });
            })
            .catch(error => {
              console.log(error.message);
            });
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
            .ref("Species")
            .child(this.specie.id)
            .update(this.specie)
            .then(specie => {
              console.log("update " + this.specie.image);

              if (this.file !== null) {
                firebase
                  .storage()
                  .ref("Species")
                  .child(this.file.name)
                  .put(this.file)
                  .then(() => {
                    this.setSuccessUpdate();
                  })
                  .catch(error => {
                    console.log("storage " + error.message);
                    this.setErrors(error);
                  });
              }
              this.setSuccessUpdate();
            })
            .catch(error => {
              console.log("updatec " + error.message);
              this.setErrors(error);
            });
        } else {
          if (this.specieExist()) {
            this.$notify({
              group: "error",
              type: "error",
              title: "ERROR:",
              text: "La especie ya existe"
            });
          } else {
            if (this.requiredField() || this.file === null) {
              this.$notify({
                group: "error",
                type: "error",
                title: "ERROR:",
                text: "Completar campos obligatorios"
              });
            } else {
              firebase
                .database()
                .ref("Species")
                .push(this.specie)
                .then(specie => {
                  firebase
                    .storage()
                    .ref("Species")
                    .child(this.file.name)
                    .put(this.file)
                    .then(() => {
                      this.setSuccessNew();
                    })
                    .catch(error => {
                      console.log("storage " + error.message);
                      this.setErrors(error);
                    });
                })
                .catch(error => {
                  console.log("newc " + error.message);
                  this.setErrors(error);
                });
            }
          }
        }
      }
    },
    requiredField() {
      if (
        this.specie.name === "" ||
        this.specie.description === "" ||
        this.specie.diet === "" ||
        this.specie.habitat === "" ||
        this.specie.reproduction === "" ||
        this.specie.group_id === ""
      )
        return true;
      return false;
    },
    specieExist() {
      if (this.species.some(sp => sp.name.toLowerCase() === this.specie.name.toLowerCase())) {
        return true;
      }
      return false;
    },
    setSuccessNew() {
      this.$notify({
        group: "success",
        type: "success",
        title: "GUARDADO:",
        text: "La especie se guardo exitosamente"
      });
      window.location.replace("#/species");
    },
    setSuccessUpdate() {
      this.$notify({
        group: "success",
        type: "success",
        title: "ACTUALIZACION:",
        text: "La especie se actualizo exitosamente"
      });
      window.location.replace("#/species");
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
    onReset(evt) {
      evt.preventDefault();
      // Reset our form values
      this.specie.name = "";
      this.specie.scientificName = "";
      this.specie.description = "";
      this.specie.diet = "";
      this.specie.habitat = "";
      this.specie.reproduction = "";
      this.specie.group_id = "";
      this.specie.image = null;
    }
  }
};
</script>

<style>
.example-slide {
  align-items: center;
  background-color: #666;
  color: #999;
  display: flex;
  font-size: 1.5rem;
  justify-content: center;
  min-height: 10rem;
  height: 50%;
  width: 50%;
}
</style>