<div class="form-group row align-items-center" :class="{'has-danger': errors.has('name'), 'has-success': fields.name && fields.name.valid }">
    <label for="name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.permission.columns.name') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('name'), 'form-control-success': fields.name && fields.name.valid}" id="name" name="name" placeholder="{{ trans('admin.permission.columns.name') }}">
        <div v-if="errors.has('name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('guard_name'), 'has-success': fields.guard_name && fields.guard_name.valid }">
    <label for="guard_name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.permission.columns.guard_name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.guard_name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('guard_name'), 'form-control-success': fields.guard_name && fields.guard_name.valid}" id="guard_name" name="guard_name" placeholder="{{ trans('admin.permission.columns.guard_name') }}">
        <div v-if="errors.has('guard_name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('guard_name') }}</div>
    </div>
</div>



