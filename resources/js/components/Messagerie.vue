<template>
  <div class="container my-5 py-5 px-md-5 z-depth-1">


    <section class="text-center text-lg-left dark-grey-text">

        <div class="text-center font-weight-bold"><span>4</span> comments</div>

        <div class="media d-block d-md-flex mt-4">
            <div class="media-body text-center text-md-left ml-md-3 ml-0">
               <div v-for="message in allMessages" :key="message.id">
                  <p class="font-weight-bold my-0">
                    {{ message.name }}
                    <a href="" class="pull-right ml-1">
                      <i class="fas fa-reply"></i>
                    </a>
                  </p>
                  <p>
                     {{ message.message }}
                  </p>
               </div>

            </div>
        </div>
    </section>
    <post v-on:messagesent="addMessage"></post>
  </div>
</template>

<script>
import post from './PostMessage'
    export default {
      components: {
          post
       },
  data () {
    return {
       allMessages: this.messages
    }
  },
  methods: {
         addMessage(message) {
          axios.post('/message/post',{
            message: message.message,
         }).then(res => {
            this.allMessages = res.data.reverse()
         }).catch(err => {
 
         })
   },
         fetchMessages() {
          axios.get('/fetch/message').then(response => {
              this.allMessages = response.data.reverse();
          });
      },
  },
  props: ['messages'],

    created() {
      this.fetchMessages();
      Echo.private('chat')
      .listen('MessageSent', (e) => {
         this.fetchMessages();
      });
  },

   }
</script>
