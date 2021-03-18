<template>
   <div class="col-md-3 col-12 p-3">
      <h3>Membres</h3>
      <hr>
      <ul>
           <li v-for="user in users" :key="user.id">
               <div>
                   <div class="header">
                       <strong class="primary-font">
                           {{ user.name }}
                       </strong>
                   </div>
               </div>
           </li>
       </ul>
   </div>
</template>


<script>
export default {
  props: ['users'],
   
}
</script>
