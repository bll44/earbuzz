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