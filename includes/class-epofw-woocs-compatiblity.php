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
/**
 * EPOFW_Woocs_Compatiblity class.
 */
if ( ! class_exists( 'EPOFW_Woocs_Compatiblity' ) ) {
	/**
	 * EPOFW_Woocs_Compatiblity class.
	 */
	class EPOFW_Woocs_Compatiblity {
		/**
		 * The object of class.
		 *
		 * @since    1.0.0
		 * @var      string $instance instance object.
		 */
		protected static $instance = null;

		/**
		 * The name of this plugin.
		 *
		 * @var      string $plugin_name The ID of this plugin.
		 *
		 * @since    1.0.0
		 */
		public function __construct() {
			$this->epofw_woocs_cmp_init();
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
		 * Function will call filters.
		 */
		public function epofw_woocs_cmp_init() {
			// phpcs:ignore.
			global $WOOCS;
			// phpcs:ignore.
			$default_currency                     = $WOOCS->default_currency;
			$woocs_raw_woocommerce_price_currency = filter_input( INPUT_GET, 'woocs_raw_woocommerce_price_currency', FILTER_SANITIZE_SPECIAL_CHARS );
			$current_currency                     = ! empty( $woocs_raw_woocommerce_price_currency ) ? sanitize_text_field( wp_unslash( $woocs_raw_woocommerce_price_currency ) ) : get_woocommerce_currency();
			if ( $current_currency !== $default_currency ) {
				add_filter( 'epofw_price_filter', array( $this, 'epofw_price_filter_callback' ), 10, 1 );
				remove_action(
					'woocommerce_before_calculate_totals',
					array(
						EPOFW_Front::instance(),
						'epofw_before_calculate_totals',
					)
				);
				add_action(
					'woocommerce_before_calculate_totals',
					array(
						$this,
						'epofw_woocs_before_calculate_totals',
					),
					10,
					1
				);
			}
			if ( is_admin() ) {
				add_filter( 'epofw_price_filter', array( $this, 'epofw_price_filter_callback' ), 10, 1 );
			}
			add_action( 'wp_enqueue_scripts', array( $this, 'epofw_front_woocs_enqueue_scripts_fn' ) );
		}

		/**
		 * Function will enqueue styles and scripts.
		 */
		public function epofw_front_woocs_enqueue_scripts_fn() {
			$get_woocs_option                     = get_option( 'woocs' );
			$woocs_raw_woocommerce_price_currency = filter_input( INPUT_GET, 'woocs_raw_woocommerce_price_currency', FILTER_SANITIZE_SPECIAL_CHARS );
			$current_currency                     = ! empty( $woocs_raw_woocommerce_price_currency ) ? sanitize_text_field( wp_unslash( $woocs_raw_woocommerce_price_currency ) ) : get_woocommerce_currency();
			if ( isset( $get_woocs_option[ $current_currency ] ) ) {
				wp_enqueue_script( 'epofw-front-js' );
				global $post;
				$product_data = ! empty( $post->ID ) ? wc_get_product( $post->ID ) : false;
				if ( $product_data ) {
					wp_localize_script(
						'epofw-front-js',
						'epofw_front_var',
						array(
							'ajaxurl'                       => admin_url( 'admin-ajax.php' ),
							'current_post_id'               => $post->ID,
							'product_price'                 => epofw_display_product_price( $product_data, 'shop' ),
							'currency'                      => get_woocommerce_currency_symbol(),
							'position'                      => isset( $get_woocs_option[ $current_currency ]['position'] ) ? $get_woocs_option[ $current_currency ]['position'] : get_option( 'woocommerce_currency_pos' ),
							'decimal_separator'             => wc_get_price_decimal_separator(),
							'thousand_separator'            => wc_get_price_thousand_separator(),
							'decimals'                      => wc_get_price_decimals(),
							'timepicker_select_validation'  => __( 'Please select a valid time.', 'extra-product-options-for-woocommerce' ),
							'timepicker_change_validation'  => __( 'Please enter a valid time.', 'extra-product-options-for-woocommerce' ),
							'datepicker_select_validation'  => __( 'Please select a valid date.', 'extra-product-options-for-woocommerce' ),
							'datepicker_change_validation'  => __( 'Please enter a valid date.', 'extra-product-options-for-woocommerce' ),
							'colorpicker_select_validation' => __( 'Please select a valid color code.', 'extra-product-options-for-woocommerce' ),
							'colorpicker_change_validation' => __( 'Please enter a valid color code.', 'extra-product-options-for-woocommerce' ),
						)
					);
				}
			}
		}

		/**
		 * Function will return price based on currency switcher.
		 *
		 * @param mixed $epofw_price Price of option.
		 *
		 * @return float|int|string
		 */
		public function epofw_price_filter_callback( $epofw_price ) {
			if ( class_exists( 'WOOCS' ) ) {
				// phpcs:ignore.
				global $WOOCS;
				// phpcs:ignore.
				return $WOOCS->woocs_exchange_value( floatval( $epofw_price ) );
			}

			return $epofw_price;
		}

		/**
		 * Function will calculate addon price based on currency switcher.
		 *
		 * @param object $cart_object Cart object data.
		 */
		public function epofw_woocs_before_calculate_totals( $cart_object ) {
			if ( class_exists( 'WOOCS' ) ) {
				if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
					return;
				}
				if ( method_exists( $cart_object, 'get_cart' ) ) {
					$cart_contents = $cart_object->get_cart();
				} else {
					$cart_contents = $cart_object->cart_contents;
				}
				if ( ! empty( $cart_contents ) ) {
					foreach ( $cart_contents as $cart_key => $cart_item ) {
						if ( isset( $cart_item['epofw_data'] ) ) {
							if ( isset( $cart_item['product_id'] ) ) {
								$product = wc_get_product( $cart_item['product_id'] );
								if ( $product ) {
									$has_regular_price = is_numeric( $cart_item['data']->get_regular_price( 'edit' ) );
									if ( $has_regular_price ) {
										$product_price = (float) $cart_item['data']->get_regular_price( 'edit' );
									}
									$has_sale_price = is_numeric( $cart_item['data']->get_sale_price( 'edit' ) );
									if ( $has_sale_price ) {
										$product_price = (float) $cart_item['data']->get_sale_price( 'edit' );
									}
								}
							} else {
								$product_price = 0;
							}
							$total_price = $product_price;
							// Creating issue with price. Addon price is calculating twice.
							$cart_item['data']->set_price( ( $total_price ) );
						}
						$cart_contents[ $cart_key ] = $cart_item;
					}
				}
				if ( method_exists( $cart_object, 'set_cart_contents' ) ) {
					$cart_object->set_cart_contents( $cart_contents );
				} else {
					$cart_object->cart_contents = $cart_contents;
				}
			}
		}
	}
}
