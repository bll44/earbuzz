@extends('layouts/master')

@section('content')

<h1>profile.edit <small> {{ $user->username}} </small></h1>

{{ Form::model($user->profile, ['method' => 'PATCH', 'route' => ['profile.update', $user->username]]) }}

<div class="form-group">
	{{ Form::label('location', 'Location:') }}
	{{ Form::text('location', null, ['class' => 'form-control']) }}
	{{ errors_for('location', $errors) }}
</div>

<div class="form-group">
	{{ Form::label('bio', 'Bio:') }}
	{{ Form::textarea('bio', null, ['class' => 'form-control']) }}
	{{ errors_for('bio', $errors) }}
</div>

<div class="form-group">
	{{ Form::label('twitter_username', 'twitter_username:') }}
	{{ Form::text('twitter_username', null, ['class' => 'form-control']) }}
	{{ errors_for('twitter_username', $errors) }}
</div>

<div class="form-group">
	{{ Form::label('lastfm_username', 'lastfm_username:') }}
	{{ Form::text('lastfm_username', null, ['class' => 'form-control']) }}
	{{ errors_for('lastfm_username', $errors) }}
</div>

<div class="form-group">
	{{ Form::label('facebook_username', 'facebook_username:') }}
	{{ Form::text('facebook_username', null, ['class' => 'form-control']) }}
	{{ errors_for('facebook_username', $errors) }}
</div>

<div class="form-group">
	{{ Form::submit('Update Profile', ['class' => 'btn btn-primary']) }}
</div>

{{ Form::close() }}

@stop

@section('scripts')

<script>

$('button.show_stream_key').click(function() {
	// hide the button
	$(this).hide();
	// show the key
	$('.streaming_key').removeClass('hidden');
});

$('#regenerate_stream_key').click(function() {
	$(this).html('<i class="fa fa-refresh fa-spin"></i>');
	setTimeout(function() {
		$.ajax({
			url: "{{ URL::to('stream/resetStreamKey') }}",
			type: 'GET'
		}).done(function(data) {
			$('input.streaming_key').val(data.key);
			$('#regenerate_stream_key').html('Reset Key');
		});
	}, 1000);
});

</script>

@stop