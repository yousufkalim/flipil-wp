<?php
/**
 * Functions used in Electro
 *
 * @since 2.0
 */

require_once get_template_directory() . '/inc/functions/header.php';
require_once get_template_directory() . '/inc/functions/home.php';

if ( ! function_exists( 'electro_handheld_header_responsive_class' ) ) {
    function electro_handheld_header_responsive_class() {
        return apply_filters( 'electro_handheld_header_responsive_class', 'hidden-xl-up' );
    }
}

if ( ! function_exists( 'electro_desktop_header_responsive_class' ) ) {
    function electro_desktop_header_responsive_class() {
        return apply_filters( 'electro_desktop_header_responsive_class', 'hidden-lg-down' );
    }
}

if ( ! function_exists( 'wp_body_open' ) ) {

	/**
	 * Shim for wp_body_open, ensuring backwards compatibility with versions of WordPress older than 5.2.
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}
