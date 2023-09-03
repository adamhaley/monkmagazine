<?php get_header(); ?>

<div class="container">
	<!-- simple mobile true image -->
	<div class="row">
		<img class="simple-mobile-true" src="<?php echo esc_url( get_stylesheet_directory_uri() .  '/assets/images/simple-mobile-true.png' ); ?>" alt="Simple.Mobile.True." >
	</div><br />
	<?php
		$args = array(
			'post_type' => 'attachment',
			'numberposts' => '10',
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
				echo "<li class='issue'><a href='" . get_permalink() . "'><img src='" . get_the_post_thumbnail_url() . "' alt='" . get_the_title() . "' /></a></li>";
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
			<li class="product"><img src="https://placekitten.com/g/200/300" alt="Issue #4"></li>
			<li class="product"><img src="https://placekitten.com/g/200/300" alt="Issue #4"></li>
			<li class="product"><img src="https://placekitten.com/g/200/300" alt="Issue #4"></li>
			<li class="product"><img src="https://placekitten.com/g/200/300" alt="Issue #5"></li>
			<li class="product"><img src="https://placekitten.com/g/200/300" alt="Issue #6"></li>
			<li class="product"><img src="https://placekitten.com/g/201/300" alt="Issue #7"></li>
			<li class="product"><img src="https://placekitten.com/g/200/300" alt="Issue #8"></li>
			<li class="product"><img src="https://placekitten.com/g/200/300" alt="Issue #9"></li>
			<li class="product"><img src="https://placekitten.com/g/200/300" alt="Issue #10"></li>
			<li class="product"><img src="https://placekitten.com/g/200/300" alt="Issue #11"></li>
			<li class="product"><img src="https://placekitten.com/g/200/300" alt="Issue #12"></li>
			<li class="product"><img src="https://placekitten.com/g/200/300" alt="Issue #13"></li>
			<li class="product"><img src="https://placekitten.com/g/200/300" alt="Issue #14"></li>
			<li class="product"><img src="https://placekitten.com/g/200/300" alt="Issue #15"></li>
			<li class="product"><img src="https://placekitten.com/g/200/300" alt="Issue #16"></li>
			<li class="product"><img src="https://placekitten.com/g/200/300" alt="Issue #17"></li>
			<li class="product"><img src="https://placekitten.com/g/200/300" alt="Issue #18"></li>
			<li class="product"><img src="https://placekitten.com/g/200/300" alt="Issue #19"></li>
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
				Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias atque doloremque dolorum et, ipsa laboriosam, libero modi odit officia quibusdam sed tempora tenetur vel vitae voluptatum! Laudantium quaerat quo voluptas.
				Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>

			<br />
			<!-- main image carousel -->
			<div id="monk-on-the-road" class="carousel slide" data-ride="carousel">
				<ol class="carousel-indicators">
					<li data-target="#monk-on-the-road" data-slide-to="0" class="active"></li>
					<li data-target="#monk-on-the-road" data-slide-to="1"></li>
					<li data-target="#monk-on-the-road" data-slide-to="2"></li>
				</ol>
				<div class="carousel-inner">
					<div class="carousel-item active">
						<img class="d-block w-600" src="<?php echo esc_url( get_stylesheet_directory_uri() .  '/assets/images/on-the-road.jpg' ) ?>" alt="Monk On The Road" class="monk-on-the-road" />
					</div>
					<div class="carousel-item">
						<!--place kitten -->
						<img class="d-block w-300" src="https://placekitten.com/g/798/534" alt="Second slide">
					</div>
					<div class="carousel-item">
						<img class="d-block w-300" src="https://placekitten.com/g/798/534" alt="Third slide">
					</div>
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
			<!--three columns-->
			<div class="thrill">
				<img src="https://placekitten.com/g/200/200" alt="Issue #4" />
				<br />
				<p class="thrill-content">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias atque doloremque dolorum et, ipsa laboriosam, libero modi odit officia quibusdam sed tempora tenetur vel vitae voluptatum! Laudantium quaerat quo voluptas.
					<span class="extended">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias atque doloremque dolorum et, ipsa laboriosam, libero modi odit officia quibusdam sed tempora tenetur vel vitae voluptatum! Laudantium quaerat quo voluptas.
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias atque doloremque dolorum et, ipsa laboriosam, libero modi odit officia quibusdam sed tempora tenetur vel vitae voluptatum! Laudantium quaerat quo voluptas.
							</span>
				</p>
			</div>
			<div class="thrill">
				<img src="https://placekitten.com/g/200/200" alt="Issue #5" />
				<br />
				<p class="thrill-content">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias atque doloremque dolorum et, ipsa laboriosam, libero modi odit officia quibusdam sed tempora tenetur vel vitae voluptatum! Laudantium quaerat quo voluptas.
					<span class="extended">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias atque doloremque dolorum et, ipsa laboriosam, libero modi odit officia quibusdam sed tempora tenetur vel vitae voluptatum! Laudantium quaerat quo voluptas.
								Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias atque doloremque dolorum et, ipsa laboriosam, libero modi odit officia quibusdam sed tempora tenetur vel vitae voluptatum! Laudantium quaerat quo voluptas.
							</span>

				</p>
			</div>
			<div class="thrill">
				<img src="https://placekitten.com/g/200/200" alt="Issue #6" />
				<br />
				<p class="thrill-content">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias atque doloremque dolorum et, ipsa laboriosam, libero modi odit officia quibusdam sed tempora tenetur vel vitae voluptatum! Laudantium quaerat quo voluptas.
					<span class="extended">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias atque doloremque dolorum et, ipsa laboriosam, libero modi odit officia quibusdam sed tempora tenetur vel vitae voluptatum! Laudantium quaerat quo voluptas.
								Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias atque doloremque dolorum et, ipsa laboriosam, libero modi odit officia quibusdam sed tempora tenetur vel vitae voluptatum! Laudantium quaerat quo voluptas.
								Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias atque doloremque dolorum et, ipsa laboriosam, libero modi odit officia.
							</span>
				</p>
			</div>
		</div>
		<div class="overflow-bottom">
			<i class="close-icon fa fa-minus"></i>
		</div>
	</div>
</div>
<?php get_footer(); ?>
