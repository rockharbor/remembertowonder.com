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
		<script>
			$(document).ready(function() {
				// setup timeline
				$('body').timeline({
					debug: true
				});
				// create factoids
				$('article > .factoid').each(function() {
					new Factoid(this);
				});
				// create solar systems
				$('.solar-system').each(function() {
					var ss = new SolarSystem(this);
					ss.spaceColor = $(this).closest('section').css('backgroundColor');
					ss.draw();
				});
			});
		</script>
	</head>
	<body class="experience">
		<section class="slide1">
			
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
				<div class="factoid f1">
					<p class="fact">It sits about 93,000,000 miles from the sun.</p>
					<div class="factoid f2"><p class="fact">A minor decrease in that distance and the effect is catastrophic. Glaciers would melt. Most of our cities would flood. Ocean area would increase before potentially boiling and evaporating entirely.</p></div>
				</div>
				<div class="factoid f3"><p class="fact">Even the slightest movement of Earth, either toward or away from the sun, and life might not exist as we know it.</p></div>
				<div class="factoid f4"><p class="fact">A minor increase in that distance and the effect is also catastrophic. More glaciers means more reflection of the sun&apos;s heat. Colder ocean temperatures would trap and dissolve much of the atmosphere&apos;s carbon dioxide. A decrease in the presence of CO<sub>2</sub> could drop temperatures devastatingly low.</p></div>
			</article>
		</section>
		<section class="slide6">
			<article>
				<p>
					How have we lost our sense of wonder?<br />
					<span class="large">Think about the ocean...</span>
				</p>
			</article>
		</section>
		<section class="slide7">
			<article>
				<div class="factoid f1"><p class="fact">At 140,000,000 square miles, it occupies more than 70% of the Earth&apos;s surface.</p></div>
				<div class="factoid f2"><p class="fact">If you evaporated all its water and spread the resulting salt equally over the earth&apos;s land area, there would be a 500-foot layer that covered our continents.</p></div>
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
			
		</section>
		<section class="alternate slide9">
			
		</section>
		<section class="alternate slide10">
			
		</section>
		<section class="alternate slide11">
			
		</section>
		<section class="alternate slide12">
			
		</section>
	</body>
</html>