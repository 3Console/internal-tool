// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here, other Firebase libraries
// are not available in the service worker.
importScripts("https://www.gstatic.com/firebasejs/7.18.0/firebase-app.js");
importScripts(
  "https://www.gstatic.com/firebasejs/7.18.0/firebase-messaging.js"
);

// Initialize the Firebase app in the service worker by passing in
// your app's Firebase config object.
// https://firebase.google.com/docs/web/setup#config-object
firebase.initializeApp({
  apiKey: "AIzaSyBF0BWf1dDJkowVXJaUO1vISw1nM8I4tIo",
  authDomain: "fir-94e10.firebaseapp.com",
  databaseURL: "https://fir-94e10.firebaseio.com",
  projectId: "fir-94e10",
  storageBucket: "fir-94e10.appspot.com",
  messagingSenderId: "181434167743",
  appId: "1:181434167743:web:2dc7259964c3d033d8b10a",
  measurementId: "G-ZEWS3MD466"
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();