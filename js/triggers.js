/**
 * This file holds all the timeline trigger functions for the slides
 */

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