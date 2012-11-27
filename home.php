<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<title>Remember To Wonder</title>
		<link rel="stylesheet" href="<?php echo $url['base']; ?>/css/reset.css" />
		<link rel="stylesheet" href="<?php echo $url['base']; ?>/css/styles.css" />
		<link rel="stylesheet" href="<?php echo $url['base']; ?>/css/fonts.css" />
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script src="<?php echo $url['base']; ?>/js/jquery.timeline.js"></script>
		<script src="<?php echo $url['base']; ?>/js/rAF.js"></script>
		<script src="<?php echo $url['base']; ?>/js/SolarSystem.js"></script>
		<script src="<?php echo $url['base']; ?>/js/Planet.js"></script>
		<script src="<?php echo $url['base']; ?>/js/Factoid.js"></script>
		<script src="<?php echo $url['base']; ?>/js/ShootingStar.js"></script>
		<script src="<?php echo $url['base']; ?>/js/triggers.js"></script>
		<script>
			$(document).ready(function() {
				// setup timeline
				$('body').timeline({
					debug: true
				});
				
				// create timeline triggers
				slide1 = new Slide1();
				$('body').timeline('trigger', 800, function(event) {
					if (event.direction === 'down') {
						slide1.endStars();
						slide1.endNag();
					} else {
						slide1.startNag();
						slide1.startStars();
					}
				});
				slide1.startStars();
				slide1.startNag();
				
				slide5 = new Slide5();
				
				slide6 = new Slide6();
				$('body').timeline('trigger', $('.slide6').offset().top - 800, function(event) {
					event.direction === 'down' ? slide6.startWaves() : slide6.endWaves();
				});
				$('body').timeline('trigger', $('.slide6').offset().top + 200, function(event) {
					event.direction === 'down' ? slide6.endWaves() : slide6.startWaves();
				});
				
				slide7 = new Slide7();
				
				// create factoids
				$('article > .factoid').each(function() {
					new Factoid(this);
				});
				// create solar systems
				$('.solar-system').each(function() {
					var ss = new SolarSystem(this);
					ss.draw();
					$(this).css({
						'background-image': 'url("<?php echo $url['base']; ?>/img/stars.png")',
						'background-repeat': 'no-repeat',
						'background-position': '50% 50%',
						'background-size': '100%'
					});
				});
			});
		</script>
	</head>
	<body class="experience">
		<section class="slide1">
			<article>
				<img class="logo" src="<?php echo $url['base']; ?>/img/wonder-white.png" alt="Wonder" />
				<p class="large">...is a lost art among us.</p>
				<p>But how?</p>
				<div class="arrow">
					<img src="<?php echo $url['base']; ?>/img/arrow.png" alt="Scroll Down" />
				</div>
				<canvas id="shooting-stars"></canvas>
			</article>
		</section>
		<section class="slide2">
			<article>
				<p>
					How have we lost our sense of wonder?<br />
					<span class="large">Think about the sun..</span>
				</p>
				<div class="solar-system"></div>
			</article>
		</section>
		<section class="slide3">
			<article>
				<p class="hint">Click the <img src="<?php echo $url['base']; ?>/img/circle.png" alt="circle" /> to see...</p>
				<div class="factoid f1"><p class="fact">The temperature on its surface is 10,000 degrees.</p></div>
				<div class="factoid f2"><p class="fact">Its pressure is 340,000,000 times greater than the earths at sea level.</p></div>
				<div class="factoid f3"><p class="fact">At its core, it is a paltry 27,000,000 degrees.</p></div>
				<div class="factoid f4">
					<p class="fact">Its estimated mass is 220 duodecillion pounds. Never heard of a duodecillion?</p>
					<div class="factoid f5">
						<p class="fact">
							It's the 14th type of &quot;illion&quot; after million, billion, trillion, ..., etc.<br />
							22,000,000,000,000,000,000,000,000,000,000,000,000,000
						</p>
					</div>
				</div>
				<div class="solar-system"></div>
			</article>
		</section>
		<section class="slide4">
			<article>
				<p>
					How have we lost our sense of wonder?<br />
					<span class="large">Think about the earth..</span>
				</p>
				<div class="solar-system"></div>
			</article>
		</section>
		<section class="slide5">
			<article>
				<img class="earth" src="<?php echo $url['base']; ?>/img/earth.png" alt="Earth" />
				<img class="miles" src="<?php echo $url['base']; ?>/img/93millionmiles.png" alt="93 Million Miles" />
				<img class="sun" src="<?php echo $url['base']; ?>/img/sun.png" alt="Sun" />
				<div class="factoid f1" data-factoid-after-click="slide5.showMiles" data-factoid-after-hide="slide5.hideMiles">
					<p class="fact">It sits about 93,000,000 miles from the sun.</p>
					<div class="factoid f2"><p class="fact">A minor decrease in that distance and the effect is catastrophic. Glaciers would melt. Most of our cities would flood. Ocean area would increase before potentially boiling and evaporating entirely.</p></div>
				</div>
				<div class="factoid f3"><p class="fact">Even the slightest movement of Earth, either toward or away from the sun, and life might not exist as we know it.</p></div>
				<div class="factoid f4"><p class="fact">A minor increase in that distance and the effect is also catastrophic. More glaciers means more reflection of the sun&apos;s heat. Colder ocean temperatures would trap and dissolve much of the atmosphere&apos;s carbon dioxide. A decrease in the presence of CO<sub>2</sub> could drop temperatures devastatingly low.</p></div>
			</article>
		</section>
		<section class="slide6">
			<div class="waves-foreground"></div>
			<div class="waves-background"></div>
			<article>
				<p>
					How have we lost our sense of wonder?<br />
					<span class="large">Think about the ocean...</span>
				</p>
			</article>
		</section>
		<section class="slide7">
			<article>
				<img class="salt" src="<?php echo $url['base']; ?>/img/salt.png" alt="Salt" />
				<img class="pie" src="<?php echo $url['base']; ?>/img/pie.png" alt="Pie Chart" />
				<img class="earth" src="<?php echo $url['base']; ?>/img/earth.png" alt="Earth" />
				<div class="factoid f1" data-factoid-after-show="slide7.showPie" data-factoid-after-click="slide7.hideAll" data-factoid-after-hide="slide7.hideAll"><p class="fact">At 140,000,000 square miles, it occupies more than 70% of the Earth&apos;s surface.</p></div>
				<div class="factoid f2" data-factoid-after-show="slide7.showSalt" data-factoid-after-click="slide7.hideAll" data-factoid-after-hide="slide7.hideAll"><p class="fact">If you evaporated all its water and spread the resulting salt equally over the earth&apos;s land area, there would be a 500-foot layer that covered our continents.</p></div>
				<img class="beaker" src="<?php echo $url['base']; ?>/img/beaker.png" alt="Beaker" />
				<div class="factoid f3">
					<p class="fact">A single milliliter of ocean water may contain tens of thousands of zooplankton, hundreds of thousands of phytoplankton, millions of bacterial cells, and more than ten million viruses.</p>
					<div class="factoid f4">
						<p class="fact">
							It provides 99% of the Earth&apos;s living space. More than 250,000 known species inhabit it.
						</p>
					</div>
				</div>
				<div class="factoid f5"><p class="fact">And less than 10% has been explored by humans.</p></div>
			</article>
		</section>
		<section class="alternate slide8">
			<article>
				<p>
					How have we lost our sense of wonder?<br />
					<span class="large">Think about the animal kingdom...</span>
				</p>
			</article>
		</section>
		<section class="alternate slide9">
			<article>
				<div class="factoid f1"><p class="fact">For every human on earth, there are 1,000,000 ants.</p></div>
				<div class="factoid f2"><p class="fact">China boasts the world&apos;s highest goat population, coming in at more than 170,000,000.</p></div>
				<div class="factoid f3"><p class="fact">Roughly 1,000,000 land species have been named. Experts project that to be only 15% of what&apos;s out there. More than 5,500,000 have yet to be discovered.</p></div>
			</article>
		</section>
		<section class="alternate slide10">
			<article>
				<p>
					How have we lost our sense of wonder?<br />
					<span class="large">Think about the human body...</span>
				</p>
			</article>
		</section>
		<section class="alternate slide11">
			<article>
				<div class="factoid f1"><p class="fact">There are over 100,000,000,000,000 cells in your body.</p></div>
				<div class="factoid f2"><p class="fact">Your heart pumps nearly 2,000 gallons of blood through your body each day.</p></div>
				<div class="factoid f3"><p class="fact">If you&apos;re like the average person, you have more than 100,000 hair follicles on their head.</p></div>
				<div class="factoid f4"><p class="fact">If you live the average lifespan, you will produce enough saliva to fill more than 2 swimming pools.</p></div>
				<div class="factoid f5"><p class="fact">You use 200 muscles to take one step.</p></div>
				<div class="factoid f6"><p class="fact">A new human is born every .25 seconds. In the amount of time it takes you to read these two sentences, 20 new people have entered the world. </p></div>
			</article>
		</section>
		<section class="alternate slide12">
			<article>
				<p>
					How have we lost our sense of WONDER...<br />
					<span class="large">...when it&apos;s all around us?</span>
				</p>
			</article>
		</section>
	</body>
</html>