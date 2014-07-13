// ==========================================================================
//
//  Scripts
//    Initialisers, configuration and interactions
//
// ==========================================================================

// --------------------------------------------------------------------------
//   Variables
// --------------------------------------------------------------------------


// --------------------------------------------------------------------------
//   Breakpoints
// --------------------------------------------------------------------------

/*
enquire.register("screen and (min-width:1024px)", {

	match : function() {

	},

	unmatch : function() {

	}

});
*/


// --------------------------------------------------------------------------
//   General
// --------------------------------------------------------------------------

$(function() {

	// --------------------------------------------------------------------------
	//   Initialise
	// --------------------------------------------------------------------------

/* 	FastClick.attach(document.body); */

	$("#video-content").fitVids();

	init_chosen();

	// --------------------------------------------------------------------------
	//   Global
	// --------------------------------------------------------------------------



	// --------------------------------------------------------------------------
	//   Form Confirmation Override
	// --------------------------------------------------------------------------

	$(document).bind('gform_confirmation_loaded', function(event, form_id) {

		console.log(event);
		console.log(form_id);

		if(form_id == 1) {
			$('#action-form').fadeOut(500);
			scrollTo("#video-wrapper");
			$('#confirmation-message').delay(300).slideDown(1000).fadeIn(1000);
			// $('#confirmation-message-details').delay(1000).fadeIn(1000);
			// $('#confirmation-social').delay(1000).fadeIn(1000);
		}

	});


	// --------------------------------------------------------------------------
	//   Form Error Override
	// --------------------------------------------------------------------------

	$(document).bind('gform_post_render', function(event, form_id) {

		console.log(event);
		console.log(form_id);

		if(form_id == 1) {
			stopScroll();
			init_chosen();
			scrollTo("#gf_1");
		}

	});



	// --------------------------------------------------------------------------
	//   Stop auto scrolling on user override
	// --------------------------------------------------------------------------

	if(window.addEventListener) document.addEventListener('DOMMouseScroll', stopScroll, false);
		document.onmousewheel = stopScroll;

	function stopScroll() {
		$('html, body').stop(true, false);	// Stops and dequeue's animations
	}


	// --------------------------------------------------------------------------
	//   ScrollTo
	// --------------------------------------------------------------------------

	function scrollTo(anchor) {

		$('html, body').stop().animate({

			scrollTop: $(anchor).offset().top

		}, 1200,'easeInOutExpo');

	}


	// --------------------------------------------------------------------------
	//   Hash Scroll
	// --------------------------------------------------------------------------

	if (window.location.hash && $(window.location.hash).length) {
		setTimeout(function() {
			if (location.hash) {
				window.scrollTo(0, 0);
			}
		}, 1);

		setTimeout(
			function(){
				scrollTo(window.location.hash);
			}, 400);
	}


	// --------------------------------------------------------------------------
	//   Replace inline svg images with pngs
	// --------------------------------------------------------------------------

	if (!Modernizr.svg) {
			var imgs = document.getElementsByTagName('img');
			var svgExtension = /.*\.svg$/
			var l = imgs.length;
			for(var i = 0; i < l; i++) {
					if(imgs[i].src.match(svgExtension)) {
							imgs[i].src = imgs[i].src.slice(0, -3) + 'png';
							console.log(imgs[i].src);
					}
			}
	}


	// --------------------------------------------------------------------------
	//   External links open in new window
	// --------------------------------------------------------------------------

		$("a[href^='http://']").filter(function() {
			 return this.hostname && this.hostname !== location.hostname;
		}).attr('target', '_blank');


});


// --------------------------------------------------------------------------
//   Select menu styling - mmmmm
// --------------------------------------------------------------------------

var init_chosen = function() {

	$("li.gfield_contains_required #input_1_3").chosen ({
		disable_search_threshold: 10,
		width: "100%"
	});

	$("#input_1_4").chosen ({
		disable_search_threshold: 10,
		width: "100%"
	});

	$("#input_1_5").chosen ({
		disable_search_threshold: 10,
		width: "100%"
	});

	$("#input_1_6").chosen ({
		disable_search_threshold: 10,
		width: "100%"
	});

};

// --------------------------------------------------------------------------
//   Helpers
// --------------------------------------------------------------------------

var hasParent = function(el, id)
{
	if (el) {
		do {
			if (el.id === id) {
				return true;
			}
			if (el.nodeType === 9) {
				break;
			}
		}
		while((el = el.parentNode));
	}
	return false;
};
