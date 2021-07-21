import AppForm from '../app-components/Form/AppForm';

Vue.component('area-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                city_id:  '' ,
                lang:  '' ,
                lat:  '' ,
                name:  '' ,
                
            }
        }
    }

});