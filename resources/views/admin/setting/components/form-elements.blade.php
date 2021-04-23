<div class="form-group row align-items-center" :class="{'has-danger': errors.has('group'), 'has-success': fields.group && fields.group.valid }">
    <label for="group" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.setting.columns.group') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.group" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('group'), 'form-control-success': fields.group && fields.group.valid}" id="group" name="group" placeholder="{{ trans('admin.setting.columns.group') }}">
        <div v-if="errors.has('group')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('group') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('key'), 'has-success': fields.key && fields.key.valid }">
    <label for="key" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.setting.columns.key') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.key" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('key'), 'form-control-success': fields.key && fields.key.valid}" id="key" name="key" placeholder="{{ trans('admin.setting.columns.key') }}">
        <div v-if="errors.has('key')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('key') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('value'), 'has-success': fields.value && fields.value.valid }">
    <label for="value" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.setting.columns.value') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <textarea class="form-control" v-model="form.value" v-validate="''" id="value" name="value"></textarea>
        </div>
        <div v-if="errors.has('value')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('value') }}</div>
    </div>
</div>


