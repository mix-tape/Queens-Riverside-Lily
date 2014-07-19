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
//   Responsive
// --------------------------------------------------------------------------


enquire.register("screen and (min-width:700px)", {

	match : function() {
		$('.block').matchHeight();
	},

	unmatch : function() {
		$('.block').matchHeight('remove');
	}

});

// Add/remove scroll-down arrow 

enquire.register("screen and (min-width:960px)", {

	match : function() {
		if ($("#scroll-down").length < 1) {
			$( "<a href='#content' id='scroll-down'></div>" ).appendTo( '#banner-wrapper' );
  		}
	},

	unmatch : function() {
		//do nothing!
	}

});

// ----- Rezise Debounce ----- //


$(window).resize(function () {

	waitForFinalEvent(function(){



	}, 500, "DeBounced");

});


// --------------------------------------------------------------------------
//   General
// --------------------------------------------------------------------------

$(function() {

	// --------------------------------------------------------------------------
	//   Initialise
	// --------------------------------------------------------------------------

	$("body").fitVids();

	init_chosen();


	// --------------------------------------------------------------------------
	//   Global
	// --------------------------------------------------------------------------

	// ----- Make .block-content fill .block ----- //

	$('.link-block .block-content').each(function () {

		$(this).outerHeight( $(this).parent().parent().outerHeight() );

	});


	// --------------------------------------------------------------------------
	//   Hero Slider
	// --------------------------------------------------------------------------

	if ($('#hero').length > 0) {

		// http://kenwheeler.github.io/slick/#settings

		$('#hero').slick({
			autoplay: true,
			slidesToShow: 1,
			lazyLoad: 'progressive',
			speed: 600,
			dots: false,
			fade: true
		});

		$('.home #hero').append('<div id="hero-underlay"></div>');

		$('.ghost-button', '#banner-content').hover(
			function () {
				$('#hero-underlay').addClass('active');
			},
			function () {
				$('#hero-underlay').removeClass('active');
			}
		);

	}


	// --------------------------------------------------------------------------
	//   General Slideshows
	// --------------------------------------------------------------------------

	if ($('.slideshow').length > 0) {

		// http://kenwheeler.github.io/slick/#settings

		$('.slideshow').slick({
			autoplay: true,
			slidesToShow: 1,
			lazyLoad: 'progressive',
			speed: 600,
			dots: false,
		});

	}


	// --------------------------------------------------------------------------
	//   Hero Clock - Moment JS Configuration
	// --------------------------------------------------------------------------

	clock = $('#clock');

	perthTime = moment(new Date(clock.data('datetime')));

	setInterval(function() {

		perthTime = perthTime.add('seconds', 1);

		clock.html(perthTime.format('hh:mm:ssA') + ' <small>AWST</small>');

	}, 1000);


	// --------------------------------------------------------------------------
	//   Form Confirmation Override
	// --------------------------------------------------------------------------

	$(document).bind('gform_confirmation_loaded', function(event, form_id) {

		console.log(event);
		console.log(form_id);

		if(form_id == 1) {
			$('#gform_wrapper_1').fadeOut(500);
			// scrollTo("#video-wrapper");
			// $('#confirmation-message').delay(300).slideDown(1000).fadeIn(1000);
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
	//  Placeholders
	// --------------------------------------------------------------------------

	if(!Modernizr.input.placeholder) {

		$('.gfield_label').show(0);

	}

	gf_placeholder();

	$(document).bind('gform_post_render', gf_placeholder);

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
		
		
	// --------------------------------------------------------------------------
	//   Instagram
	// --------------------------------------------------------------------------
		
		$("#instagram-images").jqinstapics({
		  	"user_id": "1373128803",
		  	"access_token": "1373128803.674061d.8803abd653da4c6b919afc64d71d2f19",
		  	"count": 3,
		  	"size" : "standard_resolution"
		});
		
	// --------------------------------------------------------------------------
	//   Append scroll-down prompt in banner
	// --------------------------------------------------------------------------
		

});


// --------------------------------------------------------------------------
//   Select menu styling
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
//  Gravity forms placeholders
// --------------------------------------------------------------------------

var gf_placeholder = function() {

	$('.gform_wrapper .gfield')
		.find('input, textarea').filter(function(i){
			var $field = $(this);

			if (this.nodeName == 'INPUT') {
				var type = this.type;
				return !(type == 'hidden' || type == 'file' || type == 'radio' || type == 'checkbox');
			}

			return true;
		})
		.each(function(){
			var $field = $(this);

			var id = this.id;
			var $labels = $('label[for=' + id + ']').hide();
			var label = $labels.last().text();

			if (label.length > 0 && label[ label.length-1 ] == '*') {
				label = label.substring(0, label.length-1) + ' *';
			}

			$field[0].setAttribute('placeholder', label);
		});

	var support = (!('placeholder' in document.createElement('input'))); // borrowed from Modernizr.com
	if ( support && jquery_placeholder_url )
		$.ajax({
			cache: true,
			dataType: 'script',
			url: jquery_placeholder_url,
			success: function() {
				$('input[placeholder], textarea[placeholder]').placeholder({
					blankSubmit: true
				});
			},
			type: 'get'
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

var waitForFinalEvent = (function () {
	var timers = {};
	return function (callback, ms, uniqueId) {
		if (!uniqueId) {
			uniqueId = "Don't call this twice without a uniqueId";
		}
		if (timers[uniqueId]) {
			clearTimeout (timers[uniqueId]);
		}
		timers[uniqueId] = setTimeout(callback, ms);
	};
})();
