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


import wysiwyg from "vue-wysiwyg";
import "vue-wysiwyg/dist/vueWysiwyg.css";
Vue.use(wysiwyg, {}); // config is optional. more below

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
Vue.use(VueSweetalert2);

// Import the styles too, typically in App.vue or main.js
import 'vue-swatches/dist/vue-swatches.css'
Vue.component('color', VSwatches);

Vue.mixin({
    data(){
        return {
            editor: ''
        }
    },
    methods: {
        vueSlug: function(title) {
            var slug = "";
            // Change to lower case
            var titleLower = title.toLowerCase();
            // Letter "e"
            slug = titleLower.replace(/e|é|è|ẽ|ẻ|ẹ|ê|ế|ề|ễ|ể|ệ/gi, 'e');
            // Letter "a"
            slug = slug.replace(/a|á|à|ã|ả|ạ|ă|ắ|ằ|ẵ|ẳ|ặ|â|ấ|ầ|ẫ|ẩ|ậ/gi, 'a');
            // Letter "o"
            slug = slug.replace(/o|ó|ò|õ|ỏ|ọ|ô|ố|ồ|ỗ|ổ|ộ|ơ|ớ|ờ|ỡ|ở|ợ/gi, 'o');
            // Letter "u"
            slug = slug.replace(/u|ú|ù|ũ|ủ|ụ|ư|ứ|ừ|ữ|ử|ự/gi, 'u');
            // Letter "d"
            slug = slug.replace(/đ/gi, 'd');
            // Trim the last whitespace
            slug = slug.replace(/\s*$/g, '');
            // Change whitespace to "-"
            slug = slug.replace(/\s+/g, '-');

            return slug;
        },
        editorInit: function () {
            require('brace/ext/language_tools') //language extension prerequsite...
            require('brace/mode/html')
            require('brace/mode/javascript')    //language
            require('brace/mode/php')    //language
            require('brace/mode/less')
            require('brace/theme/chrome')
            require('brace/snippets/javascript') //snippet
        }
    }
})

Vue.component('editor', require('vue2-ace-editor'));

import StarRating from 'vue-star-rating'
Vue.component('rating', StarRating);


import VueTheMask from 'vue-the-mask'
Vue.use(VueTheMask)

import VSwatches from 'vue-swatches'
// Import the styles too, typically in App.vue or main.js
import 'vue-swatches/dist/vue-swatches.css'
Vue.component('color', VSwatches);

import VueAceEdit from "vue-ace-edit"
Vue.use(VueAceEdit)

new Vue({
    mixins: [Admin],
});
