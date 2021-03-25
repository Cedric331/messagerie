<template>
<div class="container my-5">
   <div class="row">
      <div class="col-md-6">
            <div class="card bg-light">
               <div class="card-body">
                 <h4 class="card-title text-center">Mes groupes de discussion</h4>
                  <hr>
                   <ul class="cart-content" v-for="channel in channels" :key="channel.id">
                      <li class="text-center bg-light p-2 d-md-flex justify-content-between border border-dark shadow p-3 mb-5 rounded">
                         <h5 class="font-weight-bold mb-md-0 mt-2 pt-1">
                            {{ channel.name }}
                        <span v-if="count(channel.id) != 0" class="badge rounded-pill bg-info" style="font-size: 10px;">
                         {{ count(channel.id) }} message(s)
                        </span>
                         </h5>
                         <button class="btn btn-primary my-2" @click="linkChannel(channel.name)">Rejoindre</button>
                      </li>
                   </ul>

               </div>
            </div>
      </div>

            <div class="col-md-6">
            <div class="card bg-light">
               <div class="card-body">
                 <h4 class="card-title text-center">Création</h4>
                  <hr>
                   <ul class="cart-content">
                      <li class="text-center">
                         <a href="/create" class="btn btn-primary">Créer un groupe de discussion</a>
                      </li>
                   </ul>

               </div>
            </div>
      </div>

      <div class="col-md-6 m-auto">
         <div class="bg-light p-2 mt-5">
            <h3 class="text-center mb-4">Rechercher un Channel public</h3>
            <hr class="w-75 m-auto">
            <search-channel></search-channel>
         </div>
      </div>

   </div>
</div>
</template>

<script>
export default {
  methods: {
     linkChannel(name){
        window.location = '/chat/'+name;
     },
     count(id){
        var count = 0;
         this.notifications.forEach(element => {
            if (element.data.channel_id == id) {
               count++
            }
         });
        return count;
     }
  },
  props: ['channels', 'notifications'],
}
</script>
