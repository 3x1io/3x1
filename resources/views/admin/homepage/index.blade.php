@extends('brackets/admin-ui::admin.layout.default')

@section('body')
    <div class="row">
        <div class="col-md-12">
            <form class="mb-3" method="GET" action="{{url('admin/search')}}">
                <div class="input-group">
                    <input type="search" class="form-control" name="search" id="search" placeholder="{{__('What Are You Searching About?')}}">
                    <span class="input-group-append">
                        <select class="form-control" id="type" name="type">
                            <option value="customer">{{__('Customer')}}</option>
                            <option value="product">{{__('Product')}}</option>
                        </select>
                        <button type="submit" class="input-group-btn btn-primary"><i class="fa fa-search"></i> {{__('Search')}}</button>
                    </span>
                </div>
            </form>
        </div>
    </div>
    @php $modules = \Module::all(); @endphp
    @foreach($modules as $item)
        @if(View::exists($item->getLowerName() . '::dashboard'))
            @include($item->getLowerName().'::dashboard')
        @endif
    @endforeach
@endsection
@section('js')
    <script src="{{ mix('/js/admin.js') }}"></script>
@endsection
