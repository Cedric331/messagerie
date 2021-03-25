<template>

    <div class="col-12 col-lg-5 col-xl-4 border-right mt-2">
        <search v-if="channel.user_id == auth.id" :channel="channel" v-on:adduser="addMember"></search>

        <h3 class="text-center">Membres en ligne</h3>
        <hr>
        <div v-for="user in members" :key="user.id">
            <div href="#" class="list-group-item list-group-item-action border-0">
                <div class="d-flex align-items-start">
                    <img :src="'/storage/image/avatars/'+user.avatar" class="rounded-circle mr-1"
                        :alt="user.name" width="40" height="40">
                    <div class="flex-grow-1 ml-3">
                        {{ user.name }}
                    </div>
                </div>
            </div>
        </div>

        <h3 class="text-center">Membres du Chat</h3>
        <hr>
        <div v-for="user in users" :key="user.name">
            <div class="list-group-item list-group-item-action border-0">
                <div class="d-flex align-items-start">
                    <img :src="'/storage/image/avatars/'+user.avatar" class="rounded-circle mr-1"
                        :alt="user.name" width="40" height="40">
                    <div class="flex-grow-1 ml-3">
                        {{ user.name }}
                        <em v-if="channel.user_id == user.id"> - 
                           <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" title="Administrateur">
                              <em><i class="fas fa-star text-warning"></i></em>
                           </span>
                        </em>
                        <div class="btn-group dropend ml-5" v-if="auth.id == user.id || channel.user_id == auth.id">
                             <i class="fas fa-bars" data-bs-toggle="dropdown" aria-expanded="false"></i>
                           <ul class="dropdown-menu">
                             <li><button class="dropdown-item" v-if="channel.user_id == auth.id && auth.id != user.id" @click="removeMember(user)">Supprimer cet utilisateur</button></li>
                             <li><button class="dropdown-item" v-if="auth.id == user.id && channel.user_id != auth.id" @click="removeMember(user, true)">Quitter le chat</button></li>
                             <li><button class="dropdown-item" v-if="auth.id == user.id && channel.user_id == auth.id" @click="removeChannel()">Supprimer le chat</button></li>
                           </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr class="d-block d-lg-none mt-1 mb-0">
    </div>
</template>


<script>
    import search from './SearchMember'
    export default {
        methods: {
            addMember(user) {
                axios.post('/member/add', {
                    user: user.user,
                    channel: this.channel.id
                }).then(res => {
                    this.users = res.data
                }).catch(err => {

                })
            },
            removeMember(user, refresh = false) {
                axios.post('/member/remove', {
                    user: user,
                    channel: this.channel.id
                }).then(res => {
                    this.users = res.data
                    if (refresh) {
                       window.location = '/'
                    }
                }).catch(err => {

                })
            },
            removeChannel(){
               axios.post('/channel/remove',{
                  channel: this.channel.id
               }).then(res => {
                 
               })
            }
        },
        data() {
            return {
                users: this.channel.user,
                auth: this.$store.state.auth
            }
        },
        components: {
            search
        },
        props: ['channel', 'members'],
    }

</script>
