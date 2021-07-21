import AppForm from '../app-components/Form/AppForm';

Vue.component('profile-edit-profile-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                activated:  false ,
                email:  '' ,
                first_name:  '' ,
                forbidden:  false ,
                language:  '' ,
                last_name:  '' ,
                password:  '' ,
                
            },
            mediaCollections: ['avatar']
        }
    },
    methods: {
        onSuccess(data) {
            if(data.notify) {
                this.$notify({ type: data.notify.type, title: data.notify.title, text: data.notify.message});
            } else if (data.redirect) {
                window.location.replace(data.redirect);
            }
        }
    }
});