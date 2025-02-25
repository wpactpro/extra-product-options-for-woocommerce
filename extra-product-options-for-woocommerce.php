<?php
/**
 * Plugin Name:         Extra Product Options for WooCommerce
 * Description:         Extra product options for WooCommerce Plugin allows you to add custom form fields (12+ field types) and sections to your WooCommerce product page. Easy way to add custom fields as per your requirement
 * Version:             3.1.0
 * Author:              actpro
 * Author URI:          https://profiles.wordpress.org/actpro/
 * License:             GPL-2.0+
 * License URI:         http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:         extra-product-options-for-woocommerce
 * Domain Path:         /languages
 *
 * WC requires at least: 3.6
 * WC tested up to: 9.7.0
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
	define( 'EPOFW_PLUGIN_DIR', __DIR__ );
}
if ( ! defined( 'EPOFW_PLUGIN_FILE' ) ) {
	define( 'EPOFW_PLUGIN_FILE', __FILE__ );
}
if ( ! defined( 'EPOFW_PLUGIN_DIR_PATH' ) ) {
	define( 'EPOFW_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'EPOFW_PLUGIN_BASENAME' ) ) {
	define( 'EPOFW_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
}
if ( ! defined( 'EPOFW_UPLOAD_DIR' ) ) {
	define( 'EPOFW_UPLOAD_DIR', 'epofw_files' );
}
require_once EPOFW_PLUGIN_DIR_PATH . 'settings/epofw-constant.php';

/**
 * Load plugin text domain.
 */
function epofw_load_textdomain() {
	/**
	 * Apply filters for local plugin path with slug.
	 *
	 * @since 1.0.0
	 */
	$locale = apply_filters( 'plugin_locale', get_locale(), EPOFW_SLUG );
	$mofile = EPOFW_SLUG . '-' . $locale . '.mo';
	$path   = WP_PLUGIN_DIR . '/' . trim( EPOFW_FOLDER_SLUG . '/languages', '/' );
	load_textdomain( EPOFW_SLUG, $path . '/' . $mofile );
	/**
	 * Apply filters for translation file path.
	 *
	 * @since 1.0.0
	 */
	$plugin_rel_path = apply_filters( 'extra_product_options_for_woocommerce_translation_file_rel_path', EPOFW_SLUG . '/languages' );
	load_plugin_textdomain( EPOFW_SLUG, false, $plugin_rel_path );
}
add_action( 'plugins_loaded', 'epofw_load_textdomain' );

/**
 * The code that runs during plugin activation.
 */
function epofw_activate_fn() {
	if (
		! in_array(
			'woocommerce/woocommerce.php',
			/**
			 * Apply filters for active plugins.
			 *
			 * @since 1.0.0
			 */
			apply_filters(
				'active_plugins',
				get_option( 'active_plugins' )
			),
			true
		)
	) {
		wp_die( '<strong>' . esc_html( EPOFW_PLUGIN_NAME ) . '</strong> plugin requires <strong>WooCommerce</strong>. Return to <a href=' . esc_url( get_admin_url( null, 'plugins.php' ) ) . '>Plugins page</a>.' );
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
		'configure'     => sprintf(
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
		'pro_configure' => sprintf(
			'<a href="%s" target="_blank">%s</a>',
			esc_url( 'https://codecanyon.net/item/extra-product-options-for-woocommerce/29808317' ),
			esc_html__( 'Premium Features', 'extra-product-options-for-woocommerce' )
		),
	);

	return array_merge( $custom_actions, $actions );
}

if (
	in_array(
		'woocommerce/woocommerce.php',
		/**
		 * Apply filters for active plugins.
		 *
		 * @since 1.0.0
		 */
		apply_filters(
			'active_plugins',
			get_option( 'active_plugins' )
		),
		true
	)
) {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-epofw-init.php';
}

/**
 * Function will run migration process for lower version 2.0.
 */
function epofw_migration_callback() {
	if ( version_compare( EPOFW_PLUGIN_VERSION, '2.0', '<' ) ) {
		$product_option_args = array(
			'post_type'      => EPOFW_DFT_POST_TYPE,
			'post_status'    => array( 'draft', 'publish' ),
			'posts_per_page' => - 1,
			'orderby'        => 'ID',
			'order'          => 'DESC',
			'fields'         => 'ids',
		);

		$prd_wp_query = new WP_Query( $product_option_args );
		$old_data     = array();
		if ( $prd_wp_query->have_posts() ) {
			foreach ( $prd_wp_query->posts as $f_id ) {
				if ( ! get_post_meta( $f_id, 'epofw_mgr_status', true ) ) {
					$old_data[ $f_id ] = $f_id;
				}
			}
		}
		$total_count               = count( $old_data );
		$get_epofw_migration_count = get_option( 'epofw_migration_count' );
		if ( (int) $get_epofw_migration_count !== (int) $total_count ) {
			include plugin_dir_path( __FILE__ ) . 'includes/class-epofw-bg-process.php';
			$background_process = new EPOFW_Bg_Process();
			if ( ! empty( $old_data ) ) {
				$background_process->push_to_queue( $old_data );
				$background_process->save()->dispatch();
			}
		}
	}

	if ( version_compare( EPOFW_PLUGIN_VERSION, '3.0.3', '>' ) ) {
		$get_data        = get_option( 'epofw_general_data' );
		$check_migration = get_option( 'epofw_migration_304' );
		if ( ! $check_migration && is_serialized( $get_data ) ) {
			$get_data           = maybe_unserialize( $get_data );
			$epofw_general_data = epofw_check_array_key_exists( 'epofw_general_data', $get_data );
			update_option( 'epofw_general_data', sanitize_array( $epofw_general_data ) );
			update_option( 'epofw_migration_304', true );
		}
	}
}
add_action( 'init', 'epofw_migration_callback' );
