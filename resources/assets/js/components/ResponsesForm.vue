<template>
  <div>
    <div>
      <v-breadcrumbs :items="items" divider=">"></v-breadcrumbs>
    </div>
    <v-toolbar flat color="white">
      <v-toolbar-title>Respuestas de desafios</v-toolbar-title>
      <v-spacer></v-spacer>
      <download-excel
        :data="registers"
        :fields="json_fields"
        type="csv"
        name="respuesta_usuarios.xls"
      >
        <v-btn color="primary" dark>Exportar</v-btn>
      </download-excel>
    </v-toolbar>
    <v-data-table :headers="headers" :items="responses" class="elevation-1">
      <template v-slot:items="props">
        <td>{{ props.item.user_name }}</td>
        <td>{{ props.item.challenge_id }}</td>
        <td>{{ props.item.init_challenge | formatDate }}</td>
        <td>{{ props.item.finish_challenge | formatDate}}</td>
        <td class="justify-center">
          <router-link :to="'/response/view/' + props.item.id">
            <v-tooltip top>
              <template v-slot:activator="{ on }">
                <v-btn icon v-on="on">
                  <v-icon small class="mr-2">remove_red_eye</v-icon>
                </v-btn>
              </template>
              <span>Visualizar</span>
            </v-tooltip>
          </router-link>
        </td>
      </template>
      <template v-slot:no-data>
        <v-btn color="primary" @click="initialize">Recargar</v-btn>
      </template>
    </v-data-table>
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
        text: "Lista de respuestas de desafios",
        disabled: true,
        href: "#/responses"
      }
    ],
    json_fields: {
      cityname: "cityname",
      init_challenge: "init_challenge",
      finish_challenge: "finish_challenge",
      temp_min: "temp_min",
      temp_max: "temp_max",
      pressure: "pressure",
      humidity: "humidity",
      wind_speed: "wind_speed"
    },
    json_meta: [
      [
        {
          key: "charset",
          value: "utf-8"
        }
      ]
    ],
    headers: [
      { text: "Usuario", value: "user_name" },
      { text: "Desafio", value: "challenge_id" },
      { text: "Fecha de inicio", value: "init_challenge" },
      { text: "Fecha de finish_challenge", value: "finish_ challenge" },
      { text: "Accion", value: "name", sortable: false }
    ],
    responses: [],
    response: {},
    challenges: [],
    users: [],
    registers: [],
    pageCount: 1,
    pictureGeo: [],
    geoRefResp: [],
    nonDuplicatedArray: []
  }),
  created() {
    this.initialize();
  },
  mounted() {},
  methods: {
    getLocations() {
      firebase
        .database()
        .ref("Locations")
        .on("value", snapshot => {
          let locations = snapshot.val();
          var arrayCityname = [];
          var arrayPtoGeo = [];
          var aux = {};
          for (var response in this.geoRefResp) {
            for (let loc in locations) {
              var r1 = parseFloat(this.geoRefResp[response].latitud);
              var l1 = parseFloat(locations[loc].latitud);
              var xFinal = Math.pow(r1 - l1, 2);
              var yFinal = Math.pow(
                parseFloat(this.geoRefResp[response].longitud) -
                  parseFloat(locations[loc].longitud),
                2
              );
              var ptoFinal = xFinal + yFinal;

              arrayPtoGeo.push(ptoFinal);
              arrayCityname.push({
                name: locations[loc].name,
                weather: locations[loc].weather,
                init_challenge: this.geoRefResp[response].init_challenge,
                finish_challenge: this.geoRefResp[response].finish_challenge,
                ptofinal: ptoFinal
              });
            }
            var arratCpyPtoGeo = arrayPtoGeo;
            arratCpyPtoGeo.sort((a, b) => a - b);
            arrayCityname.sort((a, b) => a.ptofinal - b.ptofinal);
            var min = arrayPtoGeo.indexOf(arratCpyPtoGeo[0]);

            if (!this.pictureGeo.includes(arrayCityname[min])) {
              this.pictureGeo.push(arrayCityname[min]);
            }
            console.log(
              this.geoRefResp[response].init_challenge !== aux.init_challenge &&
                this.geoRefResp[response].finish_challenge !==
                  aux.finish_challenge
            );

            if (
              this.geoRefResp[response].init_challenge !== aux.init_challenge &&
              this.geoRefResp[response].finish_challenge !==
                aux.finish_challenge
            ) {
              arrayCityname = [];
              arrayPtoGeo = [];
              aux = this.geoRefResp[response];
              console.log(aux);
            }
          }

          this.getWeather();
        });
    },
    initialize() {
      firebase
        .database()
        .ref("ChallengesUsers")
        .on("value", snapshot => {
          this.responses = [];
          let responses = snapshot.val();
          for (let response in responses) {
            if (responses[response].user_id == "invitado") {
              this.responses.push({
                id: response,
                challenge_id: responses[response].challenge_id,
                finish_challenge: responses[response].finish_challenge,
                init_challenge: responses[response].init_challenge,
                user_id: responses[response].user_id,
                user_name: responses[response].user_id
              });
            } else {
              this.responses.push({
                id: response,
                challenge_id: responses[response].challenge_id,
                finish_challenge: responses[response].finish_challenge,
                init_challenge: responses[response].init_challenge,
                user_id: responses[response].user_id,
                user_name: responses[response].user_name
              });
            }
          }
          this.fetchData();
        });
    },
    fetchData() {
      console.log("ENTRE A FETCHDATA");

      this.responses.forEach(elem => {
        firebase
          .database()
          .ref("ChallengesUsers")
          .child(elem.id)
          .child("ImagesChallengesUsers")
          .on("value", snapshot => {
            let responses = snapshot.val();
            for (let response in responses) {
              this.geoRefResp.push({
                id: response,
                path: responses[response].path,
                longitud: responses[response].longitud,
                latitud: responses[response].latitud,
                init_challenge: elem.init_challenge,
                finish_challenge: elem.finish_challenge
              });
            }
          });
      });
      this.getLocations();
    },
    getWeather() {
      this.pictureGeo.forEach(elempg => {
        console.log(elempg);

        if (elempg.weather === true) {
          axios
            .post("api/v1/weathers", {
              init_challenge: elempg.init_challenge,
              finish_challenge: elempg.finish_challenge,
              /*lat: geoRefResp[0].latitud,
            lon: geoRefResp[0].longitud*/
              name: elempg.name
            })
            .then(({ data }) => {
              data.data.forEach(elem => {
                this.registers.push({
                  cityname: elem.cityname,
                  init_challenge: elempg.init_challenge,
                  finish_challenge: elempg.finish_challenge,
                  temp_min: parseInt(elem.temp_min),
                  temp_max: parseInt(elem.temp_max),
                  pressure: parseInt(elem.pressure),
                  humidity: parseInt(elem.humidity),
                  wind_speed: parseInt(elem.wind_speed)
                });
              });
            })
            .catch(({ response }) => {
              console.log("resp: " + response.data);
            });
        }
      });
    }
  }
};
</script>
