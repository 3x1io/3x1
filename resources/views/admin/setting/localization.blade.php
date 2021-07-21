@extends('brackets/admin-ui::admin.layout.default')

@section('title', __('Localization Settings'))

@section('body')

    <div class="card">
        <div class="card-header">
            <i class="icon icon-map"></i>
            {{__('Localization Settings')}}
        </div>
        <div class="card-body">
            <form method="POST" action="{{url('admin/localization')}}">
                @csrf
                {!! setting_show('local.country', __('Your Country'), 'select', \App\Models\Country::all(), 'name') !!}
                {!! setting_show('local.phone', __('Country Phone Code'), 'text') !!}
                {!! setting_show('local.lang', __('System Language'), 'select', \App\Models\Language::all(), 'name') !!}
                {!! setting_show('$', __('System Currency'), 'text') !!}
                {!! setting_show('local.lat', __('Location Latitude'), 'text', [], 'lat') !!}
                {!! setting_show('local.lng', __('Location longitude'), 'text', [], 'lng') !!}
                {!! setting_show('geo.key', __('Google Map Key'), 'text') !!}
                <button class="btn btn-primary"><i class="fa fa-save"></i> {{__('Save')}}</button>
            </form>
        </div>
    </div>


@endsection

@section('bottom-scripts')
    @include('sweetalert::alert')
    <script>
        if (window.navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(initMap);
        } else {
            alert('Geolocation is not supported by this browser.');
        }
        function initMap(position){
            $('#lat').val(position.coords.latitude);
            $('#lng').val(position.coords.longitude);
        }
    </script>
@endsection
