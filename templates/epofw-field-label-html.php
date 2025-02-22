<?php
/**
 * This template displaying field label.
 *
 * This template can be overridden by copying it to yourtheme/eopfw-templates/epofw-field-label-html.php
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
$check_field_title_position = epofw_get_field_label_title_position( $fields_data );
if ( 'left' === $check_field_title_position ) {
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
	 * }
	 */
	do_action( 'epofw_field_label_start_td', $args );
	/**
	 * Before title.
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
	do_action( 'epofw_field_before_title', $args );
	/**
	 * Display title html.
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
	do_action( 'epofw_field_title', $args );
	/**
	 * After title.
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
	do_action( 'epofw_field_after_title', $args );
	/**
	 * Before subtitle.
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
	do_action( 'epofw_field_before_subtitle', $args );
	/**
	 * Display subtitle html.
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
	do_action( 'epofw_field_subtitle', $args );
	/**
	 * After subtitle.
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
	do_action( 'epofw_field_after_subtitle', $args );
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
	do_action( 'epofw_field_label_end_td', $args );
}
