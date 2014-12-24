@extends( Request::ajax() ? 'layouts.modal' : 'layouts.master' )


@section('content')

<h2>registration.profile_selection</h2>

<h1>REGISTRATION</h1>
<p>Please select your profile type</p>

<div class="btn-group btn-group-justified" role="group" aria-label="...">
  <div class="btn-group" role="group">
    <button type="button" class="btn btn-default">{{ link_to_route('register.artist', 'Artist', null, null) }}</button>
  </div>
  <div class="btn-group" role="group">
    <button type="button" class="btn btn-default">{{ link_to_route('register.fan', 'Fan', null, null) }}</button>
  </div>
</div>

@stop