@extends('layouts.master')

@section('content')

<h2>concerts.create</h2>

@if(Session::has('destroy_message'))
<div class="alert alert-warning alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	{{ Session::get('destroy_message') }}
</div>
@endif

<!-- concert creation form container -->
<div class="form-container">

	{{ Form::open(['route' => 'concert.store']) }}

	<h4>Band</h4>
	<div class="row">
		<div class="col-lg-12">
			{{ Form::text('band', $artist->name, ['class' => 'form-control', 'readonly' => 'readonly']) }}
		</div>
	</div><!-- /.row -->

	<h4>Start Time</h4>
	<div class="row">

		<div class="col-lg-3">
			{{ Form::label('month', 'Month') }}
			{{ Form::selectMonth('month', $current_month) }}
			<!-- /.month select -->
		</div><!-- /.month column -->

		<div class="col-lg-2">
			<label for="day">Day</label>
			<select name="day" class="form-control">
				@for($i = 1; $i <= 31; $i++)
				@if($i != $current_day)
				<option value="{{ $i }}">{{ $i }}</option>
				@else
				<option value="{{ $i }}" selected>{{ $i }}</option>
				@endif
				@endfor
			</select><!-- /.day select -->
		</div><!-- /.day column -->

		<div class="col-lg-2">
			<label for="year">Year</label>
			{{ Form::selectYear('year', date('Y'), date('Y') + 10) }}
		</div><!-- /.year column -->

		<div class="col-lg-2">
			<label for="time">Time</label>
			{{ Form::text('time', null, ['placeholder' => 'hh:mm']) }}
		</div><!-- /.year column -->
		<div class="col-lg-2">
			<label for="ampm">AM / PM</label>
			<select name="ampm" class="form-control">
				<option value="am">am</option>
				<option value="pm">pm</option>
			</select>
		</div><!-- /.ampm column -->

	</div><!-- /.row -->

	<h4>Play for</h4>
	<div class="row">
		<div class="col-lg-12">
			<label for="duration">Hours</label>
			<select name="duration" class="form-control">
				@for($i = .5; $i <= 2.5; $i += .5)
				<option value="{{ $i }}">{{ $i }}</option>
				@endfor
			</select>
		</div>
	</div><!-- /.row -->

	<h4>Concert Description</h4>
	<div class="row">
		<div class="col-lg-12">
			{{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Description of this show (optional)']) }}
		</div>
	</div><!-- /.row -->

	<div class="row">
		<div class="col-lg-12">
			{{ Form::submit('Save & Schedule Concert', ['class' => 'btn btn-primary']) }}
		</div>
	</div><!-- /.row -->

{{ Form::close() }}

</div><!-- /.form-container -->
<!-- /.concert creation form container -->

@if($concerts->count() > 0)
<div class="concerts-container">
<h2>My Concerts</h2>
<table class="table table-striped table-hover">
<thead>
	<th>Band</th>
	<th>Starts</th>
	<!-- <th>Ends</th> -->
	<th>Actions</th>
</thead>
<tbody>
@foreach($concerts as $concert)

<tr data-concert_id="{{ $concert->id }}">
	<td>{{ Artist::find($concert->artist_id)->name }}</td>
	<td>{{ $concert->start_time }}</td>
	<!-- <td>{{ $concert->end_time }}</td> -->
	<td>
		<a href="#" data-toggle="modal" data-target="#edit-concert-modal" class="btn btn-default btn-block edit-concert-trigger" title="Edit Concert Details">
			Edit
		</a>
		<a href="{{ URL::route('concert.cancel', [$concert->id]) }}" title="Cancel Show" class="btn btn-danger btn-block">
			Cancel
		</a>
	</td>
</tr>

@endforeach
</tbody>
</table><!-- /.table -->
</div>
@endif

<!-- edit concert modal -->
<div class="modal fade" id="edit-concert-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Modal title</h4>
			</div>
			<div class="modal-body">
				<div class="edit-concert-form-container">
				{{ Form::open(['url' => '#', 'id' => 'edit-concert-form']) }}

				<h4>Band</h4>
				<div class="row">
					<div class="col-lg-12">
						{{ Form::text('band', $artist->name, ['class' => 'form-control', 'readonly' => 'readonly']) }}
					</div>
				</div><!-- /.row -->

				<h4>Start Time</h4>
				<div class="row">

					<div class="col-lg-3">
						{{ Form::label('month', 'Month') }}
						{{ Form::selectMonth('month', $current_month, ['class' => 'form-control']) }}
						<!-- /.month select -->
					</div><!-- /.month column -->

					<div class="col-lg-2">
						<label for="day">Day</label>
						<select name="day" class="form-control">
							@for($i = 1; $i <= 31; $i++)
							@if($i != $current_day)
							<option value="{{ $i }}">{{ $i }}</option>
							@else
							<option value="{{ $i }}">{{ $i }}</option>
							@endif
							@endfor
						</select><!-- /.day select -->
					</div><!-- /.day column -->

					<div class="col-lg-2">
						<label for="year">Year</label>
						<select name="year" class="form-control">
							@foreach($years as $year)
							<option value="{{ $year }}">{{ $year }}</option>
							@endforeach
						</select><!-- /.year select -->
					</div><!-- /.year column -->

					<div class="col-lg-2">
						<label for="time">Time</label>
						{{ Form::text('time', null, ['class' => 'form-control time-input', 'placeholder' => 'hh:mm']) }}
					</div><!-- /.year column -->
					<div class="col-lg-2">
						<label for="ampm">AM / PM</label>
						<select name="ampm" class="form-control">
							<option value="am">am</option>
							<option value="pm">pm</option>
						</select>
					</div><!-- /.ampm column -->

				</div><!-- /.row -->

				<h4>Play for</h4>
				<div class="row">
					<div class="col-lg-12">
						<label for="duration">Hours</label>
						<select name="duration" class="form-control">
							@for($i = .5; $i <= 2.5; $i += .5)
							<option value="{{ $i }}">{{ $i }}</option>
							@endfor
						</select>
					</div>
				</div><!-- /.row -->

				<h4>Concert Description</h4>
				<div class="row">
					<div class="col-lg-12">
						{{ Form::textarea('description', null, ['class' => 'form-control description', 'placeholder' => 'Description of this show (optional)']) }}
					</div>
				</div><!-- /.row -->

				<div class="row">
					<div class="col-lg-12">
						{{ Form::submit('Save & Schedule Concert', ['class' => 'btn btn-primary']) }}
					</div>
				</div><!-- /.row -->

				{{ Form::close() }}
				</div><!-- /.edit-concert-form-container -->
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- / edit concert modal -->

@stop

@section('scripts')

<script>

function select_option_by_value(select_options, value)
{
	$(select_options).each(function() {
		if($(this).val() == value)
		{
			$(this).attr('selected', true);
		}
	});
}

function pad_integer(number, size)
{
	var number_string = number + '';
	if(number.length < size) number_string = '0' + number;
	return number_string;
}

$('#edit-concert-form').submit(function() {
	alert('concert edited');
	return false;
});

$('.edit-concert-trigger').click(function() {
	var concert_id = $(this).closest('tr').data('concert_id');
	$.ajax({
		url: "{{ URL::to('concert/details/get') }}",
		type: 'GET',
		data: { concert_id: concert_id },
		dataType: 'json'
	}).done(function(data) {
		console.log(data);
		select_option_by_value($('#edit-concert-modal select[name="month"] option'), data.month);
		select_option_by_value($('#edit-concert-modal select[name="day"] option'), data.day);
		select_option_by_value($('#edit-concert-modal select[name="year"] option'), data.year);
		$('#edit-concert-modal .time-input').val(pad_integer(data.hours, 2) + ':' + pad_integer(data.minutes, 2));
		select_option_by_value($('#edit-concert-modal select[name="ampm"] option'), data.ampm);
		select_option_by_value($('#edit-concert-modal select[name="duration"] option'), data.duration);
		$('#edit-concert-modal .description').val(data.description);
	});
});

</script>

@stop