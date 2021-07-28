import AppForm from '../app-components/Form/AppForm';

Vue.component('block-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                key:  '' ,
                html:  '' ,
                
            }
        }
    }

});