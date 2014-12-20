<div class="col-md-3">
	<h2>{{ $post->title }}</h2>
	<div class="body">{{ $post->body }}</div>
	@include('partials/favorite-button')
</div>