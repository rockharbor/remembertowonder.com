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
		
		fact.empty();
		fact.show();
		setTimeout(showChar, 10, fact, 0, showFactoids);
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
