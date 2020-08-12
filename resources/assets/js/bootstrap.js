window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key',
//     cluster: 'mt1',
//     encrypted: true
// });


// import Echo from "laravel-echo";
//
// window.Pusher = require('pusher-js');
//
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: '1970ebdba31f21033481',
//     wsHost: '177.53.140.130',
//     wsPort: 6001,
//     disableStats: true,
//     encrypted: false,
//     enabledTransports: ['ws', 'wss']
// });

// Your web app's Firebase configuration
var firebaseConfig = {
    apiKey: "AIzaSyBmPKbYThOinh_B_t80pRavTtNznQrb8Bw",
    authDomain: "agendatrafego.firebaseapp.com",
    databaseURL: "https://agendatrafego.firebaseio.com",
    projectId: "agendatrafego",
    storageBucket: "agendatrafego.appspot.com",
    messagingSenderId: "1059077621379",
    appId: "1:1059077621379:web:d180071fd96dc4a9fd7db6"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
