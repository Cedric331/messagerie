<template>
<div class="container mt-5">
   <div class="row">
      <div class="col-md-6">
            <div class="card bg-light">
               <div class="card-body">
                 <h4 class="card-title text-center">Mes groupes de discussion</h4>
                  <hr>
                   <ul class="cart-content">
                      <li v-for="channel in channels" :key="channel.id">
                         <button class="btn btn-primary btn-sm my-2" @click="linkChannel(channel.name)">{{ channel.name }}</button>
                        <span v-if="count(channel.id) != 0" class="badge rounded-pill bg-danger" style="font-size: 10px;">
                         {{ count(channel.id) }}
                        </span>
                      </li>
                   </ul>

               </div>
            </div>
      </div>

            <div class="col-md-6">
            <div class="card bg-light">
               <div class="card-body">
                 <h4 class="card-title text-center">Menu</h4>
                  <hr>
                   <ul class="cart-content">
                      <li>
                         <a href="/create" class="btn btn-primary">Créer un groupe de discussion</a>
                      </li>
                   </ul>

               </div>
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
