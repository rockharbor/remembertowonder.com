/**
 * Build an animated representation of our solar system
 * 
 * @param HTMLElement el The container for the solar system
 */
function SolarSystem(el) {
	
	/**
	 * The center of the solar system.
	 *
	 * @var object
	 */
	this.center = {
		x: 0,
		y: 0
	};
	
	/**
	 * How long it takes the Earth to orbit, in seconds
	 * 
	 * @var integer
	 */
	this.yearLength = 10;
	
	/**
	 * The color of space, that is, the background of the solar system
	 *
	 * @var string
	 */
	this.spaceColor = '#fff';
	
	var self = this;
	
	/**
	 * The solar system container
	 *
	 * @var HTMLElement
	 */
	var container;
	
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
	 * List of planetary data, albeit wildly inaccurate for representational
	 * purposes.
	 * 
	 * ### Planet:
	 * - `oDist` integer Distance (as a percentage) where orbit lies from sun
	 * - `earthYears` integer Number of Earth years for one full orbit
	 * - `size` integer Radius of planet, in pixels
	 * - `color` string Color of planet
	 * - `planet` Planet The Planet object
	 * 
	 * @var object
	 */
	var planets = {
		'Mercury': {
			oDist: 10,
			earthYears: .25,
			size: 4,
			color: '#ad7e6e'
		},
		'Venus': {
			oDist: 15,
			earthYears: .58,
			size: 7,
			color: '#ecdbc7'
		},
		'Earth': {
			oDist: 20,
			earthYears: 1,
			size: 7,
			color: '#5fa0f0'
		},
		'Mars': {
			oDist: 27,
			earthYears: 1.92,
			size: 7,
			color: '#c6663c'
		},
		'Jupiter': {
			oDist: 47,
			earthYears: 11.83,
			size: 32,
			color: '#ebb295'
		},
		'Saturn': {
			oDist: 62,
			earthYears: 29.5,
			size: 27,
			color: '#c2976c'
		},
		'Uranus': {
			oDist: 75,
			earthYears: 84,
			size: 15,
			color: '#19beba'
		},
		'Neptune': {
			oDist: 85,
			earthYears: 164.83,
			size: 15,
			color: '#0773bc'
		},
		// don't worry, I still consider you a planet
		'Pluto': {
			oDist: 95,
			earthYears: 248,
			size: 3,
			color: '#9b9391'
		}
	};
	
	/**
	 * Returns a Planet object
	 * 
	 * @param string name The planet name
	 * @return Planet
	 */
	this.getPlanet = function(name) {
		name = name.charAt(0).toUpperCase() + name.substr(1).toLowerCase();
		if (typeof planets[name] === 'undefined') {
			return false;
		}
		return planets[name].planet;
	}
	
	/**
	 * Returns solar system container element 
	 * 
	 * @return HTMLElement
	 */
	this.getElement = function() {
		return container;
	}
	
	/**
	 * Draws space, sun, and orbits
	 */
	this.draw = function() {
		var width = canvasElement.width;
		var height = canvasElement.height;
		
		self.center = {
			x: Math.floor(width / 2),
			y: Math.floor(height / 2)
		}
		
		// draw space
		context.fillStyle = self.spaceColor;
		context.fillRect(0, 0, canvasElement.width, canvasElement.height);
		
		// draw sun
		context.beginPath();
		context.fillStyle = 'orange';
		context.arc(self.center.x, self.center.y, 20, 0, Math.PI*2);
		context.fill();
		context.beginPath();
		context.fillStyle = 'yellow';
		context.arc(self.center.x, self.center.y, 15, 0, Math.PI*2);
		context.fill();
		
		// add orbits and planets
		for (var planetName in planets) {
			var p = planets[planetName];
			
			// create the orbit
			var radius = Math.floor(width/2*(p.oDist/100));
			context.beginPath();
			context.arc(self.center.x, self.center.y, radius, 0, Math.PI*2);
			context.closePath();
			context.stroke();
			
			// let there be `document.write(planetName)`!
			if (typeof p.planet === 'undefined') {
				p.planet = new Planet(self);
				with (p.planet) {
					color = p.color;
					name = planetName;
					oDist = p.oDist;
					earthYears = p.earthYears;
					size = p.size;
					orbit();
				}
			}
		}
	}
	
	/**
	 * Initializes the solar system, including creating orbits and planets
	 *
	 * @param HTMLElement el The system's container
	 */
	function init(el) {
		container = el;
		canvasElement = document.createElement('canvas');
		canvasElement.width = container.clientWidth;
		canvasElement.height = container.clientHeight;
		container.appendChild(canvasElement);
		context = canvasElement.getContext('2d');
		
		self.draw();
	}
	
	// big bang
	init(el);
}