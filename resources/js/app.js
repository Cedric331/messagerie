require('./bootstrap');

window.Vue = require('vue').default;


Vue.component('messagerie', require('./components/Messagerie.vue').default);
Vue.component('post-message', require('./components/PostMessage.vue').default);


const app = new Vue({
    el: '#app',
    data: {
      messages: []
  },

  created() {
      this.fetchMessages();
      Echo.private('chat')
      .listen('MessageSent', (e) => {
         this.messages.push({
            message: e.message.message,
          });
      });
  },

  methods: {
      fetchMessages() {
          axios.get('/fetch/message').then(response => {
              this.messages = response.data.reverse();
          });
      },

      addMessage(message) {
         this.messages.push(message);
          axios.post('/message/post',{
            message: message.message,
         }).then(res => {
            // this.messages = res.data.reverse()
         }).catch(err => {
 
         })
      }
  }

});
