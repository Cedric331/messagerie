<template>
<div>
      <discussion :messages="allMessages"></discussion>
      
      <div class="form-group mt-4 container">
         <label for="name">Votre nom</label>
         <input type="text" class="form-control" v-model="name" id="name">
        <label for="message">Votre message</label>
        <textarea class="form-control" v-model="message" rows="5"></textarea>
        <div class="text-center my-4">
          <button class="btn btn-info btn-sm" type="button" @click="post">Poster</button>
        </div>
      </div>
</div>

</template>


<script>
import discussion from './Messagerie'
export default {
  props: ['messages'],
   components:{
      discussion
   },
  data () {
    return {
       name: '',
       message: '',
       allMessages: this.messages
    }
  },
  methods: {
     post(){
        axios.post('/message/post',{
           name: this.name,
           message: this.message,
        }).then(res => {
           this.name = ''
           this.message = ''
           this.allMessages = res.data
           console.log(this.allMessages)
        }).catch(err => {

        })
     }
  },
   
}
</script>
