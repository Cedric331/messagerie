<template>


    <div class="px-4 d-none d-md-block">
        <div class="d-flex align-items-center">
            <div class="flex-grow-1">
                <input class="dropdown-input form-control my-3" v-model="search" @keyup="searchMember"
                    placeholder="Inviter des utilisateurs...">
                <div v-if="search != '' && users.length > 0" class="dropdown-list">
                    <div v-for="user in users" :key="user.id" class="dropdown-item">
                        {{ user.name }} - <button type="button" @click="addMember(user.id)"
                            class="btn btn-primary btn-sm">Inviter</button>
                    </div>
                </div>
                <div v-show="search != '' && users.length == 0" class="dropdown-list">
                    <div class="dropdown-item">
                        Aucun utilisateur trouvé
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    export default {
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
                        search: this.search
                    }).then(res => {
                        this.users = res.data
                    }).catch(err => {

                    })
                }
            },
            addMember(user) {
                this.$emit('adduser', {
                    user: user
                });
            }
        },

    }

</script>
