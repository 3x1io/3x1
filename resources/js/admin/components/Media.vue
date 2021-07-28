<template>
    <div>
        <vue-drop
            :id="set_options.id"
            ref="file"
            :options="set_options"
            @vdropzone-removed-file="cancelFile"
            @vdropzone-complete="uploadSuccess">
        </vue-drop>
    </div>
</template>

<script>
    //@vdropzone-removed-file="getCancel"
    export default {
        name: "Media",
        props: {
            files: {},
            options: {}
        },
        data: function() {
            return {
                set_options: {}
            }
        },
        mounted() {
            this.set_options = this.$props.options;
            if(Array.isArray(this.$props.files)){
                for(let i=0; i<this.$props.files.length; i++){
                    var file = this.$props.files[i].file;
                    var url = this.$props.files[i].url;
                    this.$refs.file.manuallyAddFile(file, url);
                }

            }
            else if(this.$props.files) {
                var file = this.$props.files.file;
                var url = this.$props.files.url;
                this.$refs.file.manuallyAddFile(file, url);
            }
        },
        methods: {
            uploadSuccess(response) {
                this.$emit('upload', response.xhr.response);
            },
            cancelFile(file, error, xhr){
                for(let i=0; i<this.$props.files.length; i++ ){
                    if(this.$props.files[i].file === file){
                        this.$emit('cancel', this.$props.files[i].url);
                    }
                }

            }
        }
    }
</script>

<style scoped>

</style>
