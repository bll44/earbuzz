<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<!-- edit for live stripe key -->
	<meta name="test_publishable_key" content="{{ Config::get('stripe.test_publishable_key') }}">
</head>
@include('layouts/partials/header')
<body>
	<div class="container">
		@include('layouts/partials/navbar')
		@if (Session::has('flash_message'))
		<div class="form-group">
			<p>{{ Session::get('flash_message')}}</p>
		</div>
		@endif
		@yield('content')
		<div class="row">
			@include('layouts/partials/footer')
		</div>
	</div>
	<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Click to return on the top page" data-toggle="tooltip" data-placement="left"><span class="glyphicon glyphicon-chevron-up"></span></a>

	@yield('scripts')
	<script type="text/javascript">
	// back to top scroll
	$(document).ready(function(){
		$(window).scroll(function () {
			if ($(this).scrollTop() > 50) {
				$('#back-to-top').fadeIn();
			} else {
				$('#back-to-top').fadeOut();
			}
		});
        // scroll body to 0px on click
        $('#back-to-top').click(function () {
        	$('#back-to-top').tooltip('hide');
        	$('body,html').animate({
        		scrollTop: 0
        	}, 800);
        	return false;
        });

        $('#back-to-top').tooltip('show');

    });
	</script>
	<!-- Javascript library for home page Live Now carousel -->
	<script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.3.7/slick.min.js"></script>
</body>
</html>