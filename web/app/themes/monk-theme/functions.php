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

add_action('after_setup_theme', 'monketheme_support');
function monktheme_register_styles(){
	$version = wp_get_theme()->get('Version');
	wp_enqueue_style('monktheme-bootstrap', "https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css", array(), '4.5.2', 'all');
	wp_enqueue_style('monktheme-googlefonts', "https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap", array(), '1.0', 'all');
	wp_enqueue_style( 'monktheme-style',
		get_stylesheet_directory_uri() . '/style.css',
		[ ],
		$version
	);
}

function monktheme_register_scripts(){
	$version = wp_get_theme()->get('Version');
	wp_enqueue_script('monktheme-jquery', "https://code.jquery.com/jquery-3.6.0.slim.min.js", array(), '3.6.0', true);

	wp_enqueue_script('monktheme-bootstrap', "https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js", array(), '4.5.2', true);
	wp_enqueue_script('monktheme-main', get_stylesheet_directory_uri() . "/assets/bundle.js", array(), $version, true);
}

function smartwp_remove_wp_block_library_css(){
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'wc-blocks-style' ); // Remove WooCommerce block CSS
}
add_action( 'wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css', 100 );
add_action('wp_enqueue_scripts', 'monktheme_register_styles');
add_action('wp_enqueue_scripts', 'monktheme_register_scripts');
