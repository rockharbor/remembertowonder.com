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
					var obj = $(el).data('fade');
					var options = {
						enter: function() {},
						exit: function() {}
					}
					if (typeof obj === 'object') {
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
					}
					$('body').timeline('trigger', start, function(evt) {
						if (evt.direction === 'down') {
							$(el).animate({opacity: 1}, {complete: options['enter']});
						} else {
							$(el).animate({opacity: 0}, {complete: options['exit']});
						}
					});
					$('body').timeline('trigger', end, function(evt) {
						if (evt.direction === 'down') {
							$(el).animate({opacity: 0}, {complete: options['exit']});
						} else {
							$(el).animate({opacity: 1}, {complete: options['enter']});
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
				<section class="section-sun" style="height: 2000px">
					<p style="top: 300px" data-fade="true">Have you ever thought about the sun?</p>
					<img data-z="-2000" class="sun" src="<?php echo img('sun.png'); ?>" />
					<img data-z="-2000" class="sun hot" src="<?php echo img('sun-hot.png'); ?>" />
					<p style="top: 800px;" class="stickleft" data-fade="true">The temperature on its surface is 10,000 degrees.</p>
					<p style="top: 800px;" class="stickright"  data-fade="true">At its core, it is a paltry 27,000,000 degrees.</p>
					<p style="top: 1000px;" class="stickleft"  data-fade="true">Its pressure is 340,000,000 times greater than the earth&apos;s at sea level.</p>
					<p style="top: 1000px;" class="stickright"  data-fade="true">Its estimated mass is 220 duodecillion pounds.</p>
					<p style="top: 1500px" class="stickcenter" data-fade="true" >And this sun is just one of about 200 billion stars in our universe.</p>
				</section>
			</div>
		</div>
	</body>
</html>