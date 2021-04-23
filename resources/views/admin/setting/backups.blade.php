@extends('brackets/admin-ui::admin.layout.default')

@section('title', __('Backups'))

@section('body')

    <div class="card">
        <div class="card-header">
            <i class="icon icon-cloud-download"></i>
            {{__('Backups')}}

            <div class="pull-right">
                <form method="POST" action="{{url('admin/backups')}}">
                    @csrf
                    @method('POST')
                    <button class="btn btn-primary"><i class="fa fa-play"></i> {{__('Run Backup')}}</button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{__('Path')}}</th>
                    <th>{{__('Action')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($backups as $key=>$backup)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{str_replace(storage_path('app/Laravel') .'/', '', $backup)}}</td>
                        <td>
                            <form method="POST" target="_blank" action="{{url('admin/backups')}}">
                                @csrf
                                @method('POST')
                                <input type="hidden" name="path" value="{{$backup}}">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-download"></i> {{__('Download')}}</button>
                            </form>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('bottom-scripts')
    @include('sweetalert::alert')
@endsection
@section('js')
    <script src="{{ mix('/js/admin.js') }}"></script>
@endsection
