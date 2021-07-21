<div class="form-group row align-items-center" :class="{'has-danger': errors.has('title'), 'has-success': fields.title && fields.title.valid }">
    <label for="title" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user-notification.columns.title') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.title" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('title'), 'form-control-success': fields.title && fields.title.valid}" id="title" name="title" placeholder="{{ trans('admin.user-notification.columns.title') }}">
        <div v-if="errors.has('title')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('title') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('message'), 'has-success': fields.message && fields.message.valid }">
    <label for="message" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user-notification.columns.message') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <textarea class="form-control" v-model="form.message" v-validate="'required'" id="message" name="message" placeholder="{{ trans('admin.user-notification.columns.message') }}"></textarea>
        </div>
        <div v-if="errors.has('message')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('message') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('icon'), 'has-success': fields.icon && fields.icon.valid }">
    <label for="icon" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user-notification.columns.icon') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.icon" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('icon'), 'form-control-success': fields.icon && fields.icon.valid}" id="icon" name="icon" placeholder="{{ trans('admin.user-notification.columns.icon') }}">
        <div v-if="errors.has('icon')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('icon') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('url'), 'has-success': fields.url && fields.url.valid }">
    <label for="url" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user-notification.columns.url') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.url" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('url'), 'form-control-success': fields.url && fields.url.valid}" id="url" name="url" placeholder="{{ trans('admin.user-notification.columns.url') }}">
        <div v-if="errors.has('url')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('url') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('type'), 'has-success': fields.type && fields.type.valid }">
    <label for="type" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user-notification.columns.type') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
            <select v-model="form.type" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('type'), 'form-control-success': fields.type && fields.type.valid}" id="type" name="type">
                <option value="all">{{__('All')}}</option>
                <option value="user">{{__('User')}}</option>
            </select>
        <div v-if="errors.has('type')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('type') }}</div>
    </div>
</div>


<div v-if="form.type === 'user'" class="form-group row align-items-center" :class="{'has-danger': errors.has('user_id'), 'has-success': fields.user_id && fields.user_id.valid }">
    <label for="user_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.user-notification.columns.user_id') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <multiselect v-model="form.user_id" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_options') }}" label="full_name" track-by="id" :options="{{ $users->toJson() }}" :multiple="false" open-direction="bottom"></multiselect>
        <div v-if="errors.has('user_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('user_id') }}</div>
    </div>
</div>
