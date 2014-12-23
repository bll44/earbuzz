@extends('layouts/master')

@section('content')

<style>

#live-now-container {
	margin-top: 10px;
}

img.live_now_placeholder {
	width: 275px;
	height: 275px;
}

.carousel-header {
	display: inline;
	padding: 10px;
}

.clearfix {
	clear: both;
}

</style>

<div class="content">
	<h1>pages.index</h1>

	<!-- concerts/_partials/upcoming.blade.php -->
	@include('concerts/_partials/upcoming')
	<!-- /upcoming concerts partial -->

</div>

<div class="carousel-header-container text-center">
	<h1 class="carousel-header text-primary">Live Now</h1>
	<h1 class="carousel-header">Upcoming</h1>
</div>


<div class="well" id="live-now-container">
	<div class="live_now text-center clearfix">
		<div class="live_now_slide"><img src="{{ asset('img/placeholder_imgs/earbuzz1.png') }}" class="live_now_placeholder"></div>
		<div class="live_now_slide"><img src="{{ asset('img/placeholder_imgs/earbuzz2.png') }}" class="live_now_placeholder"></div>
		<div class="live_now_slide"><img src="{{ asset('img/placeholder_imgs/earbuzz3.png') }}" class="live_now_placeholder"></div>
		<div class="live_now_slide"><img src="{{ asset('img/placeholder_imgs/earbuzz1.png') }}" class="live_now_placeholder"></div>
		<div class="live_now_slide"><img src="{{ asset('img/placeholder_imgs/earbuzz2.png') }}" class="live_now_placeholder"></div>
		<div class="live_now_slide"><img src="{{ asset('img/placeholder_imgs/earbuzz3.png') }}" class="live_now_placeholder"></div>
		<div class="live_now_slide"><img src="{{ asset('img/placeholder_imgs/earbuzz1.png') }}" class="live_now_placeholder"></div>
		<div class="live_now_slide"><img src="{{ asset('img/placeholder_imgs/earbuzz2.png') }}" class="live_now_placeholder"></div>
	</div>
</div>


<?php
// $lastfm_api_key = 'ae94454236db108880591ee2b51a524b';
// $lastfm_api_secret = '8e195882ce2cc3864c2549217dc86e4d';
// $lastfm = new \Dandelionmood\LastFm\LastFm( $lastfm_api_key, $lastfm_api_secret );
// $mac = $lastfm->artist_getInfo(array('artist' => 'Mac DeMarco'));
?>

@if(Auth::check())
	@if(Auth::user()->artist !== null && Session::pull('complete_artist_info'))
	<div class="alert alert-warning">
		<h4>Complete your Artist profile</h4>
		<p><strong>Wait!</strong> Complete profile information text. Complete profile information text.</p>
		<p>
			{{ link_to_route('profile.edit_artist', 'Complete profile', [Auth::user()->id], ['class' => 'btn btn-info']) }}
			<button type="button" class="btn btn-default" data-dismiss="alert">I'll do this later</button>
		</p>
	</div><!-- /.alert -->
	@endif
@endif

<div class="content">

	@if (Auth::guest())
	<p>
		Welcome to the homepage.
	</p>

	@else
	<p>There really isn't much here yet. Why don't you check out your {{ link_to_profile() }}?</p>
	@endif
</div>

<script>

$(document).ready(function() {
	$('.live_now').slick({
		infinite: true,
		slidesToShow: 3,
		slidesToScroll: 3,
		autoplay: true,
		autoplaySpeed: 6000,
		speed: 700,
		arrows: false
	});
});

</script>

@stop