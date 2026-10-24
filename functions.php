<?php
/**
 * Whalebone Inn child theme (parent: Twenty Twenty-Five).
 *
 * @package whalebone-child
 */

defined( 'ABSPATH' ) || exit;

define( 'WHALEBONE_VER', '1.0.0' );
define( 'WHALEBONE_TPL', 'page-templates/template-home.php' );

/**
 * Parent + child stylesheet for any normal (non-landing) views.
 */
add_action( 'wp_enqueue_scripts', function () {
	if ( whalebone_is_landing() ) {
		return;
	}
	wp_enqueue_style( 'twentytwentyfive-style', get_template_directory_uri() . '/style.css', array(), wp_get_theme( 'twentytwentyfive' )->get( 'Version' ) );
	wp_enqueue_style( 'whalebone-child-style', get_stylesheet_uri(), array( 'twentytwentyfive-style' ), WHALEBONE_VER );
} );

/**
 * True when the current request should render the animated home page:
 * the static front page, or any page assigned the "Whalebone Home" template.
 */
function whalebone_is_landing() {
	if ( is_front_page() ) {
		return true;
	}
	return is_page() && get_page_template_slug() === WHALEBONE_TPL;
}

/**
 * Force the landing template. Needed because block-theme HTML templates in the
 * parent would otherwise win over a PHP template in the child.
 */
add_filter( 'template_include', function ( $template ) {
	if ( whalebone_is_landing() ) {
		$custom = get_stylesheet_directory() . '/' . WHALEBONE_TPL;
		if ( file_exists( $custom ) ) {
			return $custom;
		}
	}
	return $template;
}, 99 );

/**
 * Make the PHP template selectable under Page > Template in block themes.
 */
add_filter( 'theme_page_templates', function ( $templates ) {
	$templates[ WHALEBONE_TPL ] = __( 'Whalebone Home', 'whalebone-child' );
	return $templates;
} );

/**
 * Landing-page assets.
 */
add_action( 'wp_enqueue_scripts', function () {
	if ( ! whalebone_is_landing() ) {
		return;
	}
	// Drop block-library/global styles so the parent doesn't fight the design.
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'global-styles' );
	wp_dequeue_style( 'classic-theme-styles' );

	wp_enqueue_style( 'whalebone-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap', array(), null );
	wp_enqueue_style( 'whalebone-home', get_stylesheet_directory_uri() . '/assets/css/home.css', array( 'whalebone-fonts' ), WHALEBONE_VER );
	wp_enqueue_script( 'whalebone-home', get_stylesheet_directory_uri() . '/assets/js/home.js', array(), WHALEBONE_VER, true );
}, 20 );

add_action( 'wp_head', function () {
	if ( whalebone_is_landing() ) {
		echo '<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
		echo '<meta name="theme-color" content="#132822">' . "\n";
	}
}, 1 );

/** Small helper for image URLs. */
function whalebone_img( $file ) {
	return esc_url( get_stylesheet_directory_uri() . '/assets/img/' . $file );
}
