@extends('layouts.master')

@section('content')
<div class="route-info">
<h2>MediaController@showRecentStreams</h2>
<h2>recent_streams.show</h2>
</div><!-- /.route-info -->
<div class="row">
	<h1>Your most recent streams</h1>
</div>
<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

		@if(count($files) <= 0)
		<h3>Nothing needs edited right now.</h3>
		@endif

		<ul class="list-group">
		@foreach($files as $fileinfo)
		<li class="list-group-item">
		{{ link_to_route('recent_streams.edit', $fileinfo->getBasename(), [$fileinfo->getFilename()]) }}
		</li>
		@endforeach
		</ul><!-- /.list-group -->

	</div><!-- /.col-4 -->
</div>

@stop