@extends('layouts.master')

@section('content')

<h2>profile.edit_artist</h2>

{{ Form::open(['route' => ['profile.update_artist', Auth::user()->id]]) }}

<div>
{{ Form::label('band_name', 'Band Name') }}
{{ Form::text('band_name', $artist->name, ['class' => 'form-control']) }}
</div>

<div>
{{ Form::label('location', 'Location') }}
{{ Form::text('location', $profile->location, ['class' => 'form-control']) }}
</div>

<div>
{{ Form::label('genre', 'Genre') }}
{{ Form::select('genre', [$genre_select], (null !== $artist->genre) ? $artist->genre->id : null, ['class' => 'form-control']) }}
</div>

<div>
{{ Form::label('bio', 'Bio') }}
{{ Form::textarea('bio', $profile->bio, ['class' => 'form-control']) }}
</div>

<div>
{{ Form::submit('Save & Update', ['class' => 'btn btn-primary']) }}
</div>

{{ Form::close() }}

@stop