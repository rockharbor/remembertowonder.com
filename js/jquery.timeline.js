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
			 * 
			 * Automatically adds triggers that were configured in the markup:
			 * 
			 * ```
			 * <div 
			 *   data-timeline-trigger="somecallback" 
			 *   data-timeline-type="range"
			 * />
			 * ```
			 * 
			 * The trigger should be a global function (on the `window` object).
			 * 
			 * `data-timeline-type` is optional. If it is 'range', then the 
			 * trigger's range is configured to be from the top of the element 
			 * to the bottom of it. Otherwise, it's treated as a 'single' and
			 * fires when the top of the element is scrolled past.
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
				this.find('[data-timeline-trigger]').each(function() {
					var type = $(this).data('timeline-type');
					if (typeof type === 'undefined') {
						type = 'single';
					}
					
					var range = $(this).offset().top;
					if (type === 'range') {
						range = [
							$(this).offset().top,
							$(this).offset().top + $(this).height()
						];
					}
					
					var callback = window[$(this).data('timeline-trigger')];
					methods.trigger.apply(self, [range, callback])
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
					
					event.direction = scrollY - lastScrollY >= 0 ? 'down' : 'up';
					event.relativeScroll = scrollY - t.range[0];
					
					// check if we're in the range
					if (t.type === 'range' && scrollY > t.range[0] && scrollY < t.range[1]) {
						event.percent = event.relativeScroll / (t.range[1] - t.range[0]);
						triggered.push(JSON.stringify(event));
						t.callback.apply(this, [event]);
					} else if (t.type === 'single') {
						// check if we've passed the mark
						var passed = false;
						switch (event.direction) {
							case 'down':
								if (lastScrollY <= t.range[0] && scrollY >= t.range[0]) {
									passed = true;
								}
								break;
							case 'up':
								if (lastScrollY >= t.range[0] && scrollY <= t.range[0]) {
									passed = true;
								}
						}
							
						if (!passed) {
							// reset so it can be triggered again when we're
							// within the threshold
							t.triggered = false;
							continue;
						}
						
						// if we haven't triggered this event, do it now
						if (!t.triggered && passed) {
							triggered.push(JSON.stringify(event));
							t.callback.apply(this, [event]);
							t.triggered = true;
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