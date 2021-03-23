require('./bootstrap');
window.Vue = require('vue').default;

import store from './store.js'

Vue.component('home', require('./components/Home.vue').default);
Vue.component('messagerie', require('./components/Messagerie.vue').default);
Vue.component('post-message', require('./components/PostMessage.vue').default);
Vue.component('member-chat', require('./components/MemberChat.vue').default);
Vue.component('search-member', require('./components/SearchMember.vue').default);



const app = new Vue({
    el: '#app',
    store,
    created(){
      this.$store.dispatch('getData');
   },
});
