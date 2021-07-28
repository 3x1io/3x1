@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.block.actions.edit', ['name' => $block->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <block-form
                :action="'{{ $block->resource_url }}'"
                :data="{{ $block->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.block.actions.edit', ['name' => $block->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.block.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </block-form>

        </div>
    
</div>

@endsection