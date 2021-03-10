@extends('layouts.app')

@section('content')

<div class="layout">

  <!-- Navbar -->
  <div class="navigation navbar navbar-light justify-content-center py-xl-7">

  </div>
  <!-- Navbar -->

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
              <nav class="nav d-block list-discussions-js mb-n6" v-for="friend in users"
                v-if="signedUser.id != friend.id" :key="friend.id" @click="fetchPrivateMessage(friend.id)">
                <!-- Chat link -->
                <a class="text-reset nav-link p-0 mb-6" href="#">
                  <div class="card card-active-listener">
                    <div class="card-body">
                      <div class="media">
                        <div class="avatar mr-5">
                          <img class="avatar-img" src="{{asset('images/avatars/11.jpg')}}" alt="Bootstrap Themes">
                        </div>

                        <div class="media-body overflow-hidden">
                          <div class="d-flex align-items-center">
                            <li class="text-truncate mb-0 mt-3 mr-auto">
                              @{{ friend.name }}
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
                          <img src="{{asset('images/avatars/11.jpg')}}" class="avatar-img" alt="">
                        </div>

                        <div class="media-body align-self-center text-truncate">
                          <h6 class="text-truncate mb-n1"> @{{ friend.name }}</h6>
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
                      <img class="avatar-img" src="{{asset('images/avatars/11.jpg')}}" alt="">
                    </a>

                    <!-- Message: body -->
                    <div class="message-body">

                      <!-- Message: row -->
                      <div class="message-row">
                        <div class="d-flex align-items-center">

                          <!-- Message: content -->
                          <div class="message-content bg-light">
                            <div> @{{ message.message }}</div>

                            <div class="mt-1">
                              <small class="opacity-65">@{{isToday(message.created_at)}}</small>
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

                  {{-- <!-- Divider -->
                  <div class="message-divider my-9 mx-lg-5">
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
                  </div>
                  <!-- Divider --> --}}

                  <!-- Message -->
                  <div class="message message-right replies" v-if="message.receiver_id != signedUser.id">
                    <!-- Avatar -->
                    <a class="avatar avatar-sm ml-4 ml-lg-5 d-none d-lg-block" href="#"
                      data-chat-sidebar-toggle="#chat-1-user-profile">
                      <img class="avatar-img" src="{{asset('images/avatars/11.jpg')}}" alt="">
                    </a>

                    <!-- Message: body -->
                    <div class="message-body">

                      <!-- Message: row -->
                      <div class="message-row">
                        <div class="d-flex align-items-center justify-content-end">

                          <!-- Message: content -->
                          <div class="message-content bg-primary text-white">
                            <div> @{{ message.message }}</div>

                            <div class="mt-1">
                              <small class="opacity-65">@{{isToday(message.created_at)}}</small>
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
                          class="form-control bg-light border-0 mb-4 input-group" placeholder="Type your message here..."
                          v-model="newMessage" @keyup.enter="sendMessage">
                      </div>
                    </div>

                    <!-- Submit button -->
                    <div class="col-auto">
                      <button class="btn btn-ico btn-primary rounded-circle mb-4" @click="sendMessage"><img src="{{asset('images/icon.png')}}" class="rounded-circle mr-4" style="height: 24px">
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
<!-- Layout -->

{{-- <div class="container">
  <div class="row justify-content-center">
    <div class="col-md-4 pr-3">
      <div class="row no-gutters">
        <div class="col-md-12 bg-white shadow-sm rounded">
          <h2 class="p-3">User List</h2>
          <ul style="list-style: none; padding: 0;">
            <li class="p-3 bg-light" v-for="friend in users" v-if="signedUser.id != friend.id" :key="friend.id"
              @click="fetchPrivateMessage(friend.id)">
              @{{ friend.name }}
</li>
</ul>
</div>
</div>
</div>
<div class="col-md-8">
  <div class="row no-gutters">
    <div class="col-sm-12">
      <div class="title bg-primary" style="border-radius: 10px 10px 0 0;">
        <h2 class="text-white py-1 px-2 mb-0">Messages</h2>
      </div>
      <div class="content bg-white px-3 py-2 shadow-sm" style="border-radius: 0 0 10px 10px;">
        <div class="clearfix" v-for="message in messages">
          <ul style="padding: 0;">
            <li v-if="message.receiver_id === signedUser.id" class="sents" style="list-style: none;">
              <div class="chat-head">
                @{{ message.user.name }} | <span class="text-muted">@{{isToday(message.created_at)}}</span>
              </div>
              <div class="bg-secondary py-2 px-3 text-white chat-body d-inline-block"
                style="border-radius: 0 15px 15px 15px;">
                @{{ message.message }}
              </div>
            </li>
            <li v-if="message.receiver_id != signedUser.id" class="replies float-right" style="list-style: none;">
              <div class="chat-head d-block">
                <p class="text-right mb-0">@{{ message.user.name }} | <span
                    class="text-muted">@{{isToday(message.created_at)}}</span></p>
              </div>
              <div class="bg-primary py-2 px-3 text-white chat-body" style="border-radius: 15px 0 15px 15px;">
                @{{ message.message }}
              </div>
            </li>
          </ul>
        </div>
        <div class="input-group mt-3">
          <input type="text" name="message" class="form-control" placeholder="Type your message here..."
            v-model="newMessage" @keyup.enter="sendMessage">
          <button class="btn btn-primary" @click="sendMessage">Send</button>
        </div>
      </div>
    </div>
  </div>

</div>
</div>
</div> --}}
@endsection

@push('scripts')
@endpush