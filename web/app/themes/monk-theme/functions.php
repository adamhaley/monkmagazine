<?php
/**
 * Monk-theme Theme functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package monk-theme
 */

function monketheme_support(){
	add_theme_support('title-tag');
}

// add_action('wp_head', 'header_code');

function header_code() {
	echo '<!-- Global site tag (gtag.js) - Google Analytics --> <script async src="https://www.googletagmanager.com/gtag/js?id=G-NN2K5L"></script> <script>  window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag(\'js\', new Date()); gtag(\'config\', \'G-NN2K5L\');</script>';
}


add_action('after_setup_theme', 'monketheme_support');
function monktheme_register_styles(){
	$version = wp_get_theme()->get('Version');

	wp_enqueue_style('monktheme-googlefonts', "https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap", [], '1.0', 'all');
	wp_enqueue_style('monktheme-reset', get_stylesheet_directory_uri() . '/reset.css', [], $version, 'all');
	if(is_front_page()) {
		wp_enqueue_style('monktheme-bootstrap', "https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css", [], '4.5.2', 'all');
		wp_enqueue_style('monktheme-style',
			get_stylesheet_directory_uri() . '/style.css',
			[],
			$version
		);
	}else {
		wp_enqueue_style('shop-style',
			get_stylesheet_directory_uri() . '/shop.css',
			[],
			$version
		);
	}
}

function monktheme_register_scripts(){
	$version = wp_get_theme()->get('Version');
	wp_enqueue_script('monktheme-jquery', "https://code.jquery.com/jquery-3.6.0.slim.min.js", [], '3.6.0', true);
	wp_enqueue_script('monktheme-bootstrap', "https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js", [], '4.5.2', true);
	wp_enqueue_script('monktheme-main', get_stylesheet_directory_uri() . "/assets/bundle.js", [], $version, true);
	if(is_front_page()){
		wp_enqueue_script('monktheme-home', get_stylesheet_directory_uri() . "/assets/home.js", [], $version, true);
	}
}

function smartwp_remove_wp_block_library_css(){
	if(is_front_page()) {
		wp_dequeue_style('wp-block-library');
		wp_dequeue_style('wp-block-library-theme');
		wp_dequeue_style('wc-blocks-style'); // Remove WooCommerce block CSS
	}
}

/**woocommerce pages */
function add_open_container_div() {
	echo '<div class="container">';
}

function add_close_container_div() {
	echo '</div>';
}

function add_header() {
	get_header();
}

function add_footer() {
	get_footer();
}

function add_woo_support()
{
	add_theme_support( 'woocommerce' );
	add_theme_support( 'post-thumbnails' );
}

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 10 );
add_filter('woocommerce_product_description_heading', '__return_null' );
add_filter('use_block_editor_for_post', '__return_false');
add_action('after_setup_theme', 'add_woo_support');
add_action('wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css', 10);
add_action('wp_enqueue_scripts', 'monktheme_register_styles');
add_action('wp_enqueue_scripts', 'monktheme_register_scripts');
add_action('woocommerce_before_main_content','add_header', 5);
add_action('woocommerce_before_main_content','add_open_container_div', 7);
add_action('woocommerce_after_main_content','add_close_container_div', 150);
add_action('woocommerce_after_main_content','add_footer', 160);
// add_action('woocommerce_before_checkout_form','add_header', 1);
add_action('woocommerce_before_checkout_form','add_open_container_div', 7);
add_action('woocommerce_after_checkout_form','add_close_container_div', 170);
add_action('woocommerce_after_checkout_form','add_footer', 100);
add_action('woocommerce_before_cart','add_header', 5);
add_action('woocommerce_before_cart','add_open_container_div', 12);
add_action('woocommerce_after_cart','add_close_container_div', 200);
add_action('woocommerce_after_cart','add_footer', 215);
//add header before page content
add_action('the_content', 'add_header_to_page', 1);
function add_header_to_page($content) {
	if(is_page()) {
		add_header();
		add_open_container_div();
	}
	return $content;
}

//add footer after page content
add_action('the_content', 'add_footer_to_page', 300);
function add_footer_to_page($content) {
	ob_start();
	if(is_page()) {
		add_close_container_div() . add_footer();
	}
	$footer = ob_get_clean();
	return $content . $footer;
}



remove_action( 'wp_footer', 'the_block_template_skip_link' );

// REMOVE WP EMOJI
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
