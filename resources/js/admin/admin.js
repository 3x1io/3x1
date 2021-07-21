import './bootstrap';

import 'vue-multiselect/dist/vue-multiselect.min.css';
import flatPickr from 'vue-flatpickr-component';
import VueQuillEditor from 'vue-quill-editor';
import Notifications from 'vue-notification';
import Multiselect from 'vue-multiselect';
import VeeValidate from 'vee-validate';
import 'flatpickr/dist/flatpickr.css';
import VueCookie from 'vue-cookie';
import { Admin } from 'craftable';
import VModal from 'vue-js-modal'
import Vue from 'vue';

import './app-components/bootstrap';
import './index';

import 'craftable/dist/ui';
import Echo from "laravel-echo";
import Pusher from "pusher-js";

Vue.component('multiselect', Multiselect);
Vue.use(VeeValidate, {strict: true});
Vue.component('datetime', flatPickr);
Vue.use(VModal, { dialog: true, dynamic: true, injectModalsContainer: true });
Vue.use(VueQuillEditor);
Vue.use(Notifications);
Vue.use(VueCookie);


let pusher = new Pusher(pusherKey, {
    encrypted: true,
    cluster: 'eu'
});
Pusher.logToConsole = false;
let channel = pusher.subscribe('push-notifications');
channel.bind('App\\Events\\PushNotification', function(data) {
    if(data.type === 'all' || authId == data.authId){
        Notification.requestPermission( permission => {
            let notification = new Notification(data.title, {
                body: data.message, // content for the alert
                icon: data.image // optional image url
            });

            // link to page on clicking the notification
            notification.onclick = (data) => {
                window.open(data.url);
            };
        });

        //Push To Notification
        $('#not-area').append('<a href="'+data.url+'" class="dropdown-item"><i class="fa '+data.icon+' text-success"></i> '+data.title+'</a>');
    }
});


window.Visibility = require('visibilityjs'); // import the visibility.js library

let liveChanel = pusher.subscribe('live-monitor');
liveChanel.bind('App\\Events\\FinishedCheck', function(e) {
    const { id, type, last_run_message, element_class, last_update, host_id } = e.message; // destructure the event data

    $(`#${id} .${type}`)
        .text(last_run_message)
        .removeClass('text-success text-danger text-warning')
        .addClass(element_class);

    $(`#${host_id}`).text(`Last update: ${last_update}`);

    Visibility.change(function (e, state) {
        $.post('/page-visibility', { state }); // hidden or visible
    });
});



new Vue({
    mixins: [Admin],
});
