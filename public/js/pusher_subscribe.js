// global notification
(function() {

	// Open a connection, and subscribe to the demo channel.
	var pusher = new Pusher('999a6964f87015288a65');
	var channels = {};
	// channels.demo = pusher.subscribe('demo');

	$('meta[name=channel]').each(function() {
		var value = $(this).attr('content');
		channels[value] = pusher.subscribe(value);
	});

	// Namespacing
	window.App = {};
	App.Listeners = {};

	// Notifier
	App.Notifier = function() {
		this.notify = function(message) {
			var template = Handlebars.compile($('#flash-template').html());

			$(template({ message: message}))
				.appendTo('#temp-notification-spot')
				.fadeIn(300)
				.delay(5000)
				.fadeOut(300, function() { $(this).remove(); });
		}
	};

	// Listeners
	App.Listeners.Post = {
		whenPostWasPublished: function(data) {
			(new App.Notifier).notify(data.title);
		}
	};

	// Register bindings
	// channel.bind('PostWasPublished', App.Listeners.Post.whenPostWasPublished);
	for(var x in channels)
	{
		channels[x].bind('PostWasPublished', App.Listeners.Post.whenPostWasPublished);
	}

})();