import AppForm from '../app-components/Form/AppForm';

Vue.component('user-notification-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                title:  '' ,
                message:  '' ,
                icon:  'fa fa-user' ,
                url:  '' ,
                type:  'all' ,
                user_id:  '' ,
                
            },
            mediaCollections: ['image']
        }
    }

});
