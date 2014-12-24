@extends('layouts.master')

@section('content')

<h2>{{ $artist->name }}</h2>
<div class="music-listing-container">

@foreach($music->albums as $album => $data)
<div class="album">
	<h3>{{ $album }}</h3>
	<p>{{ link_to_route('store.album.purchase', 'Buy Entire Album', [$data['album']->id]) }}</p>
	<table class="table table-striped">
		<thead>
			<th>No.</th>
			<th>Name</th>
			<th>Time</th>
			<th>Artist</th>
			<th>Album</th>
			<th>Year</th>
			<th>Download</th>
		</thead>
		<tbody>
		<?php $i = 1 ?>
		@foreach($data['tracks'] as $track)
			<tr>
				<td>{{ $i }}</td>
				<td>{{ $track->name }}</td>
				<td>{{ $track->getHMSString() }}</td>
				<td>{{ $artist->name }}</td>
				<td>{{ $album }}</td>
				<td>{{ $track->album->year }}</td>
				<td>{{ link_to_route('store.track.purchase', 'Buy', [$track->id], ['class' => 'btn btn-sm btn-default']) }}</td>
				<!-- <td><button type="button" class="btn btn-sm btn-default">Buy $0.99</button></td> -->
			</tr>
		<?php $i++ ?>
		@endforeach
		</tbody>
	</table>
	<!-- /.table -->
</div>
<!-- /.album -->
@endforeach

</div>
<!-- /.music-listing-container -->

@stop

@section('scripts')

@stop