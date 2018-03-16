
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

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('site-header', require('./components/SiteHeader.vue'));
Vue.component('welcome', require('./components/Welcome'));
Vue.component('backstory-generator', function (resolve) {require(['./components/Characters/BackstoryGenerator.vue'], resolve);});

const vm = new Vue({
    el: '#app',
    data: {
        page: 'welcome'
    }
});

export {
    vm
};

require('./main')
