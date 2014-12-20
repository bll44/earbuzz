@extends('layouts.master')

@section('content')

<h1>{{ $artist->name }}</h1>

<div class="row">
@foreach($albums as $album)
	<div class="panel panel-default col-lg-6 col-md-6">
		<div class="panel-heading">
			<h3 class="panel-title">{{ $album->name }}</h3>
		</div>
		<!-- /.panel-heading -->
		<div class="panel-body">
			<ul class="list-group">
			@foreach($album->tracks as $track)
				<li class="list-group-item">{{ $track->number.'. '.$track->name }}</li>
			@endforeach
			</ul>
			<!-- /.list-group -->
		</div>
		<!-- /.panel-body -->
	</div>
	<!-- /.panel -->
@endforeach
</div>
<!-- /.row -->

@stop