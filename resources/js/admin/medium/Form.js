import AppForm from '../app-components/Form/AppForm';

Vue.component('medium-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                collection_name:  '' ,
                conversions_disk:  '' ,
                custom_properties:  this.getLocalizedFormDefaults() ,
                disk:  '' ,
                file_name:  '' ,
                generated_conversions:  this.getLocalizedFormDefaults() ,
                manipulations:  this.getLocalizedFormDefaults() ,
                mime_type:  '' ,
                model_id:  '' ,
                model_type:  '' ,
                name:  '' ,
                order_column:  '' ,
                responsive_images:  this.getLocalizedFormDefaults() ,
                size:  '' ,
                uuid:  '' ,
                
            }
        }
    }

});