<?php
/**
 * Admin section.
 *
 * @package    Extra_Product_Options_For_WooCommerce
 * @subpackage Extra_Product_Options_For_WooCommerce/includes
 *
 * @since
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * EPOFW_WC_Wholesale_Prices_Rymera class.
 */
if ( ! class_exists( 'EPOFW_WC_Wholesale_Prices_Rymera' ) ) {
	/**
	 * EPOFW_WC_Wholesale_Prices_Rymera class.
	 */
	class EPOFW_WC_Wholesale_Prices_Rymera {
		/**
		 * The object of class.
		 *
		 * @since 2.5
		 *
		 * @var      string $instance instance object.
		 */
		protected static $instance = null;

		/**
		 * The name of this plugin.
		 *
		 * @var      string $plugin_name The ID of this plugin.
		 *
		 * @since 2.5
		 */
		public function __construct() {
			$this->epofw_wcwpr_init();
		}

		/**
		 * Define the plugins name and versions and also call admin section.
		 *
		 * @since 2.5
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Function will call filters.
		 *
		 * @since 2.5
		 */
		public function epofw_wcwpr_init() {
			add_filter( 'epofw_display_product_price', array( $this, 'epofw_display_product_price_callback' ), 10, 2 );
			add_filter(
				'epofw_price_before_calculation',
				array(
					$this,
					'epofw_price_before_calculation_callback',
				),
				10,
				2
			);
			remove_action(
				'woocommerce_before_calculate_totals',
				array(
					WWP_Wholesale_Prices::instance( array() ),
					'apply_product_wholesale_price_to_cart',
				),
				99
			);
			add_filter(
				'epofw_original_price_without_tax',
				array(
					$this,
					'epofw_original_price_without_tax_callback',
				),
				10,
				2
			);
		}

		/**
		 * Function will return wholesale product price based on wholeslae role.
		 *
		 * @since 2.5
		 *
		 * @param float|double $product_price Product price.
		 * @param object       $product_data  Product data.
		 *
		 * @return mixed
		 */
		public function epofw_display_product_price_callback( $product_price, $product_data ) {
			global $wc_wholesale_prices;
			$current_user_role = $wc_wholesale_prices->wwp_wholesale_roles->getUserWholesaleRole();
			if ( ! empty( $current_user_role ) && ! empty( $product_data ) ) {
				$product_id         = $product_data->get_id();
				$whole_sale_product = WWP_Wholesale_Prices::get_product_wholesale_price_on_shop_v3( $product_id, $current_user_role );
				$product_price      = ! empty( $whole_sale_product['wholesale_price'] ) ? WWP_Helper_Functions::wwp_wpml_price( $whole_sale_product['wholesale_price'] ) : $product_price;
			}

			return $product_price;
		}

		/**
		 * Function will set product price before calculation with wholesale price with taxable based on wholeslae role.
		 *
		 * @since 2.5
		 *
		 * @param array $price          Different type of prices array.
		 * @param array $cart_item_data Cart ite data.
		 *
		 * @return mixed
		 */
		public function epofw_price_before_calculation_callback( $price, $cart_item_data ) {
			global $wc_wholesale_prices;
			$current_user_role = $wc_wholesale_prices->wwp_wholesale_roles->getUserWholesaleRole();
			if ( ! empty( $current_user_role ) ) {
				$product_id = isset( $cart_item_data['data'] ) && isset( $cart_item_data['product_id'] ) ? $cart_item_data['product_id'] : '';
				if ( ! empty( $product_id ) ) {
					$whole_sale_product = WWP_Wholesale_Prices::get_product_wholesale_price_on_shop_v3( $product_id, $current_user_role );
					$price              = ! empty( $whole_sale_product['wholesale_price'] ) ? WWP_Helper_Functions::wwp_wpml_price( $whole_sale_product['wholesale_price'] ) : $price;
				}
			}

			return $price;
		}

		/**
		 * Function will set product price with wholesale price but price will be without taxable based on wholeslae role.
		 *
		 * @since 2.5
		 *
		 * @param array $price          Different type of prices array.
		 * @param array $cart_item_data Cart ite data.
		 *
		 * @return mixed
		 */
		public function epofw_original_price_without_tax_callback( $price, $cart_item_data ) {
			global $wc_wholesale_prices;
			$current_user_role = $wc_wholesale_prices->wwp_wholesale_roles->getUserWholesaleRole();
			if ( ! empty( $current_user_role ) ) {
				$product_id = isset( $cart_item_data['data'] ) && isset( $cart_item_data['product_id'] ) ? $cart_item_data['product_id'] : '';
				if ( ! empty( $product_id ) ) {
					$whole_sale_product = WWP_Wholesale_Prices::get_product_wholesale_price_on_shop_v3( $product_id, $current_user_role );
					$price              = ! empty( $whole_sale_product['wholesale_price_raw'] ) ? WWP_Helper_Functions::wwp_wpml_price( $whole_sale_product['wholesale_price_raw'] ) : $price;
				}
			}

			return $price;
		}
	}
}
