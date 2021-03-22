<template>
   <div class="container p-0 my-5">
		<div class="card">
			<div class="row g-0">
         <member :members="members" :channel="channel" :key="members.length"></member>

				<div class="col-12 col-lg-7 col-xl-9">
               <h1 class="text-center">{{channel.name}}</h1>

					<div class="position-relative chat-messages">
                  <div class="text-center mt-1">
                     <button v-if="channel.messages.length > count" @click="moreMessage" class="btn btn-outline-dark m-auto">Afficher plus de message</button> 
                  </div>
						<div class="p-4" v-for="message in allMessages" :key="message.id">

							<div v-if="message.user.id == user.id" class="chat-message-right pb-4">
								<div class="flex-shrink-1 text-break bg-dark text-white rounded py-2 px-3 mr-3">
									<div class="font-weight-bold text-white mb-1">Vous</div>
									{{ message.message }}
								</div>
							</div>

							<div v-else class="chat-message-left pb-4">
								<div class="flex-shrink-1 text-break bg-lightm text-dark rounded py-2 px-3 ml-3">
									<div class="font-weight-bold mb-1">{{ message.user.name }}</div>
                           {{ message.message }}
								</div>
							</div>

						</div>
					</div>

					<div class="py-2 px-4 border-bottom d-none d-lg-block">
						<div class="d-flex align-items-center py-1">
							<div class="flex-grow-1 pl-3" v-show="typing">
								<strong>{{ other }}</strong>
								<div class="text-muted small">
                           <em>écrit un message</em>
                        </div>
							</div>
						</div>
					</div>

            <post :channel="channel" :user="user" v-on:messagesent="addMessage"></post>

				</div>
			</div>
		</div>
	</div>
</template>

<script>
import post from './PostMessage'
import member from './MemberChat'
    export default {
  props: ['channel', 'user'],

      components: {
          post,
          member
       },
  data () {
    return {
       allMessages: this.messages,
       count: 10,
       members: [],
       typing: false,
       other: ''
    }
  },
  methods: {
         addMessage(message) {
          axios.post('/message/post',{
            message: message.message,
            channel: this.channel.id
         }).then(res => {
            this.allMessages = res.data.reverse()
            this.scroll()
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
      },
      scroll(){
         setTimeout(function() {
            this.container = document.querySelector(".chat-messages");
            container.scrollTop = container.scrollHeight;
            }, 1000);
      }
  },
    created() {
      this.fetchMessages();
       let _this = this;
      Echo.private('chat.'+this.channel.id)
      .listen('MessageSent', (e) => {
         this.fetchMessages();
      })  
      .listenForWhisper('typing', (e) => {
        this.typing = e.typing
        this.other = e.name

         setTimeout(function() {
            _this.typing = false
            }, 1200);
      });

      Echo.join('chat.'+this.channel.id)
         .here((users) => {
       this.members = users
      })
         .joining((user) => {
         this.members.push(user)
    })
    .leaving((user) => {
         this.members = this.members.filter(function(item) { 
             return item !== user
         })
    });
  },

  mounted(){
     this.scroll()
  }

   }
</script>
