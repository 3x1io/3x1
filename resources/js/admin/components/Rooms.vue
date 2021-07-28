<template>
    <div class="card">
        <modal name="view" dir="ltr" height="auto" :scrollable="true">
            <form  class="form-horizontal form-create" :class="$props.title.dir" method="post" :action="$props.title.action">
            <div class="modal-header">
                <div class="modal-title"><i class="icon-plus"></i> {{$props.title.title}}</div>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="icon-user"></i></span>
                        </div>
                        <input type="text" v-model="form.meetingName" class="form-control" :placeholder="$props.title.meetingName">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="icon-lock"></i></span>
                        </div>
                        <input type="password" v-model="form.attendeePW" class="form-control" :placeholder="$props.title.attendeePW">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="icon-lock"></i></span>
                        </div>
                        <input type="password" v-model="form.moderatorPW" class="form-control" :placeholder="$props.title.moderatorPW">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" @click.prevent="makeRoom()" class="btn btn-primary">
                    <i class="fa fa-save"></i>
                   {{$props.title.create}}
                </button>
                <button class="btn btn-secondary" @click.prevent="$modal.hide('view')"><i class="fa fa-close"></i> {{$props.title.close}}</button>
            </div>
            </form>
        </modal>
        <modal name="join" dir="ltr" height="auto" :scrollable="true">
            <form  class="form-horizontal form-create" :class="$props.title.dir" method="post" :action="$props.title.actionJoin">
                <div class="modal-header">
                    <div class="modal-title"><i class="icon-plus"></i> {{$props.title.title}}</div>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="icon-user"></i></span>
                            </div>
                            <input type="text" v-model="join.username" class="form-control" :placeholder="$props.title.username">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="icon-lock"></i></span>
                            </div>
                            <input type="password" v-model="join.password" class="form-control" :placeholder="$props.title.password">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" @click.prevent="joinToUrl()" class="btn btn-primary">
                        <i class="fa fa-save"></i>
                        {{$props.title.join}}
                    </button>
                    <button class="btn btn-secondary" @click.prevent="$modal.hide('join')"><i class="fa fa-close"></i> {{$props.title.close}}</button>
                </div>
            </form>
        </modal>
        <modal name="password" dir="ltr" height="auto" :scrollable="true">
            <form  class="form-horizontal form-create" :class="$props.title.dir" method="post" :action="$props.title.actionJoin">
                <div class="modal-header">
                    <div class="modal-title"><i class="icon-plus"></i> {{$props.title.title}}</div>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="userPassword">{{$props.title.userPassword}}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="icon-lock"></i></span>
                            </div>
                            <input id="userPassword" type="text" class="form-control" v-model="password.user">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="adminPassword">{{$props.title.adminPassword}}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="icon-lock"></i></span>
                            </div>
                            <input id="adminPassword" type="text" class="form-control" v-model="password.admin">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" @click.prevent="$modal.hide('password')"><i class="fa fa-close"></i> {{$props.title.close}}</button>
                </div>
            </form>
        </modal>
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <p class="card-title m-0"><i class="icon-login"></i> {{$props.title.title}}</p>
                </div>
                <div class="col-auto">
                    <div class="dropdown">
                        <button class="btn p-0 text-white" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-options icon-lg text-muted pb-3px"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-left">
                            <button @click="$modal.show('view')" class="dropdown-item d-flex align-items-center"  role="button"><i class="fa fa-plus"></i>&nbsp; {{$props.title.new}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row" v-if="rooms.length">
                <div class="col-md-4" v-for="(item,key) in rooms">
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="icon-graduation text-primary" style="font-size: 40px;"></i>
                            <h6>{{item.meetingName}}<small> [ {{item.meetingID}} ]</small></h6>
                            <small>{{item.createDate}}</small>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary btn-rounded" @click="joinToRoom(item.meetingID)"><i class="icon-link"></i> {{$props.title.join}}</button>
                            <button class="btn btn-info btn-rounded" @click="showPasswords(item)"><i class="icon-lock"></i> {{$props.title.info}}</button>
                            <button class="btn btn-danger btn-rounded" @click="endMeeting(item.meetingID, item.moderatorPW)"><i class="icon-close"></i> {{$props.title.end}}</button>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="text-center">
                <i class="icon-magnifier" style="font-size: 50px"></i>
                <h3 class="mt-3 mb-3">{{ $props.title.no_item }}</h3>
                <p class="mb-3">{{ $props.title.go_now }}</p>
                <button @click="createMeeting()" class="btn btn-primary" role="button"><i class="fa fa-plus"></i>&nbsp; {{ $props.title.create }}</button>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Rooms",
        data(){
            return {
                form: {
                    meetingName: "",
                    meetingID: "",
                    attendeePW: "",
                    moderatorPW: ""
                },
                join: {
                  meetingID: "",
                  username: "",
                  password: "",
                },
                password: {
                  user: "",
                  admin: ""
                },
                showPassword: [],
                live: '',
                rooms: this.$props.title.rooms
            }
        },
        props: {
            title: {},
        },
        methods: {
            showPasswords(item){
                this.password = {
                    user: item.attendeePW,
                    admin: item.moderatorPW
                }
                this.$modal.show('password');
            },
            createMeeting(){
                this.form = {
                    meetingName: "",
                        meetingID: "",
                        attendeePW: "",
                        moderatorPW: ""
                };
                this.$modal.show('view');
            },
            makeRoom(){
                this.form.meetingID = this.vueSlug(this.form.meetingName);
                axios.post(this.$props.title.action, this.form).then(res => {
                    this.rooms = res.data.rooms;
                    this.$swal.fire({
                        icon: 'success',
                        text: res.data.message
                    })
                    this.$modal.hide('view');
                })
            },
            joinToRoom(id){
                this.join = {
                    meetingID: "",
                    username: "",
                    password: "",
                };
                this.join.meetingID = id;
                this.$modal.show('join');
            },
            joinToUrl(){
                axios.post(this.$props.title.actionJoin, this.join).then(res => {
                    window.open(res.data.url);
                    this.$modal.hide('join');
                })
            },
            endMeeting(id, password){
                axios.post(this.$props.title.actionEnd, {
                    meetingID: id,
                    moderatorPW: password
                }).then(res => {
                    this.rooms = res.data.rooms;
                    this.$swal.fire({
                        icon: 'success',
                        text: res.data.message
                    })
                })
            }
        }
    }
</script>

<style scoped>

</style>
