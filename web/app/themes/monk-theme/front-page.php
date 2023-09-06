<?php get_header(); ?>

<div class="container">
	<!-- simple mobile true image -->
	<div class="row">
		<img class="simple-mobile-true" src="<?php echo esc_url( get_stylesheet_directory_uri() .  '/assets/images/simple-mobile-true.png' ); ?>" alt="Simple.Mobile.True." >
	</div><br />
	<?php
		$args = array(
			'post_type' => 'attachment',
			'numberposts' => '30',
			'orderby'	 => 'post_name',
			'order'		 => 'ASC',
			'category_name' => 'home-carousel'
		);
		$images = get_posts($args);

		$num_images = count($images);
	?>

	<!-- main image carousel -->
	<div id="monks-home" class="carousel slide" data-ride="carousel">
		<ol class="carousel-indicators">
			<?php
				foreach($images as $key => $image) {
					if ($key == 0) {
						echo '<li data-target="#monks-home" data-slide-to="' . $key . '" class="active"></li>';
					} else {
						echo '<li data-target="#monks-home" data-slide-to="' . $key . '"></li>';
					}
				}
			?>
		</ol>
		<div class="carousel-inner">
			<?php
				foreach($images as $key => $image) {
					if ($key == 0) {
						echo '<div class="carousel-item active">';
					} else {
						echo '<div class="carousel-item">';
					}
					echo "<img class='monks-home d-block w-300' src='" . wp_get_attachment_url($image->ID) . "' alt='Monks Home'>";
					echo '</div>';
				}
			?>
		</div>
		<a class="carousel-control-prev" href="#monks-home" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="carousel-control-next" href="#monks-home" role="button" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>

	<div class="content">
		<img class="read-this" src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/read-this.png' ) ?>" alt="Read This" /><br />
		<?php
			$post = get_post( 1 );

			echo $post->post_excerpt;
			?>
			<br /><br />

			<a name="read-this"></a>
		<a href="" class="more-link"><img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/more.png' ) ?>" alt="More" class="more" /><i class="fa fa-solid fa-plus"></i>
		</a>
	</div>
	<div class="row">
			<span class="overflow">
				<?php echo $post->post_content; ?>
				<div class="overflow-bottom">
					<i class="close-icon fa fa-minus"></i>
				</div>
			</span>

	</div>
	<div class="buy">
		<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/literally-buy.png' ) ?>" alt="Buy" />
	</div>

	<a href="" class="cart"><i class="fa fa-solid fa-shopping-cart"></i></a>
	<ul class="back-issues">
		<?php
			$args = array(
				'post_type'      => 'product',
				'posts_per_page' => 19,
				'orderby'	 => 'issue-number',
				'order'		 => 'ASC',
				'product_cat'    => 'back-issues'
			);

			$loop = new WP_Query( $args );
				if ( $loop->have_posts() ) {
				while ( $loop->have_posts() ) : $loop->the_post();
				echo "<li class='issue'><!--<a href='" . get_permalink() . "'>--><img src='" . get_the_post_thumbnail_url() . "' alt='" . get_the_title() . "' /><!--</a>--></li>";
				endwhile;
			} else {
				echo __( 'No products found' );
			}
			wp_reset_postdata();

			?>
	</ul>
	<a href="" class="more-stuff-to-buy"><img src="<?php echo esc_url( get_stylesheet_directory_uri() .   '/assets/images/more-stuff-to-buy.png' ) ?>" alt="More Stuff To Buy" class="more" /><i class="fa fa-solid fa-plus"></i></a>
	<div class="buy-overflow overflow">
		<ul class="more-stuff">
			<?php
			$args = array(
				'post_type'      => 'product',
				'posts_per_page' => 20,
				'order'		 => 'ASC',
				'product_cat'    => 'travel-guides',
			);

			$loop = new WP_Query( $args );
			if ( $loop->have_posts() ) {
				while ( $loop->have_posts() ) : $loop->the_post();
					echo "<li class='product'><!--<a href='" . get_permalink() . "'>--><img src='" . get_the_post_thumbnail_url() . "' alt='" . get_the_title() . "' /><!--</a>--></li>";
				endwhile;
			} else {
				echo __( 'No products found' );
			}
			wp_reset_postdata();

			?>
		</ul>
		<div class="overflow-bottom">
			<i class="close-icon fa fa-minus"></i>
		</div>
	</div>
	<div class="on-the-road">
		<div class="on-the-road-content">
			<p>
				<a name="on-the-road"></a>
				<img src="<?php echo esc_url( get_stylesheet_directory_uri() .   '/assets/images/on-the-road-with-the-monks.png' ) ?>" alt="On The Road With The Monks" class="on-the-road-with-the-monks" /><br />
				<?php

				$post = get_post(132);

				echo $post->post_content;

				?>
			<br />
			<!-- main image carousel -->
				<?php
				$args = array(
					'post_type' => 'attachment',
					'numberposts' => '30',
					'order' => 'ASC',
					'order_by' => 'post_name',
					'category_name' => 'on-the-road-carousel',
				);
				$images = get_posts($args);
				$num_images = count($images);
				?>

				<!-- main image carousel -->
				<div id="monk-on-the-road" class="carousel slide" data-ride="carousel">
					<ol class="carousel-indicators">
						<?php
						foreach($images as $key => $image) {
							if ($key == 0) {
								echo '<li data-target="#monk-on-the-road" data-slide-to="' . $key . '" class="active"></li>';
							} else {
								echo '<li data-target="#monk-on-the-road" data-slide-to="' . $key . '"></li>';
							}
						}
						?>
					</ol>
					<div class="carousel-inner">
						<?php
						foreach($images as $key => $image) {
							if ($key == 0) {
								echo '<div class="carousel-item active">';
							} else {
								echo '<div class="carousel-item">';
							}
							echo "<img class='monks-home d-block w-300' src='" . wp_get_attachment_url($image->ID) . "' alt='Monks Home'>";
							echo '</div>';
						}
						?>
					</div>
					<a class="carousel-control-prev" href="#monk-on-the-road" role="button" data-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="carousel-control-next" href="#monk-on-the-road" role="button" data-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
				</div>
			<a href="" class="more-thrills"><img src="<?php echo esc_url( get_stylesheet_directory_uri() .  '/assets/images/more-thrills.png' ) ?>" alt="More Thrills" class="more-thrills" /><i class="fa fa-solid fa-plus"></i></a>
		</div>
	</div>
	<div class="thrills-overflow overflow">
		<div class="thrills-wrapper">
			<?php
			$args = array(
				'posts_per_page' => 3,
				'order_by'		 => 'post_date',
				'order'		 => 'ASC',
				'category_name'    => 'more-thrills',
			);

			$loop = new WP_Query( $args );
			if ( $loop->have_posts() ) {
				while ( $loop->have_posts() ) : $loop->the_post();
					echo "<div class='thrill'>";
					echo "<img src='" . get_the_post_thumbnail_url() . "' alt='" . get_the_title() . "' />";
					echo "<br />";
					echo "<p class='thrill-content'>" . get_the_content() . "</p>";
					echo "</div>";

				endwhile;
			} else {
				echo __( 'No thrills found' );
			}
			wp_reset_postdata();

			?>
		</div>
		<div class="overflow-bottom">
			<i class="close-icon fa fa-minus"></i>
		</div>
	</div>
</div>
<?php get_footer(); ?>
