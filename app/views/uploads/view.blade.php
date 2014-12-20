@extends('layouts/master')

@section('content')

<h1>uploads.view</h1>

<img src="{{{ asset('img/upload/'.$name) }}}" alt="">
@stop