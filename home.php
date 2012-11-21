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
			<p>
				How have we lost our sense of wonder?<br />
				<span class="large">Think about the sun..</span>
			</p>
			<div class="solar-system"></div>
		</section>
		<section class="slide3">
			
		</section>
		<section class="slide4">
			
		</section>
		<section class="slide5">
			
		</section>
		<section class="slide6">
			
		</section>
		<section class="slide7">
			
		</section>
		<section class="slide8">
			
		</section>
		<section class="slide9">
			
		</section>
		<section class="slide10">
			
		</section>
		<section class="slide11">
			
		</section>
		<section class="slide12">
			
		</section>
	</body>
</html>