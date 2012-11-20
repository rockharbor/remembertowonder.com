/**
 * A planet
 * 
 * @param SolarSystem ss The solar system to orbit
 */
function Planet(ss) {
	
	/**
	 * Planet name
	 * 
	 * @var string
	 */
	this.name = 'Unknown';
	
	/**
	 * Number of Earth years for one full orbit
	 * 
	 * @var int
	 */
	this.earthYears = 1;
	
	/**
	 * Size of planet, in pixels
	 * 
	 * @var int
	 */
	this.size = 10;
	
	/**
	 * Planet color, as accepted by canvas color setters
	 *
	 * @var string
	 */
	this.color = '#000';
	
	var self = this;
	
	/**
	 * The solar system this planet belongs to
	 *
	 * @var SolarSystem
	 */
	var system;
	
	/**
	 * The canvas element
	 *
	 * @var HTMLCanvasElement
	 */
	var canvasElement;
	
	/**
	 * Canvas context
	 * 
	 * @var context
	 */
	var context;
	
	/**
	 * Distance (as a percentage) where orbit lies from sun
	 * 
	 * @var int
	 */
	this.oDist = 20;
	
	/**
	 * Current location, in degrees
	 * 
	 * @var int
	 */
	var location = 0;
	
	/**
	 * Begins the planet's orbit animation
	 */
	this.orbit = function() {
		draw();
		requestAnimationFrame(self.orbit);
	}
	
	/**
	 * Initializes the planet canvas
	 * 
	 * @param SolarSystem ss The solar system to orbit
	 */
	function init(ss) {
		system = ss;
		
		// add a canvas
		canvasElement = document.createElement('canvas');
		canvasElement.width = system.getElement().clientWidth;
		canvasElement.height = system.getElement().clientHeight;
		context = canvasElement.getContext('2d');
		system.getElement().insertBefore(canvasElement);
	}
	
	/**
	 * Redraws the planet at the current location in its orbit
	 */
	function draw() {
		context.fillStyle = context.strokeStyle = self.color;
		
		// get current location and clear the planet
		var orbitRadius = Math.floor(canvasElement.width/2*(self.oDist/100));
		var currentCoords = getCartesianCoords(location, orbitRadius);
		// clear previous drawing (with a 2px margin)
		var rectSize = (self.size + 2) * 2;
		context.clearRect(currentCoords.x - rectSize/2, currentCoords.y - rectSize/2, rectSize, rectSize);
		
		// get delta based on solar system year length and how many earth years
		// this planet takes to orbit
		var secondsPerOrbit = system.yearLength * self.earthYears;
		// degrees per second at 60 FPS
		var delta = (1/60) * (360 / secondsPerOrbit);
		location -= delta;
		
		// create the planet
		var newCoords = getCartesianCoords(location, orbitRadius);
		context.beginPath();
		context.arc(newCoords.x, newCoords.y, self.size, 0, Math.PI*2);
		context.fill();
		
		// a bit of extra work for Saturn
		if (self.name === 'Saturn') {
			// (you were always my favorite anyway)
			context.beginPath();
			context.moveTo(newCoords.x - self.size, newCoords.y + self.size);
			context.lineTo(newCoords.x + self.size, newCoords.y - self.size)
			context.stroke();
		}
	}
	
	/**
	 * Helper function for getting the cartesian coordinates on the orbit
	 * 
	 * @param integer degrees Location on orbit, as degrees
	 * @param integer radius Radius of the orbit
	 */
	function getCartesianCoords(degrees, radius) {
		var rads = degrees * Math.PI / 180;
		return {
			x: Math.floor(system.center.x + radius * Math.cos(rads)),
			y: Math.floor(system.center.y + radius * Math.sin(rads))
		};
	}
	
	init(ss);
	
}