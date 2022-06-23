(function($) {

	window.$ipsite = {
		header: $('#header'),
		banner: $('#banner'),
		footer: $('#footer'),
	};

	function setWidth() {
		var cols = Math.floor($ipsite.xwp.width() / $ipsite.xwu);
		if(cols === 0) {
			$ipsite.xw.css('width', '');
		}
		else {
			$ipsite.xw.width(cols * $ipsite.xwu);
		}
	}
	
	$(document).ready(function() {
	
		$('.xwidth').each(function() {
			$ipsite.xw = $(this);
			$ipsite.xwp = $ipsite.xw.parent();
			$ipsite.xwu = $ipsite.xw.children().first().outerWidth(true);
			$(window).on('load resize', setWidth);
		});
				
		$('.carousel').each(function() {
			var $c = $(this);
			$c.hammer().on('dragleft swipeleft', function(event) {
				event.gesture.preventDefault();
				event.gesture.stopDetect();
				$c.carousel('next');
			});
			$c.hammer().on('dragright swiperight', function(event) {
				event.gesture.preventDefault();
				event.gesture.stopDetect();
				$c.carousel('prev');
			});
			$c.find('.item').each(function() {
				$(this).css('cursor', 'pointer');
				$(this).on('click', function(event) {
					if (!$(event.target).is('a')) {
						$c.carousel('next');
					}
				});
			});
		});
		
		if(typeof $f !== 'undefined') {
			var player = $f($ipsite.banner.children('iframe')[0]);
			player.addEvent('ready', function() {
				player.addEvent('play', function() {
					$ipsite.header.addClass('collapsed');
				});
				player.addEvent('pause', function() {
					$ipsite.header.removeClass('collapsed');
				});
				player.addEvent('finish', function() {
					$ipsite.header.removeClass('collapsed');
				});
			});
		}
		
		$('a[href^=#]:not([href=#])').on('click', function(e) {
			console.log(this.hash);
			var target = $(this.hash);
			if (target.length) {
				e.preventDefault();
				$('html,body').scrollTop(target.offset().top);
			}
		});
		
	});

	$(window).load(function() {
		
		var $w = $(this),
			st = $w.scrollTop(),
			$c = $ipsite.banner.children('.banner-caption');
		
		$w.on('scroll', function() {
			st = $w.scrollTop();
		});
		
		if($ipsite.header.length > 0) {
			$ipsite.header.scrollupbar();
			
			if($ipsite.banner.length > 0) {
				var bh = $ipsite.banner.height() - $ipsite.header.outerHeight() / 2;
				$w.on('scroll', function() {
					if (st > bh) {
						$ipsite.header.addClass('invert');
					}
					else {
						$ipsite.header.removeClass('invert');
					}
				});
			}
		}
		
		if($c.length > 0) {
			var co = $c.offset().top;
			$w.on('scroll', function() {
				$c.css('opacity', 1 - (st / co));
			});
		}
		
	});
	
})(jQuery);