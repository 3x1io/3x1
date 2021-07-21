import AppForm from '../app-components/Form/AppForm';

Vue.component('admin-user-form', {
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
                
            }
        }
    }
});