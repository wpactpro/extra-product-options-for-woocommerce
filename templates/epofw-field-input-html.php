<?php
/**
 * This template displaying field input.
 *
 * This template can be overridden by copying it to yourtheme/eopfw-templates/epofw-field-input-html.php
 *
 * NOTE, on occasion Extra Product Options for WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @package Extra_Product_Options_For_WooCommerce/Templates
 * @version 2.5
 */

defined( 'ABSPATH' ) || exit;

$fields_data                = isset( $args['epofwtwp_args']['fields_data'] ) ? $args['epofwtwp_args']['fields_data'] : array();
$product_data               = isset( $args['epofwtwp_args']['product_data'] ) ? $args['epofwtwp_args']['product_data'] : array();
$epofw_action               = isset( $args['epofwtwp_args']['epofw_action'] ) ? $args['epofwtwp_args']['epofw_action'] : array();
$get_exftpoc                = EPOFW_Front::instance()->exclude_field_type_on_cart_page();
$attr_data                  = epofw_get_field_input_property( $fields_data );
$check_field_inp_type       = epofw_get_field_type( $fields_data );
$check_epofw_field_settings = epofw_get_field_settings( $fields_data );
if ( ! in_array( $check_field_inp_type, $get_exftpoc, true ) ) {
	/**
	 * Start td.
	 *
	 * @since 2.5
	 *
	 * @param array    $epofwtwp_args  {
	 *                                 The array of data.
	 *
	 * @type object    $product_data   Data of the current product.
	 * @type int|float $product_price  Product price.
	 * @type string    $opt_price_type Price type - Fixed, Percentage of product price or etc.
	 * @type string    $epofw_action   Page action - shop|product page.
	 * @type array     $fields_data    Array of addon data.
	 *                                 }
	 */
	do_action( 'epofw_field_input_start_td', $args );

	echo wp_kses_post( cp_render_fields_front( $attr_data, $check_field_inp_type, $args ) );
	/**
	 * End td.
	 *
	 * @since 2.5
	 *
	 * @param array    $epofwtwp_args  {
	 *                                 The array of data.
	 *
	 * @type object    $product_data   Data of the current product.
	 * @type int|float $product_price  Product price.
	 * @type string    $opt_price_type Price type - Fixed, Percentage of product price or etc.
	 * @type string    $epofw_action   Page action - shop|product page.
	 * @type array     $fields_data    Array of addon data.
	 * }
	 */
	do_action( 'epofw_field_input_end_td', $args );
}
