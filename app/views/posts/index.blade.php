@extends('layouts/master')

@section('content')

<!-- <h1>posts.index</h1> -->

<div id="show-artists" class="panel">
	<div class="row">
		<h1>Artists</h1>
	</div>
	<div class="row">
		@foreach($artists as $artist)
			<div class="artist-container">
				<div class="inner">
					<h2>{{ $artist->name }}</h2>

					<!-- online status of artist -->
					@if($artist->user->status)
						<p class="label success"><i></i>Online</p>
					@else
						<p class="label secondary"><i></i>Offline</p>
					@endif

					<p>{{ link_to_route('profile.show', 'view artist profile', [$artist->user->username]) }}</p>
					<button type="button" class="follow-artist-btn">Follow Artist</button>
					@if(null !== $artist->genre)
						<p>Genre: {{ $artist->genre->name }}</p>
					@endif
				</div>
			</div>
		@endforeach
	</div>
</div>
@stop
