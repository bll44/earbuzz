@extends('layouts.master')


@section('content')

<h3>{{ $user->displayname }}'s Live Stream</h3>
<div id="video">

</div>

<script type="text/javascript">

var streamKey = "{{ $streamingKey }}";
if (navigator.userAgent.match(/android/i) != null){
} else {
	jwplayer("video").setup({
		autostart: 'false',

		// Real URL
		sources: [{ file: "rtmp://10.0.0.15:1935/live/" + streamKey }],
		// { file: "http://straightcash.co:1935/live/switcher/playlist.m3u8" }],

		// Test URL
		// sources: [{ file: "rtmp://fms.12E5.edgecastcdn.net/0012E5/mp4:videos/8Juv1MVa-485.mp4" },
		// { file: "http://devimages.apple.com/iphone/samples/bipbop/bipbopall.m3u8" }],
		rtmp: { bufferlength: 5 },
		width: "100%",
		primary: "flash"
	});
}
</script>

@stop