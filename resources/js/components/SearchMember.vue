<template>
   <div>
      <input class="dropdown-input form-control" v-model="search" @keyup="searchMember" placeholder="Inviter des utilisateurs...">
      <div v-show="search != '' && users.length > 0" class="dropdown-list">
        <div v-for="user in users" :key="user.id" class="dropdown-item">
           {{ user.name }} - <button type="button" @click="addMember(user.id)" class="btn btn-primary btn-sm">Inviter</button>
        </div>
      </div>
  </div>
</template>


<script>
export default {
  data () {
    return {
       search: '',
       users: []
    }
  },
  methods: {
     searchMember(){
        axios.post('/member/search',{
           search: this.search
        }).then(res =>{
           this.users = res.data
        }).catch(err =>{

        })
     },
     addMember(user){
         this.$emit('adduser', {
            user: user
         });
     }
  },
   
}
</script>
