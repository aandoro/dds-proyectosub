<template>
  <div>
    <div>
      <h2>{{title}}</h2>
    </div>
    <div>
      <v-breadcrumbs :items="items" divider=">"></v-breadcrumbs>
    </div>
    <v-text-field
      v-model="group.name"
      :rules="nameRules"
      label="Nombre"
      required
      :disabled="varShow"
    ></v-text-field>
    <v-textarea
      v-model="group.description"
      :rules="descriptionRules"
      label="Descripcion"
      required
      :disabled="varShow"
      :auto-grow="true"
    ></v-textarea>
    <div>
      <v-btn @click="submit" v-show="!varShow">Guardar</v-btn>
      <v-btn to="/groups" v-show="varShow">Volver</v-btn>
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
              <v-btn color="green darken-1" flat to="/groups">Confirmar</v-btn>
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
        disabled: false,
        href: "#/groups"
      }
    ],
    varShow: false,
    group: {
      name: "",
      description: ""
    },
    nameRules: [v => !!v || "El nombre es obligatorio"],
    descriptionRules: [v => !!v || "La descripcion es obligatorio"],
    error: "",
    editedIndex: null,
    dialogBack: false,
    title: "",
    groups: []
  }),
  created() {
    this.allGroups();
    this.formTitle();
    this.edit();
  },
  methods: {
    allGroups() {
      firebase
        .database()
        .ref("Groups")
        .on("value", snapshot => {
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
    formTitle() {
      this.editedIndex = this.$route.params.id;
      if (this.editedIndex == null) {
        this.title = "Nuevo Grupo";
        this.items.push({
          text: "Nuevo grupo",
          disabled: true,
          href: "#/group/new"
        });
      } else {
        this.title = "Editando " + this.group.name;
      }
    },
    OpenDialogBack() {
      this.dialogBack = true;
    },
    edit() {
      if (this.$route.params.id == null) {
        return;
      }
      if (this.$route.path.includes("view")) {
        this.varShow = true;
        this.title = "Visualizando " + this.group.name;
        this.items.push({
          text: "Visualizando Grupo",
          disabled: true,
          href: "#/group/view/" + this.$route.params.id
        });
      } else {
        this.varShow = false;
        this.items.push({
          text: "Editando grupo",
          disabled: true,
          href: "#/group/" + this.$route.params.id
        });
      }
      firebase
        .database()
        .ref("Groups")
        .child(this.$route.params.id)
        .on("value", snapshot => {
          this.group = snapshot.val();
          this.group.id = this.$route.params.id;
          let group = this.groups.pop(this.group.id);
        });
    },
    submit() {
      if (this.$route.params.id != null) {
        firebase
          .database()
          .ref("Groups")
          .child(this.group.id)
          .update(this.group)
          .then(() => {
            this.setSuccessUpdate();
          })
          .catch(error => {
            this.setErrors(error);
          });
      } else {
        if (this.groupExist()) {
          this.$notify({
            group: "error",
            type: "error",
            title: "ERROR:",
            text: "El grupo ya existe"
          });
        } else {
          if (this.requiredField()) {
            this.$notify({
              group: "error",
              type: "error",
              title: "ERROR:",
              text: "Completar campos obligatorios"
            });
          } else {
            firebase
              .database()
              .ref("Groups")
              .push(this.group)
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
    groupExist() {
      if (
        this.groups.some(gr => gr.name.toLowerCase() === this.group.name.toLowerCase()) ||
        this.groups.some(gr => gr.description === this.group.description)
      )
        return true;
      return false;
    },
    requiredField() {
      if (this.group.name === "" || this.group.description === "") return true;
      return false;
    },
    setSuccessNew() {
      this.$notify({
        group: "success",
        type: "success",
        title: "GUARDADO:",
        text: "El grupo se guardo exitosamente"
      });
      window.location.replace("#/groups");
    },
    setSuccessUpdate() {
      this.$notify({
        group: "success",
        type: "success",
        title: "ACTUALIZACION:",
        text: "El grupo se actualizo exitosamente"
      });
      window.location.replace("#/groups");
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
      this.group.name = "";
      this.group.description = "";
    }
  }
};
</script>
