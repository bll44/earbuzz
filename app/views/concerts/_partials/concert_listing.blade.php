@foreach($concerts as $c)

	<div class="panel">
		<h5>{{ $c->artist->name }}</h5>
		<p>{{ $c->description }}</p>
		@if(Auth::check() && Auth::user()->id !== $c->artist->user->id)
			<p>
				@if(in_array($c->id, $mcids))
					<button type="button" class="button success attend-concert-button" data-concert-id="{{ $c->id }}">Attending</button>
				@else
					<button type="button" class="button attend-concert-button" data-concert-id="{{ $c->id }}">Attend</button>
				@endif
			</p>
		@endif
	</div>
	<!-- /.panel -->
@endforeach
<!-- pagination links -->
{{ $concerts->links() }}
<!-- /.pagination links -->

<script>
$('.attend-concert-button').click(function() {
	var concert_id = $(this).data('concert-id');
	var element = $(this);
	$.ajax({
		url: "{{ URL::route('concert.attend') }}",
		type: 'POST',
		data: { concert: concert_id },
		dataType: 'json'
	}).done(function(data) {
		if(data.success)
		{
			element.addClass('success');
			element.text('Attending');
		}
	});
});
</script>