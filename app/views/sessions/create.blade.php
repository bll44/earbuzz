@extends( Request::ajax() ? 'layouts.modal' : 'layouts.master' )

@section('content')

<!-- <h1>sessions.create</h1> -->

<?php $fb_login = route('registration.loginWithFacebook'); ?>
<?php $twitter_login = route('registration.loginWithTwitter'); ?>
<?php $google_login = route('registration.loginWithGoogle'); ?>

<div class="container">
	<div class="omb_login">
		<h1>Sign In</h1>

		<div class="row social">
			<div class="large-4 columns">
				<a href="{{ $fb_login }}" class="button facebook">
					<i class="fa fa-facebook visible-xs"></i>
					<span>Facebook</span>
				</a>
			</div>
			<div class="large-4 columns">
				<a href="{{ $twitter_login }}" class="button twitter">
					<i class="fa fa-twitter visible-xs"></i>
					<span class="hidden-xs">Twitter</span>
				</a>
			</div>
			<div class="large-4 columns">
				<a href="{{ $google_login }}" class="button google">
					<i class="fa fa-google-plus visible-xs"></i>
					<span class="hidden-xs">Google+</span>
				</a>
			</div>
		</div>

		<hr>
		<span class="span-or">OR</span>

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

					{{ Form::submit('Login', ['class' => 'button submit-form', 'aria-label' => 'submit form', 'role' => 'button']) }}
					<div class="rememberMe">
						<div class="switch">
							<input id="exampleCheckboxSwitch" type="checkbox" value="remember-me">
							<label for="exampleCheckboxSwitch">Remember Me</label>
						</div>
						<p class="copy">Remember Me</p>
					</div>
				</form>
			</div>
		</div>
		<div class="row">
			<div>
				<p class="forgotPwd">
					{{ link_to('/password/remind', 'Forgot password?', null, ['class' => 'page']) }}
				</p>
			</div>
		</div>
		{{ Form::close() }}
	</div>
</div>

@stop
