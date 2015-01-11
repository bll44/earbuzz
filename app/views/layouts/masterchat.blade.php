<!DOCTYPE html>
<html lang="en">

	@include('layouts/partials/header')

<body class="{{$bodyClass or 'vHome'}} no-js">

	<div class="container row">
		<header class="sticky">
			@include('layouts/partials/navigation')
		</header>

		@include('messenger.flash')

		@if (Session::has('success'))
		<div class="alert-box success">{{ Session::get('success')}}</div>
		@endif

		@if (Session::has('error'))
		<div class="alert-box alert">{{ Session::get('error')}}</div>
		@endif

		<main class="main row">@yield('content')</main>
	</div>

	<footer>
		@include('layouts/partials/footer')
	</footer>

	<!-- ::INCLUDE Move to partial -->
	@include('/partials/modal')
	<!-- ::END INCLUDE -->

	<!-- Add Foudnation -->
	{{ HTML::script('js/foundation.min.js') }}

	<!-- Add jQuery Plugins -->
	<script src="http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.1.7/underscore-min.js"></script>
	{{ HTML::script('js/vendor/jquery.gritter.min.js') }}
	{{ HTML::script('js/vendor/jquery.hammer.js') }}
	{{ HTML::script('js/vendor/jquery.coverflow.js') }}
	{{ HTML::script('js/vendor/jquery.magicsuggest.min.js') }}
	{{ HTML::script('js/vendor/handlebars.js') }}
	<script src="http://js.pusherapp.com/1.8/pusher.min.js"></script>

	<!-- Add Custom Scripts -->
	{{ HTML::script('js/custom.js') }}
	<script src="https://js.stripe.com/v2/"></script>
	@yield('scripts')

	<script>
		$(document).foundation(); // init foudnation
	</script>

</body>
</html>
