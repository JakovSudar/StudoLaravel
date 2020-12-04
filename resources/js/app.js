/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


Vue.component('navbar', require('./components/Navbar.vue').default);
Vue.component('filter-bar', require('./components/Filterbar.vue').default);
Vue.component('jobs-space', require('./components/Jobs.vue').default);
Vue.component('jobs-space-empl', require('./components/JobsEmployer.vue').default);
Vue.component('job-item', require('./components/JobItem.vue').default);
Vue.component('job-item-empl', require('./components/JobItemEmployer.vue').default);
Vue.component('details-modal', require('./components/DetailsModal.vue').default);
Vue.component('main-component', require('./components/MainComponent.vue').default);
Vue.component('login-modal', require('./components/LoginModal.vue').default);
Vue.component('register-modal', require('./components/RegisterModal.vue').default);
Vue.component('message-modal', require('./components/MessageModal.vue').default);
Vue.component('newJob-modal', require('./components/NewJobModal.vue').default);
Vue.component('jobApplication-modal', require('./components/JobApplicationModal.vue').default);
Vue.component('profile', require('./components/Profile.vue').default);
Vue.component('application-details', require('./components/ApplicationDetails.vue').default);
Vue.component('application-item', require('./components/ApplicationItem.vue').default);
Vue.component('applied-job', require('./components/AppliedJob.vue').default);


var VueCookie = require('vue-cookie')

Vue.use(VueCookie);

import VueLoading from 'vuejs-loading-plugin'

// using default options
Vue.use(VueLoading)


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
