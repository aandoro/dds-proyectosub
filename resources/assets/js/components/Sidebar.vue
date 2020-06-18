<!--<template>
  <div>
    <v-app id="inspire">
      <v-navigation-drawer clipped v-model="drawer" fixed app v-if="authenticated">
        <v-list dense>
          <v-list-item>
            <v-list-tile-action>
              <v-icon>home</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile to="/home">
                <v-list-tile-title>Inicio</v-list-tile-title>
              </v-list-tile>
            </v-list-tile-content>
          </v-list-item>
          <div v-if="isAdmin() === true">
            <v-list-group
              v-for="item in items"
              :key="item.title"
              v-model="item.active"
              :prepend-icon="item.action"
              no-action
            >
              <template v-slot:activator>
                <v-list-tile>
                  <v-list-tile-action>
                    <v-icon>{{item.icon}}</v-icon>
                  </v-list-tile-action>
                  <v-list-tile-content>
                    <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                  </v-list-tile-content>
                </v-list-tile>
              </template>
              <v-list-tile v-for="subItem in item.items" :key="subItem.title" :to="subItem.path">
                <v-list-tile-content>
                  <v-list-tile-title>{{ subItem.title }}</v-list-tile-title>
                </v-list-tile-content>
                <v-list-tile-action>
                  <v-icon>{{ subItem.action }}</v-icon>
                </v-list-tile-action>
              </v-list-tile>
            </v-list-group>
          </div>
          <div v-else>
            <v-list-group
              v-for="item in itemsUsers"
              :key="item.title"
              v-model="item.active"
              :prepend-icon="item.action"
              no-action
            >
              <template v-slot:activator>
                <v-list-tile>
                  <v-list-tile-action>
                    <v-icon>{{item.icon}}</v-icon>
                  </v-list-tile-action>
                  <v-list-tile-content>
                    <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                  </v-list-tile-content>
                </v-list-tile>
              </template>
              <v-list-tile v-for="subItem in item.items" :key="subItem.title" :to="subItem.path">
                <v-list-tile-content>
                  <v-list-tile-title>{{ subItem.title }}</v-list-tile-title>
                </v-list-tile-content>
                <v-list-tile-action>
                  <v-icon>{{ subItem.action }}</v-icon>
                </v-list-tile-action>
              </v-list-tile>
            </v-list-group>
          </div>
          <v-list-tile>
            <v-list-tile-action>
              <v-icon>assignment_turned_in</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile to="/responses">
                <v-list-tile-title>Respuestas de desafios</v-list-tile-title>
              </v-list-tile>
            </v-list-tile-content>
          </v-list-tile>
        </v-list>
      </v-navigation-drawer>
      <v-toolbar color="indigo" dark fixed clipped-left app v-if="authenticated">
        <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
        <v-toolbar-title>Proyecto Sub</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn
          rounded
          color="primary"
          dark
          v-if="authenticated"
          to="/login"
          v-on:click.native="logout()"
          replace
        >Cerrar Sesion</v-btn>
      </v-toolbar>
      <v-content>
        <v-container fluid>
          <router-view @authenticated="setAuthenticated"></router-view>
          <notifications group="success" position="bottom right" />
          <notifications group="error" position="bottom right" />
        </v-container>
      </v-content>
      <v-footer color="indigo" class="pa-3" v-if="authenticated">
        <v-spacer></v-spacer>
        <span class="white--text" right>UNPSJB &copy; 2019</span>
      </v-footer>
    </v-app>
  </div>
</template>-->
<template>
  <div>
    <v-app id="inspire">
      <v-navigation-drawer clipped v-model="drawer" app v-if="user">
        <v-list dense>
          <v-list-tile>
            <v-list-tile-action>
              <v-icon>home</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile to="/home">
                <v-list-tile-title>Inicio</v-list-tile-title>
              </v-list-tile>
            </v-list-tile-content>
          </v-list-tile>
          <div v-if="isAdmin() === true">
            <v-list-group
              v-for="item in items"
              :key="item.title"
              v-model="item.active"
              :prepend-icon="item.action"
              no-action
            >
              <template v-slot:activator>
                <v-list-tile>
                  <v-list-tile-action>
                    <v-icon>{{item.icon}}</v-icon>
                  </v-list-tile-action>
                  <v-list-tile-content>
                    <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                  </v-list-tile-content>
                </v-list-tile>
              </template>
              <v-list-tile v-for="subItem in item.items" :key="subItem.title" :to="subItem.path">
                <v-list-tile-content>
                  <v-list-tile-title>{{ subItem.title }}</v-list-tile-title>
                </v-list-tile-content>
                <v-list-tile-action>
                  <v-icon>{{ subItem.action }}</v-icon>
                </v-list-tile-action>
              </v-list-tile>
            </v-list-group>
          </div>
          <div v-else>
            <v-list-group
              v-for="item in itemsUsers"
              :key="item.title"
              v-model="item.active"
              :prepend-icon="item.action"
              no-action
            >
              <template v-slot:activator>
                <v-list-tile>
                  <v-list-tile-action>
                    <v-icon>{{item.icon}}</v-icon>
                  </v-list-tile-action>
                  <v-list-tile-content>
                    <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                  </v-list-tile-content>
                </v-list-tile>
              </template>
              <v-list-tile v-for="subItem in item.items" :key="subItem.title" :to="subItem.path">
                <v-list-tile-content>
                  <v-list-tile-title>{{ subItem.title }}</v-list-tile-title>
                </v-list-tile-content>
                <v-list-tile-action>
                  <v-icon>{{ subItem.action }}</v-icon>
                </v-list-tile-action>
              </v-list-tile>
            </v-list-group>
          </div>
          <v-list-tile>
            <v-list-tile-action>
              <v-icon>assignment_turned_in</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile to="/responses">
                <v-list-tile-title>Respuestas de desafios</v-list-tile-title>
              </v-list-tile>
            </v-list-tile-content>
          </v-list-tile>
        </v-list>
      </v-navigation-drawer>
      <v-toolbar color="indigo" dark fixed clipped-left app v-if="user">
        <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
        <v-toolbar-title>Proyecto Sub</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn
          rounded
          color="primary"
          dark
          to="/login"
          v-on:click.native="logout()"
          replace
        >Cerrar Sesion</v-btn>
      </v-toolbar>
      <v-content>
        <v-container fluid>
          <router-view></router-view>
          <notifications group="success" position="bottom right" />
          <notifications group="error" position="bottom right" />
        </v-container>
      </v-content>
      <v-footer color="indigo" class="pa-3" v-if="user">
        <v-spacer></v-spacer>
        <span class="white--text" right>UNPSJB &copy; 2019</span>
      </v-footer>
    </v-app>
  </div>
</template>

<script>
import firebase from "firebase/app";
import "firebase/auth";
import "firebase/database";

export default {
  data: () => ({
    drawer: null,
    user: null,
    items: [
      {
        title: "Administracion",
        icon: "verified_user",
        items: [
          { path: "/user/new", title: "Nuevo usuario", action: "add" },
          { path: "/users", title: "Lista de usuarios", action: "list" },
          { path: "/levels", title: "Agregar Niveles", action: "add" },
          { path: "/locations", title: "Agregar Localidades", action: "add" }
        ]
      },
      {
        title: "Desafios",
        icon: "mobile_screen_share",
        items: [
          { path: "/Challenge/new", title: "Nuevo desafio", action: "add" },
          { path: "/Challenges", title: "Lista de desafios", action: "list" }
        ]
      },
      {
        title: "Trivias",
        icon: "live_help",
        items: [
          { path: "/trivia/new", title: "Nueva trivia", action: "add" },
          { path: "/trivias", title: "Lista de trivias", action: "list" }
        ]
      },
      {
        title: "Grupos de especies",
        icon: "school",
        items: [
          { path: "/group/new", title: "Nuevo grupo", action: "add" },
          { path: "/groups", title: "Lista de grupos", action: "list" }
        ]
      },
      {
        title: "Especies",
        icon: "bug_report",
        items: [
          { path: "/specie/new", title: "Nueva especie", action: "add" },
          { path: "/species", title: "Lista de especies", action: "list" }
        ]
      }
    ],
    itemsUsers: [
      {
        title: "Desafios",
        icon: "mobile_screen_share",
        items: [
          { path: "/Challenge/new", title: "Nuevo desafio", action: "add" },
          { path: "/Challenges", title: "Lista de desafios", action: "list" }
        ]
      },
      {
        title: "Trivias",
        icon: "live_help",
        items: [
          { path: "/trivia/new", title: "Nueva trivia", action: "add" },
          { path: "/trivias", title: "Lista de trivias", action: "list" }
        ]
      },
      {
        title: "Grupos de especies",
        icon: "school",
        items: [
          { path: "/group/new", title: "Nuevo grupo", action: "add" },
          { path: "/groups", title: "Lista de grupos", action: "list" }
        ]
      },
      {
        title: "Especies",
        icon: "bug_report",
        items: [
          { path: "/specie/new", title: "Nueva especie", action: "add" },
          { path: "/species", title: "Lista de especies", action: "list" }
        ]
      }
    ]
  }),
  created() {
    firebase.auth().onAuthStateChanged(user => {
      if (user) {
        firebase
          .database()
          .ref("UsersWeb")
          .orderByChild("email")
          .equalTo(user.email)
          .on("value", snapshot => {
            var cUser = snapshot.val();
            for (const key in cUser) {
              this.user = cUser[key];
            }
          });
      } else {
        this.user = null;
      }
    });
  },
  methods: {
    isAdmin() {
      if (this.user.role === "user") {
        return false;
      }
      return true;
    },
    logout() {
      firebase
        .auth()
        .signOut()
        .then(() => {
          this.$router.push({ path: "/login" });
        });
    }
  }
};
</script>
