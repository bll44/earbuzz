// global notification
(function() {

	// Open a connection, and subscribe to the demo channel.
	var pusher = new Pusher('999a6964f87015288a65');
	var channels = {};
	channels.demo = pusher.subscribe('demo');
	// var channel = pusher.subscribe('demo');

	// $('meta[name=channel]').each(function() {
	// 	var
	// });

	// Namespacing
	window.App = {};
	App.Listeners = {};

	// Notifier
	App.Notifier = function() {
		this.notify = function(message) {
			var template = Handlebars.compile($('#flash-template').html());

			$(template({ message: message}))
				.appendTo('body')
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
	channels.demo.bind('PostWasPublished', App.Listeners.Post.whenPostWasPublished);

})();