require('./bootstrap');
import Notifications from 'vue-notification'
import store from './store.js'

window.Vue = require('vue').default;


Vue.component('home', require('./components/Home.vue').default);
Vue.component('messagerie', require('./components/Messagerie.vue').default);
Vue.component('post-message', require('./components/PostMessage.vue').default);
Vue.component('member-chat', require('./components/MemberChat.vue').default);
Vue.component('search-member', require('./components/SearchMember.vue').default);
Vue.component('create-chat', require('./components/CreateChat.vue').default);
Vue.component('account', require('./components/Account.vue').default);
Vue.component('name', require('./components/Name.vue').default);

Vue.use(Notifications)

const app = new Vue({
    el: '#app',
    store,
    created(){
      this.$store.dispatch('getData');
   },
});
