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

<div class="alert alert-danger alert-dismissable hidden" role="alert">
	<button type="button" class="close" data-dismiss="alert">
		<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
	</button>
	<p class="message_content"></p>
</div><!-- /.alert-danger -->
<div class="alert alert-success alert-dismissable hidden" role="alert">
	<button type="button" class="close" data-dismiss="alert">
		<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
	</button>
	<p class="message_content"></p>
</div><!-- /.alert-success -->

<div class="row">
	<div id="video" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	</div><!-- /#video -->
</div><!-- /.row -->

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 clipping-instructions">
		<strong>Instructions:</strong>
		<p class="clip-instruction-text">Start by clicking the "Create New Track" button to begin clipping the video down to tracks so you can starting selling the concert and make some money!</p>
	</div><!-- /.clipping-instructions -->
</div><!-- /.row -->

<div class="row">
	<div class="clip-btn-container">
		<button class="track-clipping-btn btn btn-default">Create New Track</button>
		<button class="finish-process-tracks btn btn-primary">Finish and Process Tracks</button>
	</div><!-- /.clip-btn-container -->
</div><!-- /.row -->

<div class="row">
	<div class="alert alert-warning processing-alert alert-dismissible hidden" role="alert">
	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	<p><strong>Hold on!</strong> This action may take some time to complete. Please check back later to see if it is done. This process could take anywhere from 30 minutes to 2 hours. We will send you an email when it is done as well so you don't have to wait around. Thank you!</p>
	<p><button type="button" class="btn btn-warning continue-processing">Continue</button></p>
	</div><!-- /.alert -->
</div><!-- /.row -->

<div class="track-container table-responsive">
<h3 id="album-title">Tracks</h3>
<table class="table table-hover stream-tracks">
	<thead>
		<th>#</th>
		<th>Name</th>
		<th>Time</th>
		<th>Actions</th>
	</thead><!-- / table header rows -->
	<tbody>
	</tbody><!-- / table body rows -->
</table><!-- /.table -->
</div><!-- /.track-container -->

<div class="modal" id="album-name-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Create a name for your new Album</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<input type="text" class="form-control" id="album-name-input" placeholder="Create a name for your new album">
				</div>
				<div class="form-group">
					<input type="text" class="form-control" id="album-genre-input" placeholder="Specify a genre for this album">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-primary" id="save-album-name-btn">Save Album</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.album-name-modal -->

<div class="modal" id="track-name-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Create a name for this Track here.</h4>
			</div>
			<div class="modal-body">
				<input type="text" class="form-control" id="track-name-input">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-primary" id="save-track-name-btn">Save Track</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.track-name-modal -->

<script>

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
		$('#album-name-modal').modal();
		$('#album-name-input').focus();
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
		$('#track-name-modal').modal();
		$('#track-name-input').focus();
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
			$('.alert-success .message_content').text(data.message);
			$('.alert-success').removeClass('hidden');
		}
		else if(data.status === 'error')
		{
			$('.alert-danger .message_content').text(data.message);
			$('.alert-danger').removeClass('hidden');
		}
		$('#album-name-modal').modal('hide');
	});
});
save_name_btn.click(function() {
	track.name = $('#track-name-input').val();
	var rounded_duration = Math.ceil(track.duration);
	var minutes = Math.floor(rounded_duration / 60);
	var seconds = (rounded_duration % 60);
	track.duration_f = minutes + ':' + seconds;
	$('#track-name-modal').modal('hide');
	track_number++;
	track_clipping_btn.text('Create New Track');
	$('.stream-tracks tbody').append("<tr class='track_" + track.number + "'><td>"+track.number+"</td><td>"+track.name+"</td><td>" + track.duration_f + "</td><td>Remove | Properties</td></tr>");
	tracks.push(track);
});

$('.finish-process-tracks').click(function() {
	$('.processing-alert').removeClass('hidden');
});

$('.continue-processing').click(function() {
	$('.processing-alert').alert('close');
	$('.finish-process-tracks').html('Working&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-spinner fa-spin"></i>');
	$.ajax({
		url: "<?php echo URL::route('recent_streams.process') ?>",
		type: 'POST',
		data: { file_name: filename, track_listing: tracks, album_name: album },
		dataType: 'json'
	}).done(function(data) {
		if(data.status === 'success')
		{
			$('.finish-process-tracks').removeClass('btn-primary').addClass('btn-success').html('Finished&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-check"></i>');
		}
	});
});

</script>

@stop