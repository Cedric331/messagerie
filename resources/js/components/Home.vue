<template>
<div class="container">
   <div class="row">
      <div class="col-md-6">
            <div class="card bg-light">
               <div class="card-body">
                 <h4 class="card-title text-center">Mes groupes de discussion</h4>
                  <hr>
                   <ul class="cart-content">
                      <li v-for="channel in channels" :key="channel.id">
                         <button class="btn btn-primary" @click="linkChannel(channel.name)">{{ channel.name }}</button>
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
     }
  },
  props: ['channels'],
   
}
</script>
