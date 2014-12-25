@extends('layouts.master')

@section('content')
    <h1>Need to reset your password?</h1>

    {{ Form::open() }}
        <div>
            {{ Form::label('email', 'Email Address:') }}
            {{ Form::email('email') }}
        </div>

        <div>
            {{ Form::submit('Reset') }}
        </div>
    {{ Form::close() }}

@stop
