<template>
  <div>
    <div>
      <h2>{{title}}</h2>
    </div>
    <div>
      <v-breadcrumbs :items="items" divider=">"></v-breadcrumbs>
    </div>
    <div class="col-sm mt-3 mt-sm-0">
      <v-carousel>
        <v-carousel-item
          v-for="(image,i) in images"
          :key="i"
          :src="image.src"
          reverse-transition="fade-transition"
        ></v-carousel-item>
      </v-carousel>
    </div>
    <br />
    <div>
      <p>
        <strong>
          <font color="red">Aclaración:</font>
        </strong>El clima del desafio es de una localidad aproximada. (fotos de {{pictureGeo[0].name}})
      </p>
    </div>
    <br />
    <v-data-table :headers="headers" :items="registers">
      <template v-slot:items="props">
        <td>{{ props.item.cityname }}</td>
        <td>{{ props.item.temp_min }}</td>
        <td>{{ props.item.temp_max }}</td>
        <td>{{ props.item.pressure }}</td>
        <td>{{ props.item.humidity }}</td>
        <td>{{ props.item.wind_speed }}</td>
      </template>
    </v-data-table>
    <br />
    <v-layout v-show="response.user_id != 'invitado'">
      <v-flex xs12 md8>
        <v-slider
          v-model="point"
          color="orange"
          label="Puntos"
          :min="1"
          :max="challenge.point"
          :hidden="varShow"
          thumb-label
        ></v-slider>
      </v-flex>
      <v-flex xs12 md2></v-flex>
      <v-flex xs12 md3>
        <v-text-field v-model="point" :hidden="varShow" max="100"></v-text-field>
      </v-flex>
    </v-layout>
    <div v-show="response.user_id != 'invitado'">
      <v-btn @click="submit">Enviar</v-btn>
      <v-btn to="/responses">Volver</v-btn>
    </div>
    <div v-show="response.user_id == 'invitado'">
      <v-btn to="/responses">Volver</v-btn>
    </div>
  </div>
</template>

<script>
import firebase from "firebase/app";
import "firebase/database";
import "firebase/storage";

export default {
  data: () => ({
    headers: [
      { text: "Clima Obtenido", value: "cityname" },
      { text: "Temp minima", value: "temp_min" },
      { text: "Temp maxima", value: "temp_max" },
      { text: "Presion", value: "pressure" },
      { text: "Humedad", value: "humidity" },
      { text: "Velocidad del viento", value: "wind_speed" }
    ],
    items: [
      {
        text: "Inicio",
        disabled: false,
        href: "#/home"
      },
      {
        text: "Lista de respuestas de desafios",
        disabled: false,
        href: "#/responses"
      }
    ],
    title: "",
    response: {},
    user: {},
    challenge: {},
    point: 1,
    responses: [],
    error: "",
    varShow: false,
    images: [],
    registers: [],
    dates: {},
    locations: [],
    pictureGeo: []
  }),
  created() {
    this.view();
  },
  methods: {
    getLocations() {
      firebase
        .database()
        .ref("Locations")
        .on("value", snapshot => {
          let locations = snapshot.val();
          var arrayCityname = [];
          var arrayPtoGeo = [];
          for (var response in this.responses) {
            for (let loc in locations) {
              console.log(locations[loc].name);

              var r1 = parseFloat(this.responses[response].latitud);
              var l1 = parseFloat(locations[loc].latitud);
              var xFinal = Math.pow(r1 - l1, 2);
              var yFinal = Math.pow(
                parseFloat(this.responses[response].longitud) -
                  parseFloat(locations[loc].longitud),
                2
              );
              var ptoFinal = xFinal + yFinal;
              console.log(ptoFinal);

              arrayPtoGeo.push(ptoFinal);
              arrayCityname.push({
                name: locations[loc].name,
                weather: locations[loc].weather,
                ptofinal: ptoFinal
              });
            }

            console.log(arrayPtoGeo);
            var arratCpyPtoGeo = arrayPtoGeo;
            arratCpyPtoGeo.sort((a, b) => a - b);
            arrayCityname.sort((a, b) => a.ptofinal - b.ptofinal);
            console.log("pto geo");
            console.log(arratCpyPtoGeo);

            var min = arrayPtoGeo.indexOf(arratCpyPtoGeo[0]);
            console.log("min " + min);
            console.log(arrayCityname);

            /*if (!this.pictureGeo.includes(arrayCityname[min])) {
              this.pictureGeo.push(arrayCityname[min]);
            }*/
          }

          console.log("pictureGeo");
          this.pictureGeo = arrayCityname;
          console.log(this.pictureGeo);
          this.getWeather();
        });
    },
    view() {
      firebase
        .database()
        .ref("ChallengesUsers")
        .child(this.$route.params.id)
        .on("value", snapshot => {
          this.response = snapshot.val();
          this.response.id = this.$route.params.id;
          this.getUser();
          firebase
            .database()
            .ref("ChallengesUsers")
            .child(this.$route.params.id)
            .child("ImagesChallengesUsers")
            .on("value", snapshot => {
              let responses = snapshot.val();
              for (let response in responses) {
                this.responses.unshift({
                  id: response,
                  path: responses[response].path,
                  longitud: responses[response].longitud,
                  latitud: responses[response].latitud
                });
              }
              this.responses.forEach(item => {
                firebase
                  .storage()
                  .ref("ImagesChallengesUser/" + item.path)
                  .getDownloadURL()
                  .then(url => {
                    this.images.push({ src: url });
                  })
                  .catch(error => {
                    console.log(error.message);
                  });
              });
            });
          this.getLocations();
        });
    },
    getUser() {
      if (this.response.user_id != "invitado")
        firebase
          .database()
          .ref("UserMobile")
          .child(this.response.user_id)
          .on("value", snapshot => {
            this.user = snapshot.val();
          });
    },
    getWeather() {
      var weatherAchieved = false;
      console.log(this.pictureGeo.length);
      this.pictureGeo.forEach(elem => {
        console.log(elem.weather === true);

        if (elem.weather === true && weatherAchieved === false) {
          weatherAchieved = true;
          console.log(elem);

          axios
            .post("api/v1/weathers", {
              init_challenge: this.response.init_challenge,
              finish_challenge: this.response.finish_challenge,
              /*lat: this.responses[0].latitud,
            lon: this.responses[0].longitud*/
              //name: elem.name.toLowerCase()
              name: elem.name
            })
            .then(({ data }) => {
              data.data.forEach(elem => {
                this.registers.push({
                  cityname: elem.cityname,
                  temp_min: elem.temp_min,
                  temp_max: elem.temp_max,
                  pressure: elem.pressure,
                  humidity: elem.humidity,
                  wind_speed: elem.wind_speed
                });
              });
            });
        }
      });
    },
    submit() {
      this.user.point += this.point;
      firebase
        .database()
        .ref("UserMobile")
        .child(this.user.id)
        .update(this.user)
        .then(user => {
          this.setSuccessNew();
        })
        .catch(error => {
          this.setErrors(error);
        });
    },
    setSuccessNew() {
      this.$notify({
        group: "success",
        type: "success",
        title: "ENVIADO:",
        text: "Los puntos se enviaron exitosamente"
      });
      window.location.replace("#/responses");
    },
    setErrors(response) {
      this.error = response;
      this.$notify({
        group: "error",
        type: "error",
        title: "ERROR:",
        text: "Ocurrio un error al querer enviarle los puntos"
      });
    }
  }
};
</script>
