@extends('layouts/masterchat')

@section('content')
<h1>
	{{ $user->displayname }}
	@if(Auth::check() && Auth::user()->id === $user->id)
	<div class="switch">
		@if(Auth::check() && Auth::user()->status)
		<input id="status-switch" type="checkbox" checked>
		@else
		<input id="status-switch" type="checkbox">
		@endif
		<label for="status-switch">Status</label>
	</div>
	@endif
</h1>
<h1>
	profile.show
	<small>
		@if (Auth::check() && $user->isCurrent())
			{{ link_to_route('profile.edit', 'Edit Your Profile', $user->username) }}
		@endif
	</small>
</h1>
<!-- Video -->
<div class="row">
	<div class="col-sm-9 col-md-9">

		@if($is_artist_profile)
			{{ link_to_route('live.show', 'View Live Stream', [$artist->id]) }}
		@endif

		<h3>Video</h3>

		@if($countdown)
			<div class="countdown-wrapper">
				<div id="countdown">
				@if($next_concert === null)
				<h4>No upcoming concerts</h4>
				@endif
				</div>
				<!-- /#countdown -->
			</div>
			<!-- /.countdown-wrapper -->
		@else
			<div class="video-wrapper">
				<div id="video">
				</div>
				<!-- /#video -->
			</div>
			<!-- /.video-wrapper -->
		@endif
	</div>
	<!-- /.column -->
</div>
<!-- /.row -->
<!-- / Video -->

<!-- Chat -->
<!-- Chat window and input -->
<div>
	<h3>Chat Room</h3>

	<div id="chatroom">
	</div>
	<!-- /#chatroom -->

	<div id="messageform">
		<!-- change this according to your deploy url -->
	{{ Form::open(array('route' => 'get.chat', 'id'=>'newmessage')) }}
		<!-- <form action="/testchat/index.php" method="POST" id="newmessage"> -->
		<input type="text" id="message" name="message" />
		@if(Auth::check())
			<input type="hidden" id="user" name="user" value="{{ Auth::user()->username }}" />
		@endif
		<button name="submit" id="submit" type="submit">Post</button>
	{{ Form::close() }}
	</div>
	<!-- /#messageform -->
</div>
<!-- / Chat window and input -->

<div id="waiting">
	Waiting to establish connection ...
</div>
<!-- /#waiting -->

<!-- / Chat -->
<!-- Profile Info -->
<div class="row">
	<div class="col-sm-9 col-md-9">
		<p id="user-favorites">
			@if($user->isCurrent())
				{{ $user->username }}: {{ link_to_route('profile.favorites', 'View My Favorites', $user->username) }}
			@else
				{{ $user->username }}: {{ link_to_route('profile.favorites', 'View Their Favorites', $user->username) }}
			@endif
		</p>
		<!-- /#user-favorites -->

		<p id="user-location">
		<cite title="Source Title">
			{{ $user->profile->location }} <i class="glyphicon glyphicon-map-marker"></i>
		</cite>
		</p>
		<!-- /#user-location -->

		<p id="user-bio">
			{{ $user->profile->bio }}
		</p>
		<!-- /#bio -->

		<p>
			@if($user->isCurrent())
			@else
			<i class="glyphicon glyphicon-envelope"></i> {{ link_to_route('messages.create', 'Send Private Message', 'to='.$user->username) }}
			@endif
			<br/>
			<i class="fa fa-twitter"></i> Twitter: {{ link_to('http://twitter.com/'. $user->profile->twitter_username, $user->profile->twitter_username) }}
			<br />
			<i class="fa fa-facebook"></i> Facebook: {{ link_to('http://facebook.com/'. $user->profile->facebook_username, $user->profile->facebook_username) }}
			<br />
			<i class="fa fa-music"></i> Last.fm: {{ link_to('http://last.fm/'. $user->profile->lastfm_username, $user->profile->lastfm_username) }}
		</p>
	</div>
	<!-- /.column -->
</div>
<!-- /.row -->
@if($is_artist_profile)
	<div class="row">
		<div class="buy-music-btn-container">
			{{ link_to_route('store.artist.music', "See Music by {$artist->name}", [$artist->id], ['class' => 'btn btn-danger']) }}
		</div>
		<!-- /.buy music button -->
	</div>
	<!-- /.row -->
@endif

<!-- Favorite -->

@if(Auth::check() && ! $user->isCurrent())
	@if($favorited = in_array($artist->id, $favorites))
		{{ Form::open(['method' => 'DELETE', 'route' => ['favorites.destroy', $artist->id]]) }}
	@else
		{{ Form::open(['route' => 'favorites.store']) }}
		{{ Form::hidden('post-id', $artist->id) }}
	@endif
	<button type="submit">
		Favorite <i class="fa fa-heart {{ $favorited ? 'favorited' : 'not-favorited' }}"></i>
	</button>
	{{ Form::close() }}
@endif

@stop

@section('scripts')

<script>
	var channel = '{{ $user->id }}';
	$(function() {
		var PUSHER = {
			KEY: '999a6964f87015288a65'
		};

		var messageForm = $('#newmessage'),
		messageFormDisplay = $('#messageform'),
		message = $('#message'),
		user = $('#user'),
		messageTemplate = _.template(
			'<p><span class="user"><%= user %></span>: <span><%= content %></span></p>'),
		chatContent = $('#chatroom'),
        // pusher channels
        pusher = new Pusher(PUSHER.KEY),
        socketId = 0,
        chatChannel = pusher.subscribe(channel);

        socketId = pusher.bind('pusher:connection_established',
        	function(ev) {
        		socketId = ev.socket_id;
        		$('#waiting').hide();
        		messageFormDisplay.show();

            // perform all bindings here
            chatChannel.bind('message-created', function(message) {
                // console.log(message);
                chatContent.append(messageTemplate({
                	user: message.user,
                	content: message.content
                }));
            });

            messageForm.submit(function(e) {
            	e.preventDefault();
            	var content = message.val();
            	if (content.length > 0) {
            		$.post(messageForm.attr('action'), {
            			user: user.val(),
            			content: content,
            			channel: channel
            		});
            	}
            	message.val('').focus();
            	return false;
            });
        }
        );
    });
</script>

{{ HTML::script('js/countdown.min.js') }}
<!-- VIDEO -->
@if( ! $countdown)
<script>
	jwplayer("video").setup({
		autostart: 'false',

		// Real URL
		sources: [{ file: "rtmp://10.0.0.15:1935/live/dog" }],
		// { file: "http://straightcash.co:1935/live/switcher/playlist.m3u8" }],

		// Test URL
		// sources: [{ file: "rtmp://fms.12E5.edgecastcdn.net/0012E5/mp4:videos/8Juv1MVa-485.mp4" },
		// { file: "http://devimages.apple.com/iphone/samples/bipbop/bipbopall.m3u8" }],
		rtmp: { bufferlength: 5 },
		width: "100%",
		primary: "flash"
	});
</script>
@endif
<script type="text/javascript">
$('#status-switch').change(function() {
	var status;
	$(this).is(':checked') ? status = 1 : status = 0;

	$.ajax({
		url: "{{ URL::route('status.change') }}",
		type: 'POST',
		data: { online_status: status }
	}).done(function(data) {
		console.log(data);
	});
});
</script>

@if(null !== $next_concert && $countdown)
<script>
	var start_time = "{{ $next_concert->start_time }}";
	var countdownTimer = countdown(
			new Date(start_time),
			function(ts) {
				if(ts.value > 0)
				{
					window.clearInterval(countdownTimer);
					location.reload();
				}
				else
				{
					document.getElementById('countdown').innerHTML = ts.toHTML("strong");
				}
			}
		);
</script>
@endif

@stop