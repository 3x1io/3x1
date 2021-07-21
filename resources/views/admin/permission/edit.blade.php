@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.permission.actions.edit', ['name' => $permission->name]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <permission-form
                :action="'{{ $permission->resource_url }}'"
                :data="{{ $permission->toJson() }}"
                v-cloak
                inline-template>

                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.permission.actions.edit', ['name' => $permission->name]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.permission.components.form-elements')
                    </div>


                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>

                </form>

        </permission-form>

        </div>

</div>

@endsection
