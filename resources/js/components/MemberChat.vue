<template>
   <div class="col-md-3 col-12 p-3 bg-light">
      <search class="mb-2" v-on:adduser="addMember"></search>
      <h3>Membres du {{channel.name}}</h3>
      <hr>
      <ul>
           <li v-for="user in users" :key="user.id">
               <div>
                   <div class="header">
                       <strong class="primary-font">
                           {{ user.name }}<em v-if="channel.user_id == user.id"> - admin</em>
                       </strong>
                   </div>
               </div>
           </li>
       </ul>
   </div>
</template>


<script>
import search from './SearchMember'
export default {
  methods: {
     addMember(user){
        axios.post('/member/add',{
           user: user.user,
           channel: this.channel.id
        }).then(res => {
          this.users = res.data
        }).catch(err => {
           console.log(err)
        })
     }
  },
  data () {
    return {
       users: this.channel.user
    }
  },
   components: {
      search
   },
  props: ['channel'],
   
}
</script>
