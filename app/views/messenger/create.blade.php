@if(isset($_GET['to']))
<?php
$user_exists = DB::table('users')
    ->where('username', '=', $_GET['to'])
    ->first();
?>
@else
<?php
$user_exists = null;
?>
@endif

@extends('layouts.master')

@section('content')
<h1>Create a new message</h1>
{{Form::open(['route' => 'messages.store'])}}
<div class="col-md-6">
	<!-- To Form Input -->
	<div class="input-group form-group">
		{{ Form::label('to', 'To') }}
		{{ Form::text('recipients[]', null, array('class' => 'form-control','id' => 'ms')) }}
	</div>

	<!-- Subject Form Input -->
	<div class="form-group">
		{{ Form::label('subject', 'Subject', ['class' => 'control-label']) }}
		{{ Form::text('subject', null, ['class' => 'form-control']) }}
	</div>

	<!-- Message Form Input -->
	<div class="form-group">
		{{ Form::label('message', 'Message', ['class' => 'control-label']) }}
		{{ Form::textarea('message', null, ['class' => 'form-control']) }}
	</div>

	<!-- Submit Form Input -->
	<div class="form-group">
		{{ Form::submit('Submit', ['class' => 'btn btn-primary form-control']) }}
	</div>
</div>
{{Form::close()}}

@endsection

@section('scripts')
<script>
$(function() {

    $('#ms').magicSuggest({
    	allowFreeEntries: false,
    	required: true,
        data: "/api/search/",
        @if(is_null($user_exists))
        @else
        value: [{{ $user_exists->id }}],
        @endif
        valueField: 'id',
        displayField: 'username'
    });

});
// var movies = new Bloodhound({
//     datumTokenizer: function (datum) {
//         return Bloodhound.tokenizers.whitespace(datum.value);
//     },
//     queryTokenizer: Bloodhound.tokenizers.whitespace,
//     remote: {
//         url: 'http://localhost:8080/api/search/%QUERY',
//         // url: 'http://api.themoviedb.org/3/search/movie?query=%QUERY&api_key=470fd2ec8853e25d2f8d86f685d2270e',
//         filter: function (movies) {
//             // Map the remote source JSON array to a JavaScript object array
//             return $.map(movies.results, function (movie) {
//                 return {
//                     value: movie.original_title
//                 };
//             });
//         }
//     }
// });

// // Initialize the Bloodhound suggestion engine
// movies.initialize();

// // Instantiate the Typeahead UI
// $('.typeahead').typeahead(null, {
//     displayKey: 'value',
//     source: movies.ttAdapter()
// });

// var bestPictures = new Bloodhound({
//   datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
//   queryTokenizer: Bloodhound.tokenizers.whitespace,
//   remote: 'http://localhost:8080/api/search/%QUERY'

// });

// bestPictures.initialize();

// $('.typeahead').typeahead(null, {
//   name: 'username',
//   displayKey: 'value',
//   source: bestPictures.ttAdapter()
// });

// My failings
    // $('.typeahead').typeahead([
    //     {
    //         name: 'username',
    //         remote: {{URL::to("/api/search/%USERNAME")}}
    //     }
    // ]);
</script>
@endsection
@stop
