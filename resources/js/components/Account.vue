<template>

<div class="container my-5 p-5 z-depth-1 bg-light">
  <section class="text-center">
    <h2 class="font-weight-bold mb-4 pb-2 text-uppercase">Mes Informations</h2>
<notifications group="success" position="bottom right" />
    <div class="row d-flex justify-content-around ">

   <div class="col-12 col-md-8 mb-4 p-3 bg-color-custom">
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
  props: ['user'],
  data () {
    return {
       nameUpdate: this.user.name,
       emailUpdate: this.user.email    
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
            console.log(error)
         });
     },

     update(){
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
         .catch(error => {
            // console.log(error.response.data )
         });
     }
  },
    
}
</script>