import AppForm from '../app-components/Form/AppForm';

Vue.component('city-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                country_id:  '' ,
                lang:  '' ,
                lat:  '' ,
                name:  '' ,
                price:  '' ,
                shipping:  '' ,
                
            }
        }
    }

});