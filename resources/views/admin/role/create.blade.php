@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.role.actions.create'))

@section('body')

    <div class="container-xl">

                <div class="card">

        <role-form
            :action="'{{ url('admin/roles') }}'"
            :permissions="{{$permissions->toJson()}}"
            v-cloak
            inline-template>

            <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action" novalidate>

                <div class="card-header">
                    <i class="fa fa-plus"></i> {{ trans('admin.role.actions.create') }}
                </div>

                <div class="card-body">
                    @include('admin.role.components.form-elements')

                    <div class="row mt-5">
                        {!! get_permissions('role', 'Roles') !!}
                        {!! get_permissions('permission', 'Permissions') !!}
                        {!! get_permissions('language', 'Languages') !!}
                        {!! get_permissions('country', 'Countries') !!}
                        {!! get_permissions('medium', 'Media') !!}
                        {!! get_permissions('translation', 'Translations') !!}
                        {!! get_permissions('admin-user', 'Admin Users') !!}
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" :disabled="submiting">
                        <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                        {{ trans('brackets/admin-ui::admin.btn.save') }}
                    </button>
                </div>

            </form>

        </role-form>

        </div>

        </div>


@endsection
