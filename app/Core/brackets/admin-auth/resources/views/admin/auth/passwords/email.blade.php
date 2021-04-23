@extends('brackets/admin-ui::admin.layout.master')

@section('title', trans('brackets/admin-auth::admin.forgot_password.title'))

@section('content')
	<div class="container" id="app">
		<div class="row align-items-center justify-content-center auth">
			<div class="col-md-6 col-lg-5">
				<div class="card">
					<div class="card-block">
							<auth-form
									:action="'{{ url('/admin/password-reset/send') }}'"
									:data="{ 'email': '{{ old('email', '') }}' }"
									inline-template>
								<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/password-reset/send') }}" novalidate>
									{{ csrf_field() }}
									<div class="auth-header">
										<h1 class="auth-title">{{ trans('brackets/admin-auth::admin.forgot_password.title') }}</h1>
										<p class="auth-subtitle">{{ trans('brackets/admin-auth::admin.forgot_password.note') }}</p>
									</div>
									<div class="auth-body">
										@include('brackets/admin-auth::admin.auth.includes.messages')
											<div class="form-group" :class="{'has-danger': errors.has('email'), 'has-success': fields.email && fields.email.valid }">
												<label for="email">{{ trans('brackets/admin-auth::admin.auth_global.email') }}</label>
												<div class="input-group input-group--custom">
													<div class="input-group-addon"><i class="input-icon input-icon--mail"></i></div>
													<input type="text" v-model="form.email" v-validate="'required|email'" class="form-control" :class="{'form-control-danger': errors.has('email'), 'form-control-success': fields.email && fields.email.valid}" id="email" name="email" placeholder="{{ trans('brackets/admin-auth::admin.auth_global.email') }}">
												</div>
													<div v-if="errors.has('email')" class="form-control-feedback" v-cloak>@{{ errors.first('email') }}</div>
											</div>
											<div class="form-grou">
													<input type="hidden" name="remember" value="1">
													<button type="submit" class="btn btn-primary btn-block btn-spinner"><i class="fa"></i> {{ trans('brackets/admin-auth::admin.forgot_password.button') }}</button>
											</div>
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
