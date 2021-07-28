<template>

</template>

<script>
    import AppListing from "../app-components/Listing/AppListing";
    export default {
        mixins: [AppListing],
        name: "Plugins",
        data(){
            return {
                info: []
            }
        },
        methods: {
            activePackage(item){
                axios.post(this.$props.url, {
                    active: 1,
                    package: item.name
                }).then(res => {
                    this.loadData();
                    this.$swal.fire({
                        icon: 'success',
                        text: res.data.message
                    });
                    setTimeout(function(){
                        window.location.reload();
                    }, 1000);
                }).catch(err => console.log(err));
            },
            inactivePackage(item){
                axios.post(this.$props.url, {
                    active: 0,
                    package: item.name
                }).then(res => {
                    this.loadData();
                    this.$swal.fire({
                        icon: 'success',
                        text: res.data.message
                    });
                    setTimeout(function(){
                        window.location.reload();
                    }, 1000);
                }).catch(err => console.log(err));
            },
            showPackages(item){
                this.info = item.info;
                this.$modal.show('packages')
            },
            updatePackage(item){
                axios.post(this.$props.url, {
                    type: 'update',
                    active: 0,
                    package: item.composer.name
                }).then(res => {
                    this.loadData();
                    this.$swal.fire({
                        icon: 'success',
                        text: res.data.message
                    });
                }).catch(err => console.log(err));
            }
        }
    }
</script>

<style scoped>

</style>
