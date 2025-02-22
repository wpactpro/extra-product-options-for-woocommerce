<?php
/**
 * Init section.
 *
 * @package    Extra_Product_Options_For_WooCommerce
 * @subpackage Extra_Product_Options_For_WooCommerce/includes
 */

if ( ! class_exists( 'EPOFW_Init' ) ) {
	/**
	 * EPOFW_Init class.
	 */
	class EPOFW_Init {
		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			add_action( 'init', array( $this, 'init' ) );
			add_action( 'plugins_loaded', array( $this, 'epofw_load_plugin_text_domain' ) );
			add_filter( 'woocommerce_locate_template', array( $this, 'epofw_locate_wc_template' ), 20, 2 );
		}

		/**
		 * Define the plugins name and versions and also call admin section.
		 *
		 * @since 1.0.0
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Required files.
		 *
		 * @since    1.0.0
		 */
		public function init() {
			require_once EPOFW_PLUGIN_DIR_PATH . 'settings/epofw-common-function.php';
			require_once EPOFW_PLUGIN_DIR_PATH . 'settings/epofw-actions.php';
			require_once EPOFW_PLUGIN_DIR_PATH . 'includes/class-epofw-admin.php';
			require_once EPOFW_PLUGIN_DIR_PATH . 'includes/class-epofw-front.php';
			EPOFW_Front::instance();
			if ( class_exists( 'WOOCS' ) ) {
				require_once EPOFW_PLUGIN_DIR_PATH . 'includes/class-epofw-woocs-compatiblity.php';
				EPOFW_Woocs_Compatiblity::instance();
			}
			if ( class_exists( 'WooCommerceWholeSalePrices' ) ) {
				require_once EPOFW_PLUGIN_DIR_PATH . 'includes/class-epofw-wc-wholesale-prices-rymera.php';
				EPOFW_WC_Wholesale_Prices_Rymera::instance();
			}
		}

		/**
		 * Load text domain file.
		 *
		 * @since 1.0.0
		 */
		public function epofw_load_plugin_text_domain() {
			load_plugin_textdomain( 'extra-product-options-for-woocommerce', false, basename( __DIR__ ) . '/languages/' );
		}

		/**
		 * Function to locates the WooCommerce template files from this plugin.
		 *
		 * @since 3.0.4
		 *
		 * @param string $template      Already found template.
		 * @param string $template_name Searchable template name.
		 *
		 * @return string search result for the template
		 * @internal
		 */
		public function epofw_locate_wc_template( $template, $template_name ) {
			// Set the path to our templates directory.
			$plugin_path = EPOFW_PLUGIN_DIR_PATH . '/woocommerce/';

			// If a template is found, make it so.
			if ( is_readable( $plugin_path . $template_name ) ) {
				$template = $plugin_path . $template_name;
			}

			return $template;
		}
	}
}
$epofw_init = new EPOFW_Init();
