<style type="text/css">
body {
    margin-top: 20px;
}

.chat-online {
    color: #34ce57;
}

.chat-offline {
    color: #e4606d;
}

.chat-messages {
    display: flex;
    flex-direction: column;
    max-height: 800px;
    overflow-y: scroll;
}

.chat-message-left,
.chat-message-right {
    display: flex;
    flex-shrink: 0;
}

.chat-message-left {
    margin-right: auto;
}

.chat-message-right {
    flex-direction: row-reverse;
    margin-left: auto;
}

.py-3 {
    padding-top: 1rem !important;
    padding-bottom: 1rem !important;
}

.px-4 {
    padding-right: 1.5rem !important;
    padding-left: 1.5rem !important;
}

.flex-grow-0 {
    flex-grow: 0 !important;
}

.border-top {
    border-top: 1px solid #dee2e6 !important;
}

.date-divider {
    text-align: center;
    color: white;
    background-color: rgb(129, 129, 129);
    border-radius: 10px;
}
</style>

<template>
<main class="content">
    <div class="container py-3">
        <h1 class="h3 mb-3">Messages</h1>

        <div class="card">
            <div class="row g-0">
                <div class="col-12 col-lg-5 col-xl-3 border-right">
                    <div class="px-4 d-none d-md-block">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <input type="text" class="form-control my-3" placeholder="Search..." />
                            </div>
                        </div>
                    </div>

                    <a href="#" class="list-group-item list-group-item-action border-0" v-for="user in users" v-if="signedUser.id != user.id" v-bind:key="user.id" @click="fetchPrivateMessage(user.id)">
                        <!-- <div class="badge bg-success float-right">5</div> -->
                        <div class="d-flex align-items-start">
                            <img src="https://bootdey.com/img/Content/avatar/avatar5.png" class="rounded-circle mr-1" alt="Vanessa Tucker" width="40" height="40" />
                            <div class="flex-grow-1 ml-3">
                                {{ user.name }}
                                <div class="small">
                                    <span class="fas fa-circle chat-online"></span>Online
                                </div>
                            </div>
                        </div>
                    </a>
                    <hr class="d-block d-lg-none mt-1 mb-0" />
                </div>
                <div class="col-12 col-lg-7 col-xl-9">
                    <div class="py-2 px-4 border-bottom d-none d-lg-block">
                        <div class="d-flex align-items-center py-1">
                            <div class="position-relative">
                                <img src="https://bootdey.com/img/Content/avatar/avatar3.png" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40" />
                            </div>
                            <div class="flex-grow-1 pl-3" v-if="activeReceiver">
                                <strong>{{ activeReceiver.name }}</strong>
                                <div class="text-muted small" v-if="typingFriend">
                                    <em>Typing</em>
                                </div>
                            </div>
                            <div class="flex-grow-1 pl-3" v-else>
                                <strong>No one is selected</strong>
                            </div>
                        </div>
                    </div>

                    <div class="position-relative">
                        <div class="chat-messages p-4" id="message-box">
                            <div class="message-warp" v-for="message in messages">
                                <div class="container col-2">
                                    <div
                                      v-html="groupByDate(message.created_at)"
                                      class="date-divider"
                                    ></div>
                                </div>
                                <div class="chat-message-right pb-4" v-if="message.receiver_id !== signedUser.id">
                                    <div>
                                        <img src="https://bootdey.com/img/Content/avatar/avatar1.png" class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40" />
                                        <div class="text-muted small text-nowrap mt-2">
                                            {{ timeFormat(message.created_at) }}
                                        </div>
                                    </div>
                                    <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                                        <div class="font-weight-bold mb-1">You</div>
                                        {{ message.message }}
                                    </div>
                                </div>

                                <div class="chat-message-left pb-4" v-if="message.receiver_id === signedUser.id">
                                    <div>
                                        <img src="https://bootdey.com/img/Content/avatar/avatar3.png" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40" />
                                        <div class="text-muted small text-nowrap mt-2">
                                            {{ timeFormat(message.created_at) }}
                                        </div>
                                    </div>
                                    <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">
                                        <div class="font-weight-bold mb-1">
                                            {{ message.user.name }}
                                        </div>
                                        {{ message.message }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <SendMessage v-bind:activeReceiver="activeReceiver" v-bind:signedUser="signedUser" v-bind:fetchPrivateMessage="fetchPrivateMessage"/>
                </div>
            </div>
        </div>
    </div>
</main>
</template>

<script type="text/javascript">
import SendMessage from './SendMessage.vue';
export default {
    components: {
      SendMessage
    },
    data() {
        return {
            messages: [],
            users: [],
            activeReceiver: null,
            signedUser: null,
            typingFriend: false,
            typingClock: null,
            temp: {
                old_unique_date: null,
            },
        };
    },
    created() {
        this.fetchUsers();
        this.fetchSignedInUser();

        Echo.private("chat")
            .listen("MessageSentEvent", (e) => {
                this.messages.push({
                    message: e.message.message,
                    user_id: e.message.user_id,
                    receiver_id: e.message.receiver_id,
                    created_at: e.message.created_at,
                    user: e.user,
                });
                console.log(this.messages);
                setTimeout(this.scrollToEnd, 100);
            })
            .listenForWhisper("typing", (e) => {
                if (e.user.id === this.signedUser.id) {
                    this.typingFriend = true;
                    this.typingClock = setTimeout(() => {
                        this.typingFriend = false;
                    }, 3000);
                }
            });
    },

    methods: {

        fetchPrivateMessage(receiver_id) {
            this.messages = [];
            this.fetchActiveReceiver(receiver_id);
            axios.get("api/messages")
                .then((response) => {
                    this.messages = response.data;
                    this.messages = this.messages.filter((message) => {
                        return (
                            (message.user_id === this.activeReceiver.id &&
                                message.receiver_id === this.signedUser.id) ||
                            (message.user_id === this.signedUser.id &&
                                message.receiver_id === this.activeReceiver.id)
                        );
                    });
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        fetchUsers() {
            axios.get("/users").then((response) => {
                this.users = response.data;
            });
        },

        fetchSignedInUser() {
            axios.get("/getSignedInUser").then((response) => {
                this.signedUser = response.data;
            });
        },

        fetchActiveReceiver(receiver_id) {
            axios.get(`/getActiveUser/${receiver_id}`).then((response) => {
                this.activeReceiver = response.data;
            });
        },

        scrollToEnd() {
            document.getElementById("message-box").scrollTo(0, 9999999);
        },

        timeFormat(date) {
            return moment(String(date)).format("HH:mm");
        },

        groupByDate(date) {
            var old_date = this.temp.old_unique_date;
            var new_date = new Date(date).getDate();
            if (old_date != new_date) {
                this.temp.old_unique_date = new_date;
                var day = ("0" + new Date(date).getDate()).slice(-2);
                var month = ("0" + (new Date(date).getMonth() + 1)).slice(-2);
                var year = ("0" + new Date(date).getFullYear()).slice(-2);
                var date_data = day + "/" + month + "/" + year;
                return date_data;
            }
        }
    }
};
</script>
