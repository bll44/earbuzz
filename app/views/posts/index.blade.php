@extends('layouts/master')

@section('content')

<h1>posts.index</h1>


@foreach($artists as $artist)
<div class="panel">
<h2>{{ $artist->name }}</h2>
<p>{{ link_to_route('profile.show', 'view artist profile', [$artist->user->username]) }}</p>
<button type="button" class="follow-artist-btn">Follow Artist</button>
@if(null !== $artist->genre)
<p>Genre: {{ $artist->genre->name }}</p>
@endif
</div>
@endforeach

@stop
