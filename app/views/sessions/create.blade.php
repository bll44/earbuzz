@extends( Request::ajax() ? 'layouts.modal' : 'layouts.master' )

@section('content')

<h1>sessions.create</h1>

<?php $fb_login = route('registration.loginWithFacebook'); ?>
<?php $twitter_login = route('registration.loginWithTwitter'); ?>
<?php $google_login = route('registration.loginWithGoogle'); ?>

<div class="container">
	<div class="omb_login">
		<h3 class="omb_authTitle">Login or <a href="/register">Sign up</a></h3>
		<div class="row omb_row-sm-offset-3 omb_socialButtons">
			<div class="col-xs-4 col-sm-2">
				<a href="{{ $fb_login }}" class="btn btn-lg btn-block omb_btn-facebook">
					<i class="fa fa-facebook visible-xs"></i>
					<span class="hidden-xs">Facebook</span>
				</a>
			</div>
			<div class="col-xs-4 col-sm-2">
				<a href="{{ $twitter_login }}" class="btn btn-lg btn-block omb_btn-twitter">
					<i class="fa fa-twitter visible-xs"></i>
					<span class="hidden-xs">Twitter</span>
				</a>
			</div>
			<div class="col-xs-4 col-sm-2">
				<a href="{{ $google_login }}" class="btn btn-lg btn-block omb_btn-google">
					<i class="fa fa-google-plus visible-xs"></i>
					<span class="hidden-xs">Google+</span>
				</a>
			</div>
		</div>

		<div class="row omb_row-sm-offset-3 omb_loginOr">
			<div class="col-xs-12 col-sm-6">
				<hr class="omb_hrOr">
				<span class="omb_spanOr">or</span>
			</div>
		</div>

		<div class="row omb_row-sm-offset-3">
			<div class="col-xs-12 col-sm-6">
				{{ Form::open(['route' => 'sessions.store']) }}
				<form class="omb_loginForm" action="" autocomplete="off" method="POST">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
						{{ Form::text('email', null, array('class' => 'form-control email-field', 'autocomplete' => 'off', 'required' => 'required', 'placeholder' => 'email address')) }}
					</div>
					<span class="help-block">{{ $errors->first('email', '<span class="alert alert-error">:message</span>') }}</span>

					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
						{{ Form::password('password', array('class' => 'form-control password-field', 'autocomplete' => 'off', 'required' => 'required', 'placeholder' => 'password')) }}
					</div>
					<span class="help-block">{{ $errors->first('password', '<span class="alert alert-error">:message</span>') }}</span>

					{{ Form::submit('Login', ['class' => 'btn btn-lg btn-primary btn-block']) }}
				</form>
			</div>
		</div>
		<div class="row omb_row-sm-offset-3">
			<div class="col-xs-12 col-sm-3">
				<label class="checkbox">
					<input type="checkbox" value="remember-me">Remember Me
				</label>
			</div>
			<div class="col-xs-12 col-sm-3">
				<p class="omb_forgotPwd">
					<a href="#">Forgot password?</a>
				</p>
			</div>
		</div>
		{{ Form::close() }}
	</div>
</div>

@stop