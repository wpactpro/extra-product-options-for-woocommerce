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
	define( 'EPOFW_PLUGIN_VERSION', '3.0.9' );
}
if ( ! defined( 'EPOFW_SLUG' ) ) {
	define( 'EPOFW_SLUG', 'extra-product-options-for-woocommerce' );
}
if ( ! defined( 'EPOFW_FOLDER_SLUG' ) ) {
	define( 'EPOFW_FOLDER_SLUG', 'extra-product-options-for-woocommerce' );
}
if ( ! defined( 'EPOFW_PLUGIN_BASENAME' ) ) {
	define( 'EPOFW_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
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
if ( ! defined( 'EPOFW_OBN' ) ) {
	define( 'EPOFW_OBN', '-' );
}
if ( ! defined( 'EPOFW_PCT' ) ) {
	define( 'EPOFW_PCT', '%' );
}
if ( ! defined( 'EPOFW_CB' ) ) {
	define( 'EPOFW_CB', ')' );
}
if ( ! defined( 'EPOFW_EQUAL' ) ) {
	define( 'EPOFW_EQUAL', '=' );
}
if ( ! defined( 'EPOFW_VALUE' ) ) {
	define( 'EPOFW_VALUE', 'value' );
}
if ( ! defined( 'EPOFW_FIELD_CONS' ) ) {
	define( 'EPOFW_FIELD_CONS', 'epofw_field_' );
}
if ( ! defined( 'EPOFW_PLUGIN_PATH' ) ) {
	define( 'EPOFW_PLUGIN_PATH', untrailingslashit( plugin_dir_path( EPOFW_PLUGIN_FILE ) ) );
}
if ( ! defined( 'EPOFW_TEMPLATE_CONSTANT' ) ) {
	define( 'EPOFW_TEMPLATE_CONSTANT', 'epofw-templates' );
}
if ( ! defined( 'EPOFW_TEMPLATE_PATH' ) ) {
	define( 'EPOFW_TEMPLATE_PATH', EPOFW_PLUGIN_PATH . '/templates/' );
}
