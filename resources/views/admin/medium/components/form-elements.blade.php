<div class="row form-inline" style="padding-bottom: 10px;" v-cloak>
    <div :class="{'col-xl-10 col-md-11 text-right': !isFormLocalized, 'col text-center': isFormLocalized, 'hidden': onSmallScreen }">
        <small>{{ trans('brackets/admin-ui::admin.forms.currently_editing_translation') }}<span v-if="!isFormLocalized && otherLocales.length > 1"> {{ trans('brackets/admin-ui::admin.forms.more_can_be_managed') }}</span><span v-if="!isFormLocalized"> | <a href="#" @click.prevent="showLocalization">{{ trans('brackets/admin-ui::admin.forms.manage_translations') }}</a></span></small>
        <i class="localization-error" v-if="!isFormLocalized && showLocalizedValidationError"></i>
    </div>

    <div class="col text-center" :class="{'language-mobile': onSmallScreen, 'has-error': !isFormLocalized && showLocalizedValidationError}" v-if="isFormLocalized || onSmallScreen" v-cloak>
        <small>{{ trans('brackets/admin-ui::admin.forms.choose_translation_to_edit') }}
            <select class="form-control" v-model="currentLocale">
                <option :value="defaultLocale" v-if="onSmallScreen">@{{defaultLocale.toUpperCase()}}</option>
                <option v-for="locale in otherLocales" :value="locale">@{{locale.toUpperCase()}}</option>
            </select>
            <i class="localization-error" v-if="isFormLocalized && showLocalizedValidationError"></i>
            <span>|</span>
            <a href="#" @click.prevent="hideLocalization">{{ trans('brackets/admin-ui::admin.forms.hide') }}</a>
        </small>
    </div>
</div>

<div class="row">
    @foreach($locales as $locale)
        <div class="col-md" v-show="shouldShowLangGroup('{{ $locale }}')" v-cloak>
            <div class="form-group row align-items-center" :class="{'has-danger': errors.has('custom_properties_{{ $locale }}'), 'has-success': fields.custom_properties_{{ $locale }} && fields.custom_properties_{{ $locale }}.valid }">
                <label for="custom_properties_{{ $locale }}" class="col-md-2 col-form-label text-md-right">{{ trans('admin.medium.columns.custom_properties') }}</label>
                <div class="col-md-9" :class="{'col-xl-8': !isFormLocalized }">
                    <input type="text" v-model="form.custom_properties.{{ $locale }}" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('custom_properties_{{ $locale }}'), 'form-control-success': fields.custom_properties_{{ $locale }} && fields.custom_properties_{{ $locale }}.valid }" id="custom_properties_{{ $locale }}" name="custom_properties_{{ $locale }}" placeholder="{{ trans('admin.medium.columns.custom_properties') }}">
                    <div v-if="errors.has('custom_properties_{{ $locale }}')" class="form-control-feedback form-text" v-cloak>{{'{{'}} errors.first('custom_properties_{{ $locale }}') }}</div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row">
    @foreach($locales as $locale)
        <div class="col-md" v-show="shouldShowLangGroup('{{ $locale }}')" v-cloak>
            <div class="form-group row align-items-center" :class="{'has-danger': errors.has('generated_conversions_{{ $locale }}'), 'has-success': fields.generated_conversions_{{ $locale }} && fields.generated_conversions_{{ $locale }}.valid }">
                <label for="generated_conversions_{{ $locale }}" class="col-md-2 col-form-label text-md-right">{{ trans('admin.medium.columns.generated_conversions') }}</label>
                <div class="col-md-9" :class="{'col-xl-8': !isFormLocalized }">
                    <input type="text" v-model="form.generated_conversions.{{ $locale }}" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('generated_conversions_{{ $locale }}'), 'form-control-success': fields.generated_conversions_{{ $locale }} && fields.generated_conversions_{{ $locale }}.valid }" id="generated_conversions_{{ $locale }}" name="generated_conversions_{{ $locale }}" placeholder="{{ trans('admin.medium.columns.generated_conversions') }}">
                    <div v-if="errors.has('generated_conversions_{{ $locale }}')" class="form-control-feedback form-text" v-cloak>{{'{{'}} errors.first('generated_conversions_{{ $locale }}') }}</div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row">
    @foreach($locales as $locale)
        <div class="col-md" v-show="shouldShowLangGroup('{{ $locale }}')" v-cloak>
            <div class="form-group row align-items-center" :class="{'has-danger': errors.has('manipulations_{{ $locale }}'), 'has-success': fields.manipulations_{{ $locale }} && fields.manipulations_{{ $locale }}.valid }">
                <label for="manipulations_{{ $locale }}" class="col-md-2 col-form-label text-md-right">{{ trans('admin.medium.columns.manipulations') }}</label>
                <div class="col-md-9" :class="{'col-xl-8': !isFormLocalized }">
                    <input type="text" v-model="form.manipulations.{{ $locale }}" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('manipulations_{{ $locale }}'), 'form-control-success': fields.manipulations_{{ $locale }} && fields.manipulations_{{ $locale }}.valid }" id="manipulations_{{ $locale }}" name="manipulations_{{ $locale }}" placeholder="{{ trans('admin.medium.columns.manipulations') }}">
                    <div v-if="errors.has('manipulations_{{ $locale }}')" class="form-control-feedback form-text" v-cloak>{{'{{'}} errors.first('manipulations_{{ $locale }}') }}</div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row">
    @foreach($locales as $locale)
        <div class="col-md" v-show="shouldShowLangGroup('{{ $locale }}')" v-cloak>
            <div class="form-group row align-items-center" :class="{'has-danger': errors.has('responsive_images_{{ $locale }}'), 'has-success': fields.responsive_images_{{ $locale }} && fields.responsive_images_{{ $locale }}.valid }">
                <label for="responsive_images_{{ $locale }}" class="col-md-2 col-form-label text-md-right">{{ trans('admin.medium.columns.responsive_images') }}</label>
                <div class="col-md-9" :class="{'col-xl-8': !isFormLocalized }">
                    <input type="text" v-model="form.responsive_images.{{ $locale }}" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('responsive_images_{{ $locale }}'), 'form-control-success': fields.responsive_images_{{ $locale }} && fields.responsive_images_{{ $locale }}.valid }" id="responsive_images_{{ $locale }}" name="responsive_images_{{ $locale }}" placeholder="{{ trans('admin.medium.columns.responsive_images') }}">
                    <div v-if="errors.has('responsive_images_{{ $locale }}')" class="form-control-feedback form-text" v-cloak>{{'{{'}} errors.first('responsive_images_{{ $locale }}') }}</div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('collection_name'), 'has-success': fields.collection_name && fields.collection_name.valid }">
    <label for="collection_name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.medium.columns.collection_name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.collection_name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('collection_name'), 'form-control-success': fields.collection_name && fields.collection_name.valid}" id="collection_name" name="collection_name" placeholder="{{ trans('admin.medium.columns.collection_name') }}">
        <div v-if="errors.has('collection_name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('collection_name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('conversions_disk'), 'has-success': fields.conversions_disk && fields.conversions_disk.valid }">
    <label for="conversions_disk" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.medium.columns.conversions_disk') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.conversions_disk" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('conversions_disk'), 'form-control-success': fields.conversions_disk && fields.conversions_disk.valid}" id="conversions_disk" name="conversions_disk" placeholder="{{ trans('admin.medium.columns.conversions_disk') }}">
        <div v-if="errors.has('conversions_disk')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('conversions_disk') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('disk'), 'has-success': fields.disk && fields.disk.valid }">
    <label for="disk" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.medium.columns.disk') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.disk" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('disk'), 'form-control-success': fields.disk && fields.disk.valid}" id="disk" name="disk" placeholder="{{ trans('admin.medium.columns.disk') }}">
        <div v-if="errors.has('disk')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('disk') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('file_name'), 'has-success': fields.file_name && fields.file_name.valid }">
    <label for="file_name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.medium.columns.file_name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.file_name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('file_name'), 'form-control-success': fields.file_name && fields.file_name.valid}" id="file_name" name="file_name" placeholder="{{ trans('admin.medium.columns.file_name') }}">
        <div v-if="errors.has('file_name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('file_name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('mime_type'), 'has-success': fields.mime_type && fields.mime_type.valid }">
    <label for="mime_type" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.medium.columns.mime_type') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.mime_type" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('mime_type'), 'form-control-success': fields.mime_type && fields.mime_type.valid}" id="mime_type" name="mime_type" placeholder="{{ trans('admin.medium.columns.mime_type') }}">
        <div v-if="errors.has('mime_type')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('mime_type') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('model_id'), 'has-success': fields.model_id && fields.model_id.valid }">
    <label for="model_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.medium.columns.model_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.model_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('model_id'), 'form-control-success': fields.model_id && fields.model_id.valid}" id="model_id" name="model_id" placeholder="{{ trans('admin.medium.columns.model_id') }}">
        <div v-if="errors.has('model_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('model_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('model_type'), 'has-success': fields.model_type && fields.model_type.valid }">
    <label for="model_type" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.medium.columns.model_type') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.model_type" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('model_type'), 'form-control-success': fields.model_type && fields.model_type.valid}" id="model_type" name="model_type" placeholder="{{ trans('admin.medium.columns.model_type') }}">
        <div v-if="errors.has('model_type')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('model_type') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('name'), 'has-success': fields.name && fields.name.valid }">
    <label for="name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.medium.columns.name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('name'), 'form-control-success': fields.name && fields.name.valid}" id="name" name="name" placeholder="{{ trans('admin.medium.columns.name') }}">
        <div v-if="errors.has('name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('order_column'), 'has-success': fields.order_column && fields.order_column.valid }">
    <label for="order_column" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.medium.columns.order_column') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.order_column" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('order_column'), 'form-control-success': fields.order_column && fields.order_column.valid}" id="order_column" name="order_column" placeholder="{{ trans('admin.medium.columns.order_column') }}">
        <div v-if="errors.has('order_column')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('order_column') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('size'), 'has-success': fields.size && fields.size.valid }">
    <label for="size" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.medium.columns.size') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.size" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('size'), 'form-control-success': fields.size && fields.size.valid}" id="size" name="size" placeholder="{{ trans('admin.medium.columns.size') }}">
        <div v-if="errors.has('size')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('size') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('uuid'), 'has-success': fields.uuid && fields.uuid.valid }">
    <label for="uuid" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.medium.columns.uuid') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.uuid" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('uuid'), 'form-control-success': fields.uuid && fields.uuid.valid}" id="uuid" name="uuid" placeholder="{{ trans('admin.medium.columns.uuid') }}">
        <div v-if="errors.has('uuid')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('uuid') }}</div>
    </div>
</div>


