/**
 * This file holds all the timeline trigger functions for the slides
 */

/*= Transitions
********************************************************/
/**
 * Clean LTR swipe that reveals the contents of `element`
 * 
 * @param HTMLElement element Element to reveal
 */
function swipeIn(element) {
	element.show();
	
	var viewport;
	if (element.parent('.viewport-contents').length === 0) {
		viewport = _swipeSetupElement(element);
	} else {
		viewport = element.closest('.viewport');
	}
	
	viewport.animate({
		left: element.data('originalPos').left
	}, 2000);
	viewport.children('.viewport-contents').animate({
		left: 0
	}, 2000);
}

/**
 * Clean RTL swipe that hides the contents of `element`
 * 
 * @param HTMLElement element Element to hide
 */
function swipeOut(element) {
	element.show();
	
	var viewport;
	if (element.parent('.viewport-contents').length === 0) {
		viewport = _swipeSetupElement(element);
		viewport.css({
			left: element.data('originalPos').left
		});
		viewport.children('.viewport-contents').css({
			left: 0
		});
	} else {
		viewport = element.closest('.viewport');
	}
	
	viewport.animate({
		left: element.data('originalPos').left - element.width()
	}, 2000);
	viewport.children('.viewport-contents').animate({
		left: element.width()
	}, 2000);
}

/**
 * Helper function for wrapping elements that use the swiping animation Defaults
 * to positioning needed to swipeIn
 *
 * @param HTMLElement element Element that will be swiped
 */
function _swipeSetupElement(element) {
	var pos = element.position();
	element.data('originalPos', pos);
	element.wrap('<div class="viewport-contents"></div>');
	var swipe = $(element).parent('.viewport-contents');
	swipe.wrap('<div class="viewport"></div>');
	var viewport = swipe.parent('.viewport');
	viewport.css({
		position: 'absolute',
		left: pos.left - element.width(),
		top: pos.top,
		overflow: 'hidden',
		height: element.height(),
		width: element.width()
	});
	swipe.css({
		position: 'absolute',
		left: element.width(),
		top: 0,
		height: element.height(),
		width: element.width()
	});
	element.css({
		position: 'absolute',
		left: 0,
		top: 0
	});
	return viewport;
}

/**
 * Slide 1 trigger functions
 */
function Slide1() {
	this.active = true;
	
	this.startStars = function() {
		var self = this;
		setTimeout(function() {
			shootAStar.apply(self);
		}, Math.random()*8000+3000)
	}
	
	this.endStars = function() {
		this.active = false;
	}
	
	function shootAStar() {
		new ShootingStar($('#shooting-stars'), 200);
		if (this.active) {
			var self = this;
			setTimeout(function() {
				shootAStar.apply(self);
			}, Math.random()*8000+3000)
		}
	}
}