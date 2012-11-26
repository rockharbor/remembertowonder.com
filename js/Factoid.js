/**
 * Turns a boring old element into an interactive factoid. Creates a clickable
 * hitspot and animates factoids, showing nested factoid when the animation is 
 * complete.
 * 
 * ```
 * <div id="f1" class="factoid">
 *   <div class="fact">
 *     This fact displays when the hitspot is clicked
 *   </div>
 *   <div id="f2" class="factoid">
 *     <div class="fact">
 *       This fact's hitspot displays when the fact for #f1 finishes
 *     </div>
 *     <div class="factoid">
 *       <div class="fact">
 *         This fact's hitspot displays when the fact for #f2 finishes
 *       </div>
 *     </div>
 *   </div>
 *   <div class="factoid">
 *     <div class="fact">
 *       This fact's hitspot displays when the fact for #f1 finishes
 *     </div>
 *   </div>
 * </div>
 * ```
 * 
 * @param HTMLElement el The factoid element
 * @param boolean isChild Whether this factoid is nested or not
 */
function Factoid(el, isChild) {

	var self = this;

/**
 * Factoid element
 * 
 * @var HTMLElement
 */
	var element;

/**
 * Click callback (for hitspot)
 */
	this.click = function() {
		var fact = element.children('.fact');
		
		if (fact.is(':visible')) {
			hideFactoid(element);
			return;
		}
		
		var line = createLine(element);
		drawLine(line, function(factoidElement) {
			var fact = $(factoidElement).children('.fact');
			fact.empty();
			fact.show();
			setTimeout(showChar, 10, fact, 0, showFactoids);
		});
		
	}

/**
 * Positions the line canvas based on its factoid hitspot and the fact it's
 * drawing to
 *
 * @param HTMLElement factoidElement The factoid
 */
	function createLine(factoidElement) {
		var line = $(factoidElement).children('.line')[0];
		var hit = $(factoidElement).children('.hitspot');
		
		var pos = $(hit).position();
		line.width = Math.abs(pos.left) + hit.width() / 2;
		line.height = Math.abs(pos.top) + hit.height() / 2;
		
		$(line).data('start-x', line.width);
		$(line).data('start-y', line.height);
		var left = 0;
		var top = 0;
		
		if (pos.left < 0) {
			line.width -= hit.width();
			$(line).data('start-x', 0);
			left = pos.left + hit.width() / 2;
		}
		if (pos.top < 0) {
			line.height -= hit.height();
			$(line).data('start-y', 0);
			top = pos.top + hit.height() / 2;
		}
		
		$(line).css({
			position: 'absolute',
			display: 'block',
			left: left,
			top: top
		});
		
		$(line).show();
		
		return line;
	}

/**
 * Draws the line, frame by frame. Algebraic!
 *
 * @param HTMLElement line The line canvas
 * @param Function callback Callback for when animation is finished
 */
	function drawLine(line, callback) {
		var start = {
			x: $(line).data('start-x'),
			y: $(line).data('start-y')
		}
		var end = {
			x: start.x > 0 ? 0 : line.width,
			y: start.y > 0 ? 0 : line.height
		};
		var pos = {
			x: start.x,
			y: start.y
		};
		var length = Math.sqrt(Math.pow(line.width, 2) + Math.pow(line.height, 2));
		var speed = .5;
		
		if (length < 100) {
			speed = .25;
		}
		
		var rads = Math.atan(line.width / line.height);
	
		var dl = length / (speed * 60);
		var dx = Math.sin(rads) * dl * (pos.x > 0 ? -1 : 1);
		var dy = Math.cos(rads) * dl * (pos.y > 0 ? -1 : 1);
		var context = line.getContext('2d');
		
		// actual animation function called frame-by-frame
		var animate = function() {	
			line.width = line.width;
			
			pos.x += dx;
			pos.y += dy;
			
			context.moveTo(start.x, start.y);
			context.lineTo(pos.x, pos.y);
			context.stroke();
			if (Math.round(pos.x) === Math.round(end.x) && Math.round(pos.y) === Math.round(end.y)) {
				callback.apply(this, [$(line).parent('.factoid')]);
			} else {
				requestAnimationFrame(animate);
			}
		};
		
		requestAnimationFrame(animate);
	}

/**
 * Writes out a single character
 * 
 * @param HTMLElement factElement The fact 
 * @param integer chr The character to show
 * @param Function callback A callback to fire when finished
 */	
	function showChar(factElement, chr, callback) {
		var text = factElement.data('text');
		factElement.text(factElement.text()+text.charAt(chr));
		chr++;
		if (chr === text.length) {
			callback.apply(self, factElement);
		} else {
			setTimeout(showChar, 10, factElement, chr, callback);
		}
	}

/**
 * Shows a factoid
 * 
 * @param HTMLElement factElement The fact element
 */
	function showFactoids(factElement) {
		$(factElement).siblings('.factoid').show();
		$(factElement).siblings('.factoid').children('.hitspot').show();
	}

/**
 * Hides a factoid, along with its children.
 * 
 * @param HTMLElement element The factoid element
 * @return integer Returns the delay, for chaining
 */
	function hideFactoid(element, delay, hideButton) {
		if (typeof hideButton === 'undefined') {
			hideButton = false;
		}
		if (typeof delay === 'undefined') {
			delay = 0;
		}
		
		// hide visible children first, increasing the delay
		$(element).children('.factoid:visible').each(function() {
			delay = hideFactoid(this, delay, true);
		});
		
		// hide this fact
		delay += 500;
		$(element).children('.fact').delay(delay).fadeOut();
		$(element).children('.line').delay(delay).fadeOut();
		if (hideButton) {
			$(element).children('canvas').delay(delay).fadeOut();
		}
		
		// chain the delay
		return delay;
	}

/**
 * Initializes the factoid
 * 
 * @param HTMLElement el The factoid element
 */
	function init(el, isChild) {
		if (typeof isChild === 'undefined') {
			isChild = false;
		}
		
		element = $(el);
		
		// draw circles
		var canvasElement = document.createElement('canvas');
		canvasElement.width = canvasElement.height = 20;
		var context = canvasElement.getContext('2d');
		context.beginPath();
		context.arc(10, 10, 9, 0, Math.PI*2);
		context.stroke();
		context.beginPath();
		context.arc(10, 10, 5, 0, Math.PI*2);
		context.stroke();
		
		$(canvasElement)
			.addClass('hitspot')
			.css('cursor', 'pointer')
			.click(self.click);
		
		// add 'line' canvas (assumes hitspot is what's positioned)
		var lineCanvas = document.createElement('canvas');
		
		$(lineCanvas)
			.addClass('line')
			.css('z-index', 10)
			.hide();

		element.prepend(lineCanvas);
		element.prepend(canvasElement);
		
		var fact = element.children('.fact');
		fact.data('text', fact.text());
		fact.empty();
		
		element.children('.fact').hide();
		
		if (isChild) {
			$(canvasElement).hide();
		}
		
		element.children('.factoid').each(function() {
			new Factoid(this, true);
		});
	}

	init(el, isChild);

}
