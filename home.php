<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<title>Remember To Wonder</title>
		<link rel="stylesheet" href="<?php echo $url['base']; ?>/css/reset.css" />
		<link rel="stylesheet" href="<?php echo $url['base']; ?>/css/styles.css" />
		<link rel="stylesheet" href="<?php echo $url['base']; ?>/css/fonts.css" />
		<link rel="stylesheet" href="<?php echo $url['base']; ?>/css/mobile.css" media="screen and (max-width: 480px)" />
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
				$('body').timeline();
				
				if (Modernizr.testAllProps('perspective')) {
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
					$('[data-z]:not(.stars)').each(function() {
						var perspective = 1000;
						var times = Math.floor(Math.abs($(this).data('z')) / perspective);
						var fauxZScale = 1;
						while (times > 0) {
							fauxZScale -= fauxZScale/2;
							times--;
						}
						$(this).css({
							zIndex: $(this).data('z'),
							transform: 'scale('+fauxZScale+', '+fauxZScale+')',
							top: (fauxZScale * $(this).position().top)+'px'
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
						$('.background .section-animal .goat').transition({top: '600px'});
					},
					hideGoat: function() {
						$('.background .section-animal .goat').transition({top: '650px'});
					}
				}
				
				Human = {
					xRay: function(evt) {
						var perc = 100-evt.percent*100;
						$('.section-human .humanhand .hand').css({top: -(evt.percent*100)+'%'});
						$('.section-human .xray .bones').css({top: perc+'%'});
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
							hideAll();
							$(el).transition({opacity: 1}, options['enter']);
						} else {
							$(el).transition({opacity: 0}, options['exit']);
						}
					});
					$('body').timeline('trigger', options.range[1], function(evt) {
						if (evt.direction === 'down') {
							$(el).transition({opacity: 0}, options['exit']);
						} else {
							hideAll();
							$(el).transition({opacity: 1}, options['enter']);
						}
					});
					$(el).css({opacity: 0});
				});
				
				function hideAll() {
					$('body').find('p:not(.alwaysshow), h1:not(.alwaysshow)').filter(function() {
						return $(this).css('opacity') > 0;
					}).stop().clearQueue().css({opacity: 0});
					Sun.hideHot();
					Earth.hide();
					Ocean.hideBeaker();
					Ocean.hideSalt();
					Animal.hideGoat();
				}
				
				$('body').timeline('trigger', [10000, 10400], Human.xRay);
				
				$('p:not(.alwaysshow), h1:not(.alwaysshow)').filter(function() {
					return $(this).position().top > 320;
				}).addClass('quickmobilefix');
			});
		</script>
		<script type="text/javascript">

		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-7415608-12']);
		_gaq.push(['_trackPageview']);

		(function() {
		  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		  ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();

	 </script>
	</head>
	<body>
		<article>
			<section class="section-sun">
				<h1 style="top: 200px; opacity:1;" data-fade='{"range":[0, 400]}'>Have you ever thought about the sun?</h1>
				<p style="top:450px" class="stickleft" data-fade='{"range":[401, 800]}'>The temperature on its surface is 10,000 degrees.</p>
				<p style="top:450px" class="stickright" data-fade='{"range":[401, 800], "enter":"Sun.showHot", "exit":"Sun.hideHot"}'>At its core, it is a paltry 27,000,000 degrees.</p>
				<p class="p1 stickleft" data-fade='{"range":[1001, 1400]}'>Its pressure is 340,000,000 times greater than the earth&apos;s at sea level.</p>
				<p class="p2 stickright" data-fade='{"range":[1001, 1400]}'>Its estimated mass is 220,000,000,000,000, 000,000,000,000,000, 000,000,000,000 pounds.</p>
				<p style="top:450px" data-fade='{"range":[1501, 1800]}'>And this sun is just one of about 200 billion stars in our universe.</p>
			</section>
			<section class="section-earth">
				<h1 style="top:350px" data-fade='{"range":[2000, 2200]}'>Have you ever thought about the earth?</h1>
				<p style="top:400px" data-fade='{"range":[2201, 2600]}'>It sits about 93,000,000 miles from the sun.</p>
				<p style="top:450px;" class="stickleft" data-fade='{"range":[2601, 3000], "enter":"Earth.showFrozen", "exit":"Earth.hide"}'>A minor decrease in that distance and the effect is catastrophic. Glaciers would melt. Most of our cities would flood. Ocean area would increase before potentially boiling and evaporating entirely.</p>
				<p class="p1 stickright" data-fade='{"range":[3001, 3400], "enter":"Earth.showCold", "exit":"Earth.hide"}'>A minor increase in that distance and the effect is also catastrophic. More glaciers means more reflection of the sun&apos;s heat. Colder ocean temperatures would trap and dissolve much of the atmosphere&apos;s carbon dioxide.<br />A decrease in the presence of CO<sub>2</sub> could drop temperatures devastatingly low.</p>
				<p style="top:400px" data-fade='{"range":[3401, 3800]}'>Even the slightest movement of Earth, either toward or away from the sun, and life might not exist as we know it.</p>
			</section>
			<section class="section-ocean">
				<h1 style="top:350px" data-fade='{"range":[4001, 4400]}'>Have you ever thought about the ocean?</h1>
				<p class="p1 stickleft" data-fade='{"range":[4801, 5100], "enter":"Ocean.showSalt", "exit":"Ocean.hideSalt"}'>If you evaporated all its water and spread the resulting salt equally over the earth&apos;s land area, there would be a 500-foot layer that covered our continents.</p>
				<p class="p2 stickleft" data-fade='{"range":[5101, 5400]}'>At 140,000,000 square miles, it occupies more than 70% of the Earth&apos;s surface.</p>
				<p style="top:400px;color:#fff" data-fade='{"range":[5501, 5700], "enter":"Ocean.showBeaker","exit":"Ocean.hideBeaker"}'>A single milliliter of ocean water may contain tens of thousands of zooplankton, hundreds of thousands of phytoplankton, millions of bacterial cells, and more than ten million viruses.</p>
				<p style="top:500px;color:#fff" data-fade='{"range":[5801, 6300]}'>It provides 99% of the Earth&apos;s living space. More than 250,000 known species inhabit it.</p>
				<p class="p3" data-fade='{"range":[6301, 6500]}'>And less than 10% has been explored by humans.</p>
			</section>
			<section class="section-animal">
				<h1 style="top:350px" data-fade='{"range":[7120, 7350]}'>Have you ever thought about the Animal Kingdom?</h1>
				<p class="p1 stickleft" data-fade='{"range":[7501, 7700]}'>Giraffes do not have vocal chords, they communicate by vibrating the hairs on their neck.</p>
				<p style="top:530px;" class="stickright" data-fade='{"range":[8001, 8200], "enter":"Animal.showGoat", "exit":"Animal.hideGoat"}'>China boasts the world&apos;s highest goat population, coming in at more than 170,000,000.</p>
				<p class="p2" class="stickright" data-fade='{"range":[8301, 8600]}'>More than 70,000 kinds of spiders exist.</p>
				<p style="top:500px;" data-fade='{"range":[8701, 8900]}'>Roughly 1,000,000 land species have been named. Experts project that to be only 15% of what&apos;s out there. More than 5,500,000 have yet to be discovered.</p>
			</section>
			<section class="section-human">
				<h1 style="top:300px;" data-fade='{"range":[9300,9600]}'>Have you ever thought about the human body?</h1>
				<p class="p1 stickright" data-fade='{"range":[9801,10100]}'>Your body contains more than 10 TRILLION cells.</p>
				<p class="p2 stickright" data-fade='{"range":[10301,10500]}'>Your heart will probably beat upwards of 3 BILLION times in your life.</p>
				<p class="p3 stickright" data-fade='{"range":[10901,11100]}'>Your stomach produces new lining every 3 to 4 days. If it didn&apos;t, the acids used to digest your food would also digest your stomach.</p>
				<p class="p4" data-fade='{"range":[11401,11500]}'>Your body contains about 60,000 miles of blood vessels</p>
				<p style="top:450px;color:#000;" data-fade='{"range":[12201,12500]}'>If you&apos;re like the average person, you&apos;ll eat 50 tons of food and drink 10,000 gallons of liquid during your lifetime</p>
			</section>
			<section class="section-wonder">
				<p class="alwaysshow">This whole world is filled with Wonder.<br />The sun, the earth, the ocean, the animals, even you, all point to it.</p>
				<p class="alwaysshow">And as amazing and astonishing as this wonder is, there's an even bigger story where the truest wonder truly begins.</p>
				<p class="alwaysshow" style="margin-bottom: 200px;">Thousands of years ago, the God of the universe &mdash; the God who created our sun, earth, ocean, and animals &mdash; this all-powerful God game into this world to tell you just how wonderful you are.</p>
				<p class="p1 alwaysshow">This Christmas...<br />Re-discover the birthplace<br />of awe and amazement.</p>
				<p class="orange alwaysshow">Re-discover</p>
			</section>
			<section class="section-info">
				<p class="join alwaysshow">Join <a target="_blank" href="http://rockharbor.org"><strong>ROCK</strong>HARBOR Church</a> in Orange County for one of 20 Christmas services in 5 different cities.</p>
				<div class="times clearfix" style="text-align:center">
					<div style="width:50%;display: inline-block">
						<p class="f alwaysshow"><a target="_blank" href="http://rockharbor.org/events/christmas">Costa Mesa</a></p>
						<p class="t alwaysshow">Dec. 22: 6pm</p>
						<p class="t alwaysshow">Dec. 23: 9am, 11am, 7pm, 9pm</p>
						<p class="t alwaysshow">Dec. 24: 12pm, 2pm, 5pm, 7pm</p>
					</div>
				</div>
				<div class="times clearfix">
					<div style="width:49%;margin-left:1%;float:right">
						<p class="f alwaysshow"><a target="_blank" href="http://missionviejo.rockharbor.org/events/christmas">Mission Viejo</a></p>
						<p class="t alwaysshow">Dec. 24: 12pm &amp; 2pm</p>
					</div>
					<div style="width:49%;margin-left:1%;float:right">
						<p class="f alwaysshow"><a target="_blank" href="http://fullerton.rockharbor.org/events/christmas">Fullerton</a></p>
						<p class="t alwaysshow">Dec. 23: 10am &amp; 7pm</p>
						<p class="t alwaysshow">Dec. 24: 4pm &amp; 6pm</p>
					</div>
				</div>
				<div class="times clearfix">
					<div style="width:49%;margin-right:1%;float:left">
						<p class="f alwaysshow"><a target="_blank" href="http://huntingtonbeach.rockharbor.org/events/christmas">Huntington Beach</a></p>
						<p class="t alwaysshow">Dec. 23: 9am &amp; 11am</p>
						<p class="t alwaysshow">Dec. 24: 4pm</p>
					</div>
					<div style="width:49%;margin-right:1%;float:left">
						<p class="f alwaysshow"><a target="_blank" href="http://orange.rockharbor.org/events/christmas">Orange</a></p>
						<p class="t alwaysshow">Dec. 23: 10am</p>
						<p class="t alwaysshow">Dec. 24: 5pm</p>
					</div>
				</div>
			</section>
		</article>
		<div class="background">
			<div class="viewport">
				<section class="section-sun" style="height: 1900px">
					<img data-z="-2000" class="sun" src="<?php echo img('sun.png'); ?>" />
					<img data-z="-2000" class="sun hot" src="<?php echo img('sun-hot.png'); ?>" />
					<div data-z="-3000" class="stars"></div>
				</section>
				<section class="section-earth" style="height: 3200px">
					<img data-z="-1400" class="earth" src="<?php echo img('earth.png'); ?>" />
					<img data-z="-1400" class="earth cold" src="<?php echo img('earth-cold.png'); ?>" />
					<img data-z="-1400" class="earth frozen" src="<?php echo img('earth-frozen.png'); ?>" />
					<div data-z="-1600" class="stars"></div>
				</section>
				<section class="section-ocean" style="height: 2700px">
					<div data-z="-1" class="water"></div>
					<div data-z="-200" class="terrain-right"></div>
					<img data-z="-180" class="salt" src="<?php echo img('salt.png'); ?>" />
					<img data-z="100" class="beaker" src="<?php echo img('beaker.png'); ?>" />
					<img data-z="-100" style="left:0; top: 800px" src="<?php echo img('whale.png'); ?>" />
					<img data-z="-1000" style="left:-1400px; top: 1000px" src="<?php echo img('whale.png'); ?>" />
					<img data-z="-1000" style="left:1000px; top: 1100px" src="<?php echo img('whale.png'); ?>" />
					<img data-z="-600" style="left:-800px; top: 1600px" src="<?php echo img('whale.png'); ?>" />
					<img data-z="-1800" style="left:-900px; top: 1700px" src="<?php echo img('whale.png'); ?>" />
					<img data-z="-1500" style="left:500px; top: 1600px" src="<?php echo img('whale.png'); ?>" />
					<div data-z="-1" class="floor"></div>
				</section>
				<section class="section-animal" style="height: 1800px">
					<img class="g2" data-z="-400" src="<?php echo img('giraffe-right.png'); ?>" />
					<img class="g1" data-z="-400" src="<?php echo img('giraffe-left.png'); ?>" />
					<img class="shrub" data-z="-40" src="<?php echo img('shrub.png'); ?>" />
					<img class="goat" data-z="-50" src="<?php echo img('goat.png'); ?>" />
					<img class="web" data-fade='{"range":[8301, 8600]}' src="<?php echo img('web.png'); ?>" />
					<div style="top: 600px; left: -200px" data-z="-45" class="terrain-right"></div>
					<div data-z="-500" class="terrain-left"></div>
				</section>
				<section class="section-human" style="height: 4000px">
					<div class="humanhand">
						<img class="hand" src="<?php echo img('hand.png'); ?>" />
					</div>
					<div class="xray">
						<img class="bones" src="<?php echo img('xray.png'); ?>" />
						<img class="machine" src="<?php echo img('xray-machine.png'); ?>" />
					</div>
					<img class="heart" src="<?php echo img('heart.png'); ?>" />
					<img class="stomach" src="<?php echo img('stomach.png'); ?>" />
					<img class="bloodvessels" src="<?php echo img('bloodvessels.png'); ?>" />
					<img class="water" src="<?php echo img('water.png'); ?>" />
					<img class="scale" src="<?php echo img('scale.png'); ?>" />
				</section>
				<section class="section-wonder">
					<img class="tree" data-fade='{"range":[13500,15000]}' src="<?php echo img('tree.png'); ?>" />
					<img class="wonder" data-fade='{"range":[13500,15000]}' src="<?php echo img('wonder.png'); ?>" />
				</section>
				<section class="section-info" style="height: 500px">
				
				</section>
			</div>
		</div>
	</body>
</html>