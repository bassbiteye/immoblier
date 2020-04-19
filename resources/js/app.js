/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import moment from 'moment';

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
    { path: '/typecomptes', component: require('./components/TypeComptesComponent.vue').default },
    { path: '/typeetats', component: require('./components/TypeEtatsComponent.vue').default },

    
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

Vue.filter('myDate',function(created){
return moment(created).format('MMMM Do YYYY');
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
