@extends('layouts/master')

@section('content')

<div class="content">
	<h1>messenger.chat</h1>
</div>

<div class="content">

	@if (Auth::guest())
	@else

<?php

$CONFIG = array(
    'KEY' => '999a6964f87015288a65',
    'SECRET' => 'ee1d6acc6f9f8dfdf94c',
    'APPID' => '80855'
);

$room = 'laravel_test';
$nick = Auth::user()->username;

$pusher = new Pusher($CONFIG['KEY'], $CONFIG['SECRET'], $CONFIG['APPID']);

if (!empty($_POST)
    && array_key_exists('channel', $_POST)
    && array_key_exists('user', $_POST)
    && array_key_exists('content', $_POST)
) {
    $pusher->trigger($_POST['channel'], 'message-created', array(
        'user' => $_POST['user'],
        'content' => $_POST['content']
    ));
    echo "Success";
    exit();
}
?>



<!doctype html>
<html>
    <head>
        <title>Test Chatroom</title>
        <!-- <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script> -->
        <script src="http://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.1.7/underscore-min.js"></script>
        <script src="http://js.pusherapp.com/1.8/pusher.min.js"></script>
        <style type="text/css">
            #messageform {
                display: none;
            }
            span.user {
                color: green;
                font-weight: bold;
            }
        </style>
        <script type="text/javascript">
            var CHANNEL = '{{ $room }}';
        </script>
    </head>
    <body>
        <div id="container">
            <div id="chatroom">
            </div>
            <div id="messageform">
                <!-- change this according to your deploy url -->
                {{Form::open(array('route' => 'post.chat', 'id'=>'newmessage'))}}
                <!-- <form action="/testchat/index.php" method="POST" id="newmessage"> -->
                    <input type="text" id="message" name="message" />
                    <input type="hidden" id="user" name="user" value="<?= $nick ?>" />
                    <button name="submit" id="submit" type="submit">Post</button>
                </form>
                {{Form::close()}}
            </div>
            <div id="waiting">
                Waiting to establish connection ...
            </div>
            <!-- change this according to your deploy url -->
            <script>


$(function() {
    var PUSHER = {
        KEY: '999a6964f87015288a65'
    };

    var messageForm = $('#newmessage'),
        messageFormDisplay = $('#messageform'),
        message = $('#message'),
        user = $('#user'),
        messageTemplate = _.template(
            '<p><span class="user"><%= user %></span>: <span><%= content %></span></p>'),
        chatContent = $('#chatroom'),
        // pusher channels
        pusher = new Pusher(PUSHER.KEY),
        socketId = 0,
        chatChannel = pusher.subscribe(CHANNEL);

    socketId = pusher.bind('pusher:connection_established',
        function(ev) {
            socketId = ev.socket_id;
            $('#waiting').hide();
            messageFormDisplay.show();

            // perform all bindings here
            chatChannel.bind('message-created', function(message) {
                console.log(message);
                chatContent.append(messageTemplate({
                    user: message.user,
                    content: message.content
                }));
            });

            messageForm.submit(function(e) {
                e.preventDefault();
                var content = message.val();
                if (content.length > 0) {
                    $.post(messageForm.attr('action'), {
                        user: user.val(),
                        content: content,
                        channel: CHANNEL
                    });
                }
                message.val('').focus();
                return false;
            });
        }
    );
});



            </script>
        </div>
    </body>
</html>






	<p></p>
	@endif
</div>

@stop