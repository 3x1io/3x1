@extends('layouts.main', ["module" => $module])

@php $tableUrl = $table @endphp
@php $table = \Illuminate\Support\Str::singular($table) @endphp

@if(isset($moduleName))
    @push('module-js')
        <script src="{{ asset('js/'.$moduleName.'.js') }}"></script>
    @endpush
@endif

@if(isset($customTitle))
    @section('title', $customTitle)
@else
    @section('title', trans('admin.'.$table.'.actions.index'))
@endif


@section('body')
    <{{$table}}-listing
    :data="{{ $data->toJson() }}"
    @if(isset($customUrl) && $customUrl)
        @yield('custom-url')
    @else
        @if(isset($getRequest))
            :url="'{{ url('admin/' . $tableUrl . '?'.$getRequest) }}'"
        @else
            :url="'{{ url('admin/' . $tableUrl) }}'"
        @endif
    @endif

    @yield('listing-urls')
    inline-template>

    <div class="container-fluid mt-3">
        @yield('models')
        @can('admin.'.$table.'.index')
            @yield('custom-top')
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div>
                            <i class="fa fa-list"></i>
                            @yield('title')
                        </div>
                        <div>
                            @can('admin.'.$table.'.create')
                                @if($create)
                                    @if(isset($customCreateBtn) && $customCreateBtn)
                                        @yield('custom-create-btn')
                                    @else
                                        <a class="btn btn-sm btn-primary" href="{{url('admin/' . $tableUrl . '/create')}}" type="button"><i class="fa fa-plus"></i> {{ trans('admin.'.$table.'.actions.create') }}</a>
                                    @endif
                                @endif
                            @endcan
                            @can('admin.'.$table.'.show')
                                @if(isset($export))
                                    <a class="btn btn-primary btn-sm pull-right m-b-0 ml-2" href="{{ url('admin/'.$tableUrl.'/export') }}" role="button"><i class="fa fa-file-excel-o"></i>&nbsp; {{ trans('admin.'.$table.'.actions.export') }}</a>
                                @endif
                            @endif
                            @yield('buttons')
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <div>
                        <form @submit.prevent="">
                            <div class="row justify-content-md-between">
                                <div class="col col-lg-7 col-xl-5 form-group">
                                    <div class="input-group">
                                        @if(isset($filters) && $filters)
                                            <span class="input-group-prepend">
                                            <button class="btn btn-primary" @click="showFilter()"><i class="search-icon fa fa-filter" ></i></button>
                                        </span>
                                        @endif
                                        <input class="form-control" placeholder="{{ trans('brackets/admin-ui::admin.placeholder.search') }}" v-model="search" @keyup.enter="filter('search', $event.target.value)" />
                                        <span class="input-group-append">
                                        <button type="button" class="btn btn-primary" @click="filter('search', search)">{{ trans('brackets/admin-ui::admin.btn.search') }}</button>
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
                        @if(isset($customListing) && $customListing)
                            @yield('listing')
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <tbody>
                                    <tr v-if="collection.length > 0">
                                        <th class="bulk-checkbox">
                                            <input class="form-check-input" id="enabled" type="checkbox" v-model="isClickedAll" v-validate="''" data-vv-name="enabled"  name="enabled_fake_element" @click="onBulkItemsClickedAllWithPagination()">
                                            <label class="form-check-label" for="enabled">
                                                #
                                            </label>
                                        </th>
                                        @if(isset($customFilters))
                                            @yield('filterList')
                                        @else
                                            <th is='sortable' :column="'id'">{{ __('#') }}</th>
                                            @foreach($fields as $filter)
                                                @if($filter === 'image' || $filter === 'images')
                                                    <th :column="'{{$filter}}'">{{ __('Images') }}</th>
                                                @elseif($filter === 'created_at')
                                                    <th is='sortable' :column="'{{$filter}}'">{{ __('Date') }}</th>
                                                @elseif($filter === 'customer_id')
                                                    <th is='sortable' :column="'{{$filter}}'">{{ __('Customer') }}</th>
                                                @elseif($filter === 'safe_id')
                                                    <th is='sortable' :column="'{{$filter}}'">{{ __('Safe') }}</th>
                                                @elseif($filter === 'type')
                                                    <th is='sortable' :column="'{{$filter}}'">{{ __('Type') }}</th>
                                                @elseif($filter === 'items')
                                                    <th is='sortable' :column="'{{$filter}}'">{{ __('Items') }}</th>
                                                @elseif($filter === 'branch_id')
                                                    <th is='sortable' :column="'{{$filter}}'">{{ __('Branch') }}</th>
                                                @elseif($filter === 'parent_id')
                                                    <th is='sortable' :column="'{{$filter}}'">{{ __('Parent') }}</th>
                                                @elseif($filter === 'account_id')
                                                    <th is='sortable' :column="'{{$filter}}'">{{ __('Account') }}</th>
                                                @elseif($filter === 'description')
                                                    <th is='sortable' :column="'{{$filter}}'">{{ __('Description') }}</th>
                                                @else
                                                    <th is='sortable' :column="'{{$filter}}'">{{ trans('admin.'.$table.'.columns.'.$filter) }}</th>
                                                @endif
                                            @endforeach
                                            @yield('filterList')
                                            @if(!isset($actions))
                                                <td>{{trans('g.dashboard.actions')}}</td>
                                            @Endif
                                        @endif
                                    </tr>
                                    <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll ">
                                        <td class="bg-bulk-info d-table-cell text-center" colspan="12">
                                            <span class="align-middle font-weight-light text-dark">
                                                {{ trans('brackets/admin-ui::admin.listing.selected_items') }} @{{ clickedBulkItemsCount }}.
                                                <a href="#" class="text-primary" @click="onBulkItemsClickedAll('/admin/{{$tableUrl}}')" v-if="(clickedBulkItemsCount < pagination.state.total)">
                                                    <i class="fa" :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i>
                                                    {{ trans('brackets/admin-ui::admin.listing.check_all_items') }}
                                                    @{{ pagination.state.total }}
                                                </a>
                                                <span class="text-primary">|</span>
                                                <a href="#" class="text-primary" @click="onBulkItemsClickedAllUncheck()">
                                                    {{ trans('brackets/admin-ui::admin.listing.uncheck_all_items') }}
                                                </a>
                                            </span>

                                            @can('admin.'.$table.'.bulk-delete')
                                                @if(isset($delete))
                                                    @if($delete)
                                                        @if(isset($customerUrlName) && $customerUrlName)
                                                            <span class="pull-right pr-2">
                                                                <button class="btn btn-sm btn-danger" @click="bulkDelete('{{$customerUrlName}}/bulk-destroy')">{{trans('g.dashboard.delete')}}</button>
                                                            </span>
                                                        @else
                                                            <span class="pull-right pr-2">
                                                                <button class="btn btn-sm btn-danger" @click="bulkDelete('{{$tableUrl}}/bulk-destroy')">{{trans('g.dashboard.delete')}}</button>
                                                            </span>
                                                        @endif
                                                    @endif
                                                @else
                                                    @if(isset($customerUrlName) && $customerUrlName)
                                                        <span class="pull-right pr-2">
                                                                <button class="btn btn-sm btn-danger" @click="bulkDelete('{{$customerUrlName}}/bulk-destroy')">{{trans('g.dashboard.delete')}}</button>
                                                            </span>
                                                    @else
                                                        <span class="pull-right pr-2">
                                                                <button class="btn btn-sm btn-danger" @click="bulkDelete('{{$tableUrl}}/bulk-destroy')">{{trans('g.dashboard.delete')}}</button>
                                                            </span>
                                                    @endif
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                    <tr
                                        v-for="(item, index) in collection"
                                        :key="item.id"
                                        :disabled="bulkCheckingAllLoader"
                                        :data-vv-name="'enabled' + item.id"
                                        :name="'enabled' + item.id + '_fake_element'"
                                        :class="bulkItems[item.id] ? 'bg-gray' : ''"
                                    >
                                        <td class="bulk-checkbox">
                                            <input class="form-check-input" :id="'enabled' + item.id" type="checkbox" v-model="bulkItems[item.id]" v-validate="''" :data-vv-name="'enabled' + item.id"  :name="'enabled' + item.id + '_fake_element'" @click="onBulkItemClicked(item.id)" :disabled="bulkCheckingAllLoader">
                                            <label class="form-check-label" :for="'enabled' + item.id">
                                            </label>
                                        </td>
                                        @yield('tableList')
                                        @if(!isset($actions))
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    @if(isset($customActions) && $customActions)
                                                        @yield('custom-actions')
                                                    @else
                                                        @if(isset($view))
                                                            @if($view)
                                                                @can('admin.'.$table.'.show')
                                                                    <a class="btn btn-sm btn-success m-1" :href="item.resource_url+'/show'" title="{{ trans('g.dashboard.show') }}"><i class="fa fa-eye"></i></a>

                                                                @endcan
                                                            @endif
                                                        @endif
                                                        @if(isset($edit))
                                                            @if($edit)
                                                                @can('admin.'.$table.'.edit')
                                                                    <a class="btn btn-sm btn-warning m-1"  :href="item.resource_url+'/edit'" title="{{ trans('g.dashboard.edit') }}"><i class="fa fa-edit"></i></a>

                                                                @endcan
                                                            @endif
                                                        @else
                                                            @can('admin.'.$table.'.edit')
                                                                <a class="btn btn-sm btn-warning m-1" :href="item.resource_url+'/edit'" title="{{ trans('g.dashboard.edit') }}"><i class="fa fa-edit"></i></a>

                                                            @endcan
                                                        @endif
                                                        @if(isset($delete))
                                                            @if($delete)
                                                                @can('admin.'.$table.'.delete')
                                                                    <form @submit.prevent="deleteItem(item.resource_url)" >
                                                                        <button type="submit" class="btn btn-sm btn-danger m-1" title="{{ trans('g.dashboard.delete') }}"><i class="fa fa-trash-o"></i></button>
                                                                    </form>
                                                                @endcan
                                                            @endif
                                                        @else
                                                            @can('admin.'.$table.'.delete')
                                                                <form @submit.prevent="deleteItem(item.resource_url)">
                                                                    <button type="submit" class="btn btn-sm btn-danger m-1" title="{{ trans('g.dashboard.delete') }}"><i class="fa fa-trash-o"></i></button>
                                                                </form>
                                                            @endcan
                                                        @endif
                                                    @endif
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                    </tbody>

                                    <div class="p-5 text-center" v-if="!collection.length > 0">
                                        <i class="icon-magnifier" style="font-size: 50px"></i>
                                        <h3 class="mt-3 mb-3">{{ trans('g.dashboard.no_items') }}</h3>
                                        <p class="mb-3">{{ trans('g.dashboard.try_changing_items') }}</p>
                                    </div>
                                </table>

                            </div>
                        @endif
                        <div v-if="pagination.state.total > 0" class="d-flex justify-content-between mt-3">
                            <div class="btn-center" v-if="collection.length > 0">
                                <button v-if="collection.length > 0" @click="loadMore(10)" class="btn btn-primary">
                                    <i class="btn-icon fa fa-refresh"></i>
                                    <span class="btn-text">{{trans('g.dashboard.reset')}}</span>
                                </button>
                                <button v-if="collection.length > 0" @click="loadMore()" class="btn btn-primary">
                                    <i class="btn-icon fa fa-chevron-circle-right"></i>
                                    <span class="btn-text">{{trans('g.dashboard.load_more')}}</span>
                                </button>
                            </div>
                            <pagination></pagination>
                            <span class="pagination-caption">{{ trans('g.dashboard.overview') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    @yield('custom-buttom')
    </div>
    </{{$table}}-listing>
@endsection
