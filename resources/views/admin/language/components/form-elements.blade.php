<div class="form-group row align-items-center" :class="{'has-danger': errors.has('arabic'), 'has-success': fields.arabic && fields.arabic.valid }">
    <label for="arabic" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.language.columns.arabic') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.arabic" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('arabic'), 'form-control-success': fields.arabic && fields.arabic.valid}" id="arabic" name="arabic" placeholder="{{ trans('admin.language.columns.arabic') }}">
        <div v-if="errors.has('arabic')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('arabic') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('iso'), 'has-success': fields.iso && fields.iso.valid }">
    <label for="iso" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.language.columns.iso') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.iso" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('iso'), 'form-control-success': fields.iso && fields.iso.valid}" id="iso" name="iso" placeholder="{{ trans('admin.language.columns.iso') }}">
        <div v-if="errors.has('iso')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('iso') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('name'), 'has-success': fields.name && fields.name.valid }">
    <label for="name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.language.columns.name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('name'), 'form-control-success': fields.name && fields.name.valid}" id="name" name="name" placeholder="{{ trans('admin.language.columns.name') }}">
        <div v-if="errors.has('name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('name') }}</div>
    </div>
</div>


