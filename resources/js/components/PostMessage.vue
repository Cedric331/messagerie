<template>
   <div class="flex-grow-0 py-3 px-4 border-top">
		<div class="input-group">
			<input type="text" class="form-control" @keydown="isTyping" v-model="newMessage" placeholder="Votre message...">
			   <button class="btn btn-primary" id="btn-chat" @click="sendMessage">
                Poster
            </button>
		</div>
	</div>
</template>


<script>
export default {
  props: ['channel', 'user'],
      data() {
            return {
                newMessage: '',
            }
        },
        methods: {
            sendMessage() {
                this.$emit('messagesent', {
                    message: this.newMessage
                });
                this.newMessage = ''
            },
            isTyping() {
                 setTimeout(() => {
                 Echo.private('chat.'+this.channel.id)
                 .whisper('typing', {
                     typing: true,
                     name: this.user.name
                 });
                 }, 600);
               }
        },
}
</script>