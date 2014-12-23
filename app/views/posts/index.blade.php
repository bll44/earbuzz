@extends('layouts/master')

@section('content')

<h1>posts.index</h1>

@if($artists->count())

<div class="alert alert-danger" role="alert">
	Make Sure Artist Has Genre
</div>

@foreach(array_chunk($genres->all(), 2) as $row)

	@foreach($row as $genre)

		<p>
			<!-- if artist has genre they will show up here -->
			@foreach ($artists as $artist)
			@if($artist->genre_id === $genre->id)
			<h3>{{ $genre['name'] }}</h3>
			<a href="http://localhost:8080/profile/{{ $artist->name }}">{{ $artist->name }}</a>
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
			@endif
			@endforeach
		</p>

	@endforeach

@endforeach

<!-- @foreach(array_chunk($artists->all(), 4) as $row)

<div class="row">
	@foreach($row as $artist)
	<div class="col-md-3">
		<a href="http://localhost:8080/profile/{{ $artist->name }}">{{ $artist->name }}</a>
		<p>
			{{ $artist->genre['name'] }}
		</p>
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

@endforeach -->

@else

<p>No favorites!</p>

@endif

@stop