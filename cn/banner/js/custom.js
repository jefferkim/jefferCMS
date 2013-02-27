jQuery(document).ready(function($) {

/*Hovers*/
	var mainColor = "#34739f";
	var darkColor = "#202020";
	var textColor = $('body').css('color');
	var borderColor = $('textarea').css('border-top-color');
	var bodyBg = $('body').css('background-color');
	var social = $('.social a').css('background-color');
	var socialTeam = $('.team-social a').css('background-color');

	$('.proj-img').append("<i></i>");
	$('.project').hover(function() {
		$(this).find('.proj-img a').css({
			left: '0',
			opacity: '0'
		});
		$(this).find('i').stop().animate({
			opacity: 0.9
		}, 'fast');
		$(this).find('.proj-info').stop().animate({
			"background-color": mainColor,
			"color": "#fff"
		}, 'fast').find('a').stop().animate({
			"color": "#fff"
		}, 'fast').parent().addClass('hov');
		$(this).find('.proj-img a').stop().animate({
			"opacity": "1",
			"left": "50%"
		}, 300);
	}, function() {
		$(this).find('i').stop().animate({
			opacity: 0
		}, 'slow');
		$(this).find('.proj-info').stop().animate({
			"background-color": "#fff",
			"color": textColor
		}, 'slow').find('a').stop().animate({
			"color": darkColor
		}, 'slow').parent().removeClass('hov');
		$(this).find('.proj-img a').stop().animate({
			"opacity": "0",
			"left": "120%"
		}, '100');
	});
	$('.more').hover(function() {
		$(this).stop().animate({
			"background-color": mainColor
		}, 'fast');
	}, function() {
		$(this).stop().animate({
			"background-color": bodyBg
		});
	});
	$('.social a').append('<span></span>');
	$('.social a').hover(function() {
		$(this).find('span').stop().animate({
			left: '0',
			right: '0',
			top: '0',
			bottom: '0'
		}, 100, function() {
			$(this).parent().stop().animate({
				backgroundColor: '#888888'
			}, 400);
		});
	}, function() {
		$(this).find('span').stop().animate({
			left: '50%',
			right: '50%',
			top: '50%',
			bottom: '50%'
		}, 300, function() {
			$(this).parent().stop().delay(100).animate({
				backgroundColor: social
			}, 200);
		});
	});
	$('.team-social a').append('<span></span>');
	$('.team-social a').hover(function() {
		$(this).find('span').stop().animate({
			left: '0',
			right: '0',
			top: '0',
			bottom: '0'
		}, 100, function() {
			$(this).parent().stop().animate({
				backgroundColor: '#888888'
			}, 400);
		});
	}, function() {
		$(this).find('span').stop().animate({
			left: '50%',
			right: '50%',
			top: '50%',
			bottom: '50%'
		}, 300, function() {
			$(this).parent().stop().delay(100).animate({
				backgroundColor: socialTeam
			}, 200);
		});
	});
	$('.send-wrap div input').hover(function() {
		$(this).stop().animate({
			"background-color": mainColor,
			"border-color": mainColor,
			"color": '#fff'
		}, 'fast');
	}, function() {
		$(this).stop().animate({
			"background-color": '#fff',
			"border-color": borderColor,
			"color": textColor
		});
	});
	$('.date-comments a.comments').hover(function() {
		$(this).stop().animate({
			"background-color": mainColor,
			"color": "#fff"
		}, 'fast');
	}, function() {
		$(this).stop().animate({
			"background-color": "#efefef",
			"color": darkColor
		});
	});

/*Dropdown menu script */
	$(".menu li").has("ul").hover(function() {
		$(this).children("a").addClass('active');
		$(this).children("ul").stop(true, true).fadeIn(150);
	}, function() {
		$(this).children("a").removeClass('active');
		$(this).children("ul").fadeOut(100);
	});

/*jPreloader*/
	$(".proj-img, .proj-img1").preloader(); /*Footer*/
	var footer = $('#footer');
	footer.css({
		display: "none"
	});
	$('.open-close a').click(function() {
		if (footer.is(":visible")) {
			$('.social').stop().animate({
				"margin-right": "20px"
			});
			footer.slideUp(300);
			$(this).removeClass("closed");
		} else {
			$('.social').stop().animate({
				"margin-right": "0"
			});
			footer.slideDown(300);
			$(this).addClass("closed");
		};
		return false;
	});

/*Nivo slider*/
	$('#slider').nivoSlider({
		effect: "random",
		slices: 15,
		boxCols: 8,
		boxRows: 4,
		animSpeed: 500,
		pauseTime: 3e3,
		startSlide: 0,
		directionNav: true,
		directionNavHide: false,
		controlNav: true,
		keyboardNav: true,
		pauseOnHover: true,
		captionOpacity: 0.97,
		afterLoad: function() {
			var $slider = $('#slider');
			$slider.css({
				height: '0',
				opacity: '0'
			});
			$('#preloader').fadeOut(800, function() {
				$slider.animate({
					'height': 381,
					'opacity': 1
				}, 400);
			});
		}
	});
	
/*prettyPhoto*/
	$("a[class^='prettyPhoto']").prettyPhoto({
		theme: 'light_rounded'
	});

/*jFlickr*/
	$('.jflickr').jFlickr({
		pictures: 6,
		flickrId: '51035555243@N01',
		tags: 'nevada',
		grabSize: 'auto',
		width: 64,
		height: 64
	});
	
/*jTweet*/
	$(".tweet").tweet({
		count: 1,
		username: ["envato"],
		loading_text: "= Loading tweets =",
		refresh_interval: 60
	});

/*jTweet in Sidebar and Footer*/
	$(".tweet1").tweet({
		count: 3,
		username: ["envato"],
		loading_text: "Loading tweets...",
		refresh_interval: 60
	});

/*Tabs*/
	$('.tabs').tabs({
		fx: {
			opacity: 'show'
		}
	});

/*ScrollTo*/
	$('.totop').click(function(e) {
		$.scrollTo(this.hash || 0, 1000);
		e.preventDefault();
	});
	$('a.comments').click(function(e) {
		$.scrollTo($('.comments-list'), 600);
		e.preventDefault();
	}); /*Accordeon*/
	$(".accordion").accordion({
		autoHeight: false,
		navigation: true
	});

/*Ajax Contact Form*/
	$(".submitform").submit(function() {
		$(this).ajaxSubmit({
			target: '#error',
			success: function() {
				$('#error').fadeIn('slow').delay(2000).fadeOut('slow');
			}
		});
		return false; // cancel conventional submit
	});

/*Portfolio filter*/
	$('ul#portfolio li').append('<span class="cover"></span>');
	$('ul#filter a').click(function() {
		$('ul#filter .current').removeClass('current');
		$(this).parent().addClass('current');
		var filterVal = $(this).text().toLowerCase().replace(' ', '-');
		if (filterVal == 'all') {
			$('ul#portfolio li.hidden').find('.cover').animate({
				"opacity": "0"
			}).css({
				display: "none"
			});
		} else {
			$('ul#portfolio li').each(function() {
				if (!$(this).hasClass(filterVal)) {
					$(this).addClass('hidden').find('.cover').css({
						display: "block"
					}).animate({
						"opacity": "0.9"
					}, 'slow');
				} else {
					$(this).removeClass('hidden').find('.cover').animate({
						"opacity": "0"
					}).css({
						display: "none"
					});
				}
			});
		}
		return false;
	});

/*jMapping*/
	$('#map').jMapping({
		default_zoom_level: 3
	});
});
