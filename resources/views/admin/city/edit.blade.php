@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.city.actions.edit', ['name' => $city->name]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <city-form
                :action="'{{ $city->resource_url }}'"
                :data="{{ $city->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.city.actions.edit', ['name' => $city->name]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.city.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </city-form>

        </div>
    
</div>

@endsection