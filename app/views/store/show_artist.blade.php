@extends('layouts.master')

@section('content')

<h2>{{ $artist->name }}</h2>
<div class="music-listing-container">

@foreach($music->albums as $album => $data)
<div class="album">
	<h3>{{ $data['album']->name }}</h3>
	<p>{{ link_to_route('store.album.purchase', 'Buy Album', [$data['album']->id]) }}</p>
	<table class="table table-striped">
		<thead>
			<th>No.</th>
			<th>Name</th>
			<th>Time</th>
			<th>Artist</th>
			<th>Album</th>
			<th>Year</th>
			<th>Download</th>
		</thead>
		<tbody>
		<?php $i = 1 ?>
		@foreach($data['tracks'] as $track)
			<tr>
				<td>{{ $i }}</td>
				<td>{{ $track->name }}</td>
				<td>{{ $track->getHMSString() }}</td>
				<td>{{ $artist->name }}</td>
				<td>{{ $album }}</td>
				<td>{{ $track->album->year }}</td>
				<td>
					{{ link_to('#', 'Buy $' . $track->price,
							  ['class' => 'btn btn-sm btn-default track-purchase-link',
							   'data-track-id' => $track->id]) }}
				</td>
			</tr>
		<?php $i++ ?>
		@endforeach
		</tbody>
	</table>
	<!-- /.table -->
</div>
<!-- /.album -->
@endforeach

</div>
<!-- /.music-listing-container -->

<div id="cc-modal" class="reveal-modal" data-reveal>
	<h2>Payment Information</h2>
	<p class="lead">Please enter your credit card information to continue with this purchase.</p>
	<p>
		Your credit card information will never be saved on our servers. We store credit cards with a secure third party to ensure that your credit card can never be stolen from us.
	</p>
	{{ Form::open(['id' => 'credit-card-form']) }}
	<div class="row">
		<div class="large-6 columns">
			<label>Card Number
				<input type="text" data-stripe="number">
			</label>
		</div>
		<!-- /.large 6 columns -->
	</div>
	<!-- /.row -->
	<div class="row">
		<div class="large-2 columns">
			<label>CVC Code
				<input type="text" data-stripe="cvc">
			</label>
		</div>
		<!-- /.large 2 columns -->
	</div>
	<!-- /.row -->
	<div class="row">
		<div class="large-4 columns">
			<label>Expiration Date
				{{ Form::selectMonth(null, null, ['data-stripe' => 'exp-month']) }}
				{{ Form::selectYear(null, date('Y'), date('Y') + 1, null, ['data-stripe' => 'exp-year']) }}
			</label>
		</div>
		<!-- /.large 4 columns -->
	</div>
	<div class="row">
		<div class="large-8 columns">
			<input id="save-payment-info-checkbox" name="save-payment-info" type="checkbox">
			<label for="checkbox1">Save payment information for later</label>
		</div>
		<!-- /.large 8 columns -->
	</div>
	<!-- /.row -->
	<div class="row">
		<div class="large-12 columns">
			<a href="#">How is my information secure?</a>
		</div>
		<!-- /.large 12 columns -->
	</div>
	<!-- /.row -->
	<div class="row">
		<div class="large-4 columns">
			{{ Form::submit('Buy Now', ['class' => 'button']) }}
		</div>
		<!-- /.lg 4 columns -->
	</div>
	<!-- /.row -->
	{{ Form::close() }}
	<a class="close-reveal-modal">&#215;</a>
</div>

@stop

@section('scripts')

<script>

$('.track-purchase-link').click(function(event) {
	event.preventDefault();

	$.ajax({
		url: "{{ URL::route('stripe.is_customer') }}",
		type: 'GET',
		dataType: 'json'
	}).done(function(data) {
		if( ! data.status)
		{
			$('#cc-modal').foundation('reveal', 'open');

		}
	});
});

</script>

@stop