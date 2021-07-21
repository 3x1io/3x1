<div class="form-group row align-items-center" :class="{'has-danger': errors.has('name'), 'has-success': fields.name && fields.name.valid }">
    <label for="name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.role.columns.name') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('name'), 'form-control-success': fields.name && fields.name.valid}" id="name" name="name" placeholder="{{ trans('admin.role.columns.name') }}">
        <div v-if="errors.has('name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('guard_name'), 'has-success': fields.guard_name && fields.guard_name.valid }">
    <label for="guard_name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.role.columns.guard_name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.guard_name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('guard_name'), 'form-control-success': fields.guard_name && fields.guard_name.valid}" id="guard_name" name="guard_name" placeholder="{{ trans('admin.role.columns.guard_name') }}">
        <div v-if="errors.has('guard_name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('guard_name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('permissions'), 'has-success': fields.permissions && fields.permissions.valid }">
    <label for="permissions" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ __('Permissions') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <multiselect v-model="form.permissions" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_options') }}" label="name" track-by="id" :close-on-select="false" :options="{{ $permissions->toJson() }}" :multiple="true" open-direction="top"></multiselect>
        <div v-if="errors.has('permissions')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('permissions') }}</div>
    </div>
</div>

