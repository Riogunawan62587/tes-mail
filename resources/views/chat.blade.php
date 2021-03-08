@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-4 pr-3">
      <div class="row no-gutters">
        <div class="col-md-12 bg-white shadow-sm rounded">
          <h2 class="p-3">User List</h2>
          <ul style="list-style: none; padding: 0;">
            <li class="p-3 bg-light" v-for="friend in users" v-if="signedUser.id != friend.id" :key="friend.id" @click="fetchPrivateMessage(friend.id)">
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
                  <div class="bg-secondary py-2 px-3 text-white chat-body d-inline-block" style="border-radius: 0 15px 15px 15px;">
                    @{{ message.message }}
                  </div>
                </li>
                <li v-if="message.receiver_id != signedUser.id" class="replies float-right" style="list-style: none;">
                  <div class="chat-head d-block">
                    <p class="text-right mb-0">@{{ message.user.name }} | <span class="text-muted">@{{isToday(message.created_at)}}</span></p>
                  </div>
                  <div class="bg-primary py-2 px-3 text-white chat-body" style="border-radius: 15px 0 15px 15px;">
                    @{{ message.message }}
                  </div>
                </li>
              </ul>
            </div>
            <div class="input-group mt-3">
              <input type="text" name="message" class="form-control" placeholder="Type your message here..." v-model="newMessage" @keyup.enter="sendMessage">
              <button class="btn btn-primary" @click="sendMessage">Send</button>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection

@push('scripts')
@endpush
