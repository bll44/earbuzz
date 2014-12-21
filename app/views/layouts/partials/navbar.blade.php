<div class="navbar navbar-default" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="/">Title</a>
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar-right">
				<li>{{ link_to('/', 'Home', ['class' => 'page']) }}</li>
				@if(Auth::check() && Auth::user()->type === 'artist')
				<li>{{ link_to('recent_streams', 'Recent Streams', ['class' => 'page']) }}</li>
				@endif
				<!-- <li><a class="page" href="/">Home</a></li> -->
				<li>{{ link_to_route('live.index', 'Live', null, ['class' => 'page']) }}</li>
				@if (Auth::guest())
				<li>{{ link_to('/register/profile', 'Sign Up', ['class' => 'page']) }}</li>
				<!-- <li><a class="page" href="/register">Sign Up</a></li> -->
				<li>{{ link_to('login', 'Sign In', ['class' => 'page']) }}</li>
				<!-- <li><a class="page" href="/login">Sign In</a></li> -->
				@else
				<?php $count = Auth::user()->newMessagesCount(); ?>
				@if($count > 0)
				<li>{{ link_to('/messages', $count.' unread msgs', ['class' => 'page']) }}</li>
				@endif
				<li>{{ link_to('artists', 'Artists', ['class' => 'page']) }}</li>
				<li>{{ link_to('browse', 'Browse', ['class' => 'page']) }}</li>
				<!-- <li><a class="page" href="/browse">Browse</a></li> -->
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ Auth::user()->username }} <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li>{{ link_to('/', 'Home', ['class' => 'page']) }}</li>
						@if(Auth::user()->type === 'artist')
						<li>{{ link_to_route('concert.create', 'My Concerts', ['class' => 'page']) }}</li>
						<li>{{ link_to('recent_streams', 'Recent Streams', ['class' => 'page']) }}
						@endif
						<!-- <li><a class="page" href="/">Home</a></li> -->
						<li>{{ link_to_profile() }}</li>
						<li>{{ link_to_route('uploads.music.create', 'Upload', null, ['class' => 'page']) }}</li>
						<li>{{ link_to_route('account.show', 'Account', ['id' => Auth::user()->id], ['class' => 'page']) }}</li>
						<!-- <li><a class="page" href="/uploads/create">Upload</a></li> -->
						<!-- <li><a class="page" href="#">Recommendations</a></li> -->
						<!-- <li><a class="page" href="#">Library</a></li> -->
						<!-- <li><a class="page" href="#">Events</a></li> -->
						<!-- <li><a class="page" href="#">Friends</a></li> -->
						<li>{{ link_to_route('messages', 'Inbox', ['id' => Auth::user()->id], ['class' => 'page']) }}</li>
						<li class="divider"></li>
						<!-- <li><a class="page" href="#">Help</a></li> -->
						<!-- <li class="divider"></li> -->
						<!-- <li><a class="page" href="#">Settings</a></li> -->
						<!-- <li><a class="page" href="#">Subscribe</a></li> -->
						<li>{{ link_to('logout', 'Sign Out', ['class' => 'page']) }}</li>
						<!-- <li><a class="page" href="/logout">Sign Out</a></li> -->
					</ul>
				</li>
				@endif
			</ul>
		</div>
	</div>
</div>
<noscript>
	<div class="alert alert-warning"><i class="fa fa-warning"></i>Tuned requires JavaScript to function properly!</div>
</noscript>
