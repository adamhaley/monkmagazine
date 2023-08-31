<?php
/**
 * Monk-theme Theme functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package monk-theme
 */


function monktheme_register_styles(){
	$version = wp_get_theme()->get('Version');
	wp_enqueue_style('monktheme-bootstrap', "https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css", array(), '4.4.1', 'all');
	wp_enqueue_style('monktheme-fontawesome', "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css", array(), '5.13.0', 'all');
	wp_enqueue_style('monktheme-googlefonts', "https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap", array(), '1.0', 'all');
	wp_enqueue_style( 'monktheme-style',
		get_stylesheet_directory_uri() . '/style.css',
		[ 'twentytwentythree-style' ]
	);
}

function monktheme_register_scripts(){
	$version = wp_get_theme()->get('Version');
	wp_enqueue_script('monktheme-jquery', "https://code.jquery.com/jquery-3.4.1.slim.min.js", array(), '3.4.1', true);
	wp_enqueue_script('monktheme-popper', "https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js", array(), '1.16.0', true);
	wp_enqueue_script('monktheme-bootstrap', "https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js", array(), '4.4.1', true);
	wp_enqueue_script('monktheme-main', get_stylesheet_directory_uri() . "/assets/bundle.js", array(), $version, true);
}

add_action( 'wp_enqueue_scripts', 'twentytwentythree_parent_theme_enqueue_styles' );
add_action('wp_enqueue_scripts', 'monktheme_register_styles');
add_action('wp_enqueue_scripts', 'monktheme_register_scripts');

/**
 * Enqueue scripts and styles.
 */
function twentytwentythree_parent_theme_enqueue_styles() {
	wp_enqueue_style( 'twentytwentythree-style', get_template_directory_uri() . '/style.css' );

}
