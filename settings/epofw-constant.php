<?php
/**
 * Constant of all plugins title
 *
 * @package    Extra_Product_Options_For_WooCommerce
 * @subpackage Extra_Product_Options_For_WooCommerce/settings
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! defined( 'EPOFW_PLUGIN_VERSION' ) ) {
	define( 'EPOFW_PLUGIN_VERSION', '1.9.6.2' );
}
if ( ! defined( 'EPOFW_SLUG' ) ) {
	define( 'EPOFW_SLUG', 'extra-product-options-for-woocommerce' );
}
if ( ! defined( 'EPOFW_PLUGIN_NAME' ) ) {
	define( 'EPOFW_PLUGIN_NAME', 'Extra Product Options for WooCommerce' );
}
if ( ! defined( 'EPOFW_TEXT_DOMAIN' ) ) {
	define( 'EPOFW_TEXT_DOMAIN', 'extra-product-options-for-woocommerce' );
}
if ( ! defined( 'EPOFW_DFT_POST_TYPE' ) ) {
	define( 'EPOFW_DFT_POST_TYPE', 'dft_cpo' );
}
if ( ! defined( 'EPOFW_FIELD_LABEL' ) ) {
	define( 'EPOFW_FIELD_LABEL', esc_html__( 'Field Title', 'extra-product-options-for-woocommerce' ) );
}
if ( ! defined( 'EPOFW_FIELD_SUB_LABEL' ) ) {
	define( 'EPOFW_FIELD_SUB_LABEL', esc_html__( 'Field Sub Title', 'extra-product-options-for-woocommerce' ) );
}
if ( ! defined( 'EPOFW_ADDITIONAL_RULES' ) ) {
	define( 'EPOFW_ADDITIONAL_RULES', esc_html__( 'Additional Rules', 'extra-product-options-for-woocommerce' ) );
}
