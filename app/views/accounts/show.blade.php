<?php

$email_check = Auth::user()->email;

$id = Auth::user()->getId();

$results = DB::table('streaming_keys')
->where('user_id', "=", $id)
->get();
?>

@foreach ($results as $result)
    <?php
    $new_result = $result->key;
    ?>
@endforeach



@extends('layouts.master')

@section('content')

<h2>accounts.show</h2>

@if(Session::has('message'))
<div class="alert alert-warning">
{{ Session::get('message') }}
</div><!-- /.alert -->
@endif

<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">{{ Auth::user()->username }}</h3>
			</div>
			<div class="panel-body">
				<h4>Account information&nbsp;&nbsp;<small><a href="#"><i class="fa fa-edit"></i>Edit</a></small></h4>
				<ul class="list-group">
					<li class="list-group-item"><b>Username:</b> {{ Auth::user()->username }}</li>
					@if(is_null($email_check))
					@else
					<li class="list-group-item"><b>Email:</b> {{ Auth::user()->email }}</li>
					@endif
					<li class="list-group-item"><b>Password:</b> &#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- /.column -->
	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Streaming Key</h3>
			</div>
			<div class="panel-body">
				<!-- if the user has a streaming key -->
				@if(null !== Auth::user()->streamingKey)
				<p class="text-danger">Do not share this key with anyone! If you believe your key has been compromised please reset it below.</p>
				<button type="button" class="btn btn-primary show_stream_key">Show Streaming Key</button>
				<div class="input-group">
					{{ Form::text('streaming_key', $new_result,
								 ['class' => 'form-control input-sm streaming_key hidden',
								  'placeholder' => 'Streaming Key']) }}
					<span class="input-group-btn">
						<button type="button" class="btn btn-primary btn-default btn-sm streaming_key hidden" id="regenerate_stream_key">
							Reset Key
						</button>

					</span>
				</div>
				<!-- /.input-group -->
				<!-- if the user does NOT have a streaming key -->
				@else
				<p class="text-danger">You do not have a streaming key yet.</p>
				<button type="button" class="btn btn-primary generate-stream-key" id="generate-stream-key">Generate Streaming Key</button>
				@endif
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.column -->
</div>
<!-- /.row -->

@if (Auth::user()->type == 'fan')
@elseif (Auth::user()->type == 'artist')
<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">My Music</h3>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<p>
					You have {{ count($artist->tracks) }} songs. {{ link_to('files/music/manager/'.Auth::user()->id, 'Manage Your Music Here') }}
				</p>
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.column -->
@endif

<!-- Subscription Examples -->

	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Premium</h3>
			</div>
			<div class="panel-body">
				@if (Auth::user()->subscribed())
				<p>
					You're subscribed, dingo!
				</p>
				@endif
				@if (!Auth::user()->cancelled() && Auth::user()->subscribed() )
				<p>
					{{ link_to('cancel', 'Cancel This Subscription!', ['class' => 'page']) }}
				</p>
				@endif
				@if (Auth::user()->onPlan('premium'))
				<p>
					Congrats! You are a premium member!
				</p>
				@endif
				@if (Auth::user()->onTrial())
				<p>
					You're trial will expire {{ \Carbon\Carbon::createFromTimeStamp(strtotime(Auth::user()->trial_ends_at))->diffForHumans() }}
				</p>
				@endif
				@if (Auth::user()->cancelled())
				<p>
					{{ link_to('resume', 'Resume This Subscription!', ['class' => 'page']) }}
				</p>
				@endif
				@if (!Auth::user()->subscribed())
				<p>
					{{ link_to('/buy', 'Upgrade Here', ['class' => 'page']) }}
				</p>
				@endif
			</div>
		</div>
	</div>
	<!-- /.column -->

</div>
<!-- /.row -->

<script>

$('button.show_stream_key').click(function() {
	// hide the button
	$(this).hide();
	// show the key
	$('.streaming_key').removeClass('hidden');
});

$('#regenerate_stream_key').click(function() {
	$(this).html('<i class="fa fa-refresh fa-spin"></i>');
	$('#regenerate_stream_key').addClass('key_reset');
	$.ajax({
		url: "{{ URL::to('stream/resetStreamKey') }}",
		type: 'GET'
	}).done(function(data) {
		$('input.streaming_key').val(data.key);
		$('#regenerate_stream_key').html('Reset Key');
		$('#regenerate_stream_key').removeClass('key_reset');
	});
});

$('#generate-stream-key').click(function() {
	$(this).html('Generating <i class="fa fa-circle-o-notch fa-spin"></i>');
	var url = "{{ URL::to('stream/generateStreamKey') }}";
	window.location = url;
});

</script>

@stop
