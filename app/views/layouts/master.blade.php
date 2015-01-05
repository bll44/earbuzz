<!DOCTYPE html>
<html lang="en">

	@include('layouts/partials/header')

<body class="{{$bodyClass or 'vHome'}} no-js">

	<div class="container row">
		<header class="contain-to-grid sticky">
			@include('layouts/partials/navigation')
		</header>

		@include('messenger.flash')

		@if (Session::has('success'))
		<div class="alert-box success">{{ Session::get('success')}}</div>
		@endif

		@if (Session::has('error'))
		<div class="alert-box alert">{{ Session::get('error')}}</div>
		@endif

		<main class="row">@yield('content')</main>
	</div>

	<footer>
		@include('layouts/partials/footer')
	</footer>

	<!-- ::INCLUDE Move to partial -->
	@include('/partials/modal')
	@include('/partials/backToTop')
	<!-- ::END INCLUDE -->

	<!-- Add core jQuery -->
	{{ HTML::script('js/vendor/jquery.js') }}
	{{ HTML::script('js/vendor/jquery.ui.js') }}

	<!-- Add Foudnation -->
	{{ HTML::script('js/foundation.min.js') }}

	<!-- Add jQuery Plugins -->
	{{ HTML::script('js/vendor/underscore.js') }}
	{{ HTML::script('js/vendor/jquery.gritter.min.js') }}
	{{ HTML::script('js/vendor/jquery.hammer.js') }}
	{{ HTML::script('js/vendor/jquery.coverflow.js') }}
	{{ HTML::script('js/vendor/jquery.magicsuggest.min.js') }}
	{{ HTML::script('js/vendor/handlebars.js') }}

	<!-- Add Custom Scripts -->
	{{ HTML::script('js/custom.js') }}
	<script src="https://js.stripe.com/v2/"></script>
	@yield('scripts')

	<script>
		$(document).foundation(); // init foudnation
	</script>

</body>
</html>
