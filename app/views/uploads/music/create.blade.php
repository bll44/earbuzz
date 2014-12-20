@extends('layouts/master')

@section('content')

<style>

.clearfix {
	clear: both;
}

</style>

<h1>uploads.music</h1>

<div class="music-upload-form">

	{{ Form::open(['route' => 'uploads.music.store', 'files' => true]) }}

	<div class="form-group">
		{{ Form::label('artist', 'Artist') }}
		{{ Form::text('artist', null, array('class' => 'form-control', 'autofocus' => true, 'required' => 'required', 'placeholder' => 'auto populate with current artist name')) }}
		{{ $errors->first('artist', '<span class="alert alert-error">:message</span>') }}
		<div class="input-tag text-muted"><i class="fa fa-asterisk"></i>Required</div>
	</div>

	<div class="form-group">
		{{ Form::label('album', 'Album') }}
		{{ Form::text('album', null, array('class' => 'form-control', 'autofocus' => true, 'required' => 'required', 'placeholder' => 'Album name')) }}
		{{ $errors->first('album', '<span class="alert alert-error">:message</span>') }}
		<div class="input-tag text-muted"><i class="fa fa-asterisk"></i>Required</div>
	</div>

	<div class="form-group">
		{{ Form::label('year', 'Release Year') }}
		<input type="number" name="year" class="form-control" autofocus="true" required="required" placeholder="1990">
		{{ $errors->first('year', '<span class="alert alert-error">:message</span>') }}
		<div class="input-tag text-muted"><i class="fa fa-asterisk"></i>Required</div>
	</div>

	<div class="form-group">
		{{ Form::label('genre', 'Genre') }}
		<input type="text" name="genre" class="form-control" autofocus="true" required="required" placeholder="e.g. Rock, Hip-Hop, etc.">
		{{ $errors->first('genre', '<span class="alert alert-error">:message</span>') }}
		<div class="input-tag text-muted"><i class="fa fa-asterisk"></i>Required</div>
	</div>

	<h4>Tracks</h4>
	<div class="well" id="tracks-well">

		@if(Session::has('track_error'))
			<p class="alert alert-danger">{{ Session::get('track_error') }}</p>
		@endif

		<div class="track-list">
			<div class="form-group">
				<label for="track1" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-top">Track 1</label>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<input type="file" name="tracks[]" class="form-control">
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<input type="text" name="track1_name" class="form-control" autocomplete="off" placeholder="Track name">
				</div>
			</div>
		</div>
		<div class="pull-right">
			<button type="button" id="add-track" class="btn btn-link"><i class="fa fa-plus"></i> Add Track</button>
			<button type="button" id="remove-track" class="btn btn-link"><i class="fa fa-minus-square"></i> Remove</button>
		</div>

		<div class="form-group clearfix">
			{{ Form::submit('Upload Album', ['class' => 'btn btn-primary']) }}
		</div>

	{{ Form::close() }}

	</div>
	<!-- /#tracks-well -->
</div>
<!-- /.music-upload-form -->

<script type="text/javascript">

var trackNum = 2;
var trackFileTemplate = {
	label: '<label for="track#" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">Track #</label>',
	file_input: '<input type="file" name="tracks[]" class="form-control">',
	text_input: '<input type="text" name="track#_name" class="form-control" autocomplete="off" placeholder="Track name">'
};
console.log(trackFileTemplate);
$('#add-track').click(function() {
	$('.track-list').append(
		'<div class="form-group">'
		+ trackFileTemplate.label.replace(/#/g, trackNum)
		+ '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 track-column">'
		+ trackFileTemplate.file_input.replace(/#/g, trackNum)
		+ '</div>'
		+ '<!-- /.track-column -->'
		+ '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 track-column">'
		+ trackFileTemplate.text_input.replace(/#/g, trackNum)
		+ '</div>'
		+ '<!-- /.track-column -->'
		+ '</div>'
	);
	trackNum++;
	console.log(trackFileTemplate);
});

$('#remove-track').click(function() {
	$('.track-list div.form-group:last-child').remove();
	trackNum--;
});

</script>
@stop