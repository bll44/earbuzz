@extends('layouts/master')

@section('content')
<h1>
	profile.dashboard
	<small>
		@if (Auth::check())
		@if ($user->isCurrent())
		{{ link_to_route('profile.edit', 'Edit Your Profile', $user->username) }}
		@endif
		@endif
	</small>
</h1>

<div class="content">
	<div class="container">
		<!-- Video and Chat -->
		<div class="row">
			<div class="col-sm-9 col-md-9">
				<h3>Video</h3>
				<div id='video'>
					<a href="http://on.evan.so:1935/live/switcher/playlist.m3u8">Android Test Link 1</a>
					<br>
					<a href="rtsp://on.evan.so:1935/live/switcher">Android Test Link 2</a>
				</div>
			</div>
			<div class="col-sm-3 col-md-3">
				<h3>Chat Room</h3>
			</div>
		</div>
		<!-- Profile Info -->
		<hr>
		<div class="row">
			<div class="col-sm-3 col-md-3">
				<img src="http://placehold.it/100x130" alt="" class="img-rounded img-responsive" />
			</div>
			<div class="col-sm-9 col-md-9">
				<blockquote>
					<p>
						{{ $user->username }}: <small>{{ link_to_route('profile.favorites', 'View Their Favorites', $user->username) }}</small>
					</p>
					<small>
						<cite title="Source Title">
							{{ $user->profile->location }} <i class="glyphicon glyphicon-map-marker"></i>
						</cite>
					</small>
				</blockquote>
				<p>{{ $user->profile->bio }}</p>
				<p>
					<i class="glyphicon glyphicon-envelope"></i> {{ $user->email }}
					<br/>
					<i class="fa fa-twitter"></i> Twitter: {{ link_to('http://twitter.com/'. $user->profile->twitter_username, $user->profile->twitter_username) }}
					<br />
					<i class="fa fa-facebook"></i> Facebook: {{ link_to('http://facebook.com/'. $user->profile->facebook_username, $user->profile->facebook_username) }}
					<br />
					<i class="fa fa-music"></i> Last.fm: {{ link_to('http://last.fm/'. $user->profile->lastfm_username, $user->profile->lastfm_username) }}
				</p>
			</div>
		</div>
	</div>
</div>

<!-- VIDEO -->
<script type="text/javascript">
if (navigator.userAgent.match(/android/i) != null){
} else {
	jwplayer("video").setup({
		autostart: 'false',

		// Real URL
		sources: [{ file: "rtmp://10.0.0.15:1935/live/dog" }]
		// { file: "http://on.evan.so:1935/live/dog/playlist.m3u8" }],

		// Test URL
		// sources: [{ file: "rtmp://fms.12E5.edgecastcdn.net/0012E5/mp4:videos/8Juv1MVa-485.mp4" },
		// { file: "http://devimages.apple.com/iphone/samples/bipbop/bipbopall.m3u8" }],
		// rtmp: { bufferlength: 5 },
		// width: "100%",
		// primary: "flash"
	});
}
</script>

@stop