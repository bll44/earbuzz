@extends('layouts.master')

@section('content')
<h1>musicManager.index</h1>
<div class="music-manager-container">

@foreach($artist->albums as $album)

<div class="table-responsive">
	<div class="well" data-album_id="{{ $album->id }}" data-album_name="{{ $album->name }}">
		<h3>{{ $album->name }}</h3>
		<div class="pull-right">
			<button type="button" class="btn btn-link btn-sm edit-album-lnk" data-toggle="modal" data-target="#albumNameModal">Edit album name</button>
			<button type="button" class="btn btn-link btn-sm"><span class="text-danger">Delete this entire album</span></button>
		</div>
		<table class="table table-striped">
			<thead>
				<th>#</th>
				<th>Name</th>
				<th>Artist</th>
				<th>Year</th>
				<th>Actions</th>
			</thead>
			<tbody>
				@foreach($album->tracks as $track)

				<tr data-trackId="{{ $track->id }}">
					<td>{{ $track->number }}</td>
					<td>{{ $track->name }}</td>
					<td>{{ $track->artist->name }}</td>
					<td>{{ $track->year }}</td>
					<td>
						<button type="button" class="btn btn-link" data-toggle="modal" data-target="#albumNameModal"><i class="fa fa-edit"></i>Edit</button>
						&nbsp;&nbsp;|&nbsp;&nbsp;
						<button type="button" class="btn btn-link delete-track"><span class="text-danger"><i class="fa fa-minus-square-o"></i>Delete</span></button>
					</td>
				</tr>

				@endforeach
			</tbody>
		</table>
	</div>
	<!-- /.well -->
</div>
<!-- /.table-responsive -->

@endforeach
<!-- / album tables loop -->

</div>
<!-- /.music-manager-container -->

<!-- Modal -->
<div class="modal fade" id="albumNameModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Edit album name</h4>
			</div>
			<!-- /.modal-header -->
			<div class="modal-body">
				<input type="text" class="form-control" placeholder="Album name" id="album-name-input">
			</div>
			<!-- /.modal-body -->
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="save-album-name">Save changes</button>
			</div>
			<!-- /.modal-footer -->
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>

</script>

@stop