<template>
   <div class="container">
      <h1>Mes groupes de discussion</h1>
      <ul>
         <li v-for="channel in channels" :key="channel.id">
            <button class="btn btn-primary" @click="linkChannel(channel.name)">{{ channel.name }}</button>
         </li>
      </ul>
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
