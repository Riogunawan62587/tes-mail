/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;


import VueChatScroll from 'vue-chat-scroll';
Vue.use(VueChatScroll);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

var moment = require('moment');

const app = new Vue({
    el: '#app',

    data: {
        messages: [],
        newMessage: '',
        users: [],
        activeReceiver: null,
        signedUser: null
    },

    created() {
        // this.fetchMessages();
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
            this.activeReceiver = receiver_id;
            axios.get('/messages/' + receiver_id).then(response => {
                this.messages = response.data;
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

        addMessage(message, receiver_id) {
            axios.post('/messages', {
                message, receiver_id
            }).then(response => {
                this.messages.push({
                    message: response.data.message.message,
                    user: response.data.user
                });
            });
            // console.log(data.message.receiver_id);
        },

        sendMessage() {
            this.addMessage(this.newMessage, this.activeReceiver);
            this.newMessage = '';
        },

        isToday(date) {
            return moment(String(date)).format('hh:mm');
        }
    }
});
