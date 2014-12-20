@extends('layouts.master')

@section('content')

<h1>Begin Subscription - $10</h1>

{{ Form::open(['id' => 'billing-form']) }}


<!-- Need Front End Validation Before Submitting-->
<div class="form-row">
	<label>
		<span>Card Number:</span>
		<input type="text" data-stripe="number">
	</label>
</div>

<div class="form-row">
	<label>
		<span>CVC:</span>
		<input type="text" data-stripe="cvc">
	</label>
</div>

<div class="form-row">
	<label>
		<span>Expiration:</span>
		{{ Form::selectMonth(null, null, ['data-stripe' => 'exp-month']) }}
		{{ Form::selectYear(null, date('Y'), date('Y') + 10, null, ['data-stripe' => 'exp-year']) }}
	</label>
</div>

<div class="form-row">
	<label>
		<span>Email Address:</span>
		<input type="email" id="email" name="email">
	</label>
</div>

{{ Form::submit('Buy Now') }}

<div class="payment-errors"></div>

{{ Form::close() }}

<script src="https://js.stripe.com/v2/"></script>
<script src="/js/billing.js"></script>

@stop
