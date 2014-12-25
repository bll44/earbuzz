@extends('layouts.master')

@section('content')

<h2>streams.index</h2>
<h1>Streams Live Now</h1>

@if(count($live_artists) > 0)
	<ul class="list-group">
		@foreach($live_artists as $artist)
		<li class="list-group-item">{{ link_to_route('live.show', $artist->displayname, ['id' => $artist->id]) }}</li>
		@endforeach
	</ul>
@else

<h3>No Live Streams Available</h3>

@endif

@stop
