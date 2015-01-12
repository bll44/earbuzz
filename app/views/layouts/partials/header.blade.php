<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<meta name="description" content="EarBuzz"/>
	<meta name="test_publishable_key" content="{{ Config::get('stripe.test_publishable_key') }}">
	<meta property="og:url" content="http://localhost/"/>
	<meta property="og:title" content="EarBuzz"/>
	<meta property="og:type" content="website"/>
	<!-- <meta property="og:image" content="screenshot.png"/> -->
	<meta property="og:description" content="EarBuzz | turning the world on its ear - again"/>
	<!-- <meta property="fb:app_id" content="#"/> -->

	@if(Auth::check())
	<!-- pusher subscription channels -->
	@if(null !== (Auth::user()->concerts))
	@foreach(Auth::user()->concerts as $c)
	<meta name="channel" content="{{ $c->id }}"/>
	@endforeach
	@endif
	<!-- /.pusher channels -->
	@endif

	<title>@yield('meta-title', 'EarBuzz')</title>

	<link rel="icon" type="image/png" href="{{{ asset('favicon.png') }}}"/>

	<!-- <link href="http://fonts.googleapis.com/css?family=Roboto:400,400italic,700,700italic" rel="stylesheet" type="text/css"/> -->
	<!-- <link href="http://fonts.googleapis.com/css?family=Droid+Sans+Mono" rel="stylesheet" type="text/css"/> -->

	<link href='http://fonts.googleapis.com/css?family=Open+Sans:700,300,800,400' rel='stylesheet' type='text/css'>

	<!-- <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css"/> -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css"/>
	<link rel="stylesheet" href="{{{ asset('theme/Earbuzz_v1/css/master.css') }}}">

	<!-- <link rel="stylesheet" href="{{{ asset('css/vendor/jquery.gritter.css') }}}"> -->

	<!-- Private Messaging -->
	{{ HTML::style('css/vendor/magicsuggest-min.css') }}

	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->

	<!-- Modernizr -->
	{{ HTML::script('js/vendor/modernizr.js') }}
	<!-- Add core jQuery -->
	{{ HTML::script('js/vendor/jquery.js') }}
	{{ HTML::script('js/vendor/jquery.ui.js') }}

	<!-- JW Player -->
	<script src="http://jwpsrv.com/library/fcvmRgS4EeSXrCIAC0MJiQ.js"></script>

</head>
