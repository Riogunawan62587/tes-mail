@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-4 pr-3">
      <div class="row no-gutters">
        <div class="col-md-12 bg-white shadow-sm p-2 rounded">
          <h2>User List</h2>
          <ul>
            <li>User 1</li>
            <li>User 2</li>
            <li>User 3</li>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-md-8">
      <div class="row no-gutter">
        <div class="col-sm-12 bg-white shadow-sm p-2 rounded">
          <h2>Messages</h2>

          <div class="clearfix" v-for="message in messages">
            <ul>
              <li style="list-style: none;">
                <div class="chat-head">
                  @{{ message.user.name }} | @{{ message.created_at | formatDate }}
                </div>
                <div class="bg-primary py-2 px-3 text-white chat-body d-inline-block" style="border-radius: 0 15px 15px 15px;">
                  @{{ message.message }}
                </div>
              </li>
            </ul>
          </div>
          <div class="input-group">
            <input type="text" name="message" class="form-control" placeholder="Type your message here..." v-model="newMessage" @keyup.enter="sendMessage">
            <button class="btn btn-primary" @click="sendMessage">Send</button>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
