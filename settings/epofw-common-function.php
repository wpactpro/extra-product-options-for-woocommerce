<?php
/**
 * Common functions for plugins.
 *
 * @since      1.0.0
 * @package    Extra_Product_Options_For_WooCommerce
 * @subpackage Extra_Product_Options_For_WooCommerce/settings
 */
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/*
 * Start - Html Action
 */
add_action( 'epofw_field_start_tr', 'epofw_field_start_tr_fn', 10, 2 );
add_action( 'epofw_field_end_tr', 'epofw_field_end_tr_fn' );
add_action( 'epofw_field_start_th', 'epofw_field_start_th_fn' );
add_action( 'epofw_field_end_th', 'epofw_field_end_th_fn' );
add_action( 'epofw_field_start_label', 'epofw_field_start_label_fn', 10, 2 );
add_action( 'epofw_field_end_label', 'epofw_field_end_label_fn' );
add_action( 'epofw_field_start_td', 'epofw_field_start_td_fn', 10, 2 );
add_action( 'epofw_field_end_td', 'epofw_field_end_td_fn' );
/*
 * Html for main start tr.
 *
 * @param string $id ID of the tr.
 *
 * @param string $id Class of the tr.
 *
 * @since 1.0.0
 */
function epofw_field_start_tr_fn( $id, $class ) {
	?>
	<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class ); ?>">
	<?php
}

/*
 * Html for main end tr.
 *
 * @since 1.0.0
 */
function epofw_field_end_tr_fn() {
	?>
	</div>
	<?php
}

/*
 * Html for main start th.
 *
 * @since 1.0.0
 */
function epofw_field_start_th_fn() {
	?>
	<div scope="row1" class="col-251">
	<div scope="row" class="col-25">
	<?php
}

/*
 * Html for main end th.
 *
 * @since 1.0.0
 */
function epofw_field_end_th_fn() {
	?>
	</div>
	</div>
	<?php
}

/*
 * Html for main start label.
 *
 * @param string $for_attr Attr for label.
 *
 * @since 1.0.0
 */
function epofw_field_start_label_fn( $for_attr ) {
	?>
	<label for="<?php echo esc_attr( $for_attr ); ?>">
	<?php
}

/*
 * Html for main end label.
 *
 * @since 1.0.0
 */
function epofw_field_end_label_fn() {
	?>
	</label>
	<?php
}

/*
 * Html for main start td.
 *
 * @param string $id ID of the tr.
 *
 * @param string $id Class of the tr.
 *
 * @since 1.0.0
 */
function epofw_field_start_td_fn( $id, $class ) {
	?>
	<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class ); ?>">
	<div class="forminp1">
	<?php
}

/*
 * Html for main end td.
 *
 * @since 1.0.0
 */
function epofw_field_end_td_fn() {
	?>
	</div>
	</div>
	<?php
}

/*
 * Field data.
 *
 * @return array $filter_arr Return array of options.
 *
 * @since 1.0.0
 */
function epofw_field_property_settings( $field_property_array ) {
	$filter_arr = array();
	if ( $field_property_array ) {
		foreach ( $field_property_array as $arr_key => $arr_value ) {
			if ( ! empty( $arr_value ) ) {
				$filter_arr[ $arr_key ] = $arr_value;
			}
		}
	}

	return apply_filters( 'epofw_field_text_arr', $filter_arr );
}

/*
 * Label data.
 *
 * @return array $label_field_arr Return array of label fields.
 *
 * @since 1.0.0
 */
function epofw_label_field_arr() {
	$label_field_arr = array(
		'title'                 => epofw_field_property_settings(
			array(
				'type'        => 'text',
				'title'       => esc_html( EPOFW_FIELD_LABEL ),
				'description' => esc_html__( 'If you want to make required field then you can checked this option.', 'extra-product-options-for-woocommerce' ),
				'placeholder' => esc_html__( 'Enter Field Title', 'extra-product-options-for-woocommerce' ),
				'required'    => '1',
				'class'       => '',
				'id'          => '',
				'value'       => '',
				'min'         => '',
			)
		),
		'enable_title_extra'    => epofw_field_property_settings(
			array(
				'type'        => 'checkbox',
				'title'       => esc_html__( 'Enable Title Option', 'extra-product-options-for-woocommerce' ),
				'description' => esc_html__( 'If you want to make required field then you can checked this option.', 'extra-product-options-for-woocommerce' ),
				'required'    => '',
				'class'       => '',
				'id'          => '',
				'value'       => '',
			)
		),
		'title_extra'           => array(
			'title'        => esc_html__( 'Field Title Options', 'extra-product-options-for-woocommerce' ),
			'description'  => esc_html__( 'Select title type in which tag you want to display title.', 'extra-product-options-for-woocommerce' ),
			'extra_option' => array(
				'class' => epofw_field_property_settings(
					array(
						'type'        => 'text',
						'title'       => esc_html__( 'Label Class', 'extra-product-options-for-woocommerce' ),
						'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
						'placeholder' => esc_html__( 'Enter class name for label', 'extra-product-options-for-woocommerce' ),
						'required'    => '',
						'class'       => '',
						'id'          => '',
						'value'       => '',
					)
				),
			),
		),
		'enable_subtitle_extra' => epofw_field_property_settings(
			array(
				'type'        => 'checkbox',
				'title'       => esc_html__( 'Enable Subtitle Option', 'extra-product-options-for-woocommerce' ),
				'description' => esc_html__( 'If you want to make required field then you can checked this option.', 'extra-product-options-for-woocommerce' ),
				'required'    => '',
				'class'       => '',
				'id'          => '',
				'value'       => '',
			)
		),
		'subtitle_extra'        => array(
			'title'        => esc_html__( 'Field Subtitle Options', 'extra-product-options-for-woocommerce' ),
			'description'  => esc_html__( 'Select title type in which tag you want to display title.', 'extra-product-options-for-woocommerce' ),
			'extra_option' => array(
				'subtitle'       => epofw_field_property_settings(
					array(
						'type'        => 'text',
						'title'       => esc_html( EPOFW_FIELD_SUB_LABEL ),
						'description' => esc_html__( 'If you want to make required field then you can checked this option.', 'extra-product-options-for-woocommerce' ),
						'placeholder' => esc_html__( 'Enter Subtitle', 'extra-product-options-for-woocommerce' ),
						'required'    => '',
						'class'       => '',
						'id'          => '',
						'value'       => '',
						'min'         => '',
					)
				),
				'subtitle_class' => epofw_field_property_settings(
					array(
						'type'        => 'text',
						'title'       => esc_html__( 'Label Class', 'extra-product-options-for-woocommerce' ),
						'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
						'placeholder' => esc_html__( 'Enter class name for label', 'extra-product-options-for-woocommerce' ),
						'required'    => '',
						'class'       => '',
						'id'          => '',
						'value'       => '',
					)
				),
			),
		),
	);

	return apply_filters( 'epofw_label_field_arr', $label_field_arr );
}

/*
 * Label data.
 *
 * @return array $label_field_arr Return array of label fields.
 *
 * @since 1.0.0
 */
function epofw_price_field_arr() {
	$price_array = array(
		'title'        => esc_html__( 'Adjust Price', 'extra-product-options-for-woocommerce' ),
		'description'  => esc_html__( 'Enter price based on your needs. You can add prices with fixed or percentage.', 'extra-product-options-for-woocommerce' ),
		'extra_option' => array(
			'addon_price_type' => epofw_field_property_settings(
				array(
					'type'     => 'select',
					'required' => '',
					'class'    => '',
					'id'       => '',
					'options'  => epofw_price_type_data(),
				)
			),
			'addon_price'      => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'placeholder' => esc_html__( '0.00', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => '',
					'id'          => '',
					'value'       => '',
				)
			),
		),
	);

	return apply_filters( 'epofw_price_field_arr', $price_array );
}

/*
 * Text field data.
 *
 * @return array $field_array Return array of text field.
 *
 * @since 1.0.0
 */
function epofw_text_field_arr_fn() {
	$field_group_array   = array(
		'label' => epofw_label_field_arr(),
		'field' => array(
			'required'           => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Required', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to make required field then you can checked this option.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => '',
					'id'          => '',
					'value'       => '',
				)
			),
			'field_restriction'  => epofw_field_property_settings(
				array(
					'type'        => 'select',
					'title'       => esc_html__( 'Field Restriction', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'Select field which you want to allow to user', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'options'     => epofw_field_restriction_options_data(),
				)
			),
			'value'              => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Default Value', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'You can enter some default value which will display at front side in input box.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter default value', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
					'min'         => '',
				)
			),
			'placeholder'        => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Placeholder', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'You can enter some placeholder which will display at front side in input box.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter placeholder', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
			'name'               => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Name', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter unique name for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
			'id'                 => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'ID', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter unique id for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
			'class'              => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Class', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter class name for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
			'readonly'           => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Readonly Field', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to make this field only readable purpose then you can checked this option.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter class name for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => '',
					'id'          => '',
					'value'       => '',
				)
			),
			'enable_price_extra' => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Enable Price', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to add price for text box.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => '',
					'id'          => '',
					'value'       => '',
				)
			),
			'price_extra'        => epofw_price_field_arr(),
		),
	);
	$text_field_array    = apply_filters( 'epofw_text_field_array', $field_group_array );
	$field_array         = array();
	$field_array['text'] = $text_field_array;

	return $field_array;
}

/*
 * Password field data.
 *
 * @return array $field_array Return array of text field.
 *
 * @since 1.0.0
 */
function epofw_password_field_arr_fn() {
	$field_group_array       = array(
		'label' => epofw_label_field_arr(),
		'field' => array(
			'required'    => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Required', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to make required field then you can checked this option.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => '',
					'id'          => '',
					'value'       => '',
				)
			),
			'value'       => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Default Value', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'You can enter some default value which will display at front side in input box.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter default value', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
					'min'         => '',
				)
			),
			'placeholder' => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Placeholder', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'You can enter some placeholder which will display at front side in input box.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter placeholder', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
			'name'        => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Name', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter unique name for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
			'id'          => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'ID', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter unique id for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
			'class'       => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Class', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter class name for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
		),
	);
	$password_field_array    = apply_filters( 'epofw_password_field_array', $field_group_array );
	$field_array             = array();
	$field_array['password'] = $password_field_array;

	return $field_array;
}

/*
 * Hidden field data.
 *
 * @return array $field_array Return array of text field.
 *
 * @since 1.0.0
 */
function epofw_hidden_field_arr_fn() {
	$field_group_array     = array(
		'label' => epofw_label_field_arr(),
		'field' => array(
			'value' => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Default Value', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'You can enter some default value which will display at front side in input box.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter default value', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
					'min'         => '',
				)
			),
			'name'  => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Name', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter unique name for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
			'id'    => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'ID', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter unique id for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
		),
	);
	$hidden_fields_arr     = apply_filters( 'epofw_hidden_field_array', $field_group_array );
	$field_array           = array();
	$field_array['hidden'] = $hidden_fields_arr;

	return $field_array;
}

/*
 * Textarea field data.
 *
 * @return array $field_array Return array of text field.
 *
 * @since 1.0.0
 */
function epofw_textarea_field_arr_fn() {
	$field_group_array       = array(
		'label' => epofw_label_field_arr(),
		'field' => array(
			'required'           => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Required', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to make required field then you can checked this option.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => '',
					'id'          => '',
					'value'       => '',
				)
			),
			'value'              => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Default Value', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'You can enter some default value which will display at front side in input box.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter default value', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
					'min'         => '',
				)
			),
			'placeholder'        => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Placeholder', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'You can enter some placeholder which will display at front side in input box.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter placeholder', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
			'cols'               => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Field Cols', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. It will increase textareas width as column.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Field Cols Placeholder', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
					'cols'        => '20',
				)
			),
			'rows'               => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Field Rows', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. It will increase textareas width as row.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Field Rows Placeholder', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
					'rows'        => '10',
				)
			),
			'name'               => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Name', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter unique name for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
			'id'                 => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'ID', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter unique id for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
			'class'              => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Class', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter class name for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
			'enable_price_extra' => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Enable Price', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to add price for text box.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => '',
					'id'          => '',
					'value'       => '',
				)
			),
			'price_extra'        => epofw_price_field_arr(),
		),
	);
	$textarea_fields_arr     = apply_filters( 'epofw_textarea_field_array', $field_group_array );
	$field_array             = array();
	$field_array['textarea'] = $textarea_fields_arr;

	return $field_array;
}

/*
 * Select field data.
 *
 * @return array $field_array Return array of text field.
 *
 * @since 1.0.0
 */
function epofw_select_field_arr_fn() {
	$field_group_array     = array(
		'label' => epofw_label_field_arr(),
		'field' => array(
			'required' => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Required', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to make required field then you can checked this option.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => '',
					'id'          => '',
					'value'       => '',
				)
			),
			'options'  => epofw_field_property_settings(
				array(
					'type'        => 'repeater',
					'title'       => esc_html__( 'Options', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'Fields option which will display in product page.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Options Placeholder', 'extra-product-options-for-woocommerce' ),
					'class'       => '',
					'id'          => '',
					'value'       => '',
				)
			),
			'name'     => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Name', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter unique name for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
			'id'       => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'ID', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter unique id for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
			'class'    => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Class', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter class name for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
		),
	);
	$select_field_array    = apply_filters( 'epofw_select_field_array', $field_group_array );
	$field_array           = array();
	$field_array['select'] = $select_field_array;

	return $field_array;
}

/*
 * MultiSelect field data.
 *
 * @return array $field_array Return array of text field.
 *
 * @since 1.0.0
 */
function epofw_multiselect_field_arr_fn() {
	$field_group_array          = array(
		'label' => epofw_label_field_arr(),
		'field' => array(
			'required' => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Required', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to make required field then you can checked this option.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => '',
					'id'          => '',
					'value'       => '',
				)
			),
			'options'  => epofw_field_property_settings(
				array(
					'type'        => 'repeater',
					'title'       => esc_html__( 'Options', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'Fields option which will display in product page.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Options Placeholder', 'extra-product-options-for-woocommerce' ),
					'class'       => '',
					'id'          => '',
					'value'       => '',
				)
			),
			'name'     => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Name', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter unique name for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
			'id'       => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'ID', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter unique id for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
			'class'    => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Class', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter class name for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'epofw_multiselect2',
					'id'          => '',
					'value'       => '',
				)
			),
		),
	);
	$select_field_array         = apply_filters( 'epofw_multiselect_field_array', $field_group_array );
	$field_array                = array();
	$field_array['multiselect'] = $select_field_array;

	return $field_array;
}

/*
 * Checkbox field data.
 *
 * @return array $field_array Return array of text field.
 *
 * @since 1.0.0
 */
function epofw_checkbox_field_arr_fn() {
	$field_group_array         = array(
		'label' => epofw_label_field_arr(),
		'field' => array(
			'required' => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Required', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to make required field then you can checked this option.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => '',
					'id'          => '',
					'value'       => '',
				)
			),
			'options'  => epofw_field_property_settings(
				array(
					'type'        => 'repeater',
					'title'       => esc_html__( 'Options', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'Fields option which will display in product page.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Options Placeholder', 'extra-product-options-for-woocommerce' ),
					'class'       => '',
					'id'          => '',
					'value'       => '',
				)
			),
			'name'     => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Name', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter unique name for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
			'id'       => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'ID', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter unique id for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
			'class'    => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Class', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter class name for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
		),
	);
	$checkboxgroup_field_array = apply_filters( 'epofw_checkbox_field_array', $field_group_array );
	$field_array               = array();
	$field_array['checkbox']   = $checkboxgroup_field_array;

	return $field_array;
}

/*
 * Checkbox group field data.
 *
 * @return array $field_array Return array of text field.
 *
 * @since 1.0.0
 */
function epofw_checkboxgroup_field_arr_fn() {
	$field_group_array            = array(
		'label' => epofw_label_field_arr(),
		'field' => array(
			'required' => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Required', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to make required field then you can checked this option.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => '',
					'id'          => '',
					'value'       => '',
				)
			),
			'options'  => epofw_field_property_settings(
				array(
					'type'        => 'repeater',
					'title'       => esc_html__( 'Options', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'Fields option which will display in product page.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Options Placeholder', 'extra-product-options-for-woocommerce' ),
					'class'       => '',
					'id'          => '',
					'value'       => '',
				)
			),
			'name'     => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Name', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter unique name for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
			'id'       => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'ID', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter unique id for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
			'class'    => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Class', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter class name for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
		),
	);
	$checkboxgroup_field_array    = apply_filters( 'epofw_checkboxgroup_field_array', $field_group_array );
	$field_array                  = array();
	$field_array['checkboxgroup'] = $checkboxgroup_field_array;

	return $field_array;
}

/*
 * Radio group field data.
 *
 * @return array $field_array Return array of text field.
 *
 * @since 1.0.0
 */
function epofw_radiogroup_field_arr_fn() {
	$field_group_array         = array(
		'label' => epofw_label_field_arr(),
		'field' => array(
			'required' => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Required', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to make required field then you can checked this option.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => '',
					'id'          => '',
					'value'       => '',
				)
			),
			'options'  => epofw_field_property_settings(
				array(
					'type'        => 'repeater',
					'title'       => esc_html__( 'Options', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'Fields option which will display in product page.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Options Placeholder', 'extra-product-options-for-woocommerce' ),
					'class'       => '',
					'id'          => '',
					'value'       => '',
				)
			),
			'name'     => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Name', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter unique name for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
			'id'       => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'ID', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter unique id for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
			'class'    => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Class', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter class name for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
		),
	);
	$radiogroup_field_array    = apply_filters( 'epofw_radiogroup_field_array', $field_group_array );
	$field_array               = array();
	$field_array['radiogroup'] = $radiogroup_field_array;

	return $field_array;
}

/*
 * Number field data.
 *
 * @return array $field_array Return array of text field.
 *
 * @since 1.0.0
 */
function epofw_number_field_arr_fn() {
	$field_group_array     = array(
		'label' => epofw_label_field_arr(),
		'field' => array(
			'required'           => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Required', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to make required field then you can checked this option.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => '',
					'id'          => '',
					'value'       => '',
				)
			),
			'value'              => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Default Value', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'You can enter some default value which will display at front side in input box.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter default value', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
					'min'         => '',
				)
			),
			'name'               => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Name', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter unique name for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
			'id'                 => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'ID', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter unique id for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
			'class'              => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Class', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter class name for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
			'min'                => epofw_field_property_settings(
				array(
					'type'        => 'number',
					'title'       => esc_html__( 'Min Number', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'You can give minimum number for fields which will use at front side in number fields.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Min Number', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'value'       => '1',
				)
			),
			'max'                => epofw_field_property_settings(
				array(
					'type'        => 'number',
					'title'       => esc_html__( 'Max Number', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'You can give maximum number for fields which will use at front side in number fields.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Max Number', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'value'       => '10',
				)
			),
			'step'               => epofw_field_property_settings(
				array(
					'type'        => 'number',
					'title'       => esc_html__( 'Step Number', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'You can give increment steps number for fields which will use at front side in number fields.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Step Number', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'value'       => '1',
				)
			),
			'enable_price_extra' => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Enable Price', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to add price for text box.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => '',
					'id'          => '',
					'value'       => '',
				)
			),
			'price_extra'        => epofw_price_field_arr(),
		),
	);
	$number_field_array    = apply_filters( 'epofw_number_field_array', $field_group_array );
	$field_array           = array();
	$field_array['number'] = $number_field_array;

	return $field_array;
}

/*
 * Heading field data.
 *
 * @return array $field_array Return array of text field.
 *
 * @since 1.0.0
 */
function epofw_heading_field_arr_fn() {
	$field_group_array      = array(
		'label' => array(
			'title' => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html( EPOFW_FIELD_LABEL ),
					'description' => esc_html__( 'If you want to make required field then you can checked this option.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter Field Title', 'extra-product-options-for-woocommerce' ),
					'required'    => '1',
					'class'       => '',
					'id'          => '',
					'value'       => '',
					'min'         => '',
				)
			),
			'class' => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Label Class', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter class name for label', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => '',
					'id'          => '',
					'value'       => '',
				)
			),
		),
		'field' => array(
			'heading_type' => epofw_field_property_settings(
				array(
					'type'        => 'select',
					'title'       => esc_html__( 'Select Heading', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'It will display heading tag in product page.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => '',
					'id'          => '',
					'options'     => epofw_field_heading_type_options_data(),
				)
			),
			'id'           => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'ID', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter unique id for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
			'class'        => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Class', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter class name for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
		),
	);
	$heading_field_array    = apply_filters( 'epofw_heading_field_array', $field_group_array );
	$field_array            = array();
	$field_array['heading'] = $heading_field_array;

	return $field_array;
}

/*
 * Paragraph field data.
 *
 * @return array $field_array Return array of text field.
 *
 * @since 1.0.0
 */
function epofw_paragraph_field_arr_fn() {
	$field_group_array        = array(
		'label' => array(
			'title' => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html( EPOFW_FIELD_LABEL ),
					'description' => esc_html__( 'If you want to make required field then you can checked this option.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter Field Title', 'extra-product-options-for-woocommerce' ),
					'required'    => '1',
					'class'       => '',
					'id'          => '',
					'value'       => '',
					'min'         => '',
				)
			),
			'class' => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Label Class', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter class name for label', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => '',
					'id'          => '',
					'value'       => '',
				)
			),
		),
		'field' => array(
			'content'      => epofw_field_property_settings(
				array(
					'type'        => 'textarea',
					'title'       => esc_html__( 'Field Content', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'It will display content in product page.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter content', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'value'       => '',
				)
			),
			'content_type' => epofw_field_property_settings(
				array(
					'type'        => 'select',
					'title'       => esc_html__( 'Select Content Type', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'Select content tag in which you want to display content.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'options'     => epofw_field_content_type_options_data(),
				)
			),
			'id'           => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'ID', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter unique id for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
			'class'        => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Class', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter class name for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
		),
	);
	$paragraph_field_array    = apply_filters( 'epofw_paragraph_field_array', $field_group_array );
	$field_array              = array();
	$field_array['paragraph'] = $paragraph_field_array;

	return $field_array;
}

/*
 * Datepicker field data.
 *
 * @return array $field_array Return array of text field.
 *
 * @since 1.0.0
 */
function epofw_datepicker_field_arr_fn() {
	$field_group_array         = array(
		'label' => epofw_label_field_arr(),
		'field' => array(
			'required'           => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Required', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to make required field then you can checked this option.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => '',
					'id'          => '',
					'value'       => '',
				)
			),
			'value'              => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Default Value', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'You can enter some default value which will display at front side in input box.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter default value', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'epofw_datepicker',
					'id'          => 'epofw_datepicker',
					'value'       => '',
					'min'         => '',
				)
			),
			'placeholder'        => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Placeholder', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'You can enter some placeholder which will display at front side in input box.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter placeholder', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
			'name'               => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Name', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter unique name for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
			'id'                 => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'ID', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter unique id for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
			'class'              => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Class', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter class name for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
			'readonly'           => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Readonly Field', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to make this field only readable purpose then you can checked this option.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter class name for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => '',
					'id'          => '',
					'value'       => '',
				)
			),
			'enable_price_extra' => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Enable Price', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to add price for text box.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => '',
					'id'          => '',
					'value'       => '',
				)
			),
			'price_extra'        => epofw_price_field_arr(),
		),
	);
	$datepicker_field_array    = apply_filters( 'epofw_datepicker_field_array', $field_group_array );
	$field_array               = array();
	$field_array['datepicker'] = $datepicker_field_array;

	return $field_array;
}

/*
 * Timepicker field data.
 *
 * @return array $field_array Return array of text field.
 *
 * @since 1.0.0
 */
function epofw_timepicker_field_arr_fn() {
	$field_group_array         = array(
		'label' => epofw_label_field_arr(),
		'field' => array(
			'required'           => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Required', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to make required field then you can checked this option.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => '',
					'id'          => '',
					'value'       => '',
				)
			),
			'value'              => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Select Time', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'Display time at front side.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Select Time', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'epofw_timepicker',
					'id'          => 'epofw_timepicker',
					'value'       => '',
				)
			),
			'placeholder'        => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Placeholder', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'You can enter some placeholder which will display at front side in input box.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter placeholder', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
			'name'               => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Name', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter unique name for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
			'id'                 => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'ID', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter unique id for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
			'class'              => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Class', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter class name for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
			'readonly'           => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Readonly Field', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to make this field only readable purpose then you can checked this option.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter class name for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => '',
					'id'          => '',
					'value'       => '',
				)
			),
			'enable_price_extra' => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Enable Price', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to add price for text box.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => '',
					'id'          => '',
					'value'       => '',
				)
			),
			'price_extra'        => epofw_price_field_arr(),
		),
	);
	$datepicker_field_array    = apply_filters( 'epofw_timepicker_field_arr_fn', $field_group_array );
	$field_array               = array();
	$field_array['timepicker'] = $datepicker_field_array;

	return $field_array;
}

/*
 * Colorpicker field data.
 *
 * @return array $field_array Return array of text field.
 *
 * @since 1.0.0
 */
function epofw_colorpicker_field_arr_fn() {
	$field_group_array          = array(
		'label' => epofw_label_field_arr(),
		'field' => array(
			'required'           => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Required', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to make required field then you can checked this option.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => '',
					'id'          => '',
					'value'       => '',
				)
			),
			'value'              => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Select Default Color', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'Select default color display at front side.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'epofw_colorpicker',
					'id'          => 'epofw_colorpicker',
					'value'       => '',
				)
			),
			'name'               => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Name', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter unique name for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
			'id'                 => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'ID', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter unique id for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
			'class'              => epofw_field_property_settings(
				array(
					'type'        => 'text',
					'title'       => esc_html__( 'Class', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'This is use for fields property. Not for customer or user purpose. Note: If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter class name for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'default_num_class',
					'id'          => '',
					'value'       => '',
				)
			),
			'readonly'           => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Readonly Field', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to make this field only readable purpose then you can checked this option.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter class name for fields', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => '',
					'id'          => '',
					'value'       => '',
				)
			),
			'enable_price_extra' => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Enable Price', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to add price for text box.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => '',
					'id'          => '',
					'value'       => '',
				)
			),
			'price_extra'        => epofw_price_field_arr(),
		),
	);
	$colorpicker_field_array    = apply_filters( 'epofw_colorpicker_field_array', $field_group_array );
	$field_array                = array();
	$field_array['colorpicker'] = $colorpicker_field_array;

	return $field_array;
}

/*
 * Field act arr data.
 *
 * @return array $merge_field_array Return all fields.
 *
 * @since 1.0.0
 */
function epofw_field_act_arr_fn() {
	$text_field_array          = epofw_text_field_arr_fn();
	$password_field_array      = epofw_password_field_arr_fn();
	$hidden_field_array        = epofw_hidden_field_arr_fn();
	$textarea_field_array      = epofw_textarea_field_arr_fn();
	$select_field_array        = epofw_select_field_arr_fn();
	$multiselect_field_array   = epofw_multiselect_field_arr_fn();
	$checkbox_field_array      = epofw_checkbox_field_arr_fn();
	$checkboxgroup_field_array = epofw_checkboxgroup_field_arr_fn();
	$radiogroup_field_array    = epofw_radiogroup_field_arr_fn();
	$number_field_array        = epofw_number_field_arr_fn();
	$heading_field_array       = epofw_heading_field_arr_fn();
	$paragraph_field_array     = epofw_paragraph_field_arr_fn();
	$datepicker_field_array    = epofw_datepicker_field_arr_fn();
	$timepicker_field_array    = epofw_timepicker_field_arr_fn();
	$colorpicker_field_array   = epofw_colorpicker_field_arr_fn();
	$getting_array             = apply_filters( 'epofw_field_act_array', $getting_array = array() );
	$merge_field_array         = array_merge(
		$text_field_array,
		$password_field_array,
		$hidden_field_array,
		$textarea_field_array,
		$select_field_array,
		$multiselect_field_array,
		$checkbox_field_array,
		$checkboxgroup_field_array,
		$radiogroup_field_array,
		$number_field_array,
		$heading_field_array,
		$paragraph_field_array,
		$datepicker_field_array,
		$timepicker_field_array,
		$hidden_field_array,
		$colorpicker_field_array,
		$getting_array
	);

	return $merge_field_array;
}

add_action( 'epofw_field_type', 'epofw_field_type_fn', 10, 5 );
/*
 * Field type html.
 *
 * @param array $get_data Get all data on edit time.
 *
 * @param int $get_post_id Get field id on edit time.
 *
 * @param string $field_slug Get field slug.
 *
 * @param string $field_type Get field type.
 *
 * @since 1.0.0
 */
function epofw_field_type_fn( $get_data, $get_post_id, $field_slug, $field_type, $inc_key ) {
	$field_title = esc_html__( 'Field Type', 'extra-product-options-for-woocommerce' );
	$field_desc  = esc_html__( 'Select type which field will display in product page at front side.', 'extra-product-options-for-woocommerce' );
	$field_value = epofw_check_general_field_data( $get_data, '', $field_slug, $inc_key );
	$field_name  = 'epofw_data[general][' . $inc_key . '][field][' . $field_slug . ']';
	$field_id    = 'epofw_' . $field_slug;
	$field_class = 'text-class';
	do_action( 'epofw_field_start_tr', 'cop_ft_id', 'cop_ft_class' );
	do_action( 'epofw_field_start_th' );
	do_action( 'epofw_field_start_label', 'epofw_' . $field_slug );
	echo esc_html( $field_title );
	do_action( 'epofw_field_end_label' );
	echo wp_kses_post( wc_help_tip( $field_desc ) );
	do_action( 'epofw_field_end_th' );
	do_action( 'epofw_field_start_td', '', 'forminp' );
	$data_property          = array();
	$data_property['type']  = $field_type;
	$data_property['name']  = $field_name;
	$data_property['value'] = $field_value;
	if ( ! empty( $field_id ) ) {
		$data_property['id'] = $field_id;
	}
	if ( ! empty( $field_class ) ) {
		$data_property['class'] = $field_class;
	}
	$data_property['options'] = epofw_field_type_options_data();
	echo cp_render_fields( $data_property, $field_type, $inc_key );// phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
	do_action( 'epofw_field_end_td' );
	do_action( 'epofw_field_end_tr' );
}

add_action( 'epofw_field_status', 'epofw_field_status_fn', 10, 5 );
/*
 * Field type html.
 *
 * @param array $get_data Get all data on edit time.
 *
 * @param int $get_post_id Get field id on edit time.
 *
 * @param string $field_slug Get field slug.
 *
 * @param string $field_type Get field type.
 *
 * @since 1.0.0
 */
function epofw_field_status_fn( $get_data, $get_post_id, $field_slug, $field_type, $inc_key ) {
	$field_title = esc_html__( 'Field Status', 'extra-product-options-for-woocommerce' );
	$field_desc  = esc_html__( 'Enable or disable field based on checkbox.', 'extra-product-options-for-woocommerce' );
	$field_value = epofw_check_general_field_data( $get_data, '', $field_slug, $inc_key );
	$field_name  = 'epofw_data[general][' . $inc_key . '][field][' . $field_slug . ']';
	$field_id    = 'epofw_' . $field_slug;
	$field_class = 'text-class';
	do_action( 'epofw_field_start_tr', 'cop_ft_status_id', 'cop_ft_class' );
	do_action( 'epofw_field_start_th' );
	do_action( 'epofw_field_start_label', 'epofw_' . $field_slug );
	echo esc_html( $field_title );
	do_action( 'epofw_field_end_label' );
	echo wp_kses_post( wc_help_tip( $field_desc ) );
	do_action( 'epofw_field_end_th' );
	do_action( 'epofw_field_start_td', '', 'forminp' );
	$data_property          = array();
	$data_property['type']  = $field_type;
	$data_property['name']  = $field_name;
	$data_property['value'] = $field_value;
	if ( ! empty( $field_id ) ) {
		$data_property['id'] = $field_id;
	}
	if ( ! empty( $field_class ) ) {
		$data_property['class'] = $field_class;
	}
	echo cp_render_fields( $data_property, $field_type, $inc_key );// phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
	do_action( 'epofw_field_end_td' );
	do_action( 'epofw_field_end_tr' );
}

add_action( 'epofw_additional_rules', 'epofw_additional_rules_fn', 10, 1 );
/*
 * Additional rule html.
 *
 * @param array $get_data Get all data on edit time.
 *
 * @param int $get_post_id Get field id on edit time.
 *
 * @param string $field_type Get field type.
 *
 * @since 1.0.0
 */
function epofw_additional_rules_fn( $get_data ) {
	$field_slug  = 'additional_rules';
	$field_title = esc_html( EPOFW_ADDITIONAL_RULES );
	$field_desc  = esc_html__( 'In which product you want to display product fields.', 'extra-product-options-for-woocommerce' );
	do_action( 'epofw_field_start_tr', 'cop_ft_id', 'cop_ft_class' );
	do_action( 'epofw_field_start_th' );
	do_action( 'epofw_field_start_label', 'epofw_' . $field_slug );
	echo esc_html( $field_title );
	do_action( 'epofw_field_end_label' );
	echo wp_kses_post( wc_help_tip( $field_desc ) );
	do_action( 'epofw_field_end_th' );
	do_action( 'epofw_field_start_td', '', 'forminp' );
	$aadditional_rule_data = epofw_check_array_key_exists( 'additional_rule_data', $get_data );
	?>
	<div class="aditional_rules_section" id="aditional_rules_section">
		<div class="epofw_rule_repeater">
			<?php
			if ( ! empty( $aadditional_rule_data ) ) {
				?>
				<div class="epofw_rule_repeater">
					<?php
					if ( ! empty( $aadditional_rule_data ) ) {
						?>
						<ul class="additional_rule_ul" id="additional_rule_ul">
							<li>
								<?php
								$rule_value_check = epofw_check_array_key_exists( 'condition', $aadditional_rule_data );
								if ( $rule_value_check ) {
									?>
									<select name="epofw_data[additional_rule_data][condition]" id="epofw_data_condition"
											class="epofw_data_condition epofw_data_condition">
										<?php
										$field_add_cnd_name = epofw_field_additional_conditional_name();
										if ( ! empty( $field_add_cnd_name ) ) {
											foreach ( $field_add_cnd_name as $cnd_key => $cnd_name ) {
												?>
												<option value="<?php echo esc_attr( $cnd_key ); ?>" <?php selected( $aadditional_rule_data['condition'], $cnd_key ); ?>><?php echo esc_html( $cnd_name ); ?></option>
												<?php
											}
										}
										?>
									</select>
									<?php
								}
								?>
							</li>
							<li>
								<?php
								$rule_op_check = epofw_check_array_key_exists( 'operator', $aadditional_rule_data );
								if ( $rule_op_check ) {
									?>
									<select name="epofw_data[additional_rule_data][operator]" id="epofw_data_operator"
											class="epofw_data_operator">
										<?php
										$field_add_op_name = epofw_field_additional_conditional_operator();
										if ( ! empty( $field_add_op_name ) ) {
											foreach ( $field_add_op_name as $cnd_key => $cnd_name ) {
												?>
												<option value="<?php echo esc_attr( $cnd_key ); ?>" <?php selected( $aadditional_rule_data['operator'], $cnd_key ); ?>><?php echo esc_html( $cnd_name ); ?></option>
												<?php
											}
										}
										?>
									</select>
									<?php
								}
								?>
							</li>
							<li>
								<select id="epofw_condition_data_id"
										class="epofw_condition_data_class_<?php echo esc_attr( $aadditional_rule_data['condition'] ); ?> epofw_condition_data_class multiselect2"
										name="epofw_data[additional_rule_data][value][]" multiple="multiple">
									<?php
									if ( ! empty( $aadditional_rule_data['value'] ) ) {
										foreach ( $aadditional_rule_data['value'] as $condition_value_id ) {
											if ( 'product' === $aadditional_rule_data['condition'] ) {
												?>
												<option value="<?php echo esc_attr( $condition_value_id ); ?>" <?php selected( $condition_value_id, $condition_value_id ); ?>><?php echo wp_kses_post( get_the_title( $condition_value_id ) ); ?></option>
												<?php
											} elseif ( 'category' === $aadditional_rule_data['condition'] ) {
												$get_category = get_term_by( 'id', $condition_value_id, 'product_cat' )
												?>
												<option value="<?php echo esc_attr( $condition_value_id ); ?>" <?php selected( $condition_value_id, $condition_value_id ); ?>><?php echo wp_kses_post( $get_category->name ); ?></option>
												<?php
											}
										}
									}
									?>
								</select>
							</li>
						</ul>
						<?php
					}
					?>
				</div>
				<?php
			} else {
				?>
				<ul id="additional_rule_ul" class="additional_rule_ul">
					<li>
						<select id="epofw_and_data_condition_1" class="epofw_data_condition epofw_and_data_condition"
								name="epofw_data[additional_rule_data][condition]">
							<?php
							$field_add_cnd_name = epofw_field_additional_conditional_name();
							if ( ! empty( $field_add_cnd_name ) ) {
								foreach ( $field_add_cnd_name as $cnd_key => $cnd_name ) {
									?>
									<option value="<?php echo esc_attr( $cnd_key ); ?>"><?php echo esc_html( $cnd_name ); ?></option>
									<?php
								}
							}
							?>
						</select>
					</li>
					<li>
						<select id="epofw_and_data_operator_1" class="epofw_and_data_operator"
								name="epofw_data[additional_rule_data][operator]">
							<?php
							$field_add_op_name = epofw_field_additional_conditional_operator();
							if ( ! empty( $field_add_op_name ) ) {
								foreach ( $field_add_op_name as $cnd_key => $cnd_name ) {
									?>
									<option value="<?php echo esc_attr( $cnd_key ); ?>"><?php echo esc_html( $cnd_name ); ?></option>
									<?php
								}
							}
							?>
						</select>
					</li>
					<li>
						<select id="epofw_and_condition_data_id_1"
								class="epofw_condition_data_class_product epofw_and_condition_data_class_1 multiselect2"
								name="epofw_data[additional_rule_data][value][]" multiple="">
						</select>
					</li>
				</ul>
				<?php
			}
			?>
		</div>
	</div>
	<?php
	do_action( 'epofw_field_end_td' );
	do_action( 'epofw_field_end_tr' );
}

/*
 * Create array for data property.
 *
 * @param array $get_data Get all data on edit time.
 *
 * @param string $field_main_key Get field key.
 *
 * @param string $field_slug Get field slug.
 *
 * @param string $field_info Get field info.
 *
 * @param int $inc_key Get field key.
 *
 * @return array $data_property
 *
 * @since 1.0.0
 */
function epofw_get_data_property( $get_data, $field_main_key, $field_slug, $field_info, $inc_key ) {
	$field_placeholder  = epofw_check_array_key_exists( 'placeholder', $field_info );
	$custom_field_class = epofw_check_array_key_exists( 'class', $field_info );
	$field_options      = epofw_check_array_key_exists( 'options', $field_info );
	$field_min          = epofw_check_array_key_exists( 'min', $field_info );
	$field_max          = epofw_check_array_key_exists( 'max', $field_info );
	$field_step         = epofw_check_array_key_exists( 'step', $field_info );
	$field_rows         = epofw_check_array_key_exists( 'rows', $field_info );
	$field_cols         = epofw_check_array_key_exists( 'cols', $field_info );
	$field_info_class   = epofw_check_array_key_exists( 'class', $field_info );
	$field_info_type    = epofw_check_array_key_exists( 'type', $field_info );
	$field_required     = epofw_check_array_key_exists( 'required', $field_info );
	if ( empty( $get_data ) ) {
		$field_value = epofw_check_array_key_exists( 'value', $field_info );
	} else {
		$field_value = epofw_check_general_field_data( $get_data, $field_main_key, $field_slug, $inc_key );
	}
	$field_name            = 'epofw_data[general][' . $inc_key . '][' . $field_main_key . '][' . $field_slug . ']';
	$field_id              = 'epofw_' . $field_slug . '_' . wp_rand();
	$default_field_class   = 'text-class';
	$field_class           = $custom_field_class ? $default_field_class . ' ' . $field_info_class : $default_field_class;
	$data_property         = array();
	$data_property['type'] = $field_info_type;
	$data_property['name'] = $field_name;
	if ( empty( $field_value ) ) {
		if ( 'name' === $field_slug || 'id' === $field_slug || 'class' === $field_slug ) {
			$data_property['value'] = 'epofw_' . $field_main_key . '_' . wp_rand();
		} else {
			$data_property['value'] = '';
		}
	} else {
		$data_property['value'] = $field_value;
	}
	if ( ! empty( $field_id ) ) {
		$data_property['id'] = $field_id;
	}
	if ( ! empty( $field_class ) ) {
		$data_property['class'] = $field_class;
	}
	if ( ! empty( $field_placeholder ) ) {
		$data_property['placeholder'] = $field_placeholder;
	}
	if ( ! empty( $field_required ) ) {
		$data_property['required'] = $field_required;
	}
	if ( ! empty( $field_min ) ) {
		$data_property['min'] = $field_min;
	}
	if ( ! empty( $field_max ) ) {
		$data_property['max'] = $field_max;
	}
	if ( ! empty( $field_step ) ) {
		$data_property['step'] = $field_step;
	}
	if ( ! empty( $field_rows ) ) {
		$data_property['rows'] = $field_rows;
	}
	if ( ! empty( $field_cols ) ) {
		$data_property['cols'] = $field_cols;
	}
	if ( ! empty( $field_options ) ) {
		$data_property['options'] = $field_options;
	}

	return $data_property;
}

/*
 * All fields html.
 *
 * @param array $field_data Get fields data.
 *
 * @param array $get_data Get all data on edit time.
 *
 * @param int $get_post_id Get field id on edit time.
 *
 * @since 1.0.0
 */
function epofw_loop_fields_data( $field_data, $get_data, $get_post_id, $inc_key ) {
	foreach ( $field_data as $field_main_key => $field_info_data ) {
		foreach ( $field_info_data as $field_slug => $field_info ) {
			$field_title     = epofw_check_array_key_exists( 'title', $field_info );
			$field_desc      = epofw_check_array_key_exists( 'description', $field_info );
			$field_required  = epofw_check_array_key_exists( 'required', $field_info );
			$field_info_type = epofw_check_array_key_exists( 'type', $field_info );
			$data_property   = epofw_get_data_property( $get_data, $field_main_key, $field_slug, $field_info, $inc_key );
			do_action( 'epofw_field_start_tr', $field_slug, 'general_field' );
			do_action( 'epofw_field_start_th' );
			do_action( 'epofw_field_start_label', 'epofw_' . $field_slug );
			echo esc_html( $field_title );
			if ( '1' === $field_required ) {
				?>
				<span class="required-star">*</span>
				<?php
			}
			do_action( 'epofw_field_end_label' );
			echo wp_kses_post( wc_help_tip( $field_desc ) );
			do_action( 'epofw_field_end_th' );
			do_action( 'epofw_field_start_td', '', 'forminp' );
			$field_extra_option = epofw_check_array_key_exists( 'extra_option', $field_info );
			if ( $field_extra_option ) {
				foreach ( $field_extra_option as $feo_key => $feo_value ) {
					$feo_value_title     = epofw_check_array_key_exists( 'title', $feo_value );
					$feo_value_info_type = epofw_check_array_key_exists( 'type', $feo_value );
					$extra_data_property = epofw_get_data_property( $get_data, $field_main_key, $feo_key, $feo_value, $inc_key );
					?>
					<div class="epofw_extra_field_div epofw_extra_field_sub_div">
						<?php
						if ( ! empty( $feo_value_title ) ) {
							?>
							<div class="epofw_extra_field_label">
								<label>
									<?php echo esc_html( $feo_value_title ); ?>
								</label>
							</div>
							<?php
						}
						?>
						<div class="epofw_extra_field_inp">
							<?php
							echo cp_render_fields( $extra_data_property, $feo_value_info_type, $feo_key );// phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
							?>
						</div>
					</div>
					<?php
				}
			}
			echo cp_render_fields( $data_property, $field_info_type, $inc_key );// phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
			do_action( 'epofw_field_end_td' );
			do_action( 'epofw_field_end_tr' );
		}
	}
}

/*
 * Additional conditional rule name.
 *
 * @return array $conditional_name_arr Return conditional rule name.
 *
 * @since 1.0.0
 */
function epofw_field_additional_conditional_name() {
	$conditional_name_arr = array(
		'product'  => esc_html__( 'Product', 'extra-product-options-for-woocommerce' ),
		'category' => esc_html__( 'Category', 'extra-product-options-for-woocommerce' ),
	);

	return apply_filters( 'epofw_field_additional_conditional_name', $conditional_name_arr );
}

/*
 * Additional conditional operator name.
 *
 * @return array $conditional_op_arr Return conditional operator name.
 *
 * @since 1.0.0
 */
function epofw_field_additional_conditional_operator() {
	$conditional_op_arr = array(
		'is_equal_to'  => esc_html__( 'Is Equal To', 'extra-product-options-for-woocommerce' ),
		'not_equal_to' => esc_html__( 'Not Equal To', 'extra-product-options-for-woocommerce' ),
	);

	return apply_filters( 'epofw_field_additional_conditional_operator', $conditional_op_arr );
}

/*
 * Price type..
 *
 * @return array $conditional_op_arr Return conditional operator name.
 *
 * @since 1.0.0
 */
function epofw_price_type_data() {
	$title_position_arr = array(
		'fixed' => esc_html__( 'Fixed', 'extra-product-options-for-woocommerce' ),
	);

	return apply_filters( 'epofw_price_type_data', $title_position_arr );
}

/*
 * List of tag name.
 *
 * @return array $field_type_arr Return tag name.
 *
 * @since 1.0.0
 */
function epofw_field_heading_type_options_data() {
	$field_type_arr = array(
		'label'  => esc_html__( 'Label', 'extra-product-options-for-woocommerce' ),
		'h1'     => esc_html__( 'H1', 'extra-product-options-for-woocommerce' ),
		'h2'     => esc_html__( 'H2', 'extra-product-options-for-woocommerce' ),
		'h3'     => esc_html__( 'H3', 'extra-product-options-for-woocommerce' ),
		'h4'     => esc_html__( 'H4', 'extra-product-options-for-woocommerce' ),
		'h5'     => esc_html__( 'H5', 'extra-product-options-for-woocommerce' ),
		'h6'     => esc_html__( 'H6', 'extra-product-options-for-woocommerce' ),
		'strong' => esc_html__( 'Strong', 'extra-product-options-for-woocommerce' ),
		'span'   => esc_html__( 'Span', 'extra-product-options-for-woocommerce' ),
		'div'    => esc_html__( 'Div', 'extra-product-options-for-woocommerce' ),
	);

	return apply_filters( 'epofw_field_heading_type_options_data', $field_type_arr );
}

/*
 * List of field restriction type.
 *
 * @return array $field_type_arr Return restriction list.
 *
 * @since 1.0.0
 */
function epofw_field_restriction_options_data() {
	$field_type_arr = array(
		'all'         => esc_html__( 'Allow all', 'extra-product-options-for-woocommerce' ),
		'only_text'   => esc_html__( 'Only Text', 'extra-product-options-for-woocommerce' ),
		'only_number' => esc_html__( 'Only Number', 'extra-product-options-for-woocommerce' ),
		'all_number'  => esc_html__( 'Number with decimal', 'extra-product-options-for-woocommerce' ),
		'text_number' => esc_html__( 'Text and Number', 'extra-product-options-for-woocommerce' ),
		'email'       => esc_html__( 'Email', 'extra-product-options-for-woocommerce' ),
	);

	return apply_filters( 'epofw_field_restriction_options_data', $field_type_arr );
}

/*
 * List of content related tag name.
 *
 * @return array $field_type_arr Return content related tag name.
 *
 * @since 1.0.0
 */
function epofw_field_content_type_options_data() {
	$field_type_arr = array(
		'p'          => esc_html__( 'P', 'extra-product-options-for-woocommerce' ),
		'address'    => esc_html__( 'Address', 'extra-product-options-for-woocommerce' ),
		'blockquote' => esc_html__( 'Blockquote', 'extra-product-options-for-woocommerce' ),
		'canvas'     => esc_html__( 'Canvas', 'extra-product-options-for-woocommerce' ),
		'output'     => esc_html__( 'Output', 'extra-product-options-for-woocommerce' ),
	);

	return apply_filters( 'epofw_field_content_type_options_data', $field_type_arr );
}

/*
 * Filter for field type options data: Like: Text, Number, Textarea etc.
 *
 * @return array $field_type_arr Return all fields type.
 *
 * @since 1.0.0
 */
function epofw_field_type_options_data() {
	$field_type_arr = array(
		'text'          => esc_html__( 'Text', 'extra-product-options-for-woocommerce' ),
		'hidden'        => esc_html__( 'Hidden', 'extra-product-options-for-woocommerce' ),
		'number'        => esc_html__( 'Number', 'extra-product-options-for-woocommerce' ),
		'password'      => esc_html__( 'Password', 'extra-product-options-for-woocommerce' ),
		'textarea'      => esc_html__( 'Textarea', 'extra-product-options-for-woocommerce' ),
		'select'        => esc_html__( 'Select', 'extra-product-options-for-woocommerce' ),
		'multiselect'   => esc_html__( 'Multiselect', 'extra-product-options-for-woocommerce' ),
		'checkbox'      => esc_html__( 'Checkbox', 'extra-product-options-for-woocommerce' ),
		'checkboxgroup' => esc_html__( 'Checkbox Group', 'extra-product-options-for-woocommerce' ),
		'radiogroup'    => esc_html__( 'Radio', 'extra-product-options-for-woocommerce' ),
		'datepicker'    => esc_html__( 'Date Picker', 'extra-product-options-for-woocommerce' ),
		'timepicker'    => esc_html__( 'Time Picker', 'extra-product-options-for-woocommerce' ),
		'colorpicker'   => esc_html__( 'Color Picker', 'extra-product-options-for-woocommerce' ),
		'heading'       => esc_html__( 'Heading', 'extra-product-options-for-woocommerce' ),
		'paragraph'     => esc_html__( 'Paragraph', 'extra-product-options-for-woocommerce' ),
	);

	return apply_filters( 'epofw_field_type_options_data', $field_type_arr );
}

/*
 * Render field based on type and attr data.
 *
 * @param array $attr_data Get all fields attr data.
 *
 * @param string $field_type Get field type.
 *
 * @return mixed $html Return html.
 *
 * @since 1.0.0
 */
function cp_render_fields( $attr_data, $field_type, $inc_key ) {
	$html = '';
	switch ( $field_type ) {
		case 'text':
		case 'number':
		case 'password':
			if ( ! empty( $attr_data ) ) {
				$html .= '<input ';
				foreach ( $attr_data as $attr_name => $attr_value ) {
					if ( strpos( $attr_value, '||' ) !== false ) {
						$attr_value_ex = explode( '||', $attr_value );
						$attr_value    = $attr_value_ex[0];
					}
					$html .= $attr_name . '=' . '"' . $attr_value . '"';
				}
				$html .= '/>';
			}
			break;
		case 'checkbox':
		case 'radio':
			if ( ! empty( $attr_data ) ) {
				$html .= '<input ';
				foreach ( $attr_data as $attr_name => $attr_value ) {
					if ( 'type' === $attr_name ) {
						if ( 'checkbox' === $field_type ) {
							$html .= $attr_name . '=' . '"checkbox"';
						} elseif ( 'radio' === $field_type ) {
							$html .= $attr_name . '=' . '"radio"';
						}
					} elseif ( 'value' === $attr_name ) {
						if ( empty( $attr_value ) ) {
							$html .= $attr_name . '=' . '"on"';
						} else {
							$html .= $attr_value === 'on' ? 'checked="checked"' : '';
						}
					} else {
						$html .= $attr_name . '=' . '"' . $attr_value . '"';
					}
				}
				$html .= '/>';
			}
			break;
		case 'textarea':
			if ( ! empty( $attr_data ) ) {
				$html .= '<textarea ';
				foreach ( $attr_data as $attr_name => $attr_value ) {
					if ( 'value' !== $attr_name ) {
						$html .= $attr_name . '=' . '"' . $attr_value . '"';
					}
				}
				$html .= '>';
				foreach ( $attr_data as $attr_name => $attr_value ) {
					if ( 'value' === $attr_name ) {
						$html .= $attr_value;
					}
				}
				$html .= '</textarea>';
			}
			break;
		case 'select':
		case 'multiselect':
		case 'heading':
			$html .= '<select ';
			foreach ( $attr_data as $attr_name => $attr_value ) {
				if ( 'options' !== $attr_name ) {
					$html .= $attr_name . '=' . '"' . $attr_value . '"';
				}
			}
			$html .= '>';
			foreach ( $attr_data['options'] as $opt_key_name => $opt_key_value ) {
				$html .= '<option value=' . $opt_key_name . ' ';
				if ( $opt_key_name === $attr_data['value'] ) {
					ob_start();
					selected( $attr_data['value'], $opt_key_name, true );
					$html .= ob_get_contents();
					ob_end_clean();
				}
				$html .= '>' . $opt_key_value . '</option>';
			}
			$html .= '</select>';
			break;
		case 'repeater':
			$html .= epofw_render_repeater( $attr_data, $inc_key );
			break;
	}

	return $html;
}

/*
 * Render field on fornt side based on type and attr data.
 *
 * @param array $attr_data Get all fields attr data.
 *
 * @param string $field_type Get field type.
 *
 * @return mixed $html Return html.
 *
 * @since 1.0.0
 */
function cp_render_fields_front( $attr_data, $field_type ) {
	$html = '';
	switch ( $field_type ) {
		case 'text':
		case 'password':
		case 'hidden':
		case 'number':
		case 'datepicker':
		case 'colorpicker':
		case 'timepicker':
			if ( ! empty( $attr_data ) ) {
				$html .= '<input ';
				foreach ( $attr_data as $attr_name => $attr_value ) {
					if ( ! empty( $attr_value ) ) {
						if ( 'type' === $attr_name ) {
							if ( ( 'datepicker' === $field_type || 'colorpicker' === $field_type || 'timepicker' === $field_type ) ) {
								$html .= $attr_name . '=' . '"text"';
							} elseif ( 'number' === $field_type ) {
								$html .= $attr_name . '=' . '"number"';
							} else {
								$html .= $attr_name . '=' . '"text"';
							}
						} elseif ( 'class' === $attr_name ) {
							if ( 'datepicker' === $field_type || 'colorpicker' === $field_type || 'timepicker' === $field_type ) {
								$html .= $attr_name . '=' . '"epofw_dft_' . $field_type . ' ' . $attr_value . '"';
							} else {
								if ( strpos( $attr_value, '||' ) !== false ) {
									$attr_value = str_replace( '||', ' ', $attr_value );
								}
								$html .= $attr_name . '=' . '"' . $attr_value . '"';
							}
						} else {
							$html .= $attr_name . '=' . '"' . $attr_value . '"';
						}
					} elseif ( 'addon_price' === $attr_name ) {
						$html .= $attr_name . '=' . '"' . $attr_value . '"';
					}
				}
				$html .= '/>';
			}
			break;
		case 'checkbox':
		case 'checkboxgroup':
		case 'radiogroup':
			if ( ! empty( $attr_data ) ) {
				foreach ( $attr_data['options'] as $a_attr_name => $opt_value ) {
					if ( ! empty( $opt_value ) ) {
						if ( strpos( $opt_value, '||' ) !== false ) {
							$v_value_ex     = explode( '||', $opt_value );
							$opt_price_type = $v_value_ex[0];
							$opt_price      = $v_value_ex[1];
						} else {
							$opt_price_type = 'fixed';
							$opt_price      = '';
						}
						$addon_price_cal = epofw_calculate_price_based_on_condition( $opt_price_type, $opt_price );
					}
					$html .= '<label>';
					$html .= '<input ';
					foreach ( $attr_data as $attr_name => $attr_value ) {
						if ( ! empty( $attr_value ) ) {
							if ( 'type' === $attr_name ) {
								if ( 'checkboxgroup' === $field_type || 'checkbox' === $field_type ) {
									$html .= $attr_name . '=' . '"checkbox"';
								} elseif ( 'radiogroup' === $field_type ) {
									$html .= $attr_name . '=' . '"radio"';
								}
							} elseif ( 'name' === $attr_name ) {
								if ( 'checkbox' === $field_type ) {
									$html .= $attr_name . '=' . '"' . $attr_value . '[]"';
								} else {
									$html .= $attr_name . '=' . '"' . $attr_value . '"';
								}
							} elseif ( 'id' === $attr_name ) {
								if ( 'checkbox' === $field_type ) {
									$html .= $attr_name . '=' . '"' . 'epofw_field_' . wp_rand() . '"';
								} else {
									$html .= $attr_name . '=' . '"' . $attr_value . '"';
								}
							} elseif ( 'class' === $attr_name ) {
								if ( 'checkboxgroup' === $field_type ) {
									$html .= $attr_name . '=' . '"' . $attr_value . ' epofw_field_checkboxgroup"';
								} else {
									$html .= $attr_name . '=' . '"' . $attr_value . '"';
								}
							} else {
								if ( 'options' !== $attr_name ) {
									$html .= $attr_name . '=' . '"' . $attr_value . '"';
								} else {
									$html .= 'value=' . '"' . $a_attr_name . '"';
								}
							}
							$html .= 'addon_price=' . '"' . $addon_price_cal . '"';
						}
					}
					$html .= '/>';
					if ( ! empty( $opt_price ) ) {
						$html .= epofw_title_with_price( $a_attr_name, $opt_price );
					} else {
						$html .= $a_attr_name;
					}
					$html .= '</label>';
				}
			}
			break;
		case 'textarea':
			if ( ! empty( $attr_data ) ) {
				$html .= '<textarea ';
				foreach ( $attr_data as $attr_name => $attr_value ) {
					if ( ! empty( $attr_value ) ) {
						if ( 'value' !== $attr_name ) {
							$html .= $attr_name . '=' . '"' . $attr_value . '"';
						}
					}
				}
				$html .= '>';
				foreach ( $attr_data as $attr_name => $attr_value ) {
					if ( ! empty( $attr_value ) ) {
						if ( 'value' === $attr_name ) {
							$html .= $attr_value;
						}
					}
				}
				$html .= '</textarea>';
			}
			break;
		case 'select':
			$html .= '<select ';
			foreach ( $attr_data as $attr_name => $attr_value ) {
				if ( 'options' !== $attr_name ) {
					if ( ! empty( $attr_value ) ) {
						$html .= $attr_name . '=' . '"' . $attr_value . '"';
					}
				}
			}
			$html .= '>';
			$html .= '<option value="" addon_price="0">' . esc_html__( 'None', 'extra-product-options-for-woocommerce' ) . '</option>';
			foreach ( $attr_data['options'] as $attr_key => $attr_value ) {
				if ( ! empty( $attr_value ) ) {
					if ( strpos( $attr_value, '||' ) !== false ) {
						$v_value_ex     = explode( '||', $attr_value );
						$opt_price_type = $v_value_ex[0];
						$opt_price      = $v_value_ex[1];
					} else {
						$opt_price_type = 'fixed';
						$opt_price      = 0;
					}
					$option_title    = epofw_title_with_price( $attr_key, $opt_price );
					$addon_price_cal = epofw_calculate_price_based_on_condition( $opt_price_type, $opt_price );
					$html           .= '<option value="' . $attr_key . '" addon_price="' . $addon_price_cal . '">' . $option_title . '</option>';
				}
			}
			$html .= '</select>';
			break;
		case 'multiselect':
			$html .= '<select ';
			foreach ( $attr_data as $attr_name => $attr_value ) {
				if ( 'options' !== $attr_name ) {
					if ( ! empty( $attr_value ) ) {
						if ( 'class' === $attr_name ) {
							$html .= $attr_name . '=' . '"epofw_dft_' . $field_type . ' multiselect2 ' . $attr_value . '"';
						} elseif ( 'name' === $attr_name ) {
							$html .= $attr_name . '=' . '"' . $attr_value . '[]"';
						} else {
							$html .= $attr_name . '=' . '"' . $attr_value . '"';
							$html .= 'multiple=' . '"multiple"';
						}
					}
				}
			}
			$html .= '>';
			foreach ( $attr_data['options'] as $attr_key => $attr_value ) {
				if ( ! empty( $attr_value ) ) {
					if ( strpos( $attr_value, '||' ) !== false ) {
						$v_value_ex     = explode( '||', $attr_value );
						$opt_price_type = $v_value_ex[0];
						$opt_price      = $v_value_ex[1];
					} else {
						$opt_price_type = 'fixed';
						$opt_price      = 0;
					}
					$option_title    = epofw_title_with_price( $attr_key, $opt_price );
					$addon_price_cal = epofw_calculate_price_based_on_condition( $opt_price_type, $opt_price );
					$html           .= '<option value="' . $attr_key . '" addon_price="' . $addon_price_cal . '">' . $option_title . '</option>';
				}
			}
			$html .= '</select>';
			break;
		case 'repeater':
			$html .= epofw_render_repeater( $attr_data );
			break;
	}

	return apply_filters( 'epofw_print_fields_html', $html, $attr_data, $field_type );
}

/**
 * Function will return title with sign.
 *
 * @param $title
 * @param $price
 *
 * @return string
 */
function epofw_title_with_price( $title, $price ) {
	$price_sign = '+';
	if ( strpos( $price, '-' ) !== false ) {
		$price_sign = '';
	}
	if ( $title ) {
		return $title . ' (' . $price_sign . wc_price( $price ) . ')';
	} else {
		return ' (' . $price_sign . wc_price( $price ) . ')';
	}

}

/*
 * Render repeater field.
 *
 * @param array $field_value Get field value.
 *
 * @since 1.0.0
 */
function epofw_render_repeater( $field_value, $inc_key ) {
	?>
	<div class="optgroup">
		<div class="optgroup-detail">
			<ul class="opt-ul">
				<?php
				if ( ! empty( $field_value['value'] ) ) {
					$key = 0;
					foreach ( $field_value['value'] as $v_key => $v_value ) {
						if ( strpos( $v_value, '||' ) !== false ) {
							$v_value_ex     = explode( '||', $v_value );
							$opt_price_type = $v_value_ex[0];
							$opt_price      = $v_value_ex[1];
						} else {
							$opt_price_type = 'fixed';
							$opt_price      = 0;
						}
						$key ++;
						?>
						<li id="opt-li-<?php echo esc_attr( $inc_key ); ?>" class="opt-li">
							<input type="text"
								   name="epofw_data[general][<?php echo esc_attr( $inc_key ); ?>][field][options][label][]"
								   id="select-opt-label-<?php echo esc_attr( $inc_key ); ?>"
								   value="<?php echo esc_attr( $v_key ); ?>"
								   placeholder="<?php esc_html_e( 'Option Label', 'extra-product-options-for-woocommerce' ); ?>"
								   required="required" class="option-field"/>
							<select name="epofw_data[general][<?php echo esc_attr( $inc_key ); ?>][field][options][opt_price_type][]"
									id="opt_price_type_id" class="option-field">
								<?php
								$price_type_data = epofw_price_type_data();
								foreach ( $price_type_data as $price_t_key => $price_type_value ) {
									?>
									<option value="<?php echo esc_attr( $price_t_key ); ?>" <?php selected( $opt_price_type, $price_t_key ); ?>><?php echo esc_html( $price_type_value ); ?></option>
									<?php
								}
								?>
							</select>
							<input type="text"
								   name="epofw_data[general][<?php echo esc_attr( $inc_key ); ?>][field][options][opt_price][]"
								   id="select-opt-price-<?php echo esc_attr( $inc_key ); ?>"
								   value="<?php echo esc_attr( $opt_price ); ?>"
								   placeholder="<?php esc_html_e( 'Option Price', 'extra-product-options-for-woocommerce' ); ?>"
								   class="option-field"/>
							<?php
							if ( 1 !== $key ) {
								?>
								<a href="javascript:void(0);" id="remove-opt" class="remove-opt-btn">
									<span class="dashicons dashicons-trash"></span>
								</a>
								<?php
							}
							?>
						</li>
						<?php
					}
				} else {
					?>
					<li id="opt-li-<?php echo esc_attr( $inc_key ); ?>" class="opt-li">
						<input type="text"
							   name="epofw_data[general][<?php echo esc_attr( $inc_key ); ?>][field][options][label][]"
							   id="select-opt-label-<?php echo esc_attr( $inc_key ); ?>"
							   value="<?php esc_html_e( 'Option 1', 'extra-product-options-for-woocommerce' ); ?>"
							   placeholder="<?php esc_html_e( 'Option Label', 'extra-product-options-for-woocommerce' ); ?>"
							   required="required" class="option-field"/>
						<select name="epofw_data[general][<?php echo esc_attr( $inc_key ); ?>][field][options][opt_price_type][]"
								id="opt_price_type_id" class="option-field">
							<?php
							$price_type_data = epofw_price_type_data();
							foreach ( $price_type_data as $price_t_key => $price_type_value ) {
								?>
								<option value="<?php echo esc_attr( $price_t_key ); ?>"><?php echo esc_html( $price_type_value ); ?></option>
								<?php
							}
							?>
						</select>
						<input type="text"
							   name="epofw_data[general][<?php echo esc_attr( $inc_key ); ?>][field][options][opt_price][]"
							   id="select-opt-price-<?php echo esc_attr( $inc_key ); ?>" value="0.00"
							   placeholder="<?php esc_html_e( 'Option Price', 'extra-product-options-for-woocommerce' ); ?>"
							   class="option-field"/>
						<a href="javascript:void(0);" id="remove-opt" class="remove-opt-btn">
							<span class="dashicons dashicons-trash"></span>
						</a>
					</li>
					<?php
				}
				?>
			</ul>
			<p>
				<?php esc_html_e( 'Note: Options must be unique.', 'extra-product-options-for-woocommerce' ); ?>
			</p>
			<button type="button" class="button add-new-opt" id="add-new-opt">
				<?php esc_html_e( 'Add New Option', 'extra-product-options-for-woocommerce' ); ?>
			</button>
		</div>
	</div>
	<?php
}

/*
 * Get data for fields.
 *
 * @param array $get_data Get data for fields.
 *
 * @return array $get_data Return data for fields.
 *
 * @since 1.0.0
 */
function epofw_get_data_from_db( $get_post_id ) {
	$get_data_json = get_post_meta( $get_post_id, 'epofw_prd_opt_data', true );
	if ( is_json_string( $get_data_json ) ) {
		$get_data = json_decode( $get_data_json, true );
	} else {
		$get_data = $get_data_json;
	}

	return $get_data;
}

/*
 * Check fields key if exists then return data.
 *
 * @param array $get_data Get data for fields.
 *
 * @param string $field_main_key Key of the main field.
 *
  * @param string $key Key of the field.
 *
 * @return array $field_value Return field value.
 *
 * @since 1.0.0
 */
function epofw_check_general_field_data( $get_data, $field_main_key, $key, $gn_key ) {
	$field_value = '';
	if ( empty( $field_main_key ) ) {
		$field_main_key = 'field';
	}
	if ( ! empty( $get_data ) ) {
		if ( array_key_exists( 'general', $get_data ) ) {
			if ( array_key_exists( $gn_key, $get_data['general'] ) ) {
				if ( array_key_exists( $field_main_key, $get_data['general'][ $gn_key ] ) ) {
					if ( array_key_exists( $key, $get_data['general'][ $gn_key ][ $field_main_key ] ) ) {
						$field_value = $get_data['general'][ $gn_key ][ $field_main_key ][ $key ];
					}
				}
			}
		}
	}

	return $field_value;
}

/*
 * Check array key exists or not.
 *
 * @param array $array Array of the data.
 *
 * @param string $key Key of the field.
 *
 * @return string $var_name Return var name.
 *
 * @since 1.0.0
 */
function epofw_check_array_key_exists( $key, $array ) {
	$var_name = '';
	if ( ! empty( $array ) ) {
		if ( array_key_exists( $key, $array ) ) {
			$var_name = $array[ $key ];
		}
	}

	return $var_name;
}

/*
 * Calculate addon price based on condition.
 *
 * @param string $price_type Price type.
 *
 * @param float $price Addon Price.
 *
 * @return float $product_price Product price.
 *
 * @since 1.0.0
 */
function epofw_calculate_price_based_on_condition( $price_type, $price ) {
	if ( 'fixed' === $price_type ) {
		$addon_price = $price;
	}

	return $addon_price;
}

/**
 * Convert string Cyrillic to Latin.
 *
 * @param $string
 *
 * @return mixed
 *
 * @since 1.8.8
 */
function epofw_get_cyric_string_to_latin( $string ) {
	if ( preg_match( '/[А-Яа-яЁё]/u', $string ) ) {
		$cyr     = array(
			'а',
			'б',
			'в',
			'г',
			'д',
			'е',
			'ё',
			'ж',
			'з',
			'и',
			'й',
			'к',
			'л',
			'м',
			'н',
			'о',
			'п',
			'р',
			'с',
			'т',
			'у',
			'ф',
			'х',
			'ц',
			'ч',
			'ш',
			'щ',
			'ъ',
			'ы',
			'ь',
			'э',
			'ю',
			'я',
			'А',
			'Б',
			'В',
			'Г',
			'Д',
			'Е',
			'Ё',
			'Ж',
			'З',
			'И',
			'Й',
			'К',
			'Л',
			'М',
			'Н',
			'О',
			'П',
			'Р',
			'С',
			'Т',
			'У',
			'Ф',
			'Х',
			'Ц',
			'Ч',
			'Ш',
			'Щ',
			'Ъ',
			'Ы',
			'Ь',
			'Э',
			'Ю',
			'Я',
		);
		$lat     = array(
			'a',
			'b',
			'v',
			'g',
			'd',
			'e',
			'io',
			'zh',
			'z',
			'i',
			'y',
			'k',
			'l',
			'm',
			'n',
			'o',
			'p',
			'r',
			's',
			't',
			'u',
			'f',
			'h',
			'ts',
			'ch',
			'sh',
			'sht',
			'a',
			'i',
			'y',
			'e',
			'yu',
			'ya',
			'A',
			'B',
			'V',
			'G',
			'D',
			'E',
			'Io',
			'Zh',
			'Z',
			'I',
			'Y',
			'K',
			'L',
			'M',
			'N',
			'O',
			'P',
			'R',
			'S',
			'T',
			'U',
			'F',
			'H',
			'Ts',
			'Ch',
			'Sh',
			'Sht',
			'A',
			'I',
			'Y',
			'e',
			'Yu',
			'Ya',
		);
		$textcyr = str_replace( $cyr, $lat, $string );
	} else {
		$textcyr = $string;
	}

	return $textcyr;
}

/**
 * Get per character price.
 *
 * @param int|float $check_addon_price     Get Addon Price.
 *
 * @param string    $post_check_field_name Get value of field.
 *
 * @param string    $opt_price_type        Price type.
 *
 * @return int|float $check_addon_price
 */
function epofw_get_price_per_char( $check_addon_price, $post_check_field_name, $opt_price_type, $product_price, $quantity ) {
	$gpcp = 0;
	if ( ! empty( $post_check_field_name ) ) {
		if ( 'ppc' === $opt_price_type ) {
			$count_post_check_field_name = strlen( $post_check_field_name );
			$gpcp                        = $check_addon_price * $count_post_check_field_name;
		} elseif ( 'ppcis' === $opt_price_type ) {
			$post_check_field_name       = preg_replace( '/\s+/', '', $post_check_field_name );
			$count_post_check_field_name = strlen( $post_check_field_name );
			$gpcp                        = $check_addon_price * $count_post_check_field_name;
		} elseif ( 'ppw' === $opt_price_type ) {
			$count_post_check_field_name = str_word_count( $post_check_field_name );
			$gpcp                        = $check_addon_price * $count_post_check_field_name;
		} elseif ( 'pbopp' === $opt_price_type ) {
			if ( $check_addon_price ) {
				$gpcp = ( ( $product_price * $check_addon_price ) / 100 );
			} else {
				$gpcp = ( $product_price / 100 );
			}
		} else {
			$gpcp = $check_addon_price;
		}
	} else {
		$gpcp = 0;
	}

	return $gpcp;
}

/**
 * Check whether a string is json or not.
 *
 * @param string $string Given string.
 *
 * @return bool
 */
function is_json_string( $string ) {
	$json = json_decode($str);
	return $json && $str != $json;
}
