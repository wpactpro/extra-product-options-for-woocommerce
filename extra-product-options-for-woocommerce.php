<?php
/**
 * Plugin Name:         Extra Product Options for WooCommerce
 * Description:         Extra product options for WooCommerce Plugin allows you to add extra options (17+ field types) price fields to your WooCommerce products. Easy way to add custom fields as per your business requirement.
 * Version:             1.9.6.3
 * Author:              actpro
 * Author URI:          https://profiles.wordpress.org/actpro/
 * License:             GPL-2.0+
 * License URI:         http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:         extra-product-options-for-woocommerce
 * Domain Path:         /languages
 * WC requires at least: 3.0
 * WC tested up to: 5.7.1
 *
 * @package Extra_Product_Options_For_WooCommerce
 */
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! defined( 'EPOFW_PLUGIN_URL' ) ) {
	define( 'EPOFW_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}
if ( ! defined( 'EPOFW_PLUGIN_DIR' ) ) {
	define( 'EPOFW_PLUGIN_DIR', dirname( __FILE__ ) );
}
if ( ! defined( 'EPOFW_PLUGIN_DIR_PATH' ) ) {
	define( 'EPOFW_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'EPOFW_PLUGIN_BASENAME' ) ) {
	define( 'EPOFW_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
}
require_once plugin_dir_path( __FILE__ ) . 'settings/epofw-constant.php';
/**
 * The code that runs during plugin activation.
 */
function epofw_activate_fn() {
	if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) {
		wp_die( "<strong>" . esc_html( EPOFW_PLUGIN_NAME ) . "</strong> plugin requires <strong>WooCommerce</strong>. Return to <a href='" . esc_url( get_admin_url( null, 'plugins.php' ) ) . "'>Plugins page</a>." );
	} else {
		update_option( 'epofw_enable_logging', 'on' );
	}
}
register_activation_hook( __FILE__, 'epofw_activate_fn' );
$prefix = is_network_admin() ? 'network_admin_' : '';
add_filter(
	"{$prefix}plugin_action_links_" . EPOFW_PLUGIN_BASENAME,
	'epofw_plugin_action_links',
	10
);
/**
 * Add helpful link in plugins section.
 *
 * @param array $actions associative array of action names to anchor tags.
 *
 * @return array associative array of plugin action links
 *
 * @since 1.0.0
 */
function epofw_plugin_action_links( $actions ) {
	$custom_actions = array(
		'configure' => sprintf(
			'<a href="%s">%s</a>',
			esc_url(
				add_query_arg(
					array(
						'page' => 'epofw-main',
					),
					admin_url( 'edit.php?post_type=product' )
				)
			),
			esc_html__( 'Settings', 'extra-product-options-for-woocommerce' )
		),
		'pro_configure' => sprintf('<a href="%s" target="_blank">%s</a>',
			esc_url('https://codecanyon.net/item/extra-product-options-for-woocommerce/29808317'),
			esc_html__( 'Premium Features', 'extra-product-options-for-woocommerce' ) ),
	);
	return array_merge( $custom_actions, $actions );
}
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) {
	if ( ! class_exists( 'EPOFW_Init' ) ) {
		class EPOFW_Init {
			public function __construct() {
				add_action( 'init', array( $this, 'init' ) );
				add_action( 'plugins_loaded', array( $this, 'epofw_load_plugin_text_domain' ) );
			}
			public function init() {
				require_once plugin_dir_path( __FILE__ ) . 'settings/epofw-common-function.php';
				require_once plugin_dir_path( __FILE__ ) . 'includes/class-epofw-admin.php';
				require_once plugin_dir_path( __FILE__ ) . 'includes/class-epofw-front.php';
			}
			public function epofw_load_plugin_text_domain() {
				load_plugin_textdomain( 'extra-product-options-for-woocommerce', false, basename( dirname( __FILE__ ) ) . '/languages/' );
			}
		}
	}
	new EPOFW_Init();
}
