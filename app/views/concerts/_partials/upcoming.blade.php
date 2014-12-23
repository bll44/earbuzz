<h3>Upcoming</h3>
<div class="upcoming-shows-container">

<!-- upcoming show ul -->
<ul class="media-list col-lg-9">
@foreach($concerts as $concert)

<!-- border is temporary until design looks better -->
<li class="media" style="border: 1px solid black">
	<a class="media-left" href="#">
		<img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PGRlZnMvPjxyZWN0IHdpZHRoPSI2NCIgaGVpZ2h0PSI2NCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjEzLjQ2MDkzNzUiIHk9IjMyIiBzdHlsZT0iZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQ7ZG9taW5hbnQtYmFzZWxpbmU6Y2VudHJhbCI+NjR4NjQ8L3RleHQ+PC9nPjwvc3ZnPg==" alt="empty thumbnail">
	</a>
	<div class="media-body">
		<h4 class="media-heading">{{ $concert->artist->name }}</h4>
		<hr>
		<p><strong>{{ $concert->getShowDate() }}</strong></p>
		<p>Starts streaming at {{ $concert->getStreamTime() }}</p>
		<div>
			<a href="#" class="btn btn-primary">Start Streaming</a>
		</div>
	</div>
</li>

@endforeach
</ul><!-- /.media-list -->

</div><!-- /.upcoming-shows-container -->