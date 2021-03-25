<template>
    <div class="mt-5">
        <div class="col-md-8 col-sm-12 m-auto">
            <div class="card">
                <h1 class="card-header text-center">Création Discussion</h1>
                <div class="card-body">
                    <div v-if="errors != []">
                        <p class="text-danger" v-for="(error, index) in errors" :key="index">
                            {{ error[0] }}
                        </p>
                    </div>
                    <div class="md-form">
                        <label for="name" class="col-md-4 col-form-label text-md-left">Nom du groupe</label>
                        <input id="name" type="text" class="form-control" v-model="name" required autofocus>
                    </div>


                    <div class="custom-control mt-3 custom-switch">
                        <input type="checkbox" class="custom-control-input" v-model="checked" id="customSwitch1" checked
                            required>
                        <label class="custom-control-label" for="customSwitch1">
                            <strong v-if="checked">Discussion privée</strong>
                            <strong v-else>Discussion public</strong>
                        </label>
                        <a href="#" class="rounded-circle bg-dark p-1" data-bs-toggle="tooltip"
                            data-bs-placement="right"
                            title="En privée, les utilisateurs ne peuvent pas rejoindre votre groupe de discussion sans invitation.">
                            <strong class="text-light m-1">?</strong>
                        </a>
                    </div>

                    <div class="text-center mt-4">
                        <button type="button" @click="create" class="btn btn-rounded btn-primary">
                            Créer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    export default {
        methods: {
            create() {
                this.errors = []
                axios.post('/create', {
                    name: this.name,
                    checked: this.checked,
                }).then(res => {
                    if (res.status == 200) {
                       window.location = '/chat/'+res.data
                    }
                }).catch(err => {
                    if (err.response.status == 422) {
                        this.errors = err.response.data.errors;
                    }
                })
            },
            newChat() {
                this.name = '',
                    this.checked = true
            }
        },
        data() {
            return {
                checked: true,
                name: '',
                errors: []
            }
        },

    }

</script>
