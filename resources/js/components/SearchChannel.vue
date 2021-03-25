<template>
    <div class="px-4 d-none d-block my-3">
        <div class="d-flex align-items-center">
            <div class="flex-grow-1">
                <div class="d-flex dropdown">
                    <input class="form-control form-control" type="text" v-model="search" @keyup="searchChannel"
                        placeholder="Rechercher..." id="menu1" data-toggle="dropdown">
                    <div class="dropdown-menu w-100" v-show="search != ''" role="menu" aria-labelledby="menu1">
                        <ul v-for="channel in channels" :key="channel.id">
                            <li class="text-center">
                                <strong>{{ channel.name }}</strong> - <a @click="joinChannel(channel.id)" type="button"
                                    class="btn btn-primary btn-sm">Rejoindre le channel</a>
                            </li>
                            <div class="dropdown-divider"></div>
                        </ul>
                        <ul v-show="search != '' && channels.length == 0">
                           <li>
                              Aucun channel public trouvé
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
     searchChannel: function(){
        axios.post('/search/channel',{
           search : this.search
        }).then(res => {
           this.channels = res.data
        }).catch(err => {

        })
     },
     joinChannel: function(id){
        axios.post('/join/channel',{
           id: id
        }).then(res => {
           window.location = '/chat/'+res.data
        }).catch(err => {

        })
     }
  },
  data () {
    return {
       channels: [],
       search: ''
    }
  },

    }

</script>
