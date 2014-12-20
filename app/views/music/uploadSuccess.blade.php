@extends('layouts.master')

@section('content')

<div class="row">
	<h4>Album, <b>{{ $album }}</b>, successfully uploaded. Upload more songs?</h4>
</div>
<!-- /.row -->

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="col-lg-6">
			<a href="{{ route('uploads.music.create') }}" class="btn btn-primary">Yes</a>
		</div>
		<!-- /.column -->
		<div class="col-lg-6">
			<a href="{{ route('home') }}" class="btn btn-primary">No</a>
		</div>
		<!-- /.column -->
	</div>
	<!-- /.column -->
</div>
<!-- /.row -->

@stop