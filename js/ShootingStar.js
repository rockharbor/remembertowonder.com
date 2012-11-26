/**
 * Creates a randomized shooting star within `element`. The star will start on
 * a random side and at a random y point within the `yThreshold`.
 * 
 * @param HTMLCanvasElement element The canvas element to create the star in
 * @param integer yThreshold Maximum y-value to start (you wouldn't want it
 *   starting at the bottom, would you?
 */
function ShootingStar(element, yThreshold) {
	
	/**
	 * Radius for the star itself
	 * 
	 * @var integer
	 */
	this.starRadius = 2;
	
	/**
	 * Length of the tail
	 * 
	 * @var integer
	 */
	this.tailLength = 10;

	var el = $(element);
	
	// random side
	var side = Math.random() < .5 ? 'left' : 'right';
	
	// random start point between top of element and yThreshold
	var y = Math.random() * yThreshold;
	
	// random horizontal speed (60-90)/frame
	var xSpeed = (Math.random()*30+60);
	
	// random vertical speed (10-20)/frame
	var ySpeed = (Math.random()*10+10)
	
	// start position
	var pos = {
		x: side === 'left' ? 0 : el.width(),
		y: y
	};
	
	el[0].width = el.width();
	el[0].height = el.height();

	/**
	 * Draws the star in its new position based on where it was last
	 */
	function draw() {
		var context = el[0].getContext('2d');

		// get tail point deltas
		var angle = Math.atan(ySpeed / xSpeed);
		var dx = Math.cos(angle) * self.tailLength;
		var dy = Math.sin(angle) * self.tailLength;

		// clear canvas the lazy way
		el[0].width = el[0].width;

		// adjust position
		if (side === 'left') {
			pos.x += xSpeed;
		} else {
			pos.x -= xSpeed;
		}
		pos.y += ySpeed;

		// draw star
		context.fillStyle = '#fff';
		context.arc(pos.x, pos.y, self.starRadius, 0, Math.PI * 2);
		context.fill();

		// draw tail
		context.beginPath();
		context.moveTo(pos.x, pos.y - self.starRadius);
		if (side === 'left') {
			context.lineTo(pos.x - dx, pos.y - dy);
		} else {
			context.lineTo(pos.x + dx, pos.y - dy);
		}
		context.lineTo(pos.x, pos.y + self.starRadius);
		context.lineTo(pos.x, pos.y - self.starRadius);
		context.closePath();
		context.fill();

		if (pos.x > -100 && pos.x < el.width()+100) {
			requestAnimationFrame(draw);
		}
	}
	
	// start animation
	var self = this;
	requestAnimationFrame(draw);
}