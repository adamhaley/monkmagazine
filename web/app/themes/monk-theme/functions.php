<?php
/**
 * Monk-theme Theme functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package monk-theme
 */

add_action( 'wp_enqueue_scripts', 'twentytwentythree_parent_theme_enqueue_styles' );

/**
 * Enqueue scripts and styles.
 */
function twentytwentythree_parent_theme_enqueue_styles() {
	wp_enqueue_style( 'twentytwentythree-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'monk-theme-style',
		get_stylesheet_directory_uri() . '/style.css',
		[ 'twentytwentythree-style' ]
	);
}
