<template>
<div>
      <div class="form-group mt-4 container">
        <label for="message">Votre message</label>
        <textarea class="form-control" v-model="newMessage" rows="5"></textarea>
        <div class="text-center my-4">
          <button class="btn btn-info btn-sm" type="button" @click="sendMessage">Poster</button>
        </div>
      </div>
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
