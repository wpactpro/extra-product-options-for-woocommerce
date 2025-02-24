<?php
/**
 * This template displaying radiogroup field addon item.
 * This template can be overridden by copying it to yourtheme/eopfw-templates/epofw-radiogroup.php
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
$field_type         = isset( $args['epofwtwp_args']['attr_data']['type'] ) ? $args['epofwtwp_args']['attr_data']['type'] : 'radiogroup';
$sanitize_attr_data = array();
if ( ! empty( $args['epofwtwp_args']['attr_data'] ) ) {
	foreach ( $args['epofwtwp_args']['attr_data'] as $attr_name => $attr_value ) {
		$sanitize_attr_data['input'][ $attr_name ] = true;
		if ( 'name' === $attr_name ) {
			if ( strpos( $attr_value, 'epofw_field_' ) === false ) {
				$attr_value = 'epofw_field_' . $attr_value;
			}
			/**
			 * Apply filters for radiogroup name field property.
			 *
			 * @since 2.5
			 */
			$epofw_args['name'] = apply_filters( 'epofw_field_property_' . $field_type . '_' . $attr_name, $attr_value . '[value]', $args );
		} elseif ( 'type' === $attr_name ) {
			/**
			 * Apply filters for radiogroup type field property.
			 *
			 * @since 2.5
			 */
			$epofw_args[ $attr_name ] = apply_filters( 'epofw_field_property_' . $field_type . '_' . $attr_name, 'radio', $args );
		} elseif ( ! empty( $attr_value ) ) {
			/**
			 * Apply filters for radiogroup field property.
			 *
			 * @since 2.5
			 */
			$epofw_args[ $attr_name ] = apply_filters( 'epofw_field_property_' . $field_type . '_' . $attr_name, $attr_value, $args );
		}
	}
}
$sanitize_attr_data['input']['value']   = true;
$sanitize_attr_data['input']['checked'] = true;
$addon_options                          = isset( $args['epofwtwp_args']['fields_data']['epofw_field_settings']['options'] ) ? $args['epofwtwp_args']['fields_data']['epofw_field_settings']['options'] : '';
$unique_field_slug                      = 'epofw_' . $field_type . '_field';
/**
 * Before addon field.
 *
 * @since 2.5
 */
do_action( 'epofw_before_addon_field_' . $field_type );
if ( ! empty( $epofw_args ) && ! empty( $addon_options ) ) {
	$ck = 0;
	foreach ( $addon_options as $opt_value ) {
		++$ck;
		if ( ! empty( $opt_value ) ) {
			$opt_grp_data   = epofw_explore_label_from_opt_group( $opt_value );
			$opt_label      = $opt_grp_data['opt_label'];
			$opt_price_type = $opt_grp_data['opt_price_type'];
			$opt_price      = $opt_grp_data['opt_price'];
			/**
			 * Apply filters for radiogroup option field property.
			 *
			 * @since 2.5
			 */
			$epofw_args['value'] = apply_filters( 'epofw_field_property_' . $field_type . '_value', $opt_label );
		}
		$epofwtwp_args['opt_label']      = $opt_label;
		$epofwtwp_args['opt_price_type'] = $opt_price_type;
		$epofwtwp_args['opt_price']      = $opt_price;
		$epofwtwp_args['product_data']   = isset( $args['epofwtwp_args']['product_data'] ) ? $args['epofwtwp_args']['product_data'] : '';
		$epofwtwp_args['qty']            = isset( $args['epofwtwp_args']['qty'] ) ? $args['epofwtwp_args']['qty'] : '';
		$front_label                     = epofw_title_with_price( $epofwtwp_args, $args['epofwtwp_args']['fields_data'] );
		?>
		<label>
			<?php
			$html = '<input ';
			foreach ( $epofw_args as $attr_name => $attr_value ) {
				if ( 'id' === $attr_name ) {
					$attr_value = 'epofw_field_' . wp_rand();
				}
				$html .= ' ' . esc_attr( $attr_name ) . EPOFW_EQUAL . '"' . esc_attr( $attr_value ) . '"';
			}
			if ( 1 === $ck ) {
				$html .= " checked='checked'";
			}
			$html .= '/>';
			echo wp_kses( $html, $sanitize_attr_data );
			echo wp_kses_post( $front_label );
			?>
		</label>
		<?php
	}
}
/**
 * After addon field.
 *
 * @since 2.5
 */
do_action( 'epofw_after_addon_field_' . $field_type );
