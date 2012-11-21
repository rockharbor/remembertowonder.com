(function($) {

	$.fn.timeline = function(method) {

		/**
		 * Timeline options
		 * 
		 * ### Options
		 * - boolean `debug` Turn debug on or off
		 * 
		 * @var object
		 */
		var options = $.extend({
			debug: false
		}, method);
		
		/**
		 * List of triggers
		 *
		 * @var array
		 */
		var triggers = [];
		
		/**
		 * Last scroll position
		 *
		 * @var integer
		 */
		var lastScrollY = 0;
		
		/**
		 * List of methods, called jQuery style: 
		 * 
		 * `$(selector).timeline('update');`
		 * 
		 * @var object
		 */
		var methods = {
			
			/**
			 * Called upon initialization
			 */
			init: function() {
				if (options.debug) {
					setupDebug();
				}
				setState.apply(this);
				var self = this;
				$(window).bind('scroll', function() {
					methods.scroll.apply(self);
				});
				methods.scroll.apply(this);
			},
			
			/**
			 * Used to set a trigger
			 * 
			 * ### Range
			 * If `range` is a number, the callback will fire when the user
			 * scrolls past that point. If it is an array, like `[50, 300]`,
			 * the callback will continue to fire while the user is scrolling in
			 * between that range.
			 * 
			 * @param mixed range Number or array
			 * @callback Function Callback function
			 */
			trigger: function(range, callback) {
				var type = 'range';
				if (typeof range === 'number') {
					type = 'single';
					range = [range, range];
				}
				
				triggers.push({
					type: type,
					range: range,
					callback: callback,
					triggered: false
				});
				
				setState.apply(this);
			},
			
			/**
			 * Scroll callback
			 * 
			 * Iterates through all triggers and fires their callbacks if
			 * appropriate.
			 */
			scroll: function() {
				var scrollY = $(window).scrollTop();
				
				var triggered = [];
				
				for (var trigger in triggers) {
					var t = triggers[trigger];
					
					var event = {
						percent: null,
						direction: 'down',
						relativeScroll: 0,
						type: t.type
					};
					
					event.direction = scrollY - lastScrollY  > 0 ? 'down' : 'up';
					
					// check if we're in the range
					if (t.type === 'range' && scrollY > t.range[0] && scrollY < t.range[1]) {
						event.relativeScroll = scrollY - t.range[0];
						event.percent = event.relativeScroll / (t.range[1] - t.range[0]);
						triggered.push(JSON.stringify(event));
						t.callback.apply(this, [event]);
					} else if (t.type === 'single' && t.triggered == false) {
						event.relativeScroll = scrollY - t.range;
						// check if we passed the trigger
						if (event.direction === 'down') {
							if (t.range[0] >= lastScrollY) {
								triggered.push(JSON.stringify(event));
								t.callback.apply(this, [event]);
								t.triggered = true;
							}
						}
					}
				}
				
				debug(JSON.stringify(triggered));
				
				lastScrollY = scrollY;
				setState.apply(this);
			}
			
		}
		
		/**
		 * Gets the settings and variables from the element and overwrites the
		 * local ones here for use within other functions.
		 */
		function getState() {
			var data = this.data('timeline');
			if (typeof data === 'undefined') {
				return;
			}
			triggers = data.triggers;
			options = data.options;
			lastScrollY = data.lastScrollY;
		}
		
		/**
		 * Saves the local variables to the element's data
		 */
		function setState() {
			this.data('timeline', {
				triggers: triggers,
				options: options,
				lastScrollY: lastScrollY
			});
		}
		
		/**
		 * Output debug message
		 * 
		 * @param string msg Message to output
		 */
		function debug(msg) {
			if (!options.debug) {
				return;
			}
			
			$('#_debug ._line').html($(window).scrollTop());
			$('#_debug ._message').html(msg);
		}
		
		/**
		 * Sets up the debug div
		 */
		function setupDebug() {
			$('body').append('<div id="_debug"><span class="_line">0</span><span>Triggering events:</span><span class="_message"></span></div>');
			$('#_debug').css({
				position: 'fixed',
				bottom: 0,
				right: 0,
				background: '#ff0000',
				color: '#fff',
				padding: 5,
				fontWeight: 'bold'
			});
			$('#_debug span').css({
				display: 'block',
				textAlign: 'right'
			});
		}
		
		// initialize state
		getState.apply(this);
		
		// call method
		if (methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || ! method) {
			return methods.init.apply(this, arguments);
		} else {
			$.error('Missing method: '+method);
		}
	}

})(jQuery);