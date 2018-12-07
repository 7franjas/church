
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// base script
require('./bootstrap');
require('fastclick');
require('jquery-slimscroll');

// datatables
require('datatables.net');
require('datatables.net-bs');
require('datatables.net-responsive');
require('datatables.net-responsive-bs');
require('datatables.net-buttons');
require('datatables.net-buttons-bs');

// Dropzone
window.Dropzone = require('dropzone');

// croppie
require('croppie');

// require calendar
window.moment = require('moment');
require('fullcalendar');
require('fullcalendar/dist/locale/es.js');

// timepicker
require('bootstrap-timepicker');
require('bootstrap-datepicker');
require('bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js');

require('countimer');

require('chart.js');

require('bootstrap-colorpicker');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

//Vue.component('example-component', require('./components/ExampleComponent.vue'));

// const files = require.context('./', true, /\.vue$/i)

// files.keys().map(key => {
//     return Vue.component(_.last(key.split('/')).split('.')[0], files(key))
// })

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
/*
const app = new Vue({
    el: '#app'
});
*/
