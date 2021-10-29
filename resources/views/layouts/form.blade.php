@extends('layouts.main', ["module" => $module])

@php $tableUrl = $table @endphp
@php $table = \Illuminate\Support\Str::singular($table) @endphp
@if($create)
    @php $title = trans('admin.'.$table.'.actions.create') @endphp
@elseif($edit)
    @php $title = trans('admin.'.$table.'.actions.edit') @endphp
@endif

@if(isset($moduleName))
    @push('module-js')
        <script src="{{ asset('js/'.$moduleName.'.js') }}"></script>
    @endpush
@endif

@if(isset($customTitle))
    @section('title', $customTitle)
@else
    @if($create)
        @section('title', trans('admin.'.$table.'.actions.create'))
    @elseif($edit)
        @section('title', trans('admin.'.$table.'.actions.edit'))
    @endif
@endif

@section('body')
    <x-card title="{{ $title }}" icon="fa fa-edit">
        <{{$table}}-form
            @if($edit)
                :action="'{{ $data->resource_url }}'"
                :data="{{ $data->toJson() }}"
            @else
                @if(isset($customURL))
                    :action="'{{ $customURL }}'"
                @else
                    :action="'{{ url('admin/' . $tableUrl) }}'"
                @endif
            @endif
            @yield('options')
            inline-template>

            <form class="form-horizontal form-edit" autocomplete="off" method="post" @submit.prevent="onSubmit" :action="action">
                @if(isset($customBody))
                    @yield('custom-body')
                @else
                    @if(isset($hasMedia) && isset($modalName) && isset($collection))
                        <div class="mb-3">
                            @if($create)
                                @include('brackets/admin-ui::admin.includes.media-uploader', [
                                    'mediaCollection' => app($modalName)->getMediaCollection($collection),
                                    'label' => 'Image'
                                ])
                            @elseif($edit)
                                @include('brackets/admin-ui::admin.includes.media-uploader', [
                                    'mediaCollection' => app($modalName)->getMediaCollection($collection),
                                    'media' => $data->getThumbs200ForCollection($collection),
                                    'label' => 'Image'
                                ])
                            @endif
                        </div>
                    @endif

                    @include('admin.'.$table.'.components.form-elements')

                    <button type="submit" class="btn btn-primary" :disabled="submiting">
                        <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                        {{ trans('brackets/admin-ui::admin.btn.save') }}
                    </button>
                @endif
            </form>

        </{{$table}}-form>
    </x-card>
@endsection
