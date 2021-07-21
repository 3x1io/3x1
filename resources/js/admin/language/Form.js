import AppForm from '../app-components/Form/AppForm';

Vue.component('language-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                arabic:  '' ,
                iso:  '' ,
                name:  '' ,
                
            }
        }
    }

});