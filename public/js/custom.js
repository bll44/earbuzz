var EARBUZZ = EARBUZZ || {};
// back to top scroll
$(document).ready(function(){
	$(window).scroll(function () {
		if ($(this).scrollTop() > 50) {
			$('#back-to-top').fadeIn();
		} else {
			$('#back-to-top').fadeOut();
		}
	});
	// scroll body to 0px on click
	$('#back-to-top').click(function () {
		$('#back-to-top').tooltip('hide');
		$('body,html').animate({
			scrollTop: 0
		}, 800);
		return false;
	});

	// $('#back-to-top').tooltip();


	(function($){
	    var $coverflow = $('#coverflow'),
	        activeSlideIndex = $('#coverflow div').index($('[data-active="true"]'));

	    $coverflow.coverflow({
	        active: activeSlideIndex,
	        duration: 175,
	        scale: 1,
	        perspectiveY: 45,
	        angle: 25,
	        easing: 'easeInOutSine',
			trigger : {
				itemfocus : false,
				itemclick : true,
				mousewheel : false,
				swipe : true
			}
	    });

		$coverflow.coverflow().trigger('mousweheel');

	})(jQuery);

});

// global notification
(function() {

	// Open a connection, and subscribe to the demo channel.
	var pusher = new Pusher('999a6964f87015288a65');
	var channel = pusher.subscribe('demo');

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
	channel.bind('PostWasPublished', App.Listeners.Post.whenPostWasPublished);

})();
