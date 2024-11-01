<?
/**
 * @package Small Pommo Integration
 * @author Ulrich Kautz
 * @version 0.4
 */
/*
Plugin Name: Small Pommo Integration
Plugin URI: http://blog.foaa.de/small-pommo-integration
Description: Links your wordress with a pommo installation .. you can provide insert and remove email formulars.
Author: Ulrich Kautz
Version: 0.4
Author URI: http://fortrabbit.de
*/
include_once( 'includes.php' );
include_once( 'frontend-gui.php' );

// shortcodes
add_shortcode( 'pommo-formular', 'spi_print_pommo_form' );
add_shortcode( 'pommo-ajax-formular', 'spi_print_pommo_ajax_form' );


// announce the menu item for admin..
add_action( 'admin_menu', 'spi_init_admin_menu' );

function spi_init_admin_menu() {
	add_options_page( 'Small Pommo Integration', 'Pommo',
		'manage_options', spi_plugin_path(). '/admin-gui.php', '' );
}

?>
