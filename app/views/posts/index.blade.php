@extends('layouts/master')

@section('content')

<h1>posts.index</h1>

@if($artists->count())

@foreach(array_chunk($artists->all(), 4) as $row)

<div class="row">
	@foreach($row as $artist)
	<div class="col-md-3">
		<h2>{{ $artist->name }}</h2>
		@if(Auth::check())

		@if($favorited = in_array($artist->id, $favorites))
		{{ Form::open(['method' => 'DELETE', 'route' => ['favorites.destroy', $artist->id]]) }}
		@else
		{{ Form::open(['route' => 'favorites.store']) }}
		{{ Form::hidden('post-id', $artist->id) }}
		@endif

		<button class="btn-clear" type="submit">
			<i class="fa fa-heart {{ $favorited ? 'favorited' : 'not-favorited' }}"></i>
		</button>

		{{ Form::close() }}

		@endif
	</div>
	@endforeach
</div>

@endforeach

@else

<p>No favorites!</p>

@endif

@stop