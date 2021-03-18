<template>
<div class="p-3">
   <h1>{{channel.name}}</h1>
    <ul class="chat panel-body" id="scroll">
         <button @click="moreMessage" class="btn btn-outline-dark m-auto">Afficher plus de message</button>
        <li class="left clearfix" v-for="message in allMessages" :key="message.id">
            <div class="chat-body clearfix">
                <div class="header">
                    <strong class="primary-font">
                        {{ message.user.name }}
                    </strong>
                </div>
                <p>
                    {{ message.message }}
                </p>
            </div>
        </li>
    </ul>
    <post v-on:messagesent="addMessage"></post>
  </div>
</template>

<script>
import post from './PostMessage'
    export default {
  props: ['channel'],

      components: {
          post
       },
  data () {
    return {
       allMessages: this.messages,
       count: 10
    }
  },
  methods: {
         addMessage(message) {
          axios.post('/message/post',{
            message: message.message,
            channel: this.channel.id
         }).then(res => {
            this.allMessages = res.data.reverse()
         }).catch(err => {
 
         })
   },
         fetchMessages() {
          axios.post('/fetch/message',{
             count: this.count,
             channel: this.channel.id
          }).then(response => {
              this.allMessages = response.data.reverse();
          });
      },
      moreMessage(){
         this.count += 10
         this.fetchMessages();
      }
  },
    created() {
      this.fetchMessages();
      Echo.private('chat')
      .listen('MessageSent', (e) => {
         this.fetchMessages();
      });
  },

  mounted(){
   setTimeout(function() {
      this.container = document.querySelector("#scroll");
      container.scrollTop = 800;
      this.height = container.scrollTop
      }, 100);
  }

   }
</script>
