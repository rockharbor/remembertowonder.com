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
		<script>
			$(document).ready(function() {
				$('[data-z]').each(function() {
					$(this).css({
						transform: 'translate3d(0, 0, '+$(this).data('z')+'px)'
					});
				});
				// setup timeline
				$('body').timeline({
					debug: true
				});
				// set up perspective change to always be where the user is
				$('body').timeline('trigger', [0, $('.wrap')[0].scrollHeight], function(evt) {
					$('.viewport').css({
						'perspective-origin-y': $(window).scrollTop()
					});
				});
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