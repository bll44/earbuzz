
<!-- edit concert modal -->
<div id="edit-concert-modal" class="reveal-modal" data-reveal>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Edit Concert...</h4>
                <a class="close-reveal-modal">&#215;</a>
				<!-- <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> -->
			</div>
			<div class="modal-body">
				<div class="edit-concert-form-container">
				{{ Form::open(['url' => '#', 'id' => 'edit-concert-form']) }}

				<h4>Band</h4>
				<div class="row">
					<div class="col-lg-12">
						{{ Form::text('band', $artist->name, ['class' => 'form-control', 'readonly' => 'readonly']) }}
					</div>
				</div><!-- /.row -->

				<h4>Start Time</h4>
				<div class="row">

					<div class="col-lg-3">
						{{ Form::label('month', 'Month') }}
						{{ Form::selectMonth('month', $current_month, ['class' => 'form-control']) }}
						<!-- /.month select -->
					</div><!-- /.month column -->

					<div class="col-lg-2">
						<label for="day">Day</label>
						<select name="day" class="form-control">
							@for($i = 1; $i <= 31; $i++)
							@if($i != $current_day)
							<option value="{{ $i }}">{{ $i }}</option>
							@else
							<option value="{{ $i }}">{{ $i }}</option>
							@endif
							@endfor
						</select><!-- /.day select -->
					</div><!-- /.day column -->

					<div class="col-lg-2">
						<label for="year">Year</label>
						<select name="year" class="form-control">
							@foreach($years as $year)
							<option value="{{ $year }}">{{ $year }}</option>
							@endforeach
						</select><!-- /.year select -->
					</div><!-- /.year column -->

					<div class="col-lg-2">
						<label for="time">Time</label>
						{{ Form::text('time', null, ['class' => 'form-control time-input', 'placeholder' => 'hh:mm']) }}
					</div><!-- /.year column -->
					<div class="col-lg-2">
						<label for="ampm">AM / PM</label>
						<select name="ampm" class="form-control">
							<option value="am">am</option>
							<option value="pm">pm</option>
						</select>
					</div><!-- /.ampm column -->

				</div><!-- /.row -->

				<h4>Play for</h4>
				<div class="row">
					<div class="col-lg-12">
						<label for="duration">Hours</label>
						<select name="duration" class="form-control">
							@for($i = .5; $i <= 2.5; $i += .5)
							<option value="{{ $i }}">{{ $i }}</option>
							@endfor
						</select>
					</div>
				</div><!-- /.row -->

				<h4>Concert Description</h4>
				<div class="row">
					<div class="col-lg-12">
						{{ Form::textarea('description', null, ['class' => 'form-control description', 'placeholder' => 'Description of this show (optional)']) }}
					</div>
				</div><!-- /.row -->

				<div class="row">
					<div class="col-lg-12">
						{{ Form::submit('Save & Schedule Concert', ['class' => 'button']) }}
					</div>
				</div><!-- /.row -->

				{{ Form::close() }}
				</div><!-- /.edit-concert-form-container -->
			</div>
			<!-- <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div> -->
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- / edit concert modal -->
