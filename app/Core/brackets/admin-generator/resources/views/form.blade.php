@if($hasTranslatable)<div class="row form-inline" style="padding-bottom: 10px;" v-cloak>
    <div :class="{'col-xl-10 col-md-11 text-right': !isFormLocalized, 'col text-center': isFormLocalized, 'hidden': onSmallScreen }">
        <small>@{{ trans('brackets/admin-ui::admin.forms.currently_editing_translation') }}<span v-if="!isFormLocalized && otherLocales.length > 1"> @{{ trans('brackets/admin-ui::admin.forms.more_can_be_managed') }}</span><span v-if="!isFormLocalized"> | <a href="#" @click.prevent="showLocalization">@{{ trans('brackets/admin-ui::admin.forms.manage_translations') }}</a></span></small>
        <i class="localization-error" v-if="!isFormLocalized && showLocalizedValidationError"></i>
    </div>

    <div class="col text-center" :class="{'language-mobile': onSmallScreen, 'has-error': !isFormLocalized && showLocalizedValidationError}" v-if="isFormLocalized || onSmallScreen" v-cloak>
        <small>@{{ trans('brackets/admin-ui::admin.forms.choose_translation_to_edit') }}
            <select class="form-control" v-model="currentLocale">
                <option :value="defaultLocale" v-if="onSmallScreen">{{'@{{'}}defaultLocale.toUpperCase()}}</option>
                <option v-for="locale in otherLocales" :value="locale">{{'@{{'}}locale.toUpperCase()}}</option>
            </select>
            <i class="localization-error" v-if="isFormLocalized && showLocalizedValidationError"></i>
            <span>|</span>
            <a href="#" @click.prevent="hideLocalization">@{{ trans('brackets/admin-ui::admin.forms.hide') }}</a>
        </small>
    </div>
</div>
@endif
{{-- TODO extract to the exceptional array  --}}
@foreach($columns as $col)
@if(!in_array($col['name'], ['created_by_admin_user_id','updated_by_admin_user_id']))@if($col['name'] == 'password')
{{'{'}}!! input('password', '{{$col['name']}}', trans('admin.{{$modelLangFormat}}.columns.{{$col['name']}}'), '{{ implode('|', collect($col['frontendRules'])->reject(function($rule) use ($col) { return $rule === 'confirmed:'.$col['name'];})->toArray()) }}') !!}
{{'{'}}!! input('password', 'password_confirmation', trans('admin.{{$modelLangFormat}}.columns.{{$col['name']}}_repeat'), '{{ implode('|', $col['frontendRules']) }}') !!}
@elseif($col['type'] == 'date' && !in_array($col['name'], ['published_at']))
{{'{'}}!! input('date', '{{$col['name']}}', trans('admin.{{$modelLangFormat}}.columns.{{$col['name']}}'), '{{ implode('|', $col['frontendRules']) }}', [
"type" => "date"
]) !!}
@elseif($col['type'] == 'time')
{{'{'}}!! input('date', '{{$col['name']}}', trans('admin.{{$modelLangFormat}}.columns.{{$col['name']}}'), '{{ implode('|', $col['frontendRules']) }}', [
    "type" => "time"
]) !!}
@elseif($col['type'] == 'datetime' && !in_array($col['name'], ['published_at']))
{{'{'}}!! input('date', '{{$col['name']}}', trans('admin.{{$modelLangFormat}}.columns.{{$col['name']}}'), '{{ implode('|', $col['frontendRules'])}}', [
    "type" => "datetime"
]) !!}
@elseif($col['type'] == 'text' && in_array($col['name'], $wysiwygTextColumnNames))
{{'{'}}!! input('editor', '{{$col['name']}}', trans('admin.{{$modelLangFormat}}.columns.{{$col['name']}}'), '{{ implode('|', $col['frontendRules'])}}') !!}
@elseif($col['type'] == 'text')
{{'{'}}!! input('textarea', '{{$col['name']}}', trans('admin.{{$modelLangFormat}}.columns.{{$col['name']}}'), '{{ implode('|', $col['frontendRules'])}}') !!}
@elseif($col['type'] == 'boolean')
{{'{'}}!! input('checkbox', '{{$col['name']}}', trans('admin.{{$modelLangFormat}}.columns.{{$col['name']}}'), '{{ implode('|', $col['frontendRules'])}}') !!}
@elseif($col['type'] == 'json')
<div class="row">
    @@foreach($locales as $locale)
        <div class="col-md" v-show="shouldShowLangGroup('@{{ $locale }}')" v-cloak>
            <div class="form-group row align-items-center" :class="{'has-danger': errors.has('{{ $col['name'] }}_@{{ $locale }}'), 'has-success': fields.{{ $col['name'] }}_@{{ $locale }} && fields.{{ $col['name'] }}_@{{ $locale }}.valid }">
                <label for="{{ $col['name'] }}_@{{ $locale }}" class="col-md-2 col-form-label text-md-right">{{'{{'}} trans('admin.{{ $modelLangFormat }}.columns.{{ $col['name'] }}') }}</label>
                <div class="col-md-9" :class="{'col-xl-8': !isFormLocalized }">
                    @if(in_array($col['name'], $wysiwygTextColumnNames))<div>
                        <wysiwyg v-model="form.{{ $col['name'] }}.@{{ $locale }}" v-validate="'{!! implode('|', $col['frontendRules']) !!}'" id="{{ $col['name'] }}_@{{ $locale }}" name="{{ $col['name'] }}_@{{ $locale }}" :config="mediaWysiwygConfig"></wysiwyg>
                    </div>
                    @else<input type="text" v-model="form.{{ $col['name'] }}.@{{ $locale }}" v-validate="'{!! implode('|', $col['frontendRules']) !!}'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('{{ $col['name'] }}_@{{ $locale }}'), 'form-control-success': fields.{{ $col['name'] }}_@{{ $locale }} && fields.{{ $col['name'] }}_@{{ $locale }}.valid }" id="{{ $col['name'] }}_@{{ $locale }}" name="{{ $col['name'] }}_@{{ $locale }}" placeholder="{{'{{'}} trans('admin.{{ $modelLangFormat }}.columns.{{ $col['name'] }}') }}">
                    @endif<div v-if="errors.has('{{ $col['name'] }}_@{{ $locale }}')" class="form-control-feedback form-text" v-cloak>@{{'{{'}} errors.first('{{ $col['name'] }}_@{{ $locale }}') }}</div>
                </div>
            </div>
        </div>
    @@endforeach
</div>
@elseif(!in_array($col['name'], ['published_at']))
{{'{'}}!! input('text', '{{$col['name']}}', trans('admin.{{$modelLangFormat}}.columns.{{$col['name']}}'), '{{ implode('|', $col['frontendRules'])}}') !!}
@endif
@endif

@endforeach

@if (count($relations))
@if (count($relations['belongsToMany']))
@foreach($relations['belongsToMany'] as $belongsToMany)<div class="form-group row align-items-center" :class="{'has-danger': errors.has('{{ $belongsToMany['related_table'] }}'), 'has-success': fields.{{ $belongsToMany['related_table'] }} && fields.{{ $belongsToMany['related_table'] }}.valid }">
    <label for="{{ $belongsToMany['related_table'] }}" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{'{{'}} trans('admin.{{ $modelLangFormat }}.columns.{{ lcfirst($belongsToMany['related_model_name_plural']) }}') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <multiselect v-model="form.{{ $belongsToMany['related_table'] }}" placeholder="@{{ trans('brackets/admin-ui::admin.forms.select_options') }}" label="name" track-by="id" :options="{{'{{'}} ${{ $belongsToMany['related_table'] }}->toJson() }}" :multiple="true" open-direction="bottom"></multiselect>
        <div v-if="errors.has('{{ $belongsToMany['related_table'] }}')" class="form-control-feedback form-text" v-cloak>@@{{ errors.first('@php echo $belongsToMany['related_table']; @endphp') }}</div>
    </div>
</div>
@endforeach
@endif
@endif
