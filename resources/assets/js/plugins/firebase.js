import firebase from 'firebase/app'
import 'firebase/analytics'
import 'firebase/firestore'

var firebaseConfig = {
    apiKey: "AIzaSyB4vbaDpnRVTDbmCWwQL45yPsr-mZw_XYs",
    authDomain: "pruebafirebase-b3c3b.firebaseapp.com",
    databaseURL: "https://pruebafirebase-b3c3b.firebaseio.com",
    projectId: "pruebafirebase-b3c3b",
    storageBucket: "pruebafirebase-b3c3b.appspot.com",
    messagingSenderId: "576924216012",
    appId: "1:576924216012:web:cb5dc677f0654a64eb3069",
    measurementId: "G-NSZFLG9NL2"
};
const firebaseApp = firebase.initializeApp(firebaseConfig);
firebaseApp.analytics();

export default firebaseApp.firestore();