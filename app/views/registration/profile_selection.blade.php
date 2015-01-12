@extends( Request::ajax() ? 'layouts.modal' : 'layouts.master' )


@section('content')

<div class="sign-up">
    <h1>Welcome To EarBuzz!</h1>
    <hr/>
    <p>Please select your profile type</p>

    <div class="btn-group btn-group-justified" role="group" aria-label="...">
      <div class="btn-group" role="group">
      </div>
      <div class="btn-group" role="group">
      </div>
        {{ link_to_route('register.artist', 'Artist', null, ['class' => 'button alt', 'data-reveal-id' => 'step2Modal', 'data-reveal-ajax' => 'true']) }}
        {{ link_to_route('register.fan', 'Fan', null, ['class' => 'button alt', 'data-reveal-id' => 'step2Modal', 'data-reveal-ajax' => 'true']) }}
    </div>
</div>

@stop
