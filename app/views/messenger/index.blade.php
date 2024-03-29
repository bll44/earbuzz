@extends('layouts.master')

@section('content')
    @if($threads->count() > 0)
        @foreach($threads as $thread)
        <?php $class = $thread->isUnread($currentUserId) ? 'alert-info' : ''; ?>
        <div class="media alert {{$class}}">
            <h4 class="media-heading">{{link_to('messages/' . $thread->id, $thread->subject)}}</h4>
            {{$thread->latestMessage()->body}}
        </div>
        @endforeach
    @else
        <p>Sorry, no threads.</p>
    @endif
    <a href="messages/create"><button>compose new msg</button></a>
@stop