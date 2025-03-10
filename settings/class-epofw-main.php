<?php
/**
 * Plugins main file.
 *
 * @package    Extra_Product_Options_For_WooCommerce
 * @subpackage Extra_Product_Options_For_WooCommerce/settings
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * EPOFW_MAIN class.
 */
if ( ! class_exists( 'EPOFW_MAIN' ) ) {
	/**
	 * EPOFW_MAIN class.
	 */
	class EPOFW_MAIN {
		/**
		 * The object of class.
		 *
		 * @since    1.0.0
		 * @var      string $instance instance object.
		 */
		protected static $instance = null;
		/**
		 * Get current page.
		 *
		 * @var $page string Store current page.
		 *
		 * @since 1.0.0
		 */
		private $page;
		/**
		 * Get current tab.
		 *
		 * @var $current_tab string Store current tab.
		 *
		 * @since 1.0.0
		 */
		private $current_tab;
		/**
		 * Define the plugins name and versions and also call admin section.
		 *
		 * @since    1.0.0
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}
		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			$this->page        = EPOFW_Admin::epofw_current_page();
			$this->current_tab = EPOFW_Admin::epofw_current_tab();
		}
		/**
		 * Main plugins form.
		 *
		 * @since 1.0.0
		 */
		public function epofw_main_form() {
			/**
			 * Fire action for the admin current tab.
			 *
			 * @since 1.0.0
			 */
			$current_tab_array = do_action( 'epofw_admin_action_current_tab' );
			if ( has_filter( 'epofw_ie_admin_tab_ft' ) ) {
				/**
				 * Apply filter for Admin tab.
				 *
				 * @since 1.0.0
				 */
				$tabing_array = apply_filters( 'epofw_ie_admin_tab_ft', $current_tab_array );
			} else {
				/**
				 * Apply filter for Admin tab.
				 *
				 * @since 1.0.0
				 */
				$tabing_array = apply_filters( 'epofw_admin_tab_ft', '' );
			}
			?>
			<div class="wrap woocommerce">
				<form method="post" enctype="multipart/form-data">
					<nav class="nav-tab-wrapper woo-nav-tab-wrapper">
						<?php
						if ( ! empty( $tabing_array ) ) {
							foreach ( $tabing_array as $name => $label ) {
								$url = EPOFW_Admin::dynamic_url( $this->page, $name );
								echo '<a href="' . esc_url( $url ) . '" class="nav-tab ';
								if ( $this->current_tab === $name ) {
									echo 'nav-tab-active';
								}
								echo '">' . esc_html( $label ) . '</a>';
							}
						}
						?>
					</nav>
					<?php
					if ( has_filter( 'epofw_ie_admin_page_ft' ) ) {
						/**
						 * Apply filter for Admin page.
						 *
						 * @since 1.0.0
						 */
						apply_filters( 'epofw_ie_admin_page_ft', $this->current_tab );
						/**
						 * Apply filter for getting page.
						 *
						 * @since 1.0.0
						 */
						apply_filters( 'epofw_getting_page', $this->current_tab );
					} else {
						/**
						 * Apply filter for getting page.
						 *
						 * @since 1.0.0
						 */
						apply_filters( 'epofw_getting_page', $this->current_tab );
					}
					?>
				</form>
			</div>
			<?php
		}
	}
}
