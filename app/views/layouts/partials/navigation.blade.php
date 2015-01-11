<nav class="eb-primaryNav top-bar" data-topbar role="navigation">

	<!-- Logo -->
	<ul class="title-area">
		<li class="name">
			<h1>
				{{ link_to('/', 'EarBuzz', ['id' => 'logo']) }}
			</h1>
		</li>
	</ul>

	<!-- Primary Navigation -->
	<section class="top-bar-section">
		<!-- Right Nav Section -->
		<ul class="right">
			<li class="has-dropdown">
				<a href="#">Browse</a>
				<ul class="dropdown">
					<li>
						<a href="">Featured</a>
					</li>
					<li>
						<a href="">Shows</a>
					</li>
					<li>
						{{ link_to('browse', 'Discover', ['class' => 'page']) }}
					</li>
				</ul>
			</li>
			<li>{{ link_to('live', 'Live Now') }}</li>
			<!-- <li><a href="#">Features</a></li> -->

			@if (Auth::guest())

				<!-- <li class="register">{{ link_to('register/create', 'Register', ['class' => 'page', 'data-reveal-id' => 'loginModal', 'data-reveal-ajax' => 'true']) }}</li> -->
				<li>{{ link_to('/register/profile', 'Sign Up', ['class' => 'page', 'data-reveal-id' => 'loginModal', 'data-reveal-ajax' => 'true']) }}</li>
				<!-- <li class="logIn">{{ link_to('login', 'Log In', ['class' => 'page small', 'data-reveal-id' => 'loginModal', 'data-reveal-ajax' => 'true']) }}</li> -->
				<li>{{ link_to('login', 'Sign In', ['class' => 'page', 'data-reveal-id' => 'loginModal', 'data-reveal-ajax' => 'true']) }}</li>


				<div id="loginModal" class="reveal-modal small" data-reveal></div>
			@else
				<li class="has-dropdown">
					{{ link_to_profile( Auth::user() -> username ) }}
					<ul class="dropdown">
						<li>{{ link_to_profile('Profile') }}</li>
						@if(Auth::check() && Auth::user()->type === 'artist')

						<li>{{ link_to_route('concert.create', 'My Concerts', ['class' => 'page']) }}</li>
						<li>{{ link_to('recent_streams', 'Recent Streams', ['class' => 'page']) }}</li>

						@endif
						<li>{{ link_to_route('uploads.music.create', 'Upload', null, ['class' => 'page']) }}</li>
						<li>{{ link_to_route('account.show', 'Account', ['id' => Auth::user()->id], ['class' => 'page']) }}</li>
						<li>{{ link_to_route('messages', 'Inbox', ['id' => Auth::user()->id], ['class' => 'page']) }}</li>
						<li>{{ link_to('logout', 'Sign Out', ['class' => 'page']) }}</li>


						<!-- <li><a href="">Artist Dashboard</a></li> -->
						<!-- <li><a href="">Activity</a></li> -->
						<!-- <li><a href="">Purchased Music</a></li> -->
						<!-- wrap in an conditional -->
						<li><a href="" class="active">Go Pro!</a></li>
					</ul>
				</li>

			@endif
		</ul>

		<ul class="left">
			<li class="active"><a href="/styleguide?style=all" class="button">STYLEGUIDE</a></li>
		</ul>

	</section>

</nav>
