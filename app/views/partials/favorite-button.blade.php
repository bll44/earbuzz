@if(Auth::check())

@if($favorited = in_array($post->id, $favorites))
{{ Form::open(['method' => 'DELETE', 'route' => ['favorites.destroy', $post->id]]) }}
@else
{{ Form::open(['route' => 'favorites.store']) }}
{{ Form::hidden('post-id', $post->id) }}
@endif

<button class="btn-clear" type="submit">
	<i class="fa fa-heart {{ $favorited ? 'favorited' : 'not-favorited' }}"></i>
</button>

{{ Form::close() }}

@endif

<a class="btn btn-danger btn-xs star-rating" data-rating="4.33">
	<i class="fa fa-star" data-prev-rating-class="fa fa-star"></i>
	<i class="fa fa-star" data-prev-rating-class="fa fa-star"></i>
	<i class="fa fa-star" data-prev-rating-class="fa fa-star"></i>
	<i class="fa fa-star" data-prev-rating-class="fa fa-star"></i>
	<i class="fa fa-star-half-full" data-prev-rating-class="fa fa-star-half-full"></i>
</a>

<script type="text/javascript">
$(document).ready(function () {
	$('.star-rating i').hover(function () {
		$(this).prevAll().removeClass('fa-star-o fa-star-half-full').addClass('fa-star');
		$(this).removeClass('fa-star-o fa-star-half-full').addClass('fa-star');
		$(this).nextAll().addClass('fa-star-o').removeClass('fa-star fa-star-half-full');
	}, function () {
        //
    });

	$('.star-rating').hover(function () {
        //
    }, function () {
    	$(this).children('i').each(function () {
    		$(this).removeClass('fa-star-o fa-star-half-full')
    		$(this).attr('class', $(this).attr('data-prev-rating-class'));
    	});
    });
});
</script>