<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400&display=swap" rel="stylesheet">


	<?php wp_head(); ?>
</head>
<body>
<div class="gutter">

</div>
<header>

	<img class="header" src="<?php echo esc_url( get_stylesheet_directory_uri() .  '/assets/images/monk-magazine.jpg' ); ?>" alt="Monk Magazine">
</header>
<div class="gutter">
	<div class="hamburger">
		<svg xmlnas="http://www.w3.org/2000/svg" class="menu"  viewBox="0 0 459 459">
			<path d="M0 382.5h459v-51H0v51zM0 255h459v-51H0v51zM0 76.5v51h459v-51H0z"/>
		</svg>
		<svg xmlns="http://www.w3.org/2000/svg" class="close" preserveAspectRatio="xMidYMid" viewBox="0 0 28 28">
			<path d="M27.123 25.002l-2.12 2.12-11.44-11.438-11.44 11.44L.003 25l11.438-11.44L.003 2.122l2.12-2.12 11.44 11.44L25.002 0l2.12 2.12-11.438 11.44 11.44 11.44z" fill-rule="evenodd"/>
		</svg>
	</div>
</div>
