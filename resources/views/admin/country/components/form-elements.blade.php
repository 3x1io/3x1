<div class="form-group row align-items-center" :class="{'has-danger': errors.has('name'), 'has-success': fields.name && fields.name.valid }">
    <label for="name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.country.columns.name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('name'), 'form-control-success': fields.name && fields.name.valid}" id="name" name="name" placeholder="{{ trans('admin.country.columns.name') }}">
        <div v-if="errors.has('name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('code'), 'has-success': fields.code && fields.code.valid }">
    <label for="code" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.country.columns.code') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.code" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('code'), 'form-control-success': fields.code && fields.code.valid}" id="code" name="code" placeholder="{{ trans('admin.country.columns.code') }}">
        <div v-if="errors.has('code')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('code') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('phone'), 'has-success': fields.phone && fields.phone.valid }">
    <label for="phone" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.country.columns.phone') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.phone" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('phone'), 'form-control-success': fields.phone && fields.phone.valid}" id="phone" name="phone" placeholder="{{ trans('admin.country.columns.phone') }}">
        <div v-if="errors.has('phone')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('phone') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('lat'), 'has-success': fields.lat && fields.lat.valid }">
    <label for="lat" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.country.columns.lat') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.lat" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('lat'), 'form-control-success': fields.lat && fields.lat.valid}" id="lat" name="lat" placeholder="{{ trans('admin.country.columns.lat') }}">
        <div v-if="errors.has('lat')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('lat') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('lang'), 'has-success': fields.lang && fields.lang.valid }">
    <label for="lang" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.country.columns.lang') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.lang" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('lang'), 'form-control-success': fields.lang && fields.lang.valid}" id="lang" name="lang" placeholder="{{ trans('admin.country.columns.lang') }}">
        <div v-if="errors.has('lang')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('lang') }}</div>
    </div>
</div>


