@extends('layouts/master')

@section('content')

<div class="content">

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


	<div id="eb-featured" class="row">
		<div id="coverflow" class="large-12 columns">
			<div>
				<img src="http://placehold.it/920x460&text=0" />
			</div>

			<div data-active="true">
				<img src="http://placehold.it/920x460&text=1" />
				<div class="info">
					<h3 class="name">Artist Name</h3>
					<h4 class="genre">Genre: [genre]</h4>
				</div>
			</div>

			<div>
				<img src="http://placehold.it/920x460&text=2" />
			</div>

			<div>
				<img src="http://placehold.it/920x460&text=3" />
			</div>

			<div>
				<img src="http://placehold.it/920x460&text=4" />
			</div>
		</div>
	</div>


	<div class="row panel">
		<div id="upcoming" class="large-8 columns">
			Upcoming
			@include('concerts/_partials/concert_listing')
		</div>
		<div id="trending" class="large-4 columns">
			Trending
		</div>
	</div>


</div>

@stop
