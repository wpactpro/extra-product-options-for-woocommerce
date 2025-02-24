<?php
/**
 * This template displaying password field addon item.
 * This template can be overridden by copying it to yourtheme/eopfw-templates/epofw-password.php
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

$epofw_args         = array();
$field_type         = isset( $args['epofwtwp_args']['attr_data']['type'] ) ? $args['epofwtwp_args']['attr_data']['type'] : 'password';
$sanitize_attr_data = array();
if ( ! empty( $args['epofwtwp_args']['attr_data'] ) ) {
	foreach ( $args['epofwtwp_args']['attr_data'] as $attr_name => $attr_value ) {
		$sanitize_attr_data['input'][ $attr_name ] = true;
		if ( 'name' === $attr_name ) {
			if ( strpos( $attr_value, 'epofw_field_' ) === false ) {
				$attr_value = 'epofw_field_' . $attr_value;
			}
			/**
			 * Apply filters for password name field property.
			 *
			 * @since 2.5
			 */
			$epofw_args['name'] = apply_filters( 'epofw_field_property_' . $field_type . '_' . $attr_name, $attr_value . '[value]', $args );
		} elseif ( ! empty( $attr_value ) ) {
			/**
			 * Apply filters for password field property.
			 *
			 * @since 2.5
			 */
			$epofw_args[ $attr_name ] = apply_filters( 'epofw_field_property_' . $field_type . '_' . $attr_name, $attr_value, $args );
		}
	}
}
$html = '';
if ( ! empty( $epofw_args ) ) {
	$html .= '<input ';
	foreach ( $epofw_args as $attr_name => $attr_value ) {
		$html .= ' ' . esc_attr( $attr_name ) . EPOFW_EQUAL . '"' . esc_attr( $attr_value ) . '"';
	}
	$html .= '/>';
}
/**
 * Before addon field.
 *
 * @since 2.5
 */
do_action( 'epofw_before_addon_field_' . $field_type );
echo wp_kses( $html, $sanitize_attr_data );
/**
 * After addon field.
 *
 * @since 2.5
 */
do_action( 'epofw_after_addon_field_' . $field_type );
