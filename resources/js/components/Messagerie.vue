<template>
<div>
   <div class="row mt-3 d-flex justify-content-around">
   <member :channel="channel"></member>
   <div class="p-3 chat col-12 col-md-8 bg-light">
      <h3 class="text-center">{{channel.name}}</h3>
      <hr>
       <ul class="panel-body" id="scroll">
          <div class="text-center">
              <button v-if="channel.messages.length > count" @click="moreMessage" class="btn btn-outline-dark m-auto">Afficher plus de message</button> 
          </div>
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
   </div>
</div>
</template>

<script>
import post from './PostMessage'
import member from './MemberChat'
    export default {
  props: ['channel'],

      components: {
          post,
          member
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
               setTimeout(function() {
                  this.container = document.querySelector("#scroll");
                  container.scrollTop = 800;
                  this.height = container.scrollTop
                  }, 10);
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
      Echo.private('chat.'+this.channel.id)
      .listen('MessageSent', (e) => {
         this.fetchMessages();
      });
  },

  mounted(){
   setTimeout(function() {
      this.container = document.querySelector("#scroll");
      container.scrollTop = 800;
      this.height = container.scrollTop
      }, 500);
  }

   }
</script>
