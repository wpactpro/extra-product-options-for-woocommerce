<?php
/**
 * This template displaying html addon item.
 *
 * This template can be overridden by copying it to yourtheme/eopfw-templates/epofw-html.php
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

/**
 * Before addon field.
 *
 * @since 2.5
 */
do_action( 'epofw_before_addon_field_' . $field_type );
if ( ! empty( $args['epofwtwp_args']['attr_data'] ) ) {
	$content_id = '';
	foreach ( $args['epofwtwp_args']['attr_data'] as $attr_name => $attr_value ) {
		if ( 'name' === $attr_name ) {
			$content_id = $attr_value;
		}
	}
	// phpcs:ignore WordPress.Security.EscapeOutput
	echo wp_editor( '', $content_id );
}
/**
 * After addon field.
 *
 * @since 2.5
 */
do_action( 'epofw_after_addon_field_' . $field_type );
