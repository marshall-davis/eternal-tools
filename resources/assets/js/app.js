
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('../../semantic/dist/semantic.min');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

let bus = new Vue();

export {
    bus
};

Vue.component('site-header', require('./components/SiteHeader'));
Vue.component('welcome', require('./components/Welcome'));
Vue.component('site-footer', require('./components/SiteFooter'));
Vue.component('main-content', require('./components/MainContent'));
Vue.component('report-modal', require('./components/ReportModal'));

Vue.component('backstory-generator', function (resolve) {require(['./components/Characters/BackstoryGenerator'], resolve);});
Vue.component('map-creator', function (resolve) {require(['./components/Maps/MapCreator'], resolve);});
Vue.component('login-password', function (resolve) {require(['./components/LoginPassword'], resolve)});
Vue.component('admin', function (resolve) {require(['./components/Admin'], resolve)});

const vm = new Vue({
    el: '#app',
    data: {
        page: 'welcome'
    }
});

require('./main');
