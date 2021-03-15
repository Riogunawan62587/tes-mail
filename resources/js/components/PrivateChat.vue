<template>
  <div>
    <div class="layout shadow">

      <!-- Sidebar -->
      <div class="sidebar">
        <div class="tab-content h-100" role="tablist">
          <div class="tab-pane fade h-100" id="tab-content-create-chat" role="tabpanel">
            <div class="d-flex flex-column h-100">
              <div class="hide-scrollbar">
                <div class="container-fluid py-6">
                  <!-- Search -->
                  <form class="mb-6">
                    <div class="input-group">
                      <input type="text" class="form-control form-control-lg" placeholder="Search for messages or users..."
                        aria-label="Search for messages or users...">
                      <div class="input-group-append">
                        <button class="btn btn-lg btn-ico btn-secondary btn-minimal" type="submit">
                          <i class="fe-search"></i>
                        </button>
                      </div>
                    </div>
                  </form>
                  <!-- Search -->
                </div>
              </div>
            </div>
          </div>

          <div class="tab-pane fade h-100 show active" id="tab-content-dialogs" role="tabpanel">
            <div class="d-flex flex-column h-100">
              <div class="hide-scrollbar">
                <div class="container-fluid py-6">
                  <!-- Title -->
                  <h2 class="font-bold mb-6">User Lists</h2>
                  <!-- Title -->
                  <!-- Chats -->
                  <nav class="nav d-block list-discussions-js mb-n6 mb-1" v-for="friend in users"
                    v-if="signedUser.id != friend.id" :key="friend.id" @click="fetchPrivateMessage(friend.id)">
                    <!-- Chat link -->
                    <a class="text-reset nav-link p-0 mb-6" href="#">
                      <div class="card card-active-listener">
                        <div class="card-body">
                          <div class="media">
                            <div class="avatar mr-5">
                              <img class="avatar-img" src="/images/avatars/11.jpg" alt="Bootstrap Themes">
                            </div>
                            <div class="media-body overflow-hidden">
                              <div class="d-flex align-items-center">
                                <li class="text-truncate mb-0 mt-3 mr-auto">
                                  {{ friend.name }}
                                </li>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </a>
                    <!-- Chat link -->
                  </nav>
                  <!-- Chats -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Sidebar -->

      <!-- Main Content -->
      <div class="main" data-mobile-height="">

        <!-- Default Page -->
        <div class="chat flex-column">
          <div class="container-xxl mt-4">

            <!-- Main Content -->
            <div class="main main-visible" data-mobile-height="" v-for="friend in users" v-if="signedUser.id != friend.id" :key="friend.id">

              <!-- Chat -->
              <div id="chat-1" class="chat dropzone-form-js">

                <!-- Chat: body -->
                <div class="chat-body">

                  <!-- Chat: Header -->
                  <div class="chat-header border-bottom py-4 py-lg-6 px-lg-8">
                    <div class="container-xxl">
                      <div class="row align-items-center">

                        <!-- Close chat(mobile) -->
                        <div class="col-3 d-xl-none">
                          <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                              <a class="text-muted px-0" href="chat-1.html#" data-chat="open">
                                <i class="icon-md fe-chevron-left"></i>
                              </a>
                            </li>
                          </ul>
                        </div>

                        <!-- Chat photo -->
                        <div class="col-6 col-xl-6">
                          <div class="media text-center text-xl-left">
                            <div class="avatar avatar-sm d-none d-xl-inline-block mr-5">
                              <img src="/images/avatars/11.jpg" class="avatar-img" alt="">
                            </div>

                            <div class="media-body align-self-center text-truncate">
                              <!-- <h2 class="font-bold mb-6">Chat Rooms</h2> -->

                              <h6 class="text-truncate mb-n1">{{ friend.name }}</h6>
                              <small class="text-muted">Online</small>
                            </div>
                          </div>
                        </div>

                      </div><!-- .row -->

                    </div>
                  </div>
                  <!-- Chat: Header -->

                  <!-- Chat: Content-->
                  <div class="chat-content px-lg-8" v-chat-scroll>
                    <div class="container-xxl py-6 py-lg-10 clearfix" v-for="message in messages">

                      <!-- Message -->
                      <div class="message sents" v-if="message.receiver_id === signedUser.id">
                        <!-- Avatar -->
                        <a class="avatar avatar-sm mr-4 mr-lg-5" href="#"
                          data-chat-sidebar-toggle="#chat-1-user-profile">
                          <img class="avatar-img" src="/images/avatars/11.jpg" alt="">
                        </a>

                        <!-- Message: body -->
                        <div class="message-body">

                          <!-- Message: row -->
                          <div class="message-row">
                            <div class="d-flex align-items-center">

                              <!-- Message: content -->
                              <div class="message-content bg-light">
                                <div>
                                </div>
                                <div> {{ message.message }}</div>

                                <div class="mt-1">
                                  <small class="opacity-65">{{timeFormat(message.created_at)}}</small>
                                </div>
                              </div>
                              <!-- Message: content -->

                            </div>
                          </div>
                          <!-- Message: row -->

                        </div>
                        <!-- Message: Body -->
                      </div>
                      <!-- Message -->

                      <!-- Divider -->
                      <!-- <div class="message-divider my-9 mx-lg-5">
                        <div class="row align-items-center">

                          <div class="col">
                            <hr>
                          </div>

                          <div class="col-auto">
                            <small class="text-muted">Today</small>
                          </div>

                          <div class="col">
                            <hr>
                          </div>
                        </div>
                      </div> -->
                      <!-- Divider -->

                      <!-- Message -->
                      <div class="message message-right replies" v-if="message.receiver_id != signedUser.id">
                        <!-- Avatar -->
                        <a class="avatar avatar-sm ml-4 ml-lg-5 d-none d-lg-block" href="#"
                          data-chat-sidebar-toggle="#chat-1-user-profile">
                          <img class="avatar-img" src="/images/avatars/11.jpg" alt="">
                        </a>

                        <!-- Message: body -->
                        <div class="message-body">

                          <!-- Message: row -->
                          <div class="message-row">
                            <div class="d-flex align-items-center justify-content-end">

                              <!-- Message: content -->
                              <div class="message-content bg-primary text-white">
                                <div class="h5 text-white">{{ message.user.name }}</div>
                                <div> {{ message.message }}</div>

                                <div class="mt-1">
                                  <small class="opacity-65">{{timeFormat(message.created_at)}}</small>
                                </div>
                              </div>
                              <!-- Message: content -->

                            </div>
                          </div>
                          <!-- Message: row -->

                        </div>
                        <!-- Message: body -->
                      </div>
                      <!-- Message -->

                    </div>

                    <!-- Scroll to end -->
                    <div class="end-of-chat"></div>
                  </div>
                  <!-- Chat: Content -->

                  <!-- Chat: Footer -->
                  <div class="chat-footer border-top py-4 py-lg-6 px-lg-8">
                    <div class="container-xxl">

                      <div class="form-row align-items-center">
                        <div class="col">
                          <div class="input-group">
                            <input type="text" id="chat-id-1-input" name="message"
                              class="form-control bg-light border-0 mb-4 input-group text-black-50" placeholder="Type your message here..."
                              v-model="newMessage" @keyup.enter="sendMessage">
                          </div>
                        </div>

                        <!-- Submit button -->
                        <div class="col-auto">
                          <button class="btn btn-ico btn-primary rounded-circle mb-4" @click="sendMessage"><img src="/images/icon.png" class="rounded-circle mr-4" style="height: 24px">
                          </button>
                        </div>
                      </div>

                    </div>
                  </div>
                  <!-- Chat: Footer -->

                  <!-- Chat: DropzoneJS container -->
                  <div class="chat-files hide-scrollbar px-lg-8">
                    <div class="container-xxl">
                      <div class="dropzone-previews-js form-row py-4"></div>
                    </div>
                  </div>
                  <!-- Chat: DropzoneJS container -->




                </div>
                <!-- Chat: body -->

              </div>
              <!-- Chat -->

            </div>
            <!-- Main Content -->

          </div>
        </div>
        <!-- Default Page -->

      </div>
      <!-- Main Content -->

    </div>
  </div>
</template>

<script type="text/javascript">
  export default {
    data(){
      return{
        messages: [],
        newMessage: '',
        users: [],
        activeReceiver: null,
        signedUser: null
      };
    },
    created(){
      this.fetchUsers();
      this.fetchSignedInUser();

      Echo.private('chat')
          .listen('MessageSentEvent', (e) => {
              this.messages.push({
                  message: e.message.message,
                  created_at: e.message.created_at,
                  user: e.user
              });
      });
    },

    methods: {
        fetchMessages() {
            axios.get('/messages').then(response => {
                this.messages = response.data;
            })
        },

        fetchPrivateMessage(receiver_id) {
            this.fetchActiveReceiver(receiver_id);
            axios.get('api/messages')
            .then(response => {
                this.messages = response.data;
                this.messages = this.messages.filter(message => {
                  return (message.user_id === this.activeReceiver.id && message.receiver_id === this.signedUser.id) || (message.user_id === this.signedUser.id && message.receiver_id === this.activeReceiver.id);
                });
            })
            .catch(error => {
              console.log(error)
            })
        },

        fetchUsers() {
            axios.get('/users').then(response => {
                this.users = response.data;
            })
        },

        fetchSignedInUser() {
            axios.get('/getSignedInUser').then(response => {
                this.signedUser = response.data;
            })
        },

        fetchActiveReceiver(receiver_id) {
          axios.get(`/getActiveUser/${receiver_id}`).then(response => {
              this.activeReceiver = response.data;
          })
        },

        addMessage(message, receiver_id, user_id) {
            axios.post('/api/messages', {
                message, receiver_id, user_id
            }).then(response => {
                this.messages.push({
                    message: response.data.message.message,
                    user: response.data.user
                });
            });

        },

        sendMessage() {
            this.addMessage(this.newMessage, this.activeReceiver.id, this.signedUser.id);
            this.newMessage = '';
        },

        timeFormat(date) {
            return moment(String(date)).format('hh:mm');
        }
    }
  };
</script>
