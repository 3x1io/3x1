import AppForm from '../app-components/Form/AppForm';

Vue.component('role-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                guard_name:  '' ,
                name:  '' ,
                
            }
        }
    }

});