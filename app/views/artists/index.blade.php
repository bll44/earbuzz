@extends('layouts.master')


@section('content')

@foreach($artists as $artist)

<p>{{ link_to_route('artists.show', $artist->name, ['id' => $artist->id]) }}</p>

@endforeach

@stop