<template>
  <div>
    <div>
      <h2>{{title}}</h2>
    </div>
    <div>
      <v-breadcrumbs :items="items" divider=">"></v-breadcrumbs>
    </div>
    <v-text-field
      v-model="user.name"
      :rules="nameRules"
      label="Nombre"
      required
      :disabled="varUpdate"
    ></v-text-field>
    <v-text-field
      v-model="user.surname"
      :rules="nameRules"
      label="Apellido"
      required
      :disabled="varUpdate"
    ></v-text-field>
    <v-text-field
      v-model="user.username"
      :rules="nameRules"
      label="Nombre de usuario"
      required
      :disabled="varUpdate"
    ></v-text-field>
    <v-text-field
      v-model="user.email"
      :rules="emailRules"
      label="E-mail"
      required
      :disabled="varUpdate"
    ></v-text-field>
    <v-text-field
      v-model="user.password"
      :append-icon="show1 ? 'visibility' : 'visibility_off'"
      :rules="[rules.required, rules.min]"
      :type="show1 ? 'text' : 'password'"
      name="input-10-1"
      label="Contraseña"
      hint="Al menos 8 carácteres"
      counter
      @click:append="show1 = !show1"
      v-show="!varShow"
    ></v-text-field>
    <div>
      <v-btn @click="submit" v-show="!varShow">Guardar</v-btn>
      <v-btn to="/users" v-show="varShow">Volver</v-btn>
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
              <v-btn color="green darken-1" flat to="/users">Confirmar</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-layout>
    </div>
  </div>
</template>

<script>
import firebase from "firebase/app";
import "firebase/auth";
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
        text: "Lista de usuarios",
        disabled: false,
        href: "#/users"
      }
    ],
    varShow: false,
    varUpdate: false,
    user: {},
    nameRules: [v => !!v || "El nombre es obligatorio"],
    emailRules: [
      v => !!v || "E-mail es requerido",
      v => /.+@.+/.test(v) || "E-mail no es valido"
    ],
    show1: false,
    rules: {
      required: value => !!value || "Requerido",
      min: v => v.length >= 8 || "minimo 8 caracteres"
    },
    error: "",
    file: "",
    editedIndex: null,
    dialogBack: false,
    title: "",
    users: []
  }),
  created() {
    this.allUsers();
    this.edit();
    this.formTitle();
  },
  methods: {
    allUsers() {
      firebase
        .database()
        .ref("UsersWeb")
        .on("value", snapshot => {
          let users = snapshot.val();
          for (let user in users) {
            this.users.unshift({
              id: user,
              email: users[user].email,
              name: users[user].name,
              surname: users[user].surname,
              username: users[user].username
            });
          }
        });
    },
    formTitle() {
      if (this.editedIndex == null) {
        this.title = "Nuevo usuario";
        this.items.push({
          text: "Nuevo usuario",
          disabled: true,
          href: "#/user/new"
        });
      } else {
        this.title = "Editando " + this.user.name;
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
        this.title = "Visualizando " + this.user.name;
        this.items.push({
          text: "Visualizando Usuario",
          disabled: true,
          href: "#/user/view/" + this.$route.params.id
        });
      } else {
        this.varShow = false;
        this.items.push({
          text: "Editando usuario",
          disabled: true,
          href: "#/user/" + this.$route.params.id
        });
      }
      firebase
        .database()
        .ref("UsersWeb")
        .child(this.$route.params.id)
        .on("value", snapshot => {
          this.user = snapshot.val();
          this.user.id = this.$route.params.id;
          let user = this.users.pop(this.user.id);
        });
    },
    submit() {
      if (
        this.users.some(us => us.username.toLowerCase() === this.user.username.toLowerCase()) ||
        this.users.some(us => us.email.toLowerCase() === this.user.email.toLowerCase())
      ) {
        this.$notify({
          group: "error",
          type: "error",
          title: "ERROR:",
          text: "nombre de usuario y / o email ya existe"
        });
      } else {
        if (this.$route.params.id != null) {
          firebase
            .database()
            .ref("UsersWeb")
            .child(this.user.id)
            .update(this.user)
            .then(() => {
              this.setSuccessUpdate();
            })
            .catch(error => {
              this.setErrors(error);
            });
        } else {
          this.saveUser()
        }
      }
    },
    saveUser(id) {
      if (
        this.users.some(us => us.username.toLowerCase() === this.user.username.toLowerCase()) ||
        this.users.some(us => us.email.toLowerCase() === this.user.email.toLowerCase())
      ) {
        this.$notify({
          group: "error",
          type: "error",
          title: "ERROR:",
          text: "nombre de usuario y / o email ya existe"
        });
      } else {
        this.user.role="user"
        firebase
            .database()
            .ref("UsersWeb")
            .push(this.user)
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
        text: "El usuario se guardo exitosamente"
      });
      window.location.replace("#/users");
    },
    setSuccessUpdate() {
      this.$notify({
        group: "success",
        type: "success",
        title: "ACTUALIZACION:",
        text: "El usuario se actualizo exitosamente"
      });
      window.location.replace("#/users");
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
