<template>
   <div>
         <div class="form-group mt-2">
           <textarea class="form-control z-depth-1" v-model="newMessage" rows="3" placeholder="Votre message..."></textarea>
         </div>
         <button class="btn btn-primary" id="btn-chat" @click="sendMessage">
             Poster
         </button>
   </div>

</template>


<script>
export default {
      data() {
            return {
                newMessage: ''
            }
        },
        methods: {
            sendMessage() {
                this.$emit('messagesent', {
                    message: this.newMessage
                });
                this.newMessage = ''
            }
        }  
}
</script>