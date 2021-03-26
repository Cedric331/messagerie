<template>
   <div class="flex-grow-0 py-3 px-4 ">
<form @submit.prevent="sendMessage" enctype="multipart/form-data">
 <div class="file-field">
    <div class="btn btn-dark btn-rounded mb-2 btn-sm float-left">
      <span>
         <i class="fas fa-paperclip" aria-hidden="true"></i>
      </span>
      <input type="file" nmae="file" @change="previewFiles">
    </div>
  </div>

  	   <div class="input-group">
			<input type="text" class="form-control" aria-label="Message" @keydown="isTyping" v-model="newMessage" placeholder="Votre message...">
			   <button class="btn btn-primary" id="btn-chat" type="submit">
                Poster
            </button>
		</div>
</form>
	</div>
</template>


<script>
export default {
  props: ['channel', 'user'],
      data() {
            return {
                newMessage: '',
                fileUpload: ''
            }
        },
        methods: {
            sendMessage(e) {
                this.$emit('messagesent', {
                    message: this.newMessage,
                    file: this.fileUpload
                });
                this.newMessage = ''
                this.fileUpload = ''
                 e.target.reset();
            },
            isTyping() {
                 setTimeout(() => {
                 Echo.private('chat.'+this.channel.id)
                 .whisper('typing', {
                     typing: true,
                     name: this.user.name
                 });
                 }, 600);
               },
               previewFiles(e) {
                  this.fileUpload = e.target.files[0];
            }
        },
}
</script>