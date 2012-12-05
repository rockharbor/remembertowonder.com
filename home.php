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
		<script src="<?php echo $url['base']; ?>/js/modernizr.custom.20540.js"></script>
		<script src="<?php echo $url['base']; ?>/js/jquery.transit.min.js"></script>
		<script>
			$(document).ready(function() {
				if (!$.support.transition) {
					$.fn.transition = $.fn.animate;
				}
				
				// setup timeline
				$('body').timeline({
					debug: true
				});
				
				if (Modernizr.csstransforms3d) {
					$('[data-z]').each(function() {
						$(this).css({
							transform: 'translate3d(0, 0, '+$(this).data('z')+'px)'
						});
					});
					// set up perspective to always be where the user is
					$(window).bind('scroll', function(e) {
						$('.viewport').css({
							'perspective-origin': '0px '+$(window).scrollTop()+'px'
						});
					});
				} else {
					$('[data-z]').each(function() {
						// range being the vanishing point
						var maxRange = 1000;
						if ($(this).data('z') < 0) {
							maxRange = -10000;
						}
						var fauxZScale = 1 + (maxRange - $(this).data('z')) / Math.abs(maxRange);
						$(this).css({
							zIndex: $(this).data('z'),
							transform: 'scale('+fauxZScale+', '+fauxZScale+')'
						});
					});
				}
				
				Sun = {
					showHot: function() {
						$('.background .section-sun .sun.hot').transition({opacity: 1});
					},
					hideHot: function() {
						$('.background .section-sun .sun.hot').transition({opacity: 0});
					}
				}
				
				Earth = {
					showFrozen: function() {
						Earth.hide();
						$('.background .section-earth .earth.frozen').transition({opacity: 1});
					},
					showCold: function() {
						Earth.hide();
						$('.background .section-earth .earth.cold').transition({opacity: 1});
					},
					hide: function() {
						$('.background .section-earth .earth.cold, .section-earth .earth.frozen').transition({opacity: 0});
					}
				}
				
				Ocean = {
					showSalt: function() {
						$('.background .section-ocean .salt').transition({opacity: 1});
					},
					hideSalt: function() {
						$('.background .section-ocean .salt').transition({opacity: 0});
					},
					showBeaker: function() {
						$('.background .section-ocean .beaker').transition({opacity: 1});
					},
					hideBeaker: function() {
						$('.background .section-ocean .beaker').transition({opacity: 0});
					}
				}
				
				Animal = {
					showGoat: function() {
						$('.background .section-animal .goat').transition({top: '580px'});
					},
					hideGoat: function() {
						$('.background .section-animal .goat').transition({top: '650px'});
					}
				}
				
				$('[data-fade]').each(function() {
					var el = this;
					var obj = $(el).data('fade');
					var options = {
						enter: function() {},
						exit: function() {},
						range: [0,0]
					}
					if (typeof obj !== 'object' || typeof obj['range'] === undefined) {
						return;
					}
					options = $.extend(options, obj);
					// parse dot-syntax objects into valid callbacks
					for (var c = ['enter', 'exit'] in options) {
						var callback = options[c];
						if (typeof options[c] === 'string') {
							callback = window;
							var cbObjects = options[c].split('.');
							for (var cbObj in cbObjects) {
								callback = callback[cbObjects[cbObj]];
							}
						}
						options[c] = callback;
					}
					$('body').timeline('trigger', options.range[0], function(evt) {
						if (evt.direction === 'down') {
							$(el).transition({opacity: 1}, options['enter']);
						} else {
							$(el).transition({opacity: 0}, options['exit']);
						}
					});
					$('body').timeline('trigger', options.range[1], function(evt) {
						if (evt.direction === 'down') {
							$(el).transition({opacity: 0}, options['exit']);
						} else {
							$(el).transition({opacity: 1}, options['enter']);
						}
					});
					$(el).css({opacity: 0});
				});
			});
		</script>
	</head>
	<body>
		<article>
			<section class="section-sun">
				<h1 style="top: 200px; opacity:1;" data-fade='{"range":[0, 400]}'>Have you ever thought about the sun?</h1>
				<p style="top:450px" class="stickleft" data-fade='{"range":[401, 800]}'>The temperature on its surface is 10,000 degrees.</p>
				<p style="top:450px" class="stickright" data-fade='{"range":[401, 800], "enter":"Sun.showHot", "exit":"Sun.hideHot"}'>At its core, it is a paltry 27,000,000 degrees.</p>
				<p style="top:250px" class="stickleft" data-fade='{"range":[1001, 1200]}'>Its pressure is 340,000,000 times greater than the earth&apos;s at sea level.</p>
				<p style="top:250px" class="stickright" data-fade='{"range":[1001, 1200]}'>Its estimated mass is 220 duodecillion pounds.</p>
				<p style="top:450px" data-fade='{"range":[1501, 1800]}'>And this sun is just one of about 200 billion stars in our universe.</p>
			</section>
			<section class="section-earth">
				<h1 style="top:100px" data-fade='{"range":[2000, 2200]}'>Have you ever thought about the earth?</h1>
				<p style="top:100px" data-fade='{"range":[2201, 2600]}'>It sits about 93,000,000 miles from the sun.</p>
				<p style="top:450px" class="stickleft" data-fade='{"range":[2601, 3000], "enter":"Earth.showFrozen", "exit":"Earth.hide"}'>A minor decrease in that distance and the effect is catastrophic. Glaciers would melt. Most of our cities would flood. Ocean area would increase before potentially boiling and evaporating entirely.</p>
				<p style="top:250px" class="stickright" data-fade='{"range":[3001, 3400], "enter":"Earth.showCold", "exit":"Earth.hide"}'>A minor increase in that distance and the effect is also catastrophic. More glaciers means more reflection of the sun&apos;s heat. Colder ocean temperatures would trap and dissolve much of the atmosphere&apos;s carbon dioxide. A decrease in the presence of CO<sub>2</sub> could drop temperatures devastatingly low.</p>
				<p style="top:450px" data-fade='{"range":[3401, 3800]}'>Even the slightest movement of Earth, either toward or away from the sun, and life might not exist as we know it.</p>
			</section>
			<section class="section-ocean">
				<h1 data-fade='{"range":[4001, 4400]}'>Have you ever thought about the ocean?</h1>
				<p style="top:200px" class="stickright" data-fade='{"range":[4401, 4800]}'>At 140,000,000 square miles, it occupies more than 70% of the Earth&apos;s surface.</p>
				<p style="top:200px" class="stickleft" data-fade='{"range":[4801, 5200], "enter":"Ocean.showSalt", "exit":"Ocean.hideSalt"}'>If you evaporated all its water and spread the resulting salt equally over the earth&apos;s land area, there would be a 500-foot layer that covered our continents.</p>
				<p style="top:200px;z-index:10" data-fade='{"range":[5201, 5600], "enter":"Ocean.showBeaker","exit":"Ocean.hideBeaker"}'>A single milliliter of ocean water may contain tens of thousands of zooplankton, hundreds of thousands of phytoplankton, millions of bacterial cells, and more than ten million viruses.</p>
				<p style="top:500px;z-index:10" data-fade='{"range":[5801, 6300]}'>It provides 99% of the Earth&apos;s living space. More than 250,000 known species inhabit it.</p>
				<p style="top:500px;z-index:10" data-fade='{"range":[6301, 6500]}'>And less than 10% has been explored by humans.</p>
			</section>
			<section class="section-animal">
				<h1 data-fade='{"range":[7201, 7400]}'>Have you ever thought about the Animal Kingdom?</h1>
				<p style="top:500px;z-index:10" class="stickleft" data-fade='{"range":[7501, 7700]}'>something about giraffes?</p>
				<p style="top:400px;z-index:10" class="stickright" data-fade='{"range":[7701, 7900], "enter":"Animal.showGoat", "exit":"Animal.hideGoat"}'>China boasts the world&apos;s highest goat population, coming in at more than 170,000,000.</p>
				<p style="top:500px;z-index:10" class="stickright" data-fade='{"range":[8301, 8600]}'>More than 70,000 kinds of spiders exist.</p>
				<p style="top:500px;z-index:10" data-fade='{"range":[8701, 8900]}'>Roughly 1,000,000 land species have been named. Experts project that to be only 15% of what&apos;s out there. More than 5,500,000 have yet to be discovered.</p>
			</section>
		</article>
		<div class="background">
			<div class="viewport">
				<section class="section-sun" style="height: 1900px">
					<img data-z="-2000" class="sun" src="<?php echo img('sun.png'); ?>" />
					<img data-z="-2000" class="sun hot" src="<?php echo img('sun-hot.png'); ?>" />
				</section>
				<section class="section-earth" style="height: 3200px">
					<img data-z="-1400" class="earth" src="<?php echo img('earth.png'); ?>" />
					<img data-z="-1400" class="earth cold" src="<?php echo img('earth-cold.png'); ?>" />
					<img data-z="-1400" class="earth frozen" src="<?php echo img('earth-frozen.png'); ?>" />
				</section>
				<section class="section-ocean" style="height: 2700px">
					<div data-z="-1" class="water"></div>
					<div style="top: 0px; left: 30px" data-z="-200" class="terrain-right"></div>
					<img data-z="-100" class="salt" src="<?php echo img('salt.png'); ?>" />
					<img data-z="100" class="beaker" src="<?php echo img('beaker.png'); ?>" />
					<img data-z="-100" style="left:0; top: 800px" src="<?php echo img('whale.png'); ?>" />
					<img data-z="-1000" style="left:-1400px; top: 1000px" src="<?php echo img('whale.png'); ?>" />
					<img data-z="-1000" style="left:1000px; top: 1100px" src="<?php echo img('whale.png'); ?>" />
					<img data-z="-600" style="left:-800px; top: 1600px" src="<?php echo img('whale.png'); ?>" />
					<img data-z="-1800" style="left:-900px; top: 1800px" src="<?php echo img('whale.png'); ?>" />
					<img data-z="-1500" style="left:500px; top: 2000px" src="<?php echo img('whale.png'); ?>" />
					<div data-z="-1" class="floor"></div>
				</section>
				<section class="section-animal" style="height: 3000px">
					<img style="top: 500px; left: -700px" data-z="-400" src="<?php echo img('giraffe-right.png'); ?>" />
					<img style="top: 650px; left: -400px" data-z="-400" src="<?php echo img('giraffe-left.png'); ?>" />
					<img style="top: 650px; left: 115px;" data-z="-40" src="<?php echo img('shrub.png'); ?>" />
					<img style="top: 650px; left: 130px;" class="goat" data-z="-50" src="<?php echo img('goat.png'); ?>" />
					<img style="top: 900px; left: -600px; position: absolute;" data-fade='{"range":[8301, 8600]}' src="<?php echo img('web.png'); ?>" />
					<div style="top: 600px; left: -200px" data-z="-45" class="terrain-right"></div>
					<div style="top: 600px; left: -1000px" data-z="-500" class="terrain-left"></div>
				</section>
			</div>
		</div>
	</body>
</html>