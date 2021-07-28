@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.admin-user.actions.index'))

@section('body')

    <admin-user-listing
        :data="{{ $data->toJson() }}"
        :activation="!!'{{ $activation }}'"
        :url="'{{ url('admin/admin-users') }}'"
        inline-template>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> {{ trans('admin.admin-user.actions.index') }}
                        @can('admin.admin-user.create')
                            <a class="btn btn-primary btn-sm pull-right m-b-0" href="{{ url('admin/admin-users/create') }}" @click.prevent="$modal.show('create')" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.admin-user.actions.create') }}</a>
                            <!-- Modals -->
                            <!-- Stat Create Modal -->
                            <modal name="create" height="auto" clickToClose="false" draggable adaptive resizable scrollable>
                                <div class="card  mb-0">

                                    <admin-user-form
                                        :action="'{{ url('admin/admin-users') }}'"
                                        :activation="!!'{{ $activation }}'"

                                        inline-template>

                                        <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action">

                                            <div class="card-header">
                                                <i class="fa fa-plus"></i> {{ trans('admin.admin-user.actions.create') }}
                                            </div>

                                            <div class="card-body">

                                                @include('admin.admin-user.components.form-elements')

                                            </div>

                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-primary" :disabled="submiting">
                                                    <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                                                    {{ trans('brackets/admin-ui::admin.btn.save') }}
                                                </button>
                                            </div>

                                        </form>

                                    </admin-user-form>

                                </div>

                            </modal>
                            <!-- End Create Modal -->
                        @endcan
                    </div>
                    <div class="card-body" v-cloak>
                        <form @submit.prevent="">
                            <div class="row justify-content-md-between">
                                <div class="col col-lg-7 col-xl-5 form-group">
                                    <div class="input-group">
                                        <input class="form-control" placeholder="{{ trans('brackets/admin-ui::admin.placeholder.search') }}" v-model="search" @keyup.enter="filter('search', $event.target.value)" />
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-primary" @click="filter('search', search)"><i class="fa fa-search"></i>&nbsp; {{ trans('brackets/admin-ui::admin.btn.search') }}</button>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-sm-auto form-group ">
                                    <select class="form-control" v-model="pagination.state.per_page">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>

                            </div>
                        </form>

                        <table class="table table-hover table-listing">
                            <thead>
                                <tr>
                                    <th is='sortable' :column="'id'">{{ trans('admin.admin-user.columns.id') }}</th>
                                    <th is='sortable' :column="'first_name'">{{ trans('admin.admin-user.columns.first_name') }}</th>
                                    <th is='sortable' :column="'last_name'">{{ trans('admin.admin-user.columns.last_name') }}</th>
                                    <th is='sortable' :column="'email'">{{ trans('admin.admin-user.columns.email') }}</th>
                                    <th is='sortable' :column="'activated'" v-if="activation">{{ trans('admin.admin-user.columns.activated') }}</th>
                                    <th is='sortable' :column="'forbidden'">{{ trans('admin.admin-user.columns.forbidden') }}</th>
                                    <th is='sortable' :column="'language'">{{ trans('admin.admin-user.columns.language') }}</th>
                                    <th is='sortable' :column="'last_login_at'">{{ trans('admin.admin-user.columns.last_login_at') }}</th>

                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in collection">
                                    <td >@{{ item.id }}</td>
                                    <td >@{{ item.first_name }}</td>
                                    <td >@{{ item.last_name }}</td>
                                    <td>{!! list_fn('email', 'email') !!}</td>
                                    <td v-if="activation">
                                        {!! list_fn('action', 'activated') !!}
                                    </td>
                                    <td >
                                        {!! list_fn('action', 'forbidden', [
                                            "bg"=> "danger"
                                        ]) !!}
                                    </td>
                                    <td >@{{ item.language }}</td>
                                    <td >{!! list_fn('date', 'last_login_at', [
                                            "type" => "datetime"
                                    ]) !!}</td>

                                    <td>
                                        <div class="row no-gutters">
                                            @can('admin.admin-user.impersonal-login')
                                            <div class="col-auto">
                                                <button class="btn btn-sm btn-success" v-show="item.activated" @click="impersonalLogin(item.resource_url + '/impersonal-login', item)" title="Impersonal login" role="button"><i class="fa fa-user-o"></i></button>
                                            </div>
                                            @endcan
                                            <div class="col-auto">
                                                <button class="btn btn-sm btn-warning" v-show="!item.activated" @click="resendActivation(item.resource_url + '/resend-activation')" title="Resend activation" role="button"><i class="fa fa-envelope-o"></i></button>
                                            </div>
                                            <div class="col-auto">
                                                <a class="btn btn-sm btn-spinner btn-info" :href="item.resource_url + '/edit'" title="{{ trans('brackets/admin-ui::admin.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
                                            </div>
                                            <form class="col" @submit.prevent="deleteItem(item.resource_url)">
                                                <button type="submit" class="btn btn-sm btn-danger" title="{{ trans('brackets/admin-ui::admin.btn.delete') }}"><i class="fa fa-trash-o"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="row" v-if="pagination.state.total > 0">
                            <div class="col-sm">
                                <span class="pagination-caption">{{ trans('brackets/admin-ui::admin.pagination.overview') }}</span>
                            </div>
                            <div class="col-sm-auto">
                                <pagination></pagination>
                            </div>
                        </div>

	                    <div class="no-items-found" v-if="!collection.length > 0">
		                    <i class="icon-magnifier"></i>
                            <h3>{{ trans('brackets/admin-ui::admin.index.no_items') }}</h3>
                            <p>{{ trans('brackets/admin-ui::admin.index.try_changing_items') }}</p>
                            <a class="btn btn-primary btn-spinner" href="{{ url('admin/admin-users/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('brackets/admin-ui::admin.btn.new') }} AdminUser</a>
	                    </div>
                    </div>
                </div>
            </div>


        </div>
    </admin-user-listing>

@endsection
