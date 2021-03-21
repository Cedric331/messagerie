<template>

    <div class="col-12 col-lg-5 col-xl-3 border-right">
        <search v-on:adduser="addMember"></search>

        <h3 class="text-center">Membres connecté</h3>
        <hr>
        <div v-for="user in members" :key="user.id">
            <a href="#" class="list-group-item list-group-item-action border-0">
                <div class="badge bg-success float-right">5</div>
                <div class="d-flex align-items-start">
                    <img src="https://bootdey.com/img/Content/avatar/avatar5.png" class="rounded-circle mr-1"
                        alt="Vanessa Tucker" width="40" height="40">
                    <div class="flex-grow-1 ml-3">
                        {{ user.name }}
                        <div class="small"><span class="fas fa-circle chat-online"></span> Online</div>
                    </div>
                </div>
            </a>
        </div>

        <h3 class="text-center">Membres de {{channel.name}}</h3>
        <hr>
        <div v-for="user in users" :key="user.name">
            <a href="#" class="list-group-item list-group-item-action border-0">
                <div class="badge bg-success float-right">5</div>
                <div class="d-flex align-items-start">
                    <img src="https://bootdey.com/img/Content/avatar/avatar5.png" class="rounded-circle mr-1"
                        alt="Vanessa Tucker" width="40" height="40">
                    <div class="flex-grow-1 ml-3">
                        {{ user.name }}
                        <em v-if="channel.user_id == user.id"> - admin</em>
                        <div class="small"><span class="fas fa-circle chat-online"></span> Online</div>
                    </div>
                </div>
            </a>
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
            }
        },
        data() {
            return {
                users: this.channel.user,
                connection: this.members
            }
        },
        components: {
            search
        },
        props: ['channel', 'members'],

    }

</script>
