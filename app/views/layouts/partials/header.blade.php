<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<meta name="description" content="EarBuzz"/>
	<meta property="og:url" content="http://localhost/"/>
	<meta property="og:title" content="EarBuzz"/>
	<meta property="og:type" content="website"/>
	<!-- <meta property="og:image" content="screenshot.png"/> -->
	<meta property="og:description" content="EarBuzz | turning the world on its ear - again"/>
	<!-- <meta property="fb:app_id" content="#"/> -->

	<title>@yield('meta-title', 'EarBuzz')</title>

	<link rel="icon" type="image/png" href="{{{ asset('favicon.png') }}}"/>

	<link href="http://fonts.googleapis.com/css?family=Roboto:400,400italic,700,700italic" rel="stylesheet" type="text/css"/>
	<link href="http://fonts.googleapis.com/css?family=Droid+Sans+Mono" rel="stylesheet" type="text/css"/>

	<!-- <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css"/> -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css"/>
	<link rel="stylesheet" href="{{{ asset('theme/Earbuzz_v1/css/master.css') }}}">


	<!-- {{ HTML::style('css/custom.css') }} -->
	{{ HTML::style('css/vendor/magicsuggest-min.css') }}
	<!-- <link rel="stylesheet" href="{{{ asset('css/custom.css') }}}"> -->

	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->

	<!-- <script src="//code.jquery.com/jquery-1.11.0.min.js"></script> -->
	<script src="/js/vendor/modernizr.js"></script>
<!-- <script src="//code.jquery.com/jquery-1.11.0.min.js"></script> -->
	<!-- {{ HTML::script('js/custom.js') }} -->
	<!-- <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script> -->

	<!-- <link rel="stylesheet" href="{{{ asset('js/custom.js') }}}"> -->
	<!-- JW Player -->
	<script src="http://jwpsrv.com/library/fcvmRgS4EeSXrCIAC0MJiQ.js"></script>

</head>
