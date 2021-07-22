import AppForm from '../app-components/Form/AppForm';

Vue.component('role-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                guard_name:  '' ,
                name:  '' ,
                permissions: []
            },
            selectAllSwitch: false
        }
    },
    methods: {
        pushPermission(index){
            this.form.permissions.push(index);
        },
        removePermission(index){
          this.$attrs.permissions.push(index, 1);
          this.form.permissions.splice(this.form.permissions.indexOf(index), 1);
        },
        selectAll(permissions){
            if(this.form.permissions.length){
                this.form.permissions = [];
            }
            else {
                this.form.permissions = permissions;
            }
        }
    }

});
