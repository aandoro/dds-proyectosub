/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import router from './plugins/routes.js';
import './plugins/firebase.js'
import Vue from 'vue'
import Vuetify from 'vuetify'
import BootstrapVue from 'bootstrap-vue'
import VeeValidate from 'vee-validate';
import Notifications from 'vue-notification'
import VueCookie from 'vue-cookie'
import moment from 'moment'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import 'vuetify/dist/vuetify.min.css'
import VueCarousel from '@chenfengyuan/vue-carousel';
import JsonExcel from 'vue-json-excel'
import firebase from 'firebase'

let app = null
Vue.component('downloadExcel', JsonExcel)
Vue.component(VueCarousel.name, VueCarousel);

window.Vue = require('vue');
Vue.use(Vuetify, {
    iconfont: 'mdiSvg' || 'mdi' || 'mdiSvg' || 'md' || 'fa' || 'fa4' || 'fas'
})
Vue.use(BootstrapVue);
Vue.use(VeeValidate);
Vue.use(Notifications)
Vue.use(VueCookie)

Vue.filter('formatDate', function (value) {
    if (value) {
        return moment(String(value)).format('DD/MM/YYYY hh:mm')
    }
});

firebase.auth().onAuthStateChanged(() => {
    if (!app) {
        app = new Vue({
            el: '#app',
            router,
        });
    }
})
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('sidebar', require('./components/Sidebar.vue'));