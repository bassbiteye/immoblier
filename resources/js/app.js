/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('jquery');

require('./bootstrap');

window.Vue = require('vue');
import moment from 'moment';
import 'admin-lte/plugins/jquery/jquery.min.js';
import 'admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js';
import 'admin-lte/plugins/datatables/jquery.dataTables.js';
import 'admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.js';
import 'admin-lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js';
import 'admin-lte/plugins/jquery-mousewheel/jquery.mousewheel.js';
import 'admin-lte/plugins/raphael/raphael.min.js';
import 'admin-lte/plugins/jquery-mapael/jquery.mapael.min.js';
import 'admin-lte/plugins/jquery-mapael/maps/usa_states.min.js';

import 'admin-lte/plugins/bootstrap-switch/js/bootstrap-switch.min.js';
//ChartJS
import 'admin-lte/plugins/chart.js/Chart.min.js';



// import VueSelect from 'vue-cool-select';

import Gate from "./Gate";
Vue.prototype.$gate= new Gate(window.user)

import VueProgressBar from 'vue-progressbar';

import { Form, HasError, AlertError } from 'vform';

import Swal from 'sweetalert2';
window.Swal = Swal;
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })
  window.Toast = Toast;

window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component('pagination', require('laravel-vue-pagination'));

import VueRouter from 'vue-router'
Vue.use(VueRouter)

/* const theme = window.location.hash.slice(1)|| 'bootstrap';
Vue.use(VueSelect,{
  theme: theme
}) */
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */
let routes = [
    { path: '/home', component: require('./components/dashboardComponent.vue').default },
    { path: '/profile', component: require('./components/profileComponent.vue').default },
    { path: '/users', component: require('./components/usersComponent.vue').default },
    { path: '/developper', component: require('./components/developperComponent.vue').default },
    { path: '/not-found', component: require('./components/notFoundComponent.vue').default },
    { path: '/selected', component: require('./components/SelectComponent.vue').default },
    { path: '/biens', component: require('./components/BiensComponent.vue').default },
    { path: '/typebiens', component: require('./components/TypeBiensComponent.vue').default },
    { path: '/typeclients', component: require('./components/TypeClientsComponent.vue').default },
    { path: '/bailleurs', component: require('./components/BailleursComponent.vue').default },
    { path: '/clients', component: require('./components/ClientsComponent.vue').default },
    { path: '/louer', component: require('./components/LouersComponent.vue').default },
    { path: '/typebaiileur', component: require('./components/TypebaiileursComponent.vue').default },
    { path: '/typeetats', component: require('./components/TypeEtatsComponent.vue').default },
    { path: '/revoque', component: require('./components/RevoqueComponent.vue').default },
    { path: '/paiement', component: require('./components/PaiementComponent.vue').default },
    { path: '/divers', component: require('./components/DiversComponent.vue').default },
    { path: '/biens-louer', component: require('./components/BiensLouerComponent.vue').default },
    { path: '/biens-non-louer', component: require('./components/BiensNonLouerComponent.vue').default },
    { path: '/clients-on-paye', component: require('./components/ClientsNonPayeComponent.vue').default },
    { path: '/clients-paye', component: require('./components/ClientsPayeComponent.vue').default },

    
    
    { path: '*', component: require('./components/notFoundComponent.vue').default }

]
const router = new VueRouter({
    mode:'history',
    routes
  })
  // const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.filter('upText',function(text){
return text.charAt(0).toUpperCase()+text.slice(1)
});
import 'moment/locale/pt-br';

Vue.filter('myDate',function(created){
return moment().format("L"); 
});
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '3px'
  });
  
  window.Fire= new Vue();

  Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


const app = new Vue({
  el: '#app',  
  router,
    data:{
      search: ''
    },
    methods:{
      searchit: _.debounce(() => {
        Fire.$emit('searching');
    },1000)
    }
  });
