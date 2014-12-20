@extends('layouts/master')

@section('content')

<h1>posts.index</h1>

@if($posts->count())

@foreach(array_chunk($posts->all(), 4) as $row)

<div class="row">
	@foreach($row as $post)
		@include('posts/partials/post')
	@endforeach
</div>

@endforeach

@else

<p>You have no favorites!</p>

@endif

@stop