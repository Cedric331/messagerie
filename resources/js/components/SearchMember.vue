<template>


    <div class="px-4 d-none d-block my-3">
        <div class="d-flex align-items-center">
            <div class="flex-grow-1">
                <div class="d-flex dropdown">
                    <input class="form-control form-control" type="text" v-model="search" @keyup="searchMember"
                        placeholder="Inviter des utilisateurs..." id="menu1" data-toggle="dropdown">
                    <div class="dropdown-menu w-100" v-show="search != ''" role="menu" aria-labelledby="menu1">
                        <ul v-for="user in users" :key="user.id">
                            <li>
                                {{ user.name }} - <a @click="addMember(user.id)" type="button"
                                    class="btn btn-primary btn-sm">Inviter</a>
                            </li>
                           <li v-show="search != '' && users.length == 0">
                                 Aucun utilisateur trouvé
                            </li>
                            <div class="dropdown-divider"></div>
                        </ul>
                        <ul v-show="search != '' && users.length == 0">
                           <li>
                                 Aucun utilisateur trouvé ou déjà présent dans la discussion
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
        props: ['channel'],
        data() {
            return {
                search: '',
                users: []
            }
        },
        methods: {
            searchMember() {
                this.search = this.search.replace(/ /g, "");
                if (this.search != '') {
                    axios.post('/member/search', {
                        search: this.search,
                        channel: this.channel.id
                    }).then(res => {
                        this.users = res.data
                    }).catch(err => {})
                }
            },
            addMember(user) {
                this.$emit('adduser', {
                    user: user
                });
                this.searchMember()
            }
        },

    }

</script>
