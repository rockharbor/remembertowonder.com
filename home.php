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
		<script>
			$(document).ready(function() {
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
					$('body').timeline('trigger', [0, $('.wrap')[0].scrollHeight], function(evt) {
						$('.viewport').css({
							'perspective-origin-y': $(window).scrollTop()
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
				
				$('[data-fade]').each(function() {
					var el = this;
					var pos = $(el).offset();
					var start = pos.top - 400 < 0 ? 1 : pos.top - 400;
					var end = pos.top - 50;
					$('body').timeline('trigger', start, function(evt) {
						if (evt.direction === 'down') {
							$(el).animate({opacity: 1});
						} else {
							$(el).animate({opacity: 0});
						}
					});
					$('body').timeline('trigger', end, function(evt) {
						if (evt.direction === 'down') {
							$(el).animate({opacity: 0});
						} else {
							$(el).animate({opacity: 1});
						}
					});
					$(el).css({opacity: 0});
				})
			});
		</script>
	</head>
	<body class="experience">
		<div class="wrap">
			<div class="viewport">
				<section class="section-sun">
					<p>Have you ever thought about the sun?</p>
					<img class="sun" src="<?php echo img('sun.png'); ?>" />
					<img class="sun-hot" src="<?php echo img('sun-hot.png'); ?>" />
					<p>The temperature on its surface is 10,000 degrees.</p>
					<p>At its core, it is a paltry 27,000,000 degrees.</p>
					<p>Its pressure is 340,000,000 times greater than the earth&apos;s at sea level.</p>
					<p>Its estimated mass is 220 duodecillion pounds.</p>
					<p>And this sun is just one of about 200 billion stars in our universe.</p>
				</section>
			</div>
		</div>
	</body>
</html>