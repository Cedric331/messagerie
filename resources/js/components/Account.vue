<template>

<div class="container my-5 p-5 z-depth-1 bg-light">
  <section class="text-center">
    <h2 class="font-weight-bold pb-2 text-uppercase">Mes Informations</h2>

    <hr class="my-4">

<notifications group="success" position="bottom right" />

   <div class="col-12 col-md-8 m-auto p-3">
          <h3 class="font-weight-bold mb-2 pb-2 text-uppercase">Mon Avatar</h3>
          <div class="row">
            <div class="col-3 mt-2" v-for="avatar in avatars" :key="avatar">
               <a type="button" @click="updateAvatar(avatar)">
                  <img :src="'/storage/image/avatars/'+avatar" class="rounded-circle"
                  v-bind:class="(avatar == userAvatar)?'bg-success p-1':'bg-danger p-1'"
                   width="50" height="50">
               </a>
            </div>
          </div>
   </div>

   <hr>

    <div class="row d-flex justify-content-around ">
      <div v-if="errors != []">
          <p class="text-danger" v-for="(error, index) in errors" :key="index">
              {{ error[0] }}
          </p>
      </div>
   <div class="col-12 col-md-8 my-4 p-3">
      <div class="mb-3">
        <label for="pseudo" class="form-label">Nom</label>
        <input type="text" class="form-control" v-model="nameUpdate">
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Adresse email</label>
        <input type="email" class="form-control" v-model="emailUpdate" aria-describedby="adresse email">
      </div>
      <button @click="update()" class="btn btn-outline-success">Modifier</button>
      <hr class="w-50 mx-auto mt-5">
      <div class="col-12 col-md-6 mt-5 m-auto">
         <h5 class="font-weight-bold my-4 text-danger">
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalConfirmDelete">Supprimer mon compte</button>
         </h5>
      </div>
   </div>


    </div>
  </section>




<div class="modal fade" id="modalConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-sm modal-notify modal-danger" role="document">
    <div class="modal-content text-center">
      <div class="modal-header d-flex justify-content-center">
        <p class="heading">Êtes-vous sûr de vouloir supprimer votre compte?</p>
      </div>
      <div class="modal-body">
        <p>Attention, les chats que vous avez crée seront également supprimés!</p>
      </div>
      <div class="modal-footer flex-center">
        <a href="#" @click="deleteUser()" class="btn btn-outline-danger">Oui</a>
        <a type="button" class="btn  btn-danger waves-effect" data-dismiss="modal">Annuler</a>
      </div>
    </div>
  </div>
</div>

</div>

</template>


<script>
export default {
  props: ['user', 'avatars'],
  data () {
    return {
       nameUpdate: this.user.name,
       emailUpdate: this.user.email,
       userAvatar: this.user.avatar,
       errors: []
       }
  },
  methods: {
     deleteUser(){
      axios.post('/account/delete', {
         id: this.user.id
      })
         .then(response => {
        if (response.status == 200) {
           window.location = "/"
            }
         })
         .catch(error => {
               this.$notify({
                  group: 'success',
                  type: 'warn',
                  title: 'Erreur',
                  speed: 1000,
                  text: 'Désolé nous ne pouvons pas supprimer votre compte!',
               });
         });
     },

     update(){
        this.errors = []
         axios.post('/account', {
            name: this.nameUpdate,
            email: this.emailUpdate,
         })
         .then(response => {
            this.$store.state.auth.name = this.nameUpdate
            this.$store.state.auth.email = this.emailUpdate
            if (response.status == 200) {
              this.$notify({
                  group: 'success',
                  type: 'success',
                  title: 'Modification',
                  speed: 1000,
                  text: 'Modification effectuée!',
               });
            }
            if (response.status == 201) {
              this.$notify({
                  group: 'success',
                  type: 'info',
                  title: 'Modification',
                  speed: 1000,
                  text: 'Aucune modification nécessaire!',
               });
            }
         })
         .catch(err => {
            if (err.response.status == 422) {
               this.errors = err.response.data.errors;
            }
         });
     },
     updateAvatar(avatar){
        axios.post('/user/avatar',{
           avatar: avatar
        }).then(res => {
            if (res.status == 200) {
               this.userAvatar = avatar
              this.$notify({
                  group: 'success',
                  type: 'success',
                  title: 'Modification',
                  speed: 1000,
                  text: 'Modification effectuée!',
               });
            }
        }).catch(err => {
               this.$notify({
                  group: 'success',
                  type: 'warn',
                  title: 'Erreur',
                  speed: 1000,
                  text: 'Désolé il y a une erreur!',
               });
         });
     }
  },
    
}
</script>