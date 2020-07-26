<?php
/**
 * Go functions and definitions
 *
 * @package Go
 */

/**
 * Theme constants.
 */
define( 'GO_VERSION', '1.3.3' );

/**
 * AMPP setup, hooks, and filters.
 */
require_once get_parent_theme_file_path( 'includes/amp.php' );

/**
 * Core setup, hooks, and filters.
 */
require_once get_parent_theme_file_path( 'includes/core.php' );

/**
 * Customizer additions.
 */
require_once get_parent_theme_file_path( 'includes/customizer.php' );

/**
 * Custom template tags for the theme.
 */
require_once get_parent_theme_file_path( 'includes/template-tags.php' );

/**
 * Pluggable functions.
 */
require_once get_parent_theme_file_path( 'includes/pluggable.php' );

/**
 * TGMPA plugin activation.
 */
require_once get_parent_theme_file_path( 'includes/tgm.php' );

/**
 * WooCommerce functions.
 */
require_once get_parent_theme_file_path( 'includes/woocommerce.php' );

/**
 * Page Titles Meta functions.
 */
require_once get_parent_theme_file_path( 'includes/title-meta.php' );

/**
 * Layouts for the CoBlocks layout selector.
 */
foreach ( glob( get_parent_theme_file_path( 'partials/layouts/*.php' ) ) as $filename ) {
	require_once $filename;
}

/**
 * Run setup functions.
 */
Go\AMP\setup();
Go\Core\setup();
Go\TGM\setup();
Go\Customizer\setup();
Go\WooCommerce\setup();
Go\Title_Meta\setup();

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Fire the wp_body_open action.
	 *
	 * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
	 */
	function wp_body_open() {
		// Triggered after the opening <body> tag.
		do_action( 'wp_body_open' );
	}
endif;

/**
 * sample usage of an action to prevent wordpress from autosaving posts.
 */
function disableAutoSave(){
    wp_deregister_script('autosave');
}
add_action( 'wp_print_scripts', 'disableAutoSave' );


add_action('wp_loaded','webendev_register_nav_menu_class');
/**
* New walker class to extend Walker_Nav_Menu
* Dynamically adds child categories to menu
*
*/
function webendev_register_nav_menu_class(){

	class Submenu_Walker_Nav_Menu extends Walker_Nav_Menu  {

	    function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
		extract($args);
			global $wp_query;
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

			$class_names = $value = '';
			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;
			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
			$class_names = ' class="' . esc_attr( $class_names ) . '"';

			$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
			$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
			$output .= $indent . '<li' . $id . $value . $class_names .'>';

			$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
			$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
			$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
			$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

			$item_output = $args->before;
			$item_output .= '<a'. $attributes .'>';
			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			$item_output .= '</a>';

			if($item->object == 'category'){
				$child_cats = wp_list_categories('title_li=&echo=0&hide_empty=0&child_of='.$item->object_id);
				if( $child_cats ){
					$item_output .= '<ul class="sub-menu">' .$child_cats. '</ul>';
				}

			}

			$item_output .= $args->after;
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

	    }

	}

}