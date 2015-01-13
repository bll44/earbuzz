<nav class="eb-primaryNav top-bar" data-topbar role="navigation">

	<!-- Logo -->
	<ul class="title-area">
		<li class="name">
			<h1>
				<a href="{{ URL::to('/') }}" id="logo">
				{{ HTML::image('/img/earbuzz-logo-trans.png', 'EARBUZZ') }}
					<!-- <img src="/img/earbuzz-logo.png" alt="EARBUZZ" /> -->
					<span>EarBuzz</span>
				</a>
				<!-- {{ link_to('/', 'EarBuzz', ['id' => 'logo']) }} -->
			</h1>
		</li>
	</ul>

	<!-- Primary Navigation -->
	<section class="top-bar-section">
		<!-- Right Nav Section -->
		<ul class="right">
			<li class="has-dropdown">
				<a href="#">Discover</a>
				<ul class="dropdown">
					{{--<li>
						{{ link_to('shows', 'Shows', ['class' => 'page']) }}
					</li>--}}
					<li>
						{{ link_to('browse', 'Artist', ['class' => 'page']) }}
					</li>
				</ul>
			</li>
			<!-- <li><a href="#">Features</a></li> -->

			@if (Auth::guest())

				<!-- <li class="register">{{ link_to('register/create', 'Register', ['class' => 'page', 'data-reveal-id' => 'loginModal', 'data-reveal-ajax' => 'true']) }}</li> -->
				<li>{{ link_to('/register/profile', 'Sign Up', ['class' => 'page', 'data-reveal-id' => 'loginModal', 'data-reveal-ajax' => 'true']) }}</li>
				<!-- <li class="logIn">{{ link_to('login', 'Log In', ['class' => 'page small', 'data-reveal-id' => 'loginModal', 'data-reveal-ajax' => 'true']) }}</li> -->
				<li>{{ link_to('login', 'Sign In', ['class' => 'page', 'data-reveal-id' => 'loginModal', 'data-reveal-ajax' => 'true']) }}</li>


				<div id="loginModal" class="reveal-modal small" data-reveal></div>
				<div id="step2Modal" class="reveal-modal small" data-reveal></div>
			@else
				<li>{{ link_to('live', 'Live Now') }}</li>
				<li class="has-dropdown user">
					{{ link_to_profile( Auth::user()->username ) }}
					<ul class="dropdown">
						<li>{{ link_to_profile('Profile') }}</li>
						@if(Auth::check() && Auth::user()->type === 'artist')

						<li>{{ link_to_route('concert.create', 'My Concerts') }}</li>
						<li>{{ link_to('recent_streams', 'Recent Streams', ['class' => 'page']) }}</li>

						@endif
						{{--<li>{{ link_to_route('uploads.music.create', 'Upload', null, ['class' => 'page']) }}</li>--}}
						<li>{{ link_to_route('account.show', 'Account', ['id' => Auth::user()->id], ['class' => 'page']) }}</li>
						<li>{{ link_to_route('messages', 'Inbox', ['id' => Auth::user()->id], ['class' => 'page']) }}</li>
						<li>{{ link_to('logout', 'Sign Out', ['class' => 'page']) }}</li>
					</ul>
				</li>
			@endif
		</ul>

		<!-- <ul class="left">
			<li class="active"><a href="/styleguide?style=all" class="button">STYLEGUIDE</a></li>
		</ul> -->

	</section>

</nav>
