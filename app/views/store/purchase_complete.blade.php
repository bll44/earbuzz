@extends('layouts.master')

@section('content')
<meta name="package_type" content="{{ $package['type'] }}">

<div data-alert class="alert-box info radius purchase-details">
	<h1>Thank you for your purchase!</h1>
	<p>Your download should begin automatically.</p>
	@if($package['type'] === 'track')
	<p><strong>Track:</strong> {{ $package['item']->name }}</p>
	@elseif($package['type'] === 'album')
	<p><strong>Album:</strong> {{ $package['item']->name }}</p>
	@endif
	<p><strong>Price:</strong> ${{ $package['item']->price }}</p>
	<a href="#" class="close">&times;</a>
</div>
<!-- /.purchase-details alert-box -->

@stop

@section('scripts')

<script>
$(document).ready(function() {
	var package_type = $('meta[name="package_type"]').attr('content');
	console.log(package_type);
	if(package_type === 'track')
	{
		// $.ajax({
		// 	url: "{{ URL::to('download/track') }}",
		// 	type: 'GET',
		// }).done(function(data) {
		// 	console.log(data);
		// });
		window.location.replace("{{ URL::to('download/track') }}");
	}
	else if(package_type === 'album')
	{
		// $.ajax({
		// 	url: "{{ URL::to('download/album') }}",
		// 	type: 'GET',
		// }).done(function(data) {
		// 	console.log(data);
		// });

		window.location.replace("{{ URL::to('download/album') }}");
	}
});

</script>

@stop