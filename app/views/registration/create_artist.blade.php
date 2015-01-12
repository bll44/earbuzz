@extends( Request::ajax() ? 'layouts.modal' : 'layouts.master' )

@section('content')
<!-- <h1>registration.create_artist</h1> -->
<?php $fb_login = route('registration.registerWithFacebookArtist'); ?>
<?php $twitter_login = route('registration.registerWithTwitterArtist'); ?>
<?php $google_login = route('registration.registerWithGoogleArtist'); ?>

<div class="container">
	<div>

		<h1>Sign up!</h1>

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
				{{ Form::open(['route' => 'registration.store_artist', 'class' => 'omb_loginForm', 'role' => 'form']) }}
				<!-- <form class="omb_loginForm" action="" autocomplete="off" method="POST"> -->

					<!-- the user's Display Name for use throughout the website -->
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
						{{ Form::text('displayname', null, array('class' => 'form-control displayname-field', 'autofocus' => true, 'autocomplete' => 'off', 'required' => 'required', 'placeholder' => 'display name')) }}
					</div>
					<span class="help-block">{{ $errors->first('displayname', '<span class="alert alert-error">:message</span>') }}</span>

					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
						{{ Form::text('username', null, array('class' => 'form-control username-field', 'autocomplete' => 'off', 'required' => 'required', 'placeholder' => 'username')) }}
					</div>
					<span class="help-block">{{ $errors->first('username', '<span class="alert alert-error">:message</span>') }}</span>

					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-envelope fa-fw"></i></span>
						{{ Form::text('email', null, array('class' => 'form-control email-field', 'autocomplete' => 'off', 'required' => 'required', 'placeholder' => 'email address')) }}
					</div>
					<span class="help-block">{{ $errors->first('email', '<span class="alert alert-error">:message</span>') }}</span>

					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
						{{ Form::password('password', array('class' => 'form-control password-field', 'autocomplete' => 'off', 'required' => 'required', 'placeholder' => 'password')) }}
					</div>
					<span class="help-block">{{ $errors->first('password', '<span class="alert alert-error">:message</span>') }}</span>

					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
						{{ Form::password('password_confirmation', array('class' => 'form-control password_confirmation-field', 'autocomplete' => 'off', 'required' => 'required', 'placeholder' => 'password confirmation')) }}
					</div>
					<span class="help-block">{{ $errors->first('password', '<span class="alert alert-error">:message</span>') }}</span>

					{{ Form::submit('Sign Up', ['class' => 'button', 'aria-label' => 'submit form', 'role' => 'button']) }}

				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>

@stop
