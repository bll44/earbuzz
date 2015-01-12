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
				<h4>Account information&nbsp;&nbsp;<small><a href="#" id="account-edit-link"><i class="fa fa-edit"></i>Edit</a></small></h4>
				<ul class="list-group">
					<li class="list-group-item"><b>Username:</b> {{ Auth::user()->username }}</li>
					<li class="list-group-item"><b>Email:</b> {{ Auth::user()->email }}</li>
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
			<!-- if user is an artist -->
			@if(Auth::user()->type === 'artist')
			<div class="panel-body">
				@if(null !== Auth::user()->streamingKey)
				<p class="text-danger">Do not share this key with anyone! If you believe your key has been compromised please reset it below.</p>
				<button type="button" class="show_stream_key">Show Streaming Key</button>
				<div class="hide" id="input-key-container">
					{{ Form::text('streaming_key', Auth::user()->streamingKey->key,
								 ['class' => 'streaming_key',
								  'placeholder' => 'Streaming Key']) }}
					<button type="button" class="streaming_key" id="regenerate_stream_key">
						Reset Key
					</button>
				</div>
				<!-- if the user does NOT have a streaming key -->
				@else
				<p class="text-danger">You do not have a streaming key yet.</p>
				<button type="button" class="btn btn-primary generate-stream-key" id="generate-stream-key">Generate Streaming Key</button>
				@endif
			</div>
			<!-- /.panel-body -->
		@endif
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.column -->
</div>
<!-- /.row -->

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

@stop

@section('scripts')
<script>

$('#account-edit-link').click(function(event) {

	event.preventDefault();
});

$('button.show_stream_key').click(function() {
	// hide the button
	$(this).hide();
	// show the key
	$('#input-key-container').removeClass('hide');
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