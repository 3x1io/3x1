@extends('brackets/admin-ui::admin.layout.default')

@section('title', __('Themes Settings'))

@section('body')

    <div class="card">
        <div class="card-header">
            <i class="icon icon-globe"></i>
            {{__('Themes Settings')}}
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($data as $item)
                    <div class="col-md-3">
                        <div class="card">
                            <img src="{{url($item['info']->image)}}" alt="{{$item['info']->name}}"/>
                            <div class="card-body">
                                <h3>{{$item['info']->name}}</h3>
                                <p>{{$item['info']->description}}</p>
                                <div class="row">
                                    @if(str_replace('themes.', '', setting('themes.path')) !== $item['info']->aliases)
                                    <div class="col">
                                            <a href="{{url('admin/themes/active?theme=themes.' . $item['info']->aliases . '&name=' . $item['info']->aliases)}}" class="btn btn-success btn-block"><i class="fa fa-check"></i> {{__('Active')}}</a>
                                    </div>
                                    @endif
                                    <div class="col">
                                        <a href="{{url('/')}}" target="_blank" class="btn btn-primary btn-block"><i class="fa fa-eye"></i> {{__('Preview')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


@endsection

@section('bottom-scripts')
    @include('sweetalert::alert')
@endsection
