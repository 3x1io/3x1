In this file, there are couple of translated keys

{{ trans('good.key1') }}
{{ trans("good.key2") }}
{{ trans("good.key6 with a space") }}
{{ trans("admin::auth.key7") }}
{{ trans("brackets/admin-ui::auth.key8") }}

{{ __("Good key 3") }}
{{ __("Good 'key' 4") }}
{{ __(" ") }}
{{ __("  ") }}
{{ __('Good "key" 5') }}
{{ __('Good. Key.') }}
{{ __('File') }}
{{ __(' Good') }}
{{ __('<strong>Good</strong>') }}
{{ __('Good (better)') }}
{{ __(' ') }}
{{ __('  ') }}

But some are false positive

{{ trans('bad.$key1') }}
{{ trans('key2') }}
{{ trans(' foo.key3') }}
{{ trans('A translation can have a period. It\'s okay.') }}
{{ trans("go od.key2") }}

Bad patterns
{{ __("Bad " . " pattern double quote 1") }}
{{ __("Bad " . $a . " pattern double quote 2") }}
{{ __("Bad \" pattern double quote 3") }}
{{ __("Bad \" pattern double quote \" 4") }}
{{ __("") }}
{{ __('Bad ' . ' pattern single quote 1') }}
{{ __('Bad ' . $a . ' pattern single quote 2') }}
{{ __('Bad \' pattern single quote 3') }}
{{ __('Bad \' pattern single quote \' 4') }}
{{ __('') }}