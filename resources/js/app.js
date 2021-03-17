require('./bootstrap');

window.Vue = require('vue').default;


Vue.component('messagerie', require('./components/Messagerie.vue').default);
Vue.component('post-message', require('./components/PostMessage.vue').default);


const app = new Vue({
    el: '#app',
});
