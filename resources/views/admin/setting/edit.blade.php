@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.setting.actions.edit', ['name' => $setting->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <setting-form
                :action="'{{ $setting->resource_url }}'"
                :data="{{ $setting->toJson() }}"
                v-cloak
                inline-template>

                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.setting.actions.edit', ['name' => $setting->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.setting.components.form-elements')
                    </div>


                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>

                </form>

        </setting-form>

        </div>

</div>

@endsection
