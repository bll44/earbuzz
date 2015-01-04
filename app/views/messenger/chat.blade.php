@extends('layouts/master')

@section('content')

@include('messenger.flash')

<div class="content">
	<h1>messenger.chat</h1>
</div>

<div class="content">
	<div id="container">
		<section class="notify">
			<div class="row show-grid">
				<div class="span4 offset1">
					<p>Just enter some text into the <code>textarea</code> and click the 'Notify'.</p>
				</div>
				<div class="span4 offset1">
					<textarea id="notifyMessage">HTML5 Realtime Push Notification</textarea><br />
					<button class="button">Notify</button>
				</div>
			</div>
		</section>
	</div>
</div>

@stop

@section('scripts')
<script src="http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.1.7/underscore-min.js"></script>
<script src="//js.pusher.com/2.2/pusher.min.js" type="text/javascript"></script>
@stop