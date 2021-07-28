import AppForm from '../app-components/Form/AppForm';

Vue.component('main-form', {
    mixins: [AppForm],
    data(){
      return {
          form: {}
      }
    },
    props: {
        set_from: Object,
        items: Object,
        redirect: String
    },
    created() {
        this.form = this.$props.set_from
    },
    computed: {
        discount(){
            let discount = 0;
            if(this.$props.set_from.hasOwnProperty('items')){
                for(let i=0; i<this.$props.set_from.items.length; i++){
                    if(this.$props.set_from.items[i].hasOwnProperty('discount')){
                        discount += parseFloat(this.$props.set_from.items[i].discount)
                    }
                }
            }

            return discount
        },
        vat(){
            let fee = 0;
            if(this.$props.set_from.hasOwnProperty('items')){
                for(let i=0; i<this.$props.set_from.items.length; i++){
                    if(this.$props.set_from.items[i].hasOwnProperty('fee')){
                        fee += parseFloat(this.$props.set_from.items[i].fee)
                    }
                }
            }

            return fee
        },
        total(){
            let total = 0;
            if(this.$props.set_from.hasOwnProperty('items')){
                for(let i=0; i<this.$props.set_from.items.length; i++){
                    if(this.$props.set_from.items[i].hasOwnProperty('total')){
                        total += parseFloat(this.$props.set_from.items[i].total)
                    }
                }
            }

            return total
        },
    },
    watch: {
      'form.city':function (newVal, oldVal) {
          if(this.$props.set_from.hasOwnProperty('shipped')) {
              axios.get(this.$props.action + '/city?city='+newVal).then(data => {
                  if(data.data.price){
                      this.form.shipped = data.data.price;
                  }
              })
          }
      }
    },
    methods: {
        addFile(file){
            this.form.file = file;
        },
        addImage(image){
            this.form.image = image;
        },
        removeImage(){
            this.form.image = '';
        },
        addItem(){
            const items = JSON.stringify(this.$props.items)
            this.form.items.push(JSON.parse(items))
        },
        copyItem(item){
            const getItem = JSON.stringify(item)
            this.form.items.push(JSON.parse(getItem))
        },
        removeItem(item){
            this.form.items.splice(this.form.items.indexOf(item), 1);
        },
        onSuccess(data){
            this.$swal.fire({
                icon: 'success',
                text: data.message
            });
            window.location.replace(this.$props.redirect)
        },
        onFail(data){
            this.submiting = false;
            if(data.message){
                this.$swal.fire({
                    icon: 'error',
                    text: data.message
                });
            }
            else {
                this.$swal.fire({
                    icon: 'error',
                    text: 'some fileds has error!'
                });
            }
        }
    },

});
