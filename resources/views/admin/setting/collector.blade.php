@extends('brackets/admin-ui::admin.layout.default')

@section('title', __('Data Collector'))


@section('body')

    <div class="card">
        <div class="card-header">
            <i class="icon icon-user"></i>
            {{__('Data Collector')}}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{__('title')}}</th>
                        <th>{{__('url')}}</th>
                        <th>{{__('author')}}</th>
                        <th>{{__('city')}}</th>
                        <th>{{__('body')}}</th>
                        <th>{{__('images')}}</th>
                        <th>{{__('tags')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $key=>$item)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$item['title']}}</td>
                            <td><a href="{{$item['url']}}" class="btn btn-primary" target="_blank"><i class="fa fa-link"></i> </a></td>
                            <td>{{$item['author']}}</td>
                            <td>{{$item['city']}}</td>
                            <td>{{$item['body']}}</td>
                            <td>
                                @if(sizeof($item['images']))
                                    @foreach($item['images'] as $image)
                                        @if($type === 'olx')
                                            <img src="{{$image}}" class="avatar">
                                            @else
                                            <img src="{{$image[0]}}" class="avatar">

                                        @endif
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                @foreach($item['tags'] as $tag)
                                    @if($type === 'olx')
                                        <a href="{{$tag['url']}}" class="badge badge-success p-2 m-1"><i class="fa fa-tag"></i> {{$tag['title']}}</a>
                                    @else
                                        <a href="{{url('admin/collector/haraj')}}?tag={{$tag}}" class="badge badge-success p-2 m-1"><i class="fa fa-tag"></i> {{$tag}}</a>
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('bottom-scripts')
    @include('sweetalert::alert')
@endsection
@section('js')
    <script src="{{ mix('/js/admin.js') }}"></script>
@endsection
