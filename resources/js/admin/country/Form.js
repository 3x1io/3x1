import AppForm from '../app-components/Form/AppForm';

Vue.component('country-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                name:  '' ,
                code:  '' ,
                phone:  '' ,
                lat:  '' ,
                lang:  '' ,
                
            }
        }
    }

});