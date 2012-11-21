<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<title>Remember To Wonder</title>
		<link rel="stylesheet" href="<?php echo $url['base']; ?>/css/reset.css" />
		<link rel="stylesheet" href="<?php echo $url['base']; ?>/css/fonts.css" />
		<link rel="stylesheet" href="<?php echo $url['base']; ?>/css/styles.css" />
		<script src="<?php echo $url['base']; ?>/js/rAF.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<style>
			html,
			body {
				height: 100%;
				width: 100%;
			}
			
			body {
				background: url('img/texture.gif');
				
				font-size: 62.5%; /*= reset browser to 10px */
			}
			
			canvas {
				position: absolute;
				top: 0;
				left: 0;
			}
			
			section {
				position: relative;
				height: 100%;
				width: 100%;
			}
			
			section {
				padding: 10px;
				display: table;
				
				background-image: 
					url('img/topleft.png'),
					url('img/topright.png'),
					url('img/bottomright.png'),
					url('img/bottomleft.png');
				background-repeat: no-repeat;
				background-position: 
					top left,
					top right,
					bottom right,
					bottom left;
			}
			
			section article {
				display: table-cell;
				vertical-align: middle;
				
				text-align: center;
			}
			
			img {
				max-width: 98%;
				margin-bottom: 100px;
			}
			
			p {
				font-family: 'benthamregular', 'Times', 'serif';
				color: #fff;
				
				font-size: 2.4em;
			}
			
			p.coming-soon {
				margin-bottom: 10px;
				font-size: 4em;
			}
		</style>
		<script>
			$(document).ready(function() {
				function shootingStaaaaaaaaar() {
					var starRadius = 2;
					var tailLength = 10;
					
					// pick a side, any side
					var side = Math.random() < .5 ? 'left' : 'right';
					// random start point between top and top of Wonder image
					var y = Math.random() * $('img').offset().top;
					// random horizontal speed (60-90)/frame
					var xSpeed = (Math.random()*30+60);
					// random vertical speed (10-20)/frame
					var ySpeed = (Math.random()*10+10)
					// aaaaaaand the slope
					var slope = ySpeed / xSpeed;
					// current position
					var pos = {
						x: side === 'left' ? 0 : $('body').width(),
						y: y
					};
					
					$('#star')[0].width = $('body').width();
					$('#star')[0].height = $('body').height();
					
					requestAnimationFrame(draw);
					function draw() {
						var context = $('#star')[0].getContext('2d');
						
						// get tail point deltas
						var angle = Math.atan(slope);
						var dx = Math.cos(angle) * tailLength;
						var dy = Math.sin(angle) * tailLength;
						
						// clear
						$('#star')[0].width = $('#star')[0].width;
						
						// adjust position
						if (side === 'left') {
							pos.x += xSpeed;
						} else {
							pos.x -= xSpeed;
						}
						pos.y += ySpeed;
						
						// draw star
						context.fillStyle = '#fff';
						context.arc(pos.x, pos.y, starRadius, 0, Math.PI * 2);
						context.fill();
						
						// draw tail
						context.beginPath();
						context.moveTo(pos.x, pos.y - starRadius);
						if (side === 'left') {
							context.lineTo(pos.x - dx, pos.y - dy);
						} else {
							context.lineTo(pos.x + dx, pos.y - dy);
						}
						context.lineTo(pos.x, pos.y + starRadius);
						context.lineTo(pos.x, pos.y - starRadius);
						context.closePath();
						context.fill();
						
						if (pos.x > -100 && pos.x < $('body').width()+100) {
							requestAnimationFrame(draw);
						}
					}

					setTimeout(shootingStaaaaaaaaar, Math.random()*8000+3000)
				}
				
				setTimeout(shootingStaaaaaaaaar, Math.random()*8000+3000)
			});
		</script>
	</head>
	<body>
		<canvas id="star"></canvas>
		<section>
			<article>
				<img src="img/wonder.png" alt="Wonder" />
				<p class="coming-soon">
					Coming Soon
				</p>
				<p>
					An interactive journey to re-discover the wonder around us and the Story where it all began.
				</p>
			</article>
		</section>
	</body>
</html>