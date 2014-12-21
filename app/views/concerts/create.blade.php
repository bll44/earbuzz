@extends('layouts.master')

@section('content')

<h2>concerts.create</h2>

<div class="form-container">

{{ Form::open(['route' => 'concert.store']) }}

<div>
{{ Form::text('band', $artist->name, ['class' => 'form-control', 'readonly' => 'readonly']) }}
</div>

<div>
{{ Form::label('start_time', 'Start time') }}
{{ Form::text('start_time', null, ['class' => 'form-control', 'placeholder' => 'YYYY-MM-DD HH:MM:SS']) }}
</div>

<div>
	<label for="duration">Play for</label>
	<select name="duration" class="form-control">
	@for($i = .5; $i <= 2.5; $i += .5)
	<option value="{{ $i }}">{{ $i . ' hours' }}</option>
	@endfor
	</select>
</div>

<div>
{{ Form::label('description', 'Concert Description') }}
{{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Description of this show (optional)']) }}
</div>

{{ Form::submit('Save & Schedule Concert', ['class' => 'btn btn-primary']) }}

{{ Form::close() }}

</div><!-- /.form-container -->

@if($concerts->count() > 0)
<div class="concerts-container">
<h2>My Concerts</h2>
<table class="table table-striped table-hover">
<thead>
	<th>Band</th>
	<th>Starts</th>
	<th>Ends</th>
	<th>Actions</th>
</thead>
<tbody>
@foreach($concerts as $concert)

<tr>
	<td>{{ Artist::find($concert->artist_id)->name }}</td>
	<td>{{ $concert->start_time }}</td>
	<td>{{ $concert->end_time }}</td>
	<td>
		{{ link_to_route('concert.edit', 'Edit', [$concert->id], ['class' => 'btn btn-default']) }}
		{{ link_to_route('concert.destroy', 'Cancel', [$concert->id], ['class' => 'btn btn-danger']) }}
	</td>
</tr>

@endforeach
</tbody>
</table><!-- /.table -->
</div>
@endif

@stop