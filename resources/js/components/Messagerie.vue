<template>
    <div class="container p-0 my-5">
        <div class="card">
            <div class="row g-0">
                <member :members="members" :channel="channel" :key="members.length"></member>

                <div class="col-12 col-lg-7 col-xl-8">
                    <h1 class="text-center mt-2">{{channel.name}}</h1>
                    <hr>
                    <div class="position-relative chat-messages">
                        <div class="text-center mt-1">
                            <button v-if="channel.messages.length > count" @click="moreMessage"
                                class="btn btn-outline-dark m-auto">Afficher plus de message</button>
                        </div>
                        <div class="p-4" v-for="message in allMessages" :key="message.id">

                            <div v-if="message.user.id == user.id">
                                <div class="chat-message-right pb-2">
                                    <img :src="'/storage/image/avatars/'+message.user.avatar"
                                        class="rounded-circle mr-1" width="40" height="40">
                                    <div class="flex-shrink-1 text-break bg-dark text-white rounded py-2 px-3 mr-3">
                                        <div class="font-weight-bold text-white mb-1">Vous</div>
                                        {{ message.message }}
                                    </div>
                                </div>
                                <div class="chat-message-right" v-if="message.image != null && message.image != 'Image supprimée'">
                                    <a @click="modal(channel.id, message.image)" type="button" data-toggle="modal" data-target="#modalYT">
                                       <img :src="'/storage/image/images/'+channel.id+'/'+message.image"
                                        class="mr-1" width="200">
                                    </a>
                                </div>
                                 <div class="chat-message-right" v-if="message.image == 'Image supprimée'">
                                    <strong class="border p-1">{{message.image}}</strong>
                                </div>
                                <div class="chat-message-right" v-if="message.image != null">
                                   <span v-if="message.user.id == user.id && message.image != null && message.image != 'Image supprimée'">
                                      <button class="btn btn-outline-danger btn-sm mt-1 p-2" @click="deleteUpload(message)">Supprimer cette image</button>
                                   </span>
                                </div>
                            </div>

                            <div v-else>
                                <div class="chat-message-left pb-2">
                                    <img :src="'/storage/image/avatars/'+message.user.avatar"
                                        class="rounded-circle mr-1" width="40" height="40">
                                    <div class="flex-shrink-1 text-break bg-lightm text-dark rounded py-2 px-3 ml-3">
                                        <div class="font-weight-bold mb-1">{{ message.user.name }}</div>
                                        {{ message.message }}
                                    </div>
                                </div>
                                 <div class="chat-message-left" v-if="message.image != null && message.image != 'Image supprimée'">
                                 <a @click="modal(channel.id, message.image)" type="button" data-toggle="modal" data-target="#modalYT">
                                    <img :src="'/storage/image/images/'+channel.id+'/'+message.image"
                                        class="ml-1" width="200">
                                 </a>
                                </div>
                                 <div class="chat-message-left" v-if="message.image == 'Image supprimée'">
                                    <strong class="border p-1">{{message.image}}</strong>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="py-2 px-4 border-bottom d-none d-lg-block">
                        <div class="d-flex align-items-center py-1">
                            <div class="flex-grow-1 pl-3" v-show="typing">
                                <strong>{{ other }}</strong>
                                <div class="text-muted small">
                                    <em>écrit un message</em>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="errors != [] || error != ''">
                        <p class="text-danger" v-for="(error, index) in errors" :key="index">
                            {{ error[0] }}
                        </p>
                        <p class="text-danger">
                            {{ error }}
                        </p>
                    </div>
                    <post :channel="channel" :user="user" v-on:messagesent="addMessage"></post>
                </div>
            </div>
        </div>
        <modal v-if="channelModal != '' && imageModal != ''" :channel="channelModal" :image="imageModal"></modal>
    </div>
</template>

<script>
    import post from './PostMessage'
    import member from './MemberChat'
    import modal from './ImageModal'
    export default {
        props: ['channel', 'user'],

        components: {
            post,
            member,
            modal
        },
        data() {
            return {
                allMessages: this.messages,
                count: 10,
                members: [],
                typing: false,
                other: '',
                errors: [],
                error: '',
                channelModal: '',
                imageModal: ''
            }
        },
        methods: {
           deleteUpload(message){
              axios.post('/delete/image',{
                 message: message.id,
                 channel: this.channel.id
              }).then(res => {
                 console.log(res)
                 this.fetchMessages(false)
              }).catch(err =>{

              })
           },
            addMessage(message) {
                this.errors = []
                this.error = ''
                let formData = new FormData();
                formData.append('file', message.file);
                formData.append('message', message.message);
                formData.append('channel', this.channel.id);

                axios.post('/message/post', formData)
                    .then(res => {
                        this.fetchMessages()
                        this.notification()
                    }).catch(err => {
                        if (err.response.status == 422) {
                            this.errors = err.response.data.errors;
                        }
                        if (err.response.status == 409) {
                            this.error = err.response.data;
                        }
                    })
            },
            notification() {
                axios.post('/notification/channel', {
                    members: this.members,
                    channel: this.channel.id
                }).then(res => {

                }).catch(err => {

                })
            },
            fetchMessages(scroll = true) {
                axios.post('/fetch/message', {
                    count: this.count,
                    channel: this.channel.id
                }).then(response => {
                    this.allMessages = response.data.reverse();
                    if (scroll) {
                        this.scroll()
                    }
                });
            },
            moreMessage() {
                this.count += 10
                this.fetchMessages(false);
            },
            scroll() {
                let bodyChat = document.querySelector(".chat-messages");
                this.$nextTick(() => {
                    bodyChat.scrollTop = bodyChat.scrollHeight;
                })
            },
            modal(channel, image){
               this.channelModal = channel
               this.imageModal = image
            }
        },
        created() {
            this.fetchMessages();
            let _this = this;
            Echo.private('chat.' + this.channel.id)
                .listen('MessageSent', (e) => {
                    this.fetchMessages();
                })
                .listen('RemoveUserChat', (e) => {
                    window.location = '/'
                })
                .listenForWhisper('typing', (e) => {
                    this.typing = e.typing
                    this.other = e.name

                    setTimeout(function () {
                        _this.typing = false
                    }, 1200);
                });

            Echo.join('chat.' + this.channel.id)
                .here((users) => {
                    this.members = users
                })
                .joining((user) => {
                    this.members.push(user)
                })
                .leaving((user) => {
                    this.members = this.members.filter(function (item) {
                        return item !== user
                    })
                });
        },
    }

</script>
