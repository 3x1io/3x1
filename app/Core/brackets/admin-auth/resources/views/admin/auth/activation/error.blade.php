@extends('brackets/admin-ui::admin.layout.master')

@section('title', trans('brackets/admin-auth::admin.activation_form.title'))

@section('content')
    <div class="container" id="app">
        <div class="row align-items-center justify-content-center auth">
            <div class="col-md-6 col-lg-5">
                <div class="card">
                    <div class="card-block">
                        <auth-form
                                :action="'{{ url('/admin/activation/send') }}'"
                                :data="{ 'email': '{{ old('email', '') }}' }"
                                inline-template>
                            <form class="form-horizontal" role="form" method="POST"
                                  action="{{ url('/admin/activation/send') }}"
                                  novalidate>
                                {{ csrf_field() }}
                                <div class="auth-header">
                                    <h1 class="auth-title">{{ trans('brackets/admin-auth::admin.activation_form.title') }}</h1>
                                </div>
                                <div class="auth-body">
                                    @include('brackets/admin-auth::admin.auth.includes.messages')
                                </div>
                            </form>
                        </auth-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ mix('/js/admin.js') }}"></script>
@endsection
