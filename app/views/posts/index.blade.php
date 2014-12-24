@extends('layouts/master')

@section('content')

<h1>posts.index</h1>

<div class="artist-list-container">
	@foreach($artists as $artist)
	<div class="well">
		<p>Name: {{ link_to_route('profile.show', $artist->name, [$artist->user->username]) }}</p>
		<p>Genre: {{ $artist->genre->name }}</p>
		<div>
			<button type="button" class="btn btn-default follow-artist-btn">Follow Artist</button>
			{{ link_to_route('profile.show', 'View Artist Profile', [$artist->user->username], ['class' => 'btn btn-primary']) }}
		</div>
	</div>
	@endforeach
</div>
<!-- /.artist-list-container -->

@stop

@section('scripts')
<script>

</script>
@stop