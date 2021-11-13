<?php
/**
 * Admin section.
 *
 * @package    Extra_Product_Options_For_WooCommerce
 * @subpackage Extra_Product_Options_For_WooCommerce/includes
 */
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'EPOFW_Admin_Notice' ) ) {
	class EPOFW_Admin_Notice {
		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			$this->epofw_init();
		}
		
		/**
		 * Register actions and filters.
		 *
		 * @since    1.0.0
		 */
		public function epofw_init() {
			add_action( 'admin_init', array( $this, 'epofw_notice_update' ) );
			add_action( 'admin_init', array( $this, 'epofw_notice_remindlater' ) );
			add_action( 'admin_init', array( $this, 'epofw_notice_review' ) );
			add_action( 'admin_notices', array( $this, 'epofw_upgrade_notice' ) );
			add_action( 'admin_notices', array( $this, 'epofw_review_notice' ) );
		}
		
		public function epofw_notice_update() {
			$reminder_date    = date( 'Y-m-d', strtotime( '+ 7 days' ) );
			$epofw_notice_mbl = get_option( 'epofw_notice_mbl' );
			if ( ! get_option( 'epofw_notice_rl' ) ) {
				update_option( 'epofw_notice_rl', $reminder_date );
				update_option( 'epofw_rt', 0 );
			}
			if ( $epofw_notice_mbl && date( 'Y-m-d' ) >= $epofw_notice_mbl ) {
				//update_option( 'epofw_notice_rl', $reminder_date );
			}
		}
		
		public function epofw_notice_review() {
			$current_date = date( 'Y-m-d', strtotime( ' + 7 Days' ) );
			$epofw_mbl    = filter_input( INPUT_GET, 'epofw-mbl', FILTER_SANITIZE_STRING );
			$epofw_add    = filter_input( INPUT_GET, 'epofw-ad', FILTER_SANITIZE_STRING );
			if ( isset( $epofw_mbl ) ) {
				update_option( 'epofw_notice_mbl', $current_date );
			}
			if ( isset( $epofw_add ) ) {
				update_option( 'epofw_notice_ad', 'true' );
			}
		}
		
		public function epofw_notice_remindlater() {
			$current_date        = date( 'Y-m-d', strtotime( ' + 7 days' ) );
			$reminder_later_date = date( 'Y-m-d', strtotime( ' + 15 days' ) );
			$epofw_rl            = filter_input( INPUT_GET, 'epofw-rl', FILTER_SANITIZE_STRING );
			$epofw_ug_dismissed  = filter_input( INPUT_GET, 'epofw-ug-dismissed', FILTER_SANITIZE_STRING );
			if ( isset( $epofw_rl ) ) {
				update_option( 'epofw_notice_rl', $current_date );
				update_option( 'epofw_rt', 1 );
				update_option( 'epofw_notice_mbl', $reminder_later_date );
			}
			if ( isset( $epofw_ug_dismissed ) ) {
				update_option( 'epofw_rt', 1 );
				update_option( 'epofw_notice_mbl', $reminder_later_date );
				update_option( 'epofw_notice_dismissed', 'true' );
			}
		}
		
		public function epofw_upgrade_notice() {
			$epofw_notice_rl = get_option( 'epofw_notice_rl' );
			if ( date( 'Y-m-d' ) >= $epofw_notice_rl && ! get_option( 'epofw_notice_dismissed' ) ) {
				?>
				<div class="notice is-dismissible epofw_notice_checking">
					<div class="epofw_notice_wrap">
						<div class="epofw_gravatar">
							<img alt=""
								src="<?php echo esc_url( EPOFW_PLUGIN_URL . 'assets/images/icon-128x128.png' ); ?>">
						</div>
						<div class="epofw_authorname">
							<div class="notice_texts">
								<?php
								printf(
									__( 'Upgrade <a href="%1$s" target="_blank">Extra Product Options for WooCommerce</a> to get more features.', 'extra-product-options-for-woocommerc' ),
									esc_url( 'https://codecanyon.net/item/extra-product-options-for-woocommerce/29808317' )
								);
								?>
							</div>
							<div class="epofw_desc">
								<div class="notice_button">
									<a class="epofw-button button-primary"
										href="<?php echo esc_url( 'https://codecanyon.net/item/extra-product-options-for-woocommerce/29808317' ); ?>"
										target="_blank"><?php echo _e( 'Buy Now', 'extra-product-options-for-woocommerce' ); ?></a>
									<a href="?epofw-rl"><?php echo _e( 'Remind me later', 'extra-product-options-for-woocommerce' ); ?></a>
									<a href="?epofw-ug-dismissed"><?php echo _e( 'Dismiss Notice', 'extra-product-options-for-woocommerce' ); ?></a>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
					<button type="button"
						class="notice-dismiss">
						<span class="screen-reader-text"></span>
					</button>
				</div>
			<?php }
		}
		
		public function epofw_review_notice() {
			$epofw_notice_mbl = get_option( 'epofw_notice_mbl' );
			$epofw_rt         = get_option( 'epofw_rt' );
			if ( '' !== $epofw_notice_mbl ) {
				if ( date( 'Y-m-d' ) >= $epofw_notice_mbl && $epofw_rt && ! get_option( 'epofw_notice_ad' ) ) {
					?>
					<div class="notice is-dismissible epofw_notice_checking">
						<div class="epofw_notice_wrap">
							<div class="epofw_gravatar">
								<img alt="<?php esc_html_e( 'Extra Product Options for WooCommerce' ); ?>"
									src="<?php echo esc_url( EPOFW_PLUGIN_URL . 'assets/images/icon-128x128.png' ); ?>">
							</div>
							<div class="epofw_authorname">
								<div class="epofw_prowc_notice_review_yes">
									<div class="notice_texts">
										<?php
										printf(
											__( 'That\'s awesome! If you find our plugin to be helpful, write a <a href="%1$s" target="_blank">review</a>! Reviews help us to not only improve our plugins and services but also to let others know that we care about delivering the best quality.', 'extra-product-options-for-woocommerc' ),
											esc_url( 'https://wordpress.org/plugins/extra-product-options-for-woocommerce/#reviews' )
										);
										?>
									</div>
									<div class="epofw_desc">
										<div class="notice_button">
											<a class="epofw-button button-primary"
												href="<?php echo esc_url( 'https://wordpress.org/plugins/extra-product-options-for-woocommerce/#reviews' ); ?>"
												target="_blank"><?php echo _e( 'Okay You Deserve It', 'extra-product-options-for-woocommerce' ); ?></a>
											<a class="epofw-button button action"
												href="?epofw-mbl"><?php echo _e( 'Nope Maybe later', 'extra-product-options-for-woocommerce' ); ?></a>
											<a class="epofw-button button action"
												href="?epofw-ad"><?php echo _e( 'I Already Did', 'extra-product-options-for-woocommerce' ); ?></a>
										</div>
									</div>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>

						<button type="button"
							class="notice-dismiss">
							<span class="screen-reader-text"></span>
						</button>

					</div>
				<?php }
			} ?>
		<?php }
	}
}
$epofw_admin_notice = new EPOFW_Admin_Notice();