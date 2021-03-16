<template>
  <div class="flex-grow-0 py-3 px-4 border-top">
      <div class="input-group">
          <input type="text" class="form-control" placeholder="Type your message" v-model="newMessage" @keydown="onTyping" @keyup.enter="sendMessage" />
          <button class="btn btn-primary" @click="sendMessage">
              Send
          </button>
      </div>
  </div>
</template>

<script>
export default{
  name: 'SendMessage',
  data() {
      return {
        newMessage: ""
      };
  },
  props: [
    'activeReceiver',
    'signedUser',
    'fetchPrivateMessage'
  ],
  methods : {
    addMessage(message, receiver_id, user_id) {
        axios.post("/api/messages", {
            message,
            receiver_id,
            user_id,
        });
    },

    sendMessage() {
        this.addMessage(
            this.newMessage,
            this.activeReceiver.id,
            this.signedUser.id
        );
        this.newMessage = "";
    },

    onTyping() {
        Echo.private("chat").whisper("typing", {
            user: this.activeReceiver,
        });
    }
  }
}

</script>
