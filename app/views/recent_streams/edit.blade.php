@extends('layouts.master')

@section('content')
<meta name="filename" content="{{ $filename }}">
<meta name="streaming_key" content="{{ Auth::user()->streamingKey->key }}">

<style type="text/css">
.clipping-instructions {
	margin-top: 10px;
}
.processing-alert {
	margin-top: 10px;
}
</style>

<div class="row">
	<!-- <div id="video" class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> **bootstrap**-->
	<div id="video" class="large-12 medium-12 small-12 columns">
	</div>
	<!-- /#video -->
</div>
<!-- /.row -->

<div class="row">
	<!-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 clipping-instructions"> **bootstrap**-->
	<div class="large-12 medium-12 small-12 columns clipping-instructions">
		<strong>Instructions:</strong>
		<p class="clip-instruction-text">Start by clicking the "Create New Track" button to begin clipping the video down to tracks so you can starting selling the concert and make some money!</p>
	</div><!-- /.clipping-instructions -->
</div><!-- /.row -->

<div class="row">
	<div class="clip-btn-container">
		<button class="track-clipping-btn">Create New Track</button>
		<button class="finish-process-tracks">Finish and Process Tracks</button>
	</div><!-- /.clip-btn-container -->
</div><!-- /.row -->

<div class="track-container">
	<h3 id="album-title">Tracks<span id="on-album-name"></span></h3>
	<table class="large-12 medium-12 small-12 columns stream-tracks">
		<thead>
			<th>#</th>
			<th>Name</th>
			<th>Time</th>
			<th>Actions</th>
		</thead>
		<!-- / table header rows -->
		<tbody>
			<!-- table data rows go here -->
		</tbody>
		<!-- / table body rows -->
	</table>
	<!-- /.table -->
</div>
<!-- /.track-container -->

<div class="reveal-modal" id="album-name-modal" data-reveal>
	<h2>Create a name for your new Album</h2>
	<div>
		<input type="text" id="album-name-input" placeholder="Create a name for your new album">
	</div>
	<div>
		<input type="text" id="album-genre-input" placeholder="Specify a genre for this album">
	</div>
	<button type="button" id="save-album-name-btn">Save Album</button>
	<a class="close-reveal-modal">&#215;</a>
</div>
<!-- /#album-name-modal -->

<div class="reveal-modal" id="track-name-modal" data-reveal>
	<h2>Enter a name for this Track here.</h2>
	<input type="text" placeholder="Track Name" id="track-name-input">
	<button type="button" id="save-track-name-btn">Save Track</button>
	<a class="close-reveal-modal">&#215;</a>
</div>
<!-- /#track-name-modal -->

@stop

@section('scripts')

<script>

$('#zurb-test-modal').click(function() {
	$('#album-name-modal').foundation('reveal', 'open');
});

// create jwplayer
var filename = $('meta[name="filename"]').attr('content');
var streaming_key = $('meta[name="streaming_key"]').attr('content');
jwplayer('video').setup({
	sources: [{ file: "rtmp://straightcash.co:1935/vod/mp4:" + streaming_key + "/" + filename }],
	primary: 'flash',
	width: '100%',
});

/**
 *
 * Track editing section
 *
 */
var track_clipping_btn = $('.track-clipping-btn');
var save_name_btn = $('#save-track-name-btn');
var btn_state = 'create';
var tracks = [];
var track_number = 1;
var create_new_first_click = true;
var album;

var track;
track_clipping_btn.click(function() {
	if(create_new_first_click)
	{
		$('#album-name-modal').foundation('reveal', 'open');
		// $('#album-name-modal').modal();
		// $('#album-name-input').focus();
		return; // return to end the click event function for the first use
	}
	if(btn_state === 'create')
	{
		track = {}; // create track object, or set it back to an empty object
		track.number = track_number;
		$('input#track-name-input').attr('placeholder', 'Track ' + track.number)
		btn_state = 'start_time';
		$('p.clip-instruction-text').text('Now, go to the beginning of the track and click the "Set Start Time" button to set the track\'s start time.');
		track_clipping_btn.text('Set Start Time');
	}
	else if(btn_state === 'start_time')
	{
		btn_state = 'end_time';
		track.start_time = jwplayer('video').getPosition();
		$('p.clip-instruction-text').text('Next, go to the end of the track and click the "Set End Time" button to set the track\'s end time. The track duration will be calculated automatically based on the start and end times.');
		track_clipping_btn.text('Set End Time');
	}
	else if(btn_state === 'end_time')
	{
		btn_state = 'create';
		track.end_time = jwplayer('video').getPosition();
		track.duration = track.end_time - track.start_time;
		$('#track-name-input').val('');
		// $('#track-name-modal').modal();
		$('#track-name-modal').foundation('reveal', 'open');
		// $('#track-name-input').focus();
	}
});
$('#save-album-name-btn').click(function() {
	album = $('#album-name-input').val();
	$.ajax({
		url: "{{ URL::route('recent_streams.name_album') }}",
		type: 'POST',
		data: { album_name: album, album_genre: $('#album-genre-input').val() },
		dataType: 'json'
	}).done(function(data) {
		if(data.status === 'success')
		{
			create_new_first_click = false;
			// $('.alert-success .message_content').text(data.message); **bootstrap**
			// $('.alert-success').removeClass('hidden'); **bootstrap**
		}
		else if(data.status === 'error')
		{
			// $('.alert-danger .message_content').text(data.message); **bootstrap**
			// $('.alert-danger').removeClass('hidden'); **bootstrap**
		}
		$('span#on-album-name').text(' on ' + album);
		$('#album-name-modal').foundation('reveal', 'close');
		// $('#album-name-modal').modal('hide'); **bootstrap**
	});
});
save_name_btn.click(function() {
	track.name = $('#track-name-input').val();
	var rounded_duration = Math.ceil(track.duration);
	var minutes = Math.floor(rounded_duration / 60);
	var seconds = (rounded_duration % 60);
	if(seconds < 10)
	{
		seconds = seconds.toString();
		seconds = '0' + seconds;
	}
	track.duration_f = minutes + ':' + seconds;
	console.log(track.duration_f);
	$('#track-name-modal').foundation('reveal', 'close');
	// $('#track-name-modal').modal('hide'); **bootstrap**
	track_number++;
	track_clipping_btn.text('Create New Track');
	$('.stream-tracks tbody').append("<tr class='track_" + track.number + "'><td>"+track.number+"</td><td>"+track.name+"</td><td>" + track.duration_f + "</td><td>Remove | Properties</td></tr>");
	tracks.push(track);
});

// $('.finish-process-tracks').click(function() {
// 	$('.processing-alert').removeClass('hidden');
// });

$('.finish-process-tracks').click(function() {
	// $('.processing-alert').alert('close'); **bootstrap**
	$('.finish-process-tracks').html('Working&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-spinner fa-spin"></i>');
	$.ajax({
		url: "<?php echo URL::route('recent_streams.process') ?>",
		type: 'POST',
		data: { file_name: filename, track_listing: tracks, album_name: album },
		dataType: 'json'
	}).done(function(data) {
		if(data.status === 'success')
		{
			$('.finish-process-tracks').html('Finished&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-check"></i>');
			// $('.finish-process-tracks').removeClass('btn-primary').addClass('btn-success').html('Finished&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-check"></i>'); **bootstrap**
		}
	});
});

</script>

@stop
