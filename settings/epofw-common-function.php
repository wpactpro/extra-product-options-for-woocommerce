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
/**
 * Start - Html Action
 */
add_action( 'epofw_field_start_tr', 'epofw_field_start_tr_fn', 10, 3 );
add_action( 'epofw_field_end_tr', 'epofw_field_end_tr_fn' );
add_action( 'epofw_field_start_th', 'epofw_field_start_th_fn' );
add_action( 'epofw_field_end_th', 'epofw_field_end_th_fn' );
add_action( 'epofw_field_start_label', 'epofw_field_start_label_fn', 10, 2 );
add_action( 'epofw_field_end_label', 'epofw_field_end_label_fn' );
add_action( 'epofw_field_start_td', 'epofw_field_start_td_fn', 10, 2 );
add_action( 'epofw_field_end_td', 'epofw_field_end_td_fn' );

/**
 * Html for main start tr.
 *
 * @since 1.0.0
 *
 * @param string $tr_id     ID of the tr.
 * @param string $tr_class  Name of the class.
 * @param int    $unique_id Unique ID.
 */
function epofw_field_start_tr_fn( $tr_id, $tr_class, $unique_id ) {
	?>
	<div id="<?php echo esc_attr( $tr_id ); ?>" class="<?php echo esc_attr( $tr_class ); ?>" data-field-id="<?php echo esc_attr( $unique_id ); ?>">
	<?php
}

/**
 * Html for main end tr.
 *
 * @since 1.0.0
 */
function epofw_field_end_tr_fn() {
	?>
	</div>
	<?php
}

/**
 * Html for main start th.
 *
 * @since 1.0.0
 */
function epofw_field_start_th_fn() {
	?>
	<div scope="row1" class="col-251">    <div scope="row" class="col-25">
	<?php
}

/**
 * Html for main end th.
 *
 * @since 1.0.0
 */
function epofw_field_end_th_fn() {
	?>
	</div></div>
	<?php
}

/**
 * Html for main start label.
 *
 * @since 1.0.0
 *
 * @param string $for_attr Attr for label.
 */
function epofw_field_start_label_fn( $for_attr ) {
	?>
	<label for="<?php echo esc_attr( $for_attr ); ?>">
	<?php
}

/**
 * Html for main end label.
 *
 * @since 1.0.0
 */
function epofw_field_end_label_fn() {
	?>
	</label>
	<?php
}

/**
 * Html for main start td.
 *
 * @since 1.0.0
 *
 * @param string $tr_id    ID of the tr.
 * @param string $tr_class Class of the tr.
 */
function epofw_field_start_td_fn( $tr_id, $tr_class ) {
	?>
	<div id="<?php echo esc_attr( $tr_id ); ?>" class="<?php echo esc_attr( $tr_class ); ?>"> <div class="forminp1">
	<?php
}

/**
 * Html for main end td.
 *
 * @since 1.0.0
 */
function epofw_field_end_td_fn() {
	?>
	</div></div>
	<?php
}

/**
 * Field data.
 *
 * @since 1.0.0
 *
 * @param array $field_property_array Field property array.
 *
 * @return array $filter_arr Return array of options.
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
	/**
	 * Apply filter for text field array.
	 *
	 * @since 1.0.0
	 */
	return apply_filters( 'epofw_field_text_arr', $filter_arr );
}

/**
 * Label data.
 *
 * @since 1.0.0
 * @return array $label_field_arr Return array of label fields.
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
				'title'       => esc_html__( 'Field Title Option', 'extra-product-options-for-woocommerce' ),
				'description' => esc_html__( 'If you want to make required field then you can checked this option.', 'extra-product-options-for-woocommerce' ),
				'required'    => '',
				'class'       => 'epofw-has-sub',
				'id'          => '',
				'value'       => '',
				'data-nextfe' => 'title_extra',
				'data-crntfe' => 'enable_title_extra',
			)
		),
		'title_extra'           => array(
			'extra_option' => array(
				'class' => epofw_field_property_settings(
					array(
						'type'        => 'text',
						'title'       => esc_html__( 'Label Class', 'extra-product-options-for-woocommerce' ),
						'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
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
				'title'       => esc_html__( 'Field Subtitle Option', 'extra-product-options-for-woocommerce' ),
				'description' => esc_html__( 'Allow to add subtitle with different options.', 'extra-product-options-for-woocommerce' ),
				'required'    => '',
				'class'       => 'epofw-has-sub',
				'id'          => '',
				'value'       => '',
				'data-nextfe' => 'subtitle_extra',
				'data-crntfe' => 'enable_subtitle_extra',
			)
		),
		'subtitle_extra'        => array(
			'extra_option' => array(
				'subtitle'       => epofw_field_property_settings(
					array(
						'type'        => 'text',
						'title'       => esc_html( EPOFW_FIELD_SUB_LABEL ),
						'description' => esc_html__( 'Allow to add subtitle.', 'extra-product-options-for-woocommerce' ),
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
						'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
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
	/**
	 * Apply filter for label field array.
	 *
	 * @since 1.0.0
	 */
	return apply_filters( 'epofw_label_field_arr', $label_field_arr );
}

/**
 * Label data.
 *
 * @since 1.0.0
 *
 * @param string $type Field type.
 *
 * @return array $label_field_arr Return array of label fields.
 */
function epofw_price_field_arr( $type ) {
	$price_array                 = array();
	$common_settings             = array(
		'addon_price_type' => epofw_field_property_settings(
			array(
				'type'     => 'select',
				'required' => '',
				'class'    => 'epofw_addon_price_type',
				'id'       => '',
				'options'  => epofw_price_type_data( $type ),
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
				'description' => '',
			)
		),
	);
	$price_array['extra_option'] = $common_settings;
	if (
		'text' === $type || 'textarea' === $type || 'datepicker' === $type
		|| 'timepicker' === $type || 'number' === $type
	) {
		$custom_price_option_settings = array(
			'extra_note' => array(
				'extra_note_for_field' => true,
			),
		);
		$price_array['extra_option']  = array_merge( $common_settings, $custom_price_option_settings );
	}

	/**
	 * Apply filter for price field array.
	 *
	 * @since 1.0.0
	 */
	return apply_filters( 'epofw_price_field_arr', $price_array, $type );
}

/**
 * Text field data.
 *
 * @since 1.0.0
 * @return array $field_array Return array of text field.
 */
function epofw_text_field_arr_fn() {
	$field_group_array = array(
		'label'                => epofw_label_field_arr(),
		'field'                => array(
			'required'      => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Required', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to make required field then you can checked this option.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'epofw-has-sub',
					'id'          => '',
					'value'       => '',
					'data-crntfe' => 'required',
				)
			),
			'field_options' => array(
				'title'        => esc_html__( 'Fields Extra Options', 'extra-product-options-for-woocommerce' ),
				'extra_option' => array(
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
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
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
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
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
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
							'placeholder' => esc_html__( 'Enter class name for fields', 'extra-product-options-for-woocommerce' ),
							'required'    => '',
							'class'       => 'default_num_class',
							'id'          => '',
							'value'       => '',
						)
					),
					'readonly'    => epofw_field_property_settings(
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
				),
			),
		),
		'epofw_field_settings' => array(
			'field_restriction'  => epofw_field_property_settings(
				array(
					'type'        => 'select',
					'title'       => esc_html__( 'Field Restriction', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'Select field which you want to allow to user', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'options'     => epofw_field_restriction_options_data(),
				)
			),
			'enable_price_extra' => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Enable Price', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to add price for text box.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'epofw-has-sub',
					'id'          => '',
					'value'       => '',
					'data-nextfe' => 'price_extra',
					'data-crntfe' => 'enable_price_extra',
				)
			),
			'price_extra'        => epofw_price_field_arr( 'text' ),
		),
	);
	/**
	 * Apply filter for text fields array.
	 *
	 * @since 1.0.0
	 */
	$text_field_array    = apply_filters( 'epofw_text_field_array', $field_group_array );
	$field_array         = array();
	$field_array['text'] = $text_field_array;

	return $field_array;
}

/**
 * Password field data.
 *
 * @since 1.0.0
 * @return array $field_array Return array of text field.
 */
function epofw_password_field_arr_fn() {
	$field_group_array = array(
		'label'                => epofw_label_field_arr(),
		'field'                => array(
			'required'      => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Required', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to make required field then you can checked this option.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'epofw-has-sub',
					'id'          => '',
					'value'       => '',
					'data-crntfe' => 'required',
				)
			),
			'field_options' => array(
				'title'        => esc_html__( 'Fields Extra Options', 'extra-product-options-for-woocommerce' ),
				'extra_option' => array(
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
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
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
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
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
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
							'placeholder' => esc_html__( 'Enter class name for fields', 'extra-product-options-for-woocommerce' ),
							'required'    => '',
							'class'       => 'default_num_class',
							'id'          => '',
							'value'       => '',
						)
					),
				),
			),
		),
		'epofw_field_settings' => array(
			'enable_price_extra' => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Enable Price', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to add price for text box.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'epofw-has-sub',
					'id'          => '',
					'value'       => '',
					'data-nextfe' => 'price_extra',
					'data-crntfe' => 'enable_price_extra',
				)
			),
			'price_extra'        => epofw_price_field_arr( 'password' ),
		),
	);
	/**
	 * Apply filter for password fields array.
	 *
	 * @since 1.0.0
	 */
	$password_field_array    = apply_filters( 'epofw_password_field_array', $field_group_array );
	$field_array             = array();
	$field_array['password'] = $password_field_array;

	return $field_array;
}

/**
 * Hidden field data.
 *
 * @since 1.0.0
 * @return array $field_array Return array of text field.
 */
function epofw_hidden_field_arr_fn() {
	$field_group_array = array(
		'label' => epofw_label_field_arr(),
		'field' => array(
			'field_options' => array(
				'title'        => esc_html__( 'Fields Extra Options', 'extra-product-options-for-woocommerce' ),
				'extra_option' => array(
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
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
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
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
							'placeholder' => esc_html__( 'Enter unique id for fields', 'extra-product-options-for-woocommerce' ),
							'required'    => '',
							'class'       => 'default_num_class',
							'id'          => '',
							'value'       => '',
						)
					),
				),
			),
		),
	);
	/**
	 * Apply filter for hidden fields array.
	 *
	 * @since 1.0.0
	 */
	$hidden_fields_arr     = apply_filters( 'epofw_hidden_field_array', $field_group_array );
	$field_array           = array();
	$field_array['hidden'] = $hidden_fields_arr;

	return $field_array;
}

/**
 * Textarea field data.
 *
 * @since 1.0.0
 * @return array $field_array Return array of text field.
 */
function epofw_textarea_field_arr_fn() {
	$field_group_array = array(
		'label'                => epofw_label_field_arr(),
		'field'                => array(
			'required'        => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Required', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to make required field then you can checked this option.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'epofw-has-sub',
					'id'          => '',
					'value'       => '',
					'data-crntfe' => 'required',
				)
			),
			'field_options'   => array(
				'title'        => esc_html__( 'Fields Extra Options', 'extra-product-options-for-woocommerce' ),
				'extra_option' => array(
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
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
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
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
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
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
							'placeholder' => esc_html__( 'Enter class name for fields', 'extra-product-options-for-woocommerce' ),
							'required'    => '',
							'class'       => 'default_num_class',
							'id'          => '',
							'value'       => '',
						)
					),
				),
			),
			'txtarea_options' => array(
				'title'        => esc_html__( 'Text Area Options', 'extra-product-options-for-woocommerce' ),
				'description'  => esc_html__( 'This options for the textarea.', 'extra-product-options-for-woocommerce' ),
				'extra_option' => array(
					'cols' => epofw_field_property_settings(
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
					'rows' => epofw_field_property_settings(
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
				),
			),
		),
		'epofw_field_settings' => array(
			'enable_price_extra' => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Enable Price', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to add price for text box.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'epofw-has-sub',
					'id'          => '',
					'value'       => '',
					'data-nextfe' => 'price_extra',
					'data-crntfe' => 'enable_price_extra',
				)
			),
			'price_extra'        => epofw_price_field_arr( 'textarea' ),
		),
	);
	/**
	 * Apply filter for textarea fields array.
	 *
	 * @since 1.0.0
	 */
	$textarea_fields_arr     = apply_filters( 'epofw_textarea_field_array', $field_group_array );
	$field_array             = array();
	$field_array['textarea'] = $textarea_fields_arr;

	return $field_array;
}

/**
 * Select field data.
 *
 * @since 1.0.0
 * @return array $field_array Return array of text field.
 */
function epofw_select_field_arr_fn() {
	$field_group_array = array(
		'label'                => epofw_label_field_arr(),
		'field'                => array(
			'required'      => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Required', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to make required field then you can checked this option.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'epofw-has-sub',
					'id'          => '',
					'value'       => '',
					'data-crntfe' => 'required',
				)
			),
			'field_options' => array(
				'title'        => esc_html__( 'Fields Extra Options', 'extra-product-options-for-woocommerce' ),
				'extra_option' => array(
					'name'  => epofw_field_property_settings(
						array(
							'type'        => 'text',
							'title'       => esc_html__( 'Name', 'extra-product-options-for-woocommerce' ),
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
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
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
							'placeholder' => esc_html__( 'Enter unique id for fields', 'extra-product-options-for-woocommerce' ),
							'required'    => '',
							'class'       => 'default_num_class',
							'id'          => '',
							'value'       => '',
						)
					),
					'class' => epofw_field_property_settings(
						array(
							'type'        => 'text',
							'title'       => esc_html__( 'Class', 'extra-product-options-for-woocommerce' ),
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
							'placeholder' => esc_html__( 'Enter class name for fields', 'extra-product-options-for-woocommerce' ),
							'required'    => '',
							'class'       => 'default_num_class',
							'id'          => '',
							'value'       => '',
						)
					),
				),
			),
		),
		'epofw_field_settings' => array(
			'repeator_options' => array(
				'title'        => esc_html__( 'Options', 'extra-product-options-for-woocommerce' ),
				'description'  => esc_html__( 'Fields option which will display in product page.', 'extra-product-options-for-woocommerce' ),
				'extra_option' => array(
					'options' => epofw_field_property_settings(
						array(
							'type'        => 'repeater',
							'placeholder' => esc_html__( 'Options Placeholder', 'extra-product-options-for-woocommerce' ),
							'class'       => '',
							'id'          => '',
							'value'       => '',
						)
					),
				),
			),
		),
	);
	/**
	 * Apply filter for select fields array.
	 *
	 * @since 1.0.0
	 */
	$select_field_array    = apply_filters( 'epofw_select_field_array', $field_group_array );
	$field_array           = array();
	$field_array['select'] = $select_field_array;

	return $field_array;
}

/**
 * MultiSelect field data.
 *
 * @since 1.0.0
 * @return array $field_array Return array of text field.
 */
function epofw_multiselect_field_arr_fn() {
	$field_group_array = array(
		'label'                => epofw_label_field_arr(),
		'field'                => array(
			'required'      => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Required', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to make required field then you can checked this option.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'epofw-has-sub',
					'id'          => '',
					'value'       => '',
					'data-crntfe' => 'required',
				)
			),
			'field_options' => array(
				'title'        => esc_html__( 'Fields Extra Options', 'extra-product-options-for-woocommerce' ),
				'extra_option' => array(
					'name'  => epofw_field_property_settings(
						array(
							'type'        => 'text',
							'title'       => esc_html__( 'Name', 'extra-product-options-for-woocommerce' ),
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
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
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
							'placeholder' => esc_html__( 'Enter unique id for fields', 'extra-product-options-for-woocommerce' ),
							'required'    => '',
							'class'       => 'default_num_class',
							'id'          => '',
							'value'       => '',
						)
					),
					'class' => epofw_field_property_settings(
						array(
							'type'        => 'text',
							'title'       => esc_html__( 'Class', 'extra-product-options-for-woocommerce' ),
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
							'placeholder' => esc_html__( 'Enter class name for fields', 'extra-product-options-for-woocommerce' ),
							'required'    => '',
							'class'       => 'epofw_multiselect2',
							'id'          => '',
							'value'       => '',
						)
					),
				),
			),
		),
		'epofw_field_settings' => array(
			'repeator_options' => array(
				'title'        => esc_html__( 'Options', 'extra-product-options-for-woocommerce' ),
				'description'  => esc_html__( 'Fields option which will display in product page.', 'extra-product-options-for-woocommerce' ),
				'extra_option' => array(
					'options' => epofw_field_property_settings(
						array(
							'type'        => 'repeater',
							'placeholder' => esc_html__( 'Options Placeholder', 'extra-product-options-for-woocommerce' ),
							'class'       => '',
							'id'          => '',
							'value'       => '',
						)
					),
				),
			),
		),
	);
	/**
	 * Apply filter for multiselect fields array.
	 *
	 * @since 1.0.0
	 */
	$select_field_array         = apply_filters( 'epofw_multiselect_field_array', $field_group_array );
	$field_array                = array();
	$field_array['multiselect'] = $select_field_array;

	return $field_array;
}

/**
 * Checkbox field data.
 *
 * @since 1.0.0
 * @return array $field_array Return array of text field.
 */
function epofw_checkbox_field_arr_fn() {
	$field_group_array = array(
		'label'                => epofw_label_field_arr(),
		'field'                => array(
			'required'      => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Required', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to make required field then you can checked this option.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'epofw-has-sub',
					'id'          => '',
					'value'       => '',
					'data-crntfe' => 'required',
				)
			),
			'field_options' => array(
				'title'        => esc_html__( 'Fields Extra Options', 'extra-product-options-for-woocommerce' ),
				'extra_option' => array(
					'name'  => epofw_field_property_settings(
						array(
							'type'        => 'text',
							'title'       => esc_html__( 'Name', 'extra-product-options-for-woocommerce' ),
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
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
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
							'placeholder' => esc_html__( 'Enter unique id for fields', 'extra-product-options-for-woocommerce' ),
							'required'    => '',
							'class'       => 'default_num_class',
							'id'          => '',
							'value'       => '',
						)
					),
					'class' => epofw_field_property_settings(
						array(
							'type'        => 'text',
							'title'       => esc_html__( 'Class', 'extra-product-options-for-woocommerce' ),
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
							'placeholder' => esc_html__( 'Enter class name for fields', 'extra-product-options-for-woocommerce' ),
							'required'    => '',
							'class'       => 'default_num_class',
							'id'          => '',
							'value'       => '',
						)
					),
				),
			),
		),
		'epofw_field_settings' => array(
			'repeator_options' => array(
				'title'        => esc_html__( 'Options', 'extra-product-options-for-woocommerce' ),
				'description'  => esc_html__( 'Fields option which will display in product page.', 'extra-product-options-for-woocommerce' ),
				'extra_option' => array(
					'options' => epofw_field_property_settings(
						array(
							'type'        => 'repeater',
							'placeholder' => esc_html__( 'Options Placeholder', 'extra-product-options-for-woocommerce' ),
							'class'       => '',
							'id'          => '',
							'value'       => '',
						)
					),
				),
			),
		),
	);
	/**
	 * Apply filter for checkbox fields array.
	 *
	 * @since 1.0.0
	 */
	$checkboxgroup_field_array = apply_filters( 'epofw_checkbox_field_array', $field_group_array );
	$field_array               = array();
	$field_array['checkbox']   = $checkboxgroup_field_array;

	return $field_array;
}

/**
 * Checkbox group field data.
 *
 * @since 1.0.0
 * @return array $field_array Return array of text field.
 */
function epofw_checkboxgroup_field_arr_fn() {
	$field_group_array = array(
		'label'                => epofw_label_field_arr(),
		'field'                => array(
			'required'      => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Required', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to make required field then you can checked this option.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'epofw-has-sub',
					'id'          => '',
					'value'       => '',
					'data-crntfe' => 'required',
				)
			),
			'field_options' => array(
				'title'        => esc_html__( 'Fields Extra Options', 'extra-product-options-for-woocommerce' ),
				'extra_option' => array(
					'name'  => epofw_field_property_settings(
						array(
							'type'        => 'text',
							'title'       => esc_html__( 'Name', 'extra-product-options-for-woocommerce' ),
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
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
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
							'placeholder' => esc_html__( 'Enter unique id for fields', 'extra-product-options-for-woocommerce' ),
							'required'    => '',
							'class'       => 'default_num_class',
							'id'          => '',
							'value'       => '',
						)
					),
					'class' => epofw_field_property_settings(
						array(
							'type'        => 'text',
							'title'       => esc_html__( 'Class', 'extra-product-options-for-woocommerce' ),
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
							'placeholder' => esc_html__( 'Enter class name for fields', 'extra-product-options-for-woocommerce' ),
							'required'    => '',
							'class'       => 'default_num_class',
							'id'          => '',
							'value'       => '',
						)
					),
				),
			),
		),
		'epofw_field_settings' => array(
			'repeator_options' => array(
				'title'        => esc_html__( 'Options', 'extra-product-options-for-woocommerce' ),
				'description'  => esc_html__( 'Fields option which will display in product page.', 'extra-product-options-for-woocommerce' ),
				'extra_option' => array(
					'options' => epofw_field_property_settings(
						array(
							'type'        => 'repeater',
							'placeholder' => esc_html__( 'Options Placeholder', 'extra-product-options-for-woocommerce' ),
							'class'       => '',
							'id'          => '',
							'value'       => '',
						)
					),
				),
			),
		),
	);
	/**
	 * Apply filter for checkboxgroup fields array.
	 *
	 * @since 1.0.0
	 */
	$checkboxgroup_field_array    = apply_filters( 'epofw_checkboxgroup_field_array', $field_group_array );
	$field_array                  = array();
	$field_array['checkboxgroup'] = $checkboxgroup_field_array;

	return $field_array;
}

/**
 * Radio group field data.
 *
 * @since 1.0.0
 * @return array $field_array Return array of text field.
 */
function epofw_radiogroup_field_arr_fn() {
	$field_group_array = array(
		'label'                => epofw_label_field_arr(),
		'field'                => array(
			'required'      => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Required', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to make required field then you can checked this option.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'epofw-has-sub',
					'id'          => '',
					'value'       => '',
					'data-crntfe' => 'required',
				)
			),
			'field_options' => array(
				'title'        => esc_html__( 'Fields Extra Options', 'extra-product-options-for-woocommerce' ),
				'extra_option' => array(
					'name'  => epofw_field_property_settings(
						array(
							'type'        => 'text',
							'title'       => esc_html__( 'Name', 'extra-product-options-for-woocommerce' ),
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
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
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
							'placeholder' => esc_html__( 'Enter unique id for fields', 'extra-product-options-for-woocommerce' ),
							'required'    => '',
							'class'       => 'default_num_class',
							'id'          => '',
							'value'       => '',
						)
					),
					'class' => epofw_field_property_settings(
						array(
							'type'        => 'text',
							'title'       => esc_html__( 'Class', 'extra-product-options-for-woocommerce' ),
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
							'placeholder' => esc_html__( 'Enter class name for fields', 'extra-product-options-for-woocommerce' ),
							'required'    => '',
							'class'       => 'default_num_class',
							'id'          => '',
							'value'       => '',
						)
					),
				),
			),
		),
		'epofw_field_settings' => array(
			'repeator_options' => array(
				'title'        => esc_html__( 'Options', 'extra-product-options-for-woocommerce' ),
				'description'  => esc_html__( 'Fields option which will display in product page.', 'extra-product-options-for-woocommerce' ),
				'extra_option' => array(
					'options' => epofw_field_property_settings(
						array(
							'type'        => 'repeater',
							'placeholder' => esc_html__( 'Options Placeholder', 'extra-product-options-for-woocommerce' ),
							'class'       => '',
							'id'          => '',
							'value'       => '',
						)
					),
				),
			),
		),
	);
	/**
	 * Apply filter for radiogroup fields array.
	 *
	 * @since 1.0.0
	 */
	$radiogroup_field_array    = apply_filters( 'epofw_radiogroup_field_array', $field_group_array );
	$field_array               = array();
	$field_array['radiogroup'] = $radiogroup_field_array;

	return $field_array;
}

/**
 * Number field data.
 *
 * @since 1.0.0
 * @return array $field_array Return array of text field.
 */
function epofw_number_field_arr_fn() {
	$field_group_array = array(
		'label'                => epofw_label_field_arr(),
		'field'                => array(
			'required'       => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Required', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to make required field then you can checked this option.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'epofw-has-sub',
					'id'          => '',
					'value'       => '',
					'data-crntfe' => 'required',
				)
			),
			'field_options'  => array(
				'title'        => esc_html__( 'Fields Extra Options', 'extra-product-options-for-woocommerce' ),
				'extra_option' => array(
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
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
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
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
							'placeholder' => esc_html__( 'Enter unique id for fields', 'extra-product-options-for-woocommerce' ),
							'required'    => '',
							'class'       => 'default_num_class',
							'id'          => '',
							'value'       => '',
						)
					),
					'class' => epofw_field_property_settings(
						array(
							'type'        => 'text',
							'title'       => esc_html__( 'Class', 'extra-product-options-for-woocommerce' ),
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
							'placeholder' => esc_html__( 'Enter class name for fields', 'extra-product-options-for-woocommerce' ),
							'required'    => '',
							'class'       => 'default_num_class',
							'id'          => '',
							'value'       => '',
						)
					),
				),
			),
			'number_options' => array(
				'title'        => esc_html__( 'Number Options', 'extra-product-options-for-woocommerce' ),
				'description'  => esc_html__( 'This options for the number fields.', 'extra-product-options-for-woocommerce' ),
				'extra_option' => array(
					'min'  => epofw_field_property_settings(
						array(
							'type'        => 'number',
							'title'       => esc_html__( 'Min Number', 'extra-product-options-for-woocommerce' ),
							'description' => esc_html__( 'You can give minimum number for fields which will use at front side in number fields.', 'extra-product-options-for-woocommerce' ),
							'placeholder' => esc_html__( 'Min Number', 'extra-product-options-for-woocommerce' ),
							'required'    => '',
							'value'       => '1',
						)
					),
					'max'  => epofw_field_property_settings(
						array(
							'type'        => 'number',
							'title'       => esc_html__( 'Max Number', 'extra-product-options-for-woocommerce' ),
							'description' => esc_html__( 'You can give maximum number for fields which will use at front side in number fields.', 'extra-product-options-for-woocommerce' ),
							'placeholder' => esc_html__( 'Max Number', 'extra-product-options-for-woocommerce' ),
							'required'    => '',
							'value'       => '10',
						)
					),
					'step' => epofw_field_property_settings(
						array(
							'type'        => 'number',
							'title'       => esc_html__( 'Step Number', 'extra-product-options-for-woocommerce' ),
							'description' => esc_html__( 'You can give increment steps number for fields which will use at front side in number fields.', 'extra-product-options-for-woocommerce' ),
							'placeholder' => esc_html__( 'Step Number', 'extra-product-options-for-woocommerce' ),
							'required'    => '',
							'value'       => '1',
						)
					),
				),
			),
		),
		'epofw_field_settings' => array(
			'enable_price_extra' => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Enable Price', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to add price for text box.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'epofw-has-sub',
					'id'          => '',
					'value'       => '',
					'data-nextfe' => 'price_extra',
					'data-crntfe' => 'enable_price_extra',
				)
			),
			'price_extra'        => epofw_price_field_arr( 'number' ),
		),
	);
	/**
	 * Apply filter for number fields array.
	 *
	 * @since 1.0.0
	 */
	$number_field_array    = apply_filters( 'epofw_number_field_array', $field_group_array );
	$field_array           = array();
	$field_array['number'] = $number_field_array;

	return $field_array;
}

/**
 * Heading field data.
 *
 * @since 1.0.0
 * @return array $field_array Return array of text field.
 */
function epofw_heading_field_arr_fn() {
	$field_group_array = array(
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
					'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter class name for label', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => '',
					'id'          => '',
					'value'       => '',
				)
			),
		),
		'field' => array(
			'field_options'   => array(
				'title'        => esc_html__( 'Fields Extra Options', 'extra-product-options-for-woocommerce' ),
				'extra_option' => array(
					'id'    => epofw_field_property_settings(
						array(
							'type'        => 'text',
							'title'       => esc_html__( 'ID', 'extra-product-options-for-woocommerce' ),
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
							'placeholder' => esc_html__( 'Enter unique id for fields', 'extra-product-options-for-woocommerce' ),
							'required'    => '',
							'class'       => 'default_num_class',
							'id'          => '',
							'value'       => '',
						)
					),
					'class' => epofw_field_property_settings(
						array(
							'type'        => 'text',
							'title'       => esc_html__( 'Class', 'extra-product-options-for-woocommerce' ),
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
							'placeholder' => esc_html__( 'Enter class name for fields', 'extra-product-options-for-woocommerce' ),
							'required'    => '',
							'class'       => 'default_num_class',
							'id'          => '',
							'value'       => '',
						)
					),
				),
			),
			'heading_options' => array(
				'title'        => esc_html__( 'Heading Options', 'extra-product-options-for-woocommerce' ),
				'description'  => esc_html__( 'This options for heading.', 'extra-product-options-for-woocommerce' ),
				'extra_option' => array(
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
				),
			),
		),
	);
	/**
	 * Apply filter for heading fields array.
	 *
	 * @since 1.0.0
	 */
	$heading_field_array    = apply_filters( 'epofw_heading_field_array', $field_group_array );
	$field_array            = array();
	$field_array['heading'] = $heading_field_array;

	return $field_array;
}

/**
 * Paragraph field data.
 *
 * @since 1.0.0
 * @return array $field_array Return array of text field.
 */
function epofw_paragraph_field_arr_fn() {
	$field_group_array = array(
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
					'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
					'placeholder' => esc_html__( 'Enter class name for label', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => '',
					'id'          => '',
					'value'       => '',
				)
			),
		),
		'field' => array(
			'field_options'     => array(
				'title'        => esc_html__( 'Fields Extra Options', 'extra-product-options-for-woocommerce' ),
				'extra_option' => array(
					'id'    => epofw_field_property_settings(
						array(
							'type'        => 'text',
							'title'       => esc_html__( 'ID', 'extra-product-options-for-woocommerce' ),
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
							'placeholder' => esc_html__( 'Enter unique id for fields', 'extra-product-options-for-woocommerce' ),
							'required'    => '',
							'class'       => 'default_num_class',
							'id'          => '',
							'value'       => '',
						)
					),
					'class' => epofw_field_property_settings(
						array(
							'type'        => 'text',
							'title'       => esc_html__( 'Class', 'extra-product-options-for-woocommerce' ),
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
							'placeholder' => esc_html__( 'Enter class name for fields', 'extra-product-options-for-woocommerce' ),
							'required'    => '',
							'class'       => 'default_num_class',
							'id'          => '',
							'value'       => '',
						)
					),
				),
			),
			'paragraph_options' => array(
				'title'        => esc_html__( 'Paragraph Options', 'extra-product-options-for-woocommerce' ),
				'description'  => esc_html__( 'This options for the paragraphs.', 'extra-product-options-for-woocommerce' ),
				'extra_option' => array(
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
				),
			),
		),
	);
	/**
	 * Apply filter for paragraph fields array.
	 *
	 * @since 1.0.0
	 */
	$paragraph_field_array    = apply_filters( 'epofw_paragraph_field_array', $field_group_array );
	$field_array              = array();
	$field_array['paragraph'] = $paragraph_field_array;

	return $field_array;
}

/**
 * Datepicker field data.
 *
 * @since 1.0.0
 * @return array $field_array Return array of text field.
 */
function epofw_datepicker_field_arr_fn() {
	$field_group_array = array(
		'label'                => epofw_label_field_arr(),
		'field'                => array(
			'required'      => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Required', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to make required field then you can checked this option.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'epofw-has-sub',
					'id'          => '',
					'value'       => '',
					'data-crntfe' => 'required',
				)
			),
			'field_options' => array(
				'title'        => esc_html__( 'Fields Extra Options', 'extra-product-options-for-woocommerce' ),
				'extra_option' => array(
					'value'       => epofw_field_property_settings(
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
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
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
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
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
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
							'placeholder' => esc_html__( 'Enter class name for fields', 'extra-product-options-for-woocommerce' ),
							'required'    => '',
							'class'       => 'default_num_class',
							'id'          => '',
							'value'       => '',
						)
					),
					'readonly'    => epofw_field_property_settings(
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
				),
			),
		),
		'epofw_field_settings' => array(
			'enable_price_extra' => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Enable Price', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to add price for text box.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'epofw-has-sub',
					'id'          => '',
					'value'       => '',
					'data-nextfe' => 'price_extra',
					'data-crntfe' => 'enable_price_extra',
				)
			),
			'price_extra'        => epofw_price_field_arr( 'datepicker' ),
		),
	);
	/**
	 * Apply filter for datepicker fields array.
	 *
	 * @since 1.0.0
	 */
	$datepicker_field_array    = apply_filters( 'epofw_datepicker_field_array', $field_group_array );
	$field_array               = array();
	$field_array['datepicker'] = $datepicker_field_array;

	return $field_array;
}

/**
 * Timepicker field data.
 *
 * @since 1.0.0
 * @return array $field_array Return array of text field.
 */
function epofw_timepicker_field_arr_fn() {
	$field_group_array = array(
		'label'                => epofw_label_field_arr(),
		'field'                => array(
			'required'      => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Required', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to make required field then you can checked this option.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'epofw-has-sub',
					'id'          => '',
					'value'       => '',
					'data-crntfe' => 'required',
				)
			),
			'field_options' => array(
				'title'        => esc_html__( 'Fields Extra Options', 'extra-product-options-for-woocommerce' ),
				'extra_option' => array(
					'value'       => epofw_field_property_settings(
						array(
							'type'        => 'text',
							'title'       => esc_html__( 'Default Time', 'extra-product-options-for-woocommerce' ),
							'description' => esc_html__( 'Display time at front side.', 'extra-product-options-for-woocommerce' ),
							'placeholder' => esc_html__( 'Default Time', 'extra-product-options-for-woocommerce' ),
							'required'    => '',
							'class'       => 'epofw_timepicker',
							'id'          => 'epofw_timepicker',
							'value'       => '',
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
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
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
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
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
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
							'placeholder' => esc_html__( 'Enter class name for fields', 'extra-product-options-for-woocommerce' ),
							'required'    => '',
							'class'       => 'default_num_class',
							'id'          => '',
							'value'       => '',
						)
					),
					'readonly'    => epofw_field_property_settings(
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
				),
			),
		),
		'epofw_field_settings' => array(
			'enable_price_extra' => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Enable Price', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to add price for text box.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'epofw-has-sub',
					'id'          => '',
					'value'       => '',
					'data-nextfe' => 'price_extra',
					'data-crntfe' => 'enable_price_extra',
				)
			),
			'price_extra'        => epofw_price_field_arr( 'timepicker' ),
		),
	);
	/**
	 * Apply filter for timepicker fields array.
	 *
	 * @since 1.0.0
	 */
	$datepicker_field_array    = apply_filters( 'epofw_timepicker_field_arr_fn', $field_group_array );
	$field_array               = array();
	$field_array['timepicker'] = $datepicker_field_array;

	return $field_array;
}

/**
 * Colorpicker field data.
 *
 * @since 1.0.0
 * @return array $field_array Return array of text field.
 */
function epofw_colorpicker_field_arr_fn() {
	$field_group_array = array(
		'label'                => epofw_label_field_arr(),
		'field'                => array(
			'required'      => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Required', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to make required field then you can checked this option.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'epofw-has-sub',
					'id'          => '',
					'value'       => '',
					'data-crntfe' => 'required',
				)
			),
			'field_options' => array(
				'title'        => esc_html__( 'Fields Extra Options', 'extra-product-options-for-woocommerce' ),
				'extra_option' => array(
					'value'    => epofw_field_property_settings(
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
					'name'     => epofw_field_property_settings(
						array(
							'type'        => 'text',
							'title'       => esc_html__( 'Name', 'extra-product-options-for-woocommerce' ),
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
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
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
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
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
							'placeholder' => esc_html__( 'Enter class name for fields', 'extra-product-options-for-woocommerce' ),
							'required'    => '',
							'class'       => 'default_num_class',
							'id'          => '',
							'value'       => '',
						)
					),
					'readonly' => epofw_field_property_settings(
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
				),
			),
		),
		'epofw_field_settings' => array(
			'enable_price_extra' => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Enable Price', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to add price for text box.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'epofw-has-sub',
					'id'          => '',
					'value'       => '',
					'data-nextfe' => 'price_extra',
					'data-crntfe' => 'enable_price_extra',
				)
			),
			'price_extra'        => epofw_price_field_arr( 'colorpicker' ),
		),
	);
	/**
	 * Apply filter for colorpicker fields array.
	 *
	 * @since 1.0.0
	 */
	$colorpicker_field_array    = apply_filters( 'epofw_colorpicker_field_array', $field_group_array );
	$field_array                = array();
	$field_array['colorpicker'] = $colorpicker_field_array;

	return $field_array;
}

/**
 * HTML field data.
 *
 * @since 1.0.0
 * @return array $field_array Return array of html field.
 */
function epofw_html_field_arr_fn() {
	$field_group_array = array(
		'label'                => epofw_label_field_arr(),
		'field'                => array(
			'required'      => epofw_field_property_settings(
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
			'field_options' => array(
				'title'        => esc_html__( 'Fields Extra Options', 'extra-product-options-for-woocommerce' ),
				'extra_option' => array(
					'name'  => epofw_field_property_settings(
						array(
							'type'        => 'text',
							'title'       => esc_html__( 'Name', 'extra-product-options-for-woocommerce' ),
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
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
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
							'placeholder' => esc_html__( 'Enter unique id for fields', 'extra-product-options-for-woocommerce' ),
							'required'    => '',
							'class'       => 'default_num_class',
							'id'          => '',
							'value'       => '',
						)
					),
					'class' => epofw_field_property_settings(
						array(
							'type'        => 'text',
							'title'       => esc_html__( 'Class', 'extra-product-options-for-woocommerce' ),
							'description' => __( 'This is use for fields property. Not for customer or user purpose. <strong>Note:</strong> If you want to change it then please make it unique.', 'extra-product-options-for-woocommerce' ),
							'placeholder' => esc_html__( 'Enter class name for fields', 'extra-product-options-for-woocommerce' ),
							'required'    => '',
							'class'       => 'default_num_class',
							'id'          => '',
							'value'       => '',
						)
					),
				),
			),
		),
		'epofw_field_settings' => array(
			'enable_price_extra' => epofw_field_property_settings(
				array(
					'type'        => 'checkbox',
					'title'       => esc_html__( 'Enable Price', 'extra-product-options-for-woocommerce' ),
					'description' => esc_html__( 'If you want to add price for text box.', 'extra-product-options-for-woocommerce' ),
					'required'    => '',
					'class'       => 'epofw-has-sub',
					'id'          => '',
					'value'       => '',
					'data-nextfe' => 'price_extra',
					'data-crntfe' => 'enable_price_extra',
				)
			),
			'price_extra'        => epofw_price_field_arr( 'html' ),
		),
	);
	/**
	 * Apply filter for html fields array.
	 *
	 * @since 1.0.0
	 */
	$html_field_array    = apply_filters( 'epofw_html_field_array', $field_group_array );
	$field_array         = array();
	$field_array['html'] = $html_field_array;

	return $field_array;
}

/**
 * Field act arr data.
 *
 * @since 1.0.0
 * @return array $merge_field_array Return all fields.
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
	$html_field_array          = epofw_html_field_arr_fn();
	/**
	 * Apply filter for main fields array.
	 *
	 * @since 1.0.0
	 */
	$getting_array = apply_filters( 'epofw_field_act_array', array() );

	return array_merge(
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
		$html_field_array,
		$getting_array
	);
}

add_action( 'epofw_field_type', 'epofw_field_type_fn', 10, 5 );
/**
 * Field type html.
 *
 * @since 1.0.0
 *
 * @param array  $get_data    Get all data on edit time.
 * @param int    $get_post_id Get field id on edit time.
 * @param string $field_slug  Get field slug.
 * @param string $field_type  Get field type.
 * @param int    $inc_key     Get field key.
 */
function epofw_field_type_fn( $get_data, $get_post_id, $field_slug, $field_type, $inc_key ) {
	$field_title = esc_html__( 'Field Type', 'extra-product-options-for-woocommerce' );
	$field_desc  = esc_html__( 'Select type which field will display in product page at front side.', 'extra-product-options-for-woocommerce' );
	$field_value = epofw_check_general_field_data( $get_data, '', $field_slug, $inc_key );
	$field_name  = 'epofw_data[general][' . $inc_key . '][field][' . $field_slug . ']';
	$field_id    = 'epofw_' . $field_slug;
	$field_class = 'text-class';
	/**
	 * Fire action for start tr.
	 *
	 * @since 3.0.0
	 */
	do_action( 'epofw_field_start_tr', 'cop_ft_id', 'cop_ft_class', $inc_key );
	/**
	 * Fire action for start th.
	 *
	 * @since 3.0.0
	 */
	do_action( 'epofw_field_start_th' );
	/**
	 * Fire action for start label.
	 *
	 * @since 3.0.0
	 */
	do_action( 'epofw_field_start_label', 'epofw_' . $field_slug );
	echo esc_html( $field_title );
	/**
	 * Fire action for end label.
	 *
	 * @since 3.0.0
	 */
	do_action( 'epofw_field_end_label' );
	echo wp_kses_post( wc_help_tip( $field_desc ) );
	/**
	 * Fire action for end th.
	 *
	 * @since 3.0.0
	 */
	do_action( 'epofw_field_end_th' );
	/**
	 * Fire action for start td.
	 *
	 * @since 3.0.0
	 */
	do_action( 'epofw_field_start_td', '', 'forminp' );
	$data_property          = array();
	$data_property['type']  = $field_type;
	$data_property['name']  = $field_name;
	$data_property['value'] = $field_value;
	if ( ! empty( $field_id ) ) {
		$data_property['id'] = $field_id;
	}
	$data_property['class']   = $field_class;
	$data_property['options'] = epofw_field_type_options_data();
	// phpcs:ignore WordPress.Security.EscapeOutput
	echo cp_render_fields( $data_property, $field_type, $inc_key );
	/**
	 * Fire action for end td.
	 *
	 * @since 3.0.0
	 */
	do_action( 'epofw_field_end_td', '' );
	/**
	 * Fire action for end tr.
	 *
	 * @since 3.0.0
	 */
	do_action( 'epofw_field_end_tr' );
}

add_action( 'epofw_field_status', 'epofw_field_status_fn', 10, 5 );
/**
 * Field type html.
 *
 * @since 1.0.0
 *
 * @param array  $get_data    Get all data on edit time.
 * @param int    $get_post_id Get field id on edit time.
 * @param string $field_slug  Get field slug.
 * @param string $field_type  Get field type.
 * @param int    $inc_key     Get field key.
 */
function epofw_field_status_fn( $get_data, $get_post_id, $field_slug, $field_type, $inc_key ) {
	$field_title = esc_html__( 'Field Status', 'extra-product-options-for-woocommerce' );
	$field_desc  = esc_html__( 'Enable or disable field based on checkbox.', 'extra-product-options-for-woocommerce' );
	$field_value = epofw_check_general_field_data( $get_data, 'field_status', $field_slug, $inc_key );
	$field_name  = 'epofw_data[general][' . $inc_key . '][field_status]';
	$field_id    = 'epofw_' . $field_slug;
	$field_class = 'text-class';
	/**
	 * Fire action for start tr.
	 *
	 * @since 3.0.0
	 */
	do_action( 'epofw_field_start_tr', 'cop_ft_status_id', 'cop_ft_class', $inc_key );
	/**
	 * Fire action for start th.
	 *
	 * @since 3.0.0
	 */
	do_action( 'epofw_field_start_th' );
	/**
	 * Fire action for start label.
	 *
	 * @since 3.0.0
	 */
	do_action( 'epofw_field_start_label', 'epofw_' . $field_slug );
	echo esc_html( $field_title );
	/**
	 * Fire action for end label.
	 *
	 * @since 3.0.0
	 */
	do_action( 'epofw_field_end_label' );
	echo wp_kses_post( wc_help_tip( $field_desc ) );
	/**
	 * Fire action for end th.
	 *
	 * @since 3.0.0
	 */
	do_action( 'epofw_field_end_th' );
	/**
	 * Fire action for start td.
	 *
	 * @since 3.0.0
	 */
	do_action( 'epofw_field_start_td', '', 'forminp' );
	$data_property          = array();
	$data_property['type']  = $field_type;
	$data_property['name']  = $field_name;
	$data_property['value'] = $field_value;
	if ( ! empty( $field_id ) ) {
		$data_property['id'] = $field_id;
	}
	$data_property['class'] = $field_class;
	// phpcs:ignore WordPress.Security.EscapeOutput
	echo cp_render_fields( $data_property, $field_type, $inc_key );
	/**
	 * Fire action for end td.
	 *
	 * @since 3.0.0
	 */
	do_action( 'epofw_field_end_td', '' );
	/**
	 * Fire action for end tr.
	 *
	 * @since 3.0.0
	 */
	do_action( 'epofw_field_end_tr' );
}

add_action( 'epofw_additional_rules', 'epofw_additional_rules_fn', 10, 1 );
/**
 * Additional rule html.
 *
 * @since 1.0.0
 *
 * @param array $get_data Get all data on edit time.
 */
function epofw_additional_rules_fn( $get_data ) {
	$field_slug  = 'additional_rules';
	$field_title = esc_html( EPOFW_ADDITIONAL_RULES );
	$field_desc  = esc_html__( 'In which product you want to display product fields.', 'extra-product-options-for-woocommerce' );
	/**
	 * Fire action for start tr.
	 *
	 * @since 3.0.0
	 */
	do_action( 'epofw_field_start_tr', 'cop_ft_id', 'cop_ft_class', '' );
	/**
	 * Fire action for start th.
	 *
	 * @since 3.0.0
	 */
	do_action( 'epofw_field_start_th' );
	/**
	 * Fire action for start label.
	 *
	 * @since 3.0.0
	 */
	do_action( 'epofw_field_start_label', 'epofw_' . $field_slug );
	echo esc_html( $field_title );
	/**
	 * Fire action for end label.
	 *
	 * @since 3.0.0
	 */
	do_action( 'epofw_field_end_label' );
	echo wp_kses_post( wc_help_tip( $field_desc ) );
	/**
	 * Fire action for end th.
	 *
	 * @since 3.0.0
	 */
	do_action( 'epofw_field_end_th' );
	/**
	 * Fire action for start td.
	 *
	 * @since 3.0.0
	 */
	do_action( 'epofw_field_start_td', '', 'forminp' );
	$aadditional_rule_detail = epofw_check_array_key_exists( 'additional_rule_data', $get_data );
	$selected_condition      = '';
	?>
	<div class="aditional_rules_section" id="aditional_rules_section">
		<div class="epofw_rule_repeater_main">
			<div class="epofw_rule_repeater">
				<?php
				if ( ! empty( $aadditional_rule_detail ) ) {
					$cn = 0;
					foreach ( (array) $aadditional_rule_detail as $ard_rand_key => $aadditional_rule_data ) {
						++$cn;
						?>
						<ul class="additional_rule_ul" id="additional_rule_ul_<?php echo esc_attr( $ard_rand_key ); ?>" data-attr-key="<?php echo esc_attr( $ard_rand_key ); ?>">
							<li>
								<?php
								$rule_value_check = epofw_check_array_key_exists( 'condition', $aadditional_rule_data );
								if ( $rule_value_check ) {
									?>
									<select title='conditional_name' name="epofw_data[additional_rule_data][<?php echo esc_attr( $ard_rand_key ); ?>][condition]" id="epofw_data_condition" class="epofw_data_condition epofw_data_condition">
										<?php
										$field_add_cnd_name = epofw_field_additional_conditional_name();
										if ( ! empty( $field_add_cnd_name ) ) {
											foreach ( $field_add_cnd_name as $cnd_key => $cnd_name ) {
												$selected_condition = $aadditional_rule_data['condition'];
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
									<select title='conditional_operator' name="epofw_data[additional_rule_data][<?php echo esc_attr( $ard_rand_key ); ?>][operator]" id="epofw_data_operator" class="epofw_data_operator">
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
							<li class="epofw_condition_field_data">
								<select title='conditional_field' id="epofw_condition_data_id_<?php echo esc_attr( $ard_rand_key ); ?>" class="epofw_condition_data_class_<?php echo esc_attr( $selected_condition ); ?> epofw_condition_data_class multiselect2" name="epofw_data[additional_rule_data][<?php echo esc_attr( $ard_rand_key ); ?>][value][]" multiple="multiple">
									<?php
									if ( ! empty( $aadditional_rule_data ) && isset( $aadditional_rule_data['value'] ) ) {
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
							<?php
							if ( 1 !== $cn ) {
								?>
								<li class="conditional_action_remove">
									<a href="#" class="epofw-icon -minus remove-location-rule"></a>
								</li>
								<?php
							}
							?>
						</ul>
						<?php
					}
				} else {
					$ard_unique_id_ini = wp_rand();
					?>
					<ul id="additional_rule_ul_<?php echo esc_attr( $ard_unique_id_ini ); ?>" class="additional_rule_ul" data-attr-key="<?php echo esc_attr( $ard_unique_id_ini ); ?>">
						<li>
							<select title='conditional_name' id="epofw_data_condition" class="epofw_data_condition epofw_data_condition" name="epofw_data[additional_rule_data][<?php echo esc_attr( $ard_unique_id_ini ); ?>][condition]">
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
							<select title='conditional_operator' id="epofw_data_operator" class="epofw_data_operator" name="epofw_data[additional_rule_data][<?php echo esc_attr( $ard_unique_id_ini ); ?>][operator]">
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
						<li class="epofw_condition_field_data">
							<select title='conditional_field' id="epofw_condition_data_id_<?php echo esc_attr( $ard_unique_id_ini ); ?>" class="epofw_condition_data_class_product epofw_condition_data_class multiselect2" name="epofw_data[additional_rule_data][<?php echo esc_attr( $ard_unique_id_ini ); ?>][value][]" multiple=""></select>
						</li>
					</ul>
					<?php
				}
				?>
			</div>
		</div>
	</div>
	<?php
	/**
	 * Fire action for end td.
	 *
	 * @since 3.0.0
	 */
	do_action( 'epofw_field_end_td', '' );
	/**
	 * Fire action for end tr.
	 *
	 * @since 3.0.0
	 */
	do_action( 'epofw_field_end_tr' );
}

/**
 * Create array for data property.
 *
 * @since 1.0.0
 *
 * @param array  $get_data       Get all data on edit time.
 * @param string $field_main_key Get field key.
 * @param string $field_slug     Get field slug.
 * @param string $field_info     Get field info.
 * @param int    $inc_key        Get field key.
 *
 * @return array $data_property
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
	$field_data_nextfe  = epofw_check_array_key_exists( 'data-nextfe', $field_info );
	$field_data_crntfe  = epofw_check_array_key_exists( 'data-crntfe', $field_info );
	$required_field     = epofw_check_array_key_exists( 'data-required-field', $field_info );
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
	if ( ! empty( $field_data_nextfe ) ) {
		$data_property['data-nextfe'] = $field_data_nextfe;
	}
	if ( ! empty( $field_data_crntfe ) ) {
		$data_property['data-crntfe'] = $field_data_crntfe;
	}
	if ( ! empty( $required_field ) ) {
		$data_property['data-required-field'] = $required_field;
	}
	if ( is_array( $data_property ) ) {
		return $data_property;
	}
}

/**
 * All fields html.
 *
 * @since 1.0.0
 *
 * @param array $field_data Get fields data.
 * @param array $get_data   Get all data on edit time.
 * @param int   $inc_key    Get field key.
 */
function epofw_loop_fields_data( $field_data, $get_data, $inc_key ) {
	if ( ! empty( $field_data ) ) {
		foreach ( $field_data as $field_main_key => $field_info_data ) {
			if ( ! empty( $field_info_data ) ) {
				foreach ( $field_info_data as $field_slug => $field_info ) {
					$field_title        = epofw_check_array_key_exists( 'title', $field_info );
					$field_desc         = epofw_check_array_key_exists( 'description', $field_info );
					$field_required     = epofw_check_array_key_exists( 'required', $field_info );
					$field_info_type    = epofw_check_array_key_exists( 'type', $field_info );
					$field_extra_option = epofw_check_array_key_exists( 'extra_option', $field_info );
					$data_property      = epofw_get_data_property( $get_data, $field_main_key, $field_slug, $field_info, $inc_key );
					/**
					 * Fire action for start tr.
					 *
					 * @since 3.0.0
					 */
					do_action( 'epofw_field_start_tr', $field_slug, 'general_field', $inc_key );
					/**
					 * Fire action for start th.
					 *
					 * @since 3.0.0
					 */
					do_action( 'epofw_field_start_th' );
					/**
					 * Fire action for start label.
					 *
					 * @since 3.0.0
					 */
					do_action( 'epofw_field_start_label', 'epofw_' . $field_slug );
					echo esc_html( $field_title );
					if ( '1' === $field_required ) {
						?>
						<span class="required-star">*</span>
						<?php
					}
					/**
					 * Fire action for end label.
					 *
					 * @since 3.0.0
					 */
					do_action( 'epofw_field_end_label' );
					/**
					 * Fire action for end th.
					 *
					 * @since 3.0.0
					 */
					do_action( 'epofw_field_end_th' );
					if ( $field_extra_option ) {
						/**
						 * Fire action when start td.
						 *
						 * @since 3.0.0
						 */
						do_action( 'epofw_field_start_td', $field_slug . '_sub', 'forminp' );
					} else {
						/**
						 * Fire action when start td.
						 *
						 * @since 3.0.0
						 */
						do_action( 'epofw_field_start_td', $field_slug . '_main', 'forminp' );
					}
					if ( $field_extra_option ) {
						foreach ( $field_extra_option as $feo_key => $feo_value ) {
							$feo_value_title     = epofw_check_array_key_exists( 'title', $feo_value );
							$feo_value_info_type = epofw_check_array_key_exists( 'type', $feo_value );
							$feo_value_desc      = epofw_check_array_key_exists( 'description', $feo_value );
							$extra_data_property = epofw_get_data_property( $get_data, $field_main_key, $feo_key, $feo_value, $inc_key );
							if ( $feo_value_info_type ) {
								?>
								<div class="epofw_extra_field_div epofw_extra_field_sub_div" id="<?php echo esc_attr( $feo_key ); ?>">
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
										// phpcs:ignore WordPress.Security.EscapeOutput
										echo cp_render_fields( $extra_data_property, $feo_value_info_type, $inc_key ); // $feo_key
										if ( ! empty( $feo_value_desc ) ) {
											?>
											<span class="epofw_desc_toogle"></span>
											<p class="epofw_extra_field_inp_description epofw_description">
												<?php
												echo wp_kses_post( $feo_value_desc );
												?>
											</p>
											<?php
										}
										?>
									</div>
								</div>
								<?php
							}
						}
					}
					// phpcs:ignore WordPress.Security.EscapeOutput
					echo cp_render_fields( $data_property, $field_info_type, $inc_key );
					if ( ! empty( $field_desc ) ) {
						?>
						<span class="epofw_desc_toogle"></span>
						<p class="epofw_extra_field_inp_description epofw_description">
							<?php
							echo wp_kses_post( $field_desc );
							?>
						</p>
						<?php
					}
					/**
					 * Fire action after end td.
					 *
					 * @since 3.0.0
					 */
					do_action( 'epofw_field_end_td', $field_extra_option );
					/**
					 * Fire action after end tr.
					 *
					 * @since 3.0.0
					 */
					do_action( 'epofw_field_end_tr' );
				}
			}
		}
	}
}

/**
 * Additional conditional rule name.
 *
 * @since 1.0.0
 * @return array $conditional_name_arr Return conditional rule name.
 */
function epofw_field_additional_conditional_name() {
	$conditional_name_arr = array(
		'product'  => esc_html__( 'Product', 'extra-product-options-for-woocommerce' ),
		'category' => esc_html__( 'Category', 'extra-product-options-for-woocommerce' ),
	);

	/**
	 * Filters for field additional conditional name.
	 *
	 * @since 3.0.0
	 */
	return apply_filters( 'epofw_field_additional_conditional_name', $conditional_name_arr );
}

/**
 * Additional conditional operator name.
 *
 * @since 1.0.0
 * @return array $conditional_op_arr Return conditional operator name.
 */
function epofw_field_additional_conditional_operator() {
	$conditional_op_arr = array(
		'is_equal_to'  => esc_html__( 'Is Equal To', 'extra-product-options-for-woocommerce' ),
		'not_equal_to' => esc_html__( 'Not Equal To', 'extra-product-options-for-woocommerce' ),
	);

	/**
	 * Filters for field additional conditional operator.
	 *
	 * @since 3.0.0
	 */
	return apply_filters( 'epofw_field_additional_conditional_operator', $conditional_op_arr );
}

/**
 * Price type.
 *
 * @since 1.0.0
 *
 * @param string $type_key Field type.
 *
 * @return array $conditional_op_arr Return conditional operator name.
 */
function epofw_price_type_data( $type_key ) {
	$title_position_arr = '';
	if ( ! empty( $type_key ) ) {
		$title_position_arr = array(
			'fixed' => esc_html__( 'Fixed', 'extra-product-options-for-woocommerce' ),
		);
	}

	/**
	 * Filters for price type data.
	 *
	 * @since 3.0.0
	 */
	return apply_filters( 'epofw_price_type_data', $title_position_arr );
}

/**
 * List of tag name.
 *
 * @since 1.0.0
 * @return array $field_type_arr Return tag name.
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

	/**
	 * Filters for field heading type options data.
	 *
	 * @since 3.0.0
	 */
	return apply_filters( 'epofw_field_heading_type_options_data', $field_type_arr );
}

/**
 * List of field restriction type.
 *
 * @since 1.0.0
 * @return array $field_type_arr Return restriction list.
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

	/**
	 * Filters for field restriction options data.
	 *
	 * @since 3.0.0
	 */
	return apply_filters( 'epofw_field_restriction_options_data', $field_type_arr );
}

/**
 * List of content related tag name.
 *
 * @since 1.0.0
 * @return array $field_type_arr Return content related tag name.
 */
function epofw_field_content_type_options_data() {
	$field_type_arr = array(
		'p'          => esc_html__( 'P', 'extra-product-options-for-woocommerce' ),
		'address'    => esc_html__( 'Address', 'extra-product-options-for-woocommerce' ),
		'blockquote' => esc_html__( 'Blockquote', 'extra-product-options-for-woocommerce' ),
		'canvas'     => esc_html__( 'Canvas', 'extra-product-options-for-woocommerce' ),
		'output'     => esc_html__( 'Output', 'extra-product-options-for-woocommerce' ),
	);

	/**
	 * Filters for field content type options data.
	 *
	 * @since 3.0.0
	 */
	return apply_filters( 'epofw_field_content_type_options_data', $field_type_arr );
}

/**
 * Filter for field type options data: Like: Text, Number, Textarea etc.
 *
 * @since 1.0.0
 * @return array $field_type_arr Return all fields type.
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

	/**
	 * Filters for field type options data.
	 *
	 * @since 3.0.0
	 */
	return apply_filters( 'epofw_field_type_options_data', $field_type_arr );
}

/**
 * Render field based on type and attr data.
 *
 * @since 1.0.0
 *
 * @param array  $attr_data  Get all fields attr data.
 * @param string $field_type Get field type.
 * @param int    $inc_key    Get field key.
 *
 * @return string $html Return html.
 */
function cp_render_fields( $attr_data, $field_type, $inc_key ) {
	$html = '';
	switch ( $field_type ) {
		case 'hidden':
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
					$html .= $attr_name . EPOFW_EQUAL . '"' . $attr_value . '"';
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
							$html .= $attr_name . EPOFW_EQUAL . '"checkbox"';
						} elseif ( 'radio' === $field_type ) {
							$html .= $attr_name . EPOFW_EQUAL . '"radio"';
						}
					} elseif ( 'value' === $attr_name ) {
						if ( empty( $attr_value ) ) {
							$html .= $attr_name . EPOFW_EQUAL . '"on"';
						} else {
							$html .= 'on' === $attr_value ? 'checked="checked"' : '';
						}
					} else {
						$html .= $attr_name . EPOFW_EQUAL . '"' . $attr_value . '"';
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
						$html .= $attr_name . EPOFW_EQUAL . '"' . $attr_value . '"';
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
			if ( ! empty( $attr_data ) ) {
				$html .= '<select ';
				foreach ( $attr_data as $attr_name => $attr_value ) {
					if ( 'options' !== $attr_name && 'data-required-field' !== $attr_name && 'value' !== $attr_name ) {
						$html .= $attr_name . EPOFW_EQUAL . '"' . $attr_value . '"';
					} elseif ( 'data-required-field' === $attr_name ) {
						$html .= $attr_name . EPOFW_EQUAL . '"' . wc_esc_json( wp_json_encode( $attr_value ) ) . '"';
					}
				}
				$html .= '>';
				if ( isset( $attr_data['options'] ) ) {
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
				}
				$html .= '</select>';
			}
			break;
		case 'repeater':
			$html .= epofw_render_repeater( $attr_data, $inc_key );
			break;
	}

	return $html;
}

/**
 * Render field on front side based on type and attr data.
 *
 * @since 1.0.0
 *
 * @param array  $attr_data  Get all fields attr data.
 * @param string $field_type Get field type.
 * @param array  $args       {
 * The array of data with key epofwtwp_args.
 *
 * @type object    $product_data   Data of the current product.
 * @type int|float $product_price  Product price.
 * @type string    $opt_price_type Price type - Fixed, Percentage of product price or etc.
 * @type string    $epofw_action   Page action - shop|product page.
 * @type array     $fields_data    Array of addon data.
 * }
 * @return mixed $html Return html.
 */
function cp_render_fields_front( $attr_data, $field_type, $args ) {
	$common_class = 'epofw_fields_tag_class';
	if ( isset( $attr_data['class'] ) ) {
		$attr_data['class'] = $attr_data['class'] . ' ' . $common_class;
	}
	$html = '';
	unset( $attr_data['required'] );
	$args['epofwtwp_args']['attr_data'] = $attr_data;
	switch ( $field_type ) {
		case 'text':
		case 'password':
		case 'hidden':
		case 'number':
		case 'datepicker':
		case 'colorpicker':
		case 'timepicker':
		case 'checkboxgroup':
		case 'radiogroup':
		case 'checkbox':
		case 'textarea':
		case 'select':
		case 'multiselect':
		case 'html':
			wc_get_template(
				'epofw-' . $field_type . '.php',
				$args,
				epofw_get_template_path(),
				epofw_get_default_path()
			);
			break;
		case 'repeater':
			$html .= epofw_render_repeater( $attr_data, '' );
	}

	/**
	 * Filters to prints fields html.
	 *
	 * @since 3.0.0
	 */
	return apply_filters( 'epofw_print_fields_html', $html, $attr_data, $field_type );
}

/**
 * Render repeater field.
 *
 * @since 1.0.0
 *
 * @param array $field_value Get field value.
 * @param int   $inc_key     Get field key.
 */
function epofw_render_repeater( $field_value, $inc_key ) {
	?>
	<div class="optgroup">
		<div class="optgroup-detail">
			<div class="opt-ul">
				<div class="nested_accordion_data">
					<?php
					$requires_attr               = 'required="required"';
					$unique_field_name_array_key = 'epofw_field_settings';
					if ( ! empty( $field_value['value'] ) ) {
						$key = 0;
						foreach ( $field_value['value'] as $v_value ) {
							$opt_grp_data   = epofw_explore_label_from_opt_group( $v_value );
							$opt_label      = $opt_grp_data['opt_label'];
							$opt_price_type = $opt_grp_data['opt_price_type'];
							$opt_price      = $opt_grp_data['opt_price'];
							++$key;
							?>
							<div id="opt-li-<?php echo esc_attr( $inc_key ); ?>" class="opt-li nested_accordion_cls">
								<div class="heading_nu_move">
									<span><i class="sortable-icon dashicons dashicons-move"></i></span>
								</div>
								<div class="opt-td-label opt-dcls">
									<input type="text" name="epofw_data[general][<?php echo esc_attr( $inc_key ); ?>][<?php echo esc_attr( $unique_field_name_array_key ); ?>][options][label][]" id="select-opt-label-<?php echo esc_attr( $inc_key ); ?>" value="<?php echo esc_attr( $opt_label ); ?>" placeholder="<?php esc_attr_e( 'Option Label', 'extra-product-options-for-woocommerce' ); ?>" class="option-field"
										<?php echo esc_attr( $requires_attr ); ?>
									/>
								</div>
								<div class="opt-td-price-type opt-dcls">
									<select title='price_type' name="epofw_data[general][<?php echo esc_attr( $inc_key ); ?>][<?php echo esc_attr( $unique_field_name_array_key ); ?>][options][opt_price_type][]" id="opt_price_type_id" class="option-field">
										<?php
										$price_type_data = epofw_price_type_data( 'select' );
										if ( ! empty( $price_type_data ) ) {
											foreach ( $price_type_data as $price_t_key => $price_type_value ) {
												?>
												<option value="<?php echo esc_attr( $price_t_key ); ?>" <?php selected( $opt_price_type, $price_t_key ); ?>><?php echo esc_html( $price_type_value ); ?></option>
												<?php
											}
										}
										?>
									</select>
								</div>
								<div class="opt-td-price opt-dcls">
									<input type="text" name="epofw_data[general][<?php echo esc_attr( $inc_key ); ?>][<?php echo esc_attr( $unique_field_name_array_key ); ?>][options][opt_price][]" id="select-opt-price-<?php echo esc_attr( $inc_key ); ?>" value="<?php echo esc_attr( $opt_price ); ?>" placeholder="<?php esc_attr_e( 'Option Price', 'extra-product-options-for-woocommerce' ); ?>" class="option-field price_field"/>
								</div>
								<?php
								if ( 1 !== $key ) {
									?>
									<div class="opt-action opt-dcls">
										<a href="javascript:void(0);" id="remove-opt" class="remove-opt-btn">
											<span class="dashicons dashicons-trash"></span>
										</a>
									</div>
									<?php
								}
								?>
							</div>
							<?php
						}
					} else {
						?>
						<div id="opt-li-<?php echo esc_attr( $inc_key ); ?>" class="opt-li">
							<div class="opt-td-label opt-dcls">
								<input type="text" name="epofw_data[general][<?php echo esc_attr( $inc_key ); ?>][<?php echo esc_attr( $unique_field_name_array_key ); ?>][options][label][]" id="select-opt-label-<?php echo esc_attr( $inc_key ); ?>" value="<?php esc_attr_e( 'Option 1', 'extra-product-options-for-woocommerce' ); ?>" placeholder="<?php esc_attr_e( 'Option Label', 'extra-product-options-for-woocommerce' ); ?>" class="option-field"
									<?php echo esc_attr( $requires_attr ); ?>
								/>
							</div>
							<div class="opt-td-price-type opt-dcls">
								<select title='price_type' name="epofw_data[general][<?php echo esc_attr( $inc_key ); ?>][<?php echo esc_attr( $unique_field_name_array_key ); ?>][options][opt_price_type][]" id="opt_price_type_id" class="option-field">
									<?php
									$price_type_data = epofw_price_type_data( 'select' );
									if ( ! empty( $price_type_data ) ) {
										foreach ( $price_type_data as $price_t_key => $price_type_value ) {
											?>
											<option value="<?php echo esc_attr( $price_t_key ); ?>"><?php echo esc_html( $price_type_value ); ?></option>
											<?php
										}
									}
									?>
								</select>
							</div>
							<div class="opt-td-price opt-dcls">
								<input type="text" name="epofw_data[general][<?php echo esc_attr( $inc_key ); ?>][<?php echo esc_attr( $unique_field_name_array_key ); ?>][options][opt_price][]" id="select-opt-price-<?php echo esc_attr( $inc_key ); ?>" value="0.00" placeholder="<?php esc_attr_e( 'Option Price', 'extra-product-options-for-woocommerce' ); ?>" class="option-field price_field"/>
							</div>
							<div class="opt-dcls">
								<a href="javascript:void(0);" id="remove-opt" class="remove-opt-btn" data-attr="sop">
									<span class="dashicons dashicons-trash"></span>
								</a>
							</div>
						</div>
						<?php
					}
					?>
				</div>
			</div>
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

/**
 * Get data for fields.
 *
 * @since 1.0.0
 *
 * @param int $get_post_id Post id.
 *
 * @return array $get_data Return data for fields.
 */
function epofw_get_data_from_db( $get_post_id ) {

	if ( empty( $get_post_id ) ) {
		return array();
	}

	return get_post_meta( $get_post_id, 'epofw_prd_opt_data', true );
}

/**
 * Check fields key if exists then return data.
 *
 * @since 1.0.0
 *
 * @param array  $get_data       Get data for fields.
 * @param string $field_main_key Key of the main field.
 * @param string $key            Key of the field.
 * @param string $gn_key         check array key.
 *
 * @return array  $field_value Return field value.
 */
function epofw_check_general_field_data( $get_data, $field_main_key, $key, $gn_key ) {
	$field_value = '';
	if ( empty( $field_main_key ) ) {
		$field_main_key = 'field';
	}
	if ( is_array( $get_data ) && ! empty( $get_data ) ) {
		if ( array_key_exists( 'general', $get_data ) ) {
			if ( array_key_exists( $gn_key, $get_data['general'] ) ) {
				if ( array_key_exists( $field_main_key, $get_data['general'][ $gn_key ] ) ) {
					if ( is_array( $get_data['general'][ $gn_key ][ $field_main_key ] ) ) {
						if ( array_key_exists( $key, $get_data['general'][ $gn_key ][ $field_main_key ] ) ) {
							$field_value = $get_data['general'][ $gn_key ][ $field_main_key ][ $key ];
						}
					} else {
						$field_value = $get_data['general'][ $gn_key ][ $field_main_key ];
					}
				}
			}
		}
	}

	return $field_value;
}

/**
 * Check array key exists or not.
 *
 * @since 1.0.0
 *
 * @param string $key  Key of the field.
 * @param array  $data Array of the data.
 *
 * @return string|array $var_name Return var name.
 */
function epofw_check_array_key_exists( $key, $data = array() ) {
	$var_name = '';
	if ( ! empty( $data ) && is_array( $data ) ) {
		if ( array_key_exists( $key, $data ) ) {
			$var_name = $data[ $key ];
		}
	}
	if ( is_array( $var_name ) ) {
		return $var_name;
	} else {
		return trim( $var_name );
	}
}

/**
 * Calculate addon price based on condition and return formatted price.
 *
 * @since 1.0.0
 *
 * @param array $epofwtwp_args Addon args.
 * @param array $fields_data   Fields data.
 *
 * @return float $product_price Product price.
 */
function epofw_calculate_price_based_on_condition( $epofwtwp_args, $fields_data ) {
	$price                      = isset( $epofwtwp_args['opt_price'] ) ? $epofwtwp_args['opt_price'] : '';
	$price_type                 = isset( $epofwtwp_args['opt_price_type'] ) ? $epofwtwp_args['opt_price_type'] : '';
	$product_price              = isset( $epofwtwp_args['product_price'] ) ? $epofwtwp_args['product_price'] : '';
	$addon_price                = epofw_calculated_price_based_on_condition( $price, $price_type, $product_price );
	$epofwtwp_args['opt_price'] = $addon_price;
	$addon_price                = epofw_format_price_with_decimals( $addon_price, $epofwtwp_args, $fields_data );

	/**
	 * Filters to calculate price based on condition.
	 *
	 * @since 3.0.0
	 */
	return apply_filters( 'epofw_calculate_price_based_on_condition', $addon_price, $epofwtwp_args, $fields_data );
}

/**
 * Function will return calculated price based on condition.
 *
 * @since 2.5
 *
 * @param mixed  $price         Addon price.
 * @param string $price_type    Price type.
 * @param mixed  $product_price Product price.
 *
 * @return float|int
 */
function epofw_calculated_price_based_on_condition( $price, $price_type, $product_price ) {
	$addon_price = 0;
	if ( 'fixed' === $price_type ) {
		$addon_price = $price;
	}

	/**
	 * Filters to calculated price based on condition.
	 *
	 * @since 3.0.0
	 */
	return apply_filters( 'epofw_calculated_price_based_on_condition', $addon_price, $price, $price_type, $product_price );
}

/**
 * Explore opt group fields data.
 *
 * @since 1.1
 *
 * @param string|array $v_value Array of opt group data.
 *
 * @return array.
 */
function epofw_explore_label_from_opt_group( $v_value ) {
	if ( strpos( $v_value, '||' ) !== false ) {
		$v_value_ex     = explode( '||', $v_value );
		$opt_label      = epofw_check_array_key_exists( '0', $v_value_ex );
		$opt_price_type = epofw_check_array_key_exists( '1', $v_value_ex );
		$opt_price      = epofw_check_array_key_exists( '2', $v_value_ex );
		if ( empty( $opt_price ) ) {
			$opt_price = 0;
		}
	} else {
		$opt_label      = '';
		$opt_price_type = 'fixed';
		$opt_price      = 0;
	}

	return array(
		'opt_label'      => $opt_label,
		'opt_price_type' => $opt_price_type,
		'opt_price'      => $opt_price,
	);
}

/**
 * Function to get field list.
 *
 * @since 1.0.0
 *
 * @param int $current_prd_id   Current product id.
 * @param int $current_field_id Current field id.
 *
 * @return array
 */
function epofw_get_fields_list( $current_prd_id, $current_field_id ) {
	$product_option_args = array(
		'post_type'      => EPOFW_DFT_POST_TYPE,
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'ID',
		'order'          => 'DESC',
		'fields'         => 'ids',
		'post__in'       => array( $current_prd_id ),
	);
	$prd_wp_query        = new WP_Query( $product_option_args );
	$fields_array        = array();
	if ( $prd_wp_query->have_posts() ) {
		foreach ( $prd_wp_query->posts as $f_id ) {
			$get_data = epofw_get_data_from_db( $f_id );
			if ( ! empty( $get_data ) ) {
				$general_data = epofw_check_array_key_exists( 'general', $get_data );
				if ( ! empty( $general_data ) ) {
					foreach ( $general_data as $general_data_key => $general_data_val ) {
						if (
							! empty( $general_data_val )
							&& ( isset( $general_data_val['field_status'] ) && 'on' === $general_data_val['field_status'] )
							&& $current_field_id !== $general_data_key
						) {
							$generate_key                      = 'epofw_' . $general_data_val['field']['type'] . '_' . $general_data_key;
							$fields_array[ $general_data_key ] = $generate_key . '||' . $general_data_val['field']['type'] . '||' . $general_data_val['label']['title'];
						}
					}
				}
			}
		}
	}

	return $fields_array;
}

/**
 * Function to display product price.
 *
 * @since 1.0.0
 *
 * @param object $product_data Product data.
 * @param string $action       Action.
 *
 * @return mixed|null
 */
function epofw_display_product_price( $product_data, $action ) {
	$product_price = '';
	if ( ! empty( $product_data ) ) {
		/**
		 * Apply filters for display product price before tax.
		 *
		 * @since 1.0.0
		 */
		$product_price = apply_filters( 'epofw_display_product_price_before_tax', $product_data->get_price(), $product_data );
		if ( 'shop' === $action ) {
			if ( 'incl' === get_option( 'woocommerce_tax_display_shop' ) ) {
				$product_price = wc_get_price_including_tax( $product_data );  // Price with VAT.
			} elseif ( 'excl' === get_option( 'woocommerce_tax_display_shop' ) ) {
				$product_price = wc_get_price_excluding_tax( $product_data );  // Price with VAT.
			}
		} elseif ( 'cart' === $action ) {
			if ( 'incl' === WC()->cart->get_tax_price_display_mode() ) {
				$product_price = wc_get_price_including_tax( $product_data );  // Price with VAT.
			} elseif ( 'excl' === get_option( 'woocommerce_tax_display_shop' ) ) {
				$product_price = wc_get_price_excluding_tax( $product_data );  // Price with VAT.
			}
		}
		// Get Product bundle price.
		if ( is_object( $product_data ) && $product_data->is_type( 'bundle' ) ) {
			$product_price = $product_data->get_bundle_price();
		}
	}

	/**
	 * Filters for display product price.
	 *
	 * @since 3.0.0
	 */
	return apply_filters( 'epofw_display_product_price', $product_price, $product_data );
}

/**
 * Convert string Cyrillic to Latin.
 *
 * @since 1.2
 *
 * @param string $name_string Input string.
 *
 * @return array|string|string[]
 */
function epofw_get_cyric_string_to_latin( $name_string ) {
	if ( preg_match( '/[А-Яа-яЁё]/u', $name_string ) ) {
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
		$textcyr = str_replace( $cyr, $lat, $name_string );
	} else {
		$textcyr = $name_string;
	}

	return $textcyr;
}

/**
 * Function to get general settings.
 *
 * @param string $key Key of settings.
 *
 * @return string
 */
function epofw_general_settings( $key ) {
	$get_data = get_option( 'epofw_general_data' );
	if ( is_serialized( $get_data ) ) {
		$get_data           = maybe_unserialize( $get_data );
		$epofw_general_data = epofw_check_array_key_exists( 'epofw_general_data', $get_data );
		$value              = epofw_check_array_key_exists( $key, $epofw_general_data );
	} else {
		$value = epofw_check_array_key_exists( $key, $get_data );
	}

	return $value;
}

/**
 * Function to get addon details title.
 *
 * @param string $key Key of settings.
 *
 * @return string
 */
function epofw_get_addon_details_title( $key ) {
	$epofw_addon_details_title = epofw_general_settings( $key );

	return empty( $epofw_addon_details_title ) ? esc_html__( 'Addon Details', 'extra-product-options-for-woocommerce' ) : $epofw_addon_details_title;
}

/**
 * Function to get addon subtitle.
 *
 * @param string $key Key of settings.
 *
 * @return string
 */
function epofw_get_addon_subtitle_title( $key ) {
	$epofw_addon_details_subtotal_title = epofw_general_settings( $key );

	return empty( $epofw_addon_details_subtotal_title ) ? esc_html__( 'Subtotal', 'extra-product-options-for-woocommerce' ) : $epofw_addon_details_subtotal_title;
}

/**
 * Function will return title with price sign.
 *
 * @param array $epofwtwp_args Args of addons.
 * @param array $fields_data   Array of fields data.
 *
 * @return string
 */
function epofw_title_with_price( $epofwtwp_args, $fields_data ) {
	$title     = isset( $epofwtwp_args['opt_label'] ) ? $epofwtwp_args['opt_label'] : '';
	$opt_price = isset( $epofwtwp_args['opt_price'] ) ? $epofwtwp_args['opt_price'] : '';
	$check_hop = isset( $epofwtwp_args['check_hop'] ) ? $epofwtwp_args['check_hop'] : '';
	/**
	 * Filters for bracket before title with price.
	 *
	 * @since 3.0.0
	 */
	$price_sign = apply_filters( 'epofw_open_bracket_before_title_with_price', ' (+' );
	if ( strpos( $opt_price, '(' ) !== false ) {
		/**
		 * Filters for bracket before title with price.
		 *
		 * @since 3.0.0
		 */
		$price_sign = apply_filters( 'epofw_open_bracket_before_title_with_price', ' (' );
	}
	/**
	 * Filters for option price without wc format and with title.
	 *
	 * @since 3.0.0
	 */
	$opt_price = apply_filters( 'epofw_opt_price_without_wc_price_format_title_with_price', epofw_calculate_price_based_on_condition( $epofwtwp_args, $fields_data ), $epofwtwp_args, $fields_data );
	/**
	 * Filters for option price with wc format and with title.
	 *
	 * @since 3.0.0
	 */
	$opt_price   = apply_filters( 'epofw_opt_price_with_wc_price_format_title_with_price', wc_price( epofw_price_filter( $opt_price ), $epofwtwp_args ), $fields_data );
	$suffix_html = '';
	/**
	 * Filters for close bracket before title with price.
	 *
	 * @since 3.0.0
	 */
	$label_title = $price_sign . $opt_price . $suffix_html . apply_filters( 'epofw_close_bracket_before_title_with_price', ')' );
	if ( $title ) {
		if ( 'on' !== $check_hop ) {
			/**
			 * Filters for close bracket before title with price.
			 *
			 * @since 3.0.0
			 */
			$label_title = $title . $price_sign . $opt_price . $suffix_html . apply_filters( 'epofw_close_bracket_before_title_with_price', ')' );
		} else {
			$label_title = $title;
		}
	}

	/**
	 * Filters for title with price.
	 *
	 * @since 3.0.0
	 */
	return apply_filters( 'epofw_title_with_price', $label_title, $epofwtwp_args, $fields_data );
}

/**
 * Adde filter for the price.
 *
 * @param mixed $epofw_price Addon price.
 *
 * @return mixed|void
 */
function epofw_price_filter( $epofw_price ) {
	/**
	 * Filters for addon price.
	 *
	 * @since 3.0.0
	 */
	return apply_filters( 'epofw_price_filter', $epofw_price );
}

/**
 * Function will format price with decimal.
 *
 * @since  2.4.2
 *
 * @param mixed $addon_price Addon price.
 * @param array $egppc_args  Array of fields argument.
 * @param array $fields_data Array of fields data.
 *
 * @return mixed|string
 */
function epofw_format_price_with_decimals( $addon_price, $egppc_args, $fields_data ) {
	$opt_price = empty( $addon_price ) ? ! empty( $egppc_args['opt_price'] ) ? $egppc_args['opt_price'] : 0 : $addon_price;
	/**
	 * Filters for before format price with decimals.
	 *
	 * @since 3.0.0
	 */
	$opt_price = apply_filters( 'epofw_before_format_price_with_decimals', $opt_price, $egppc_args, $fields_data );
	if ( ! is_string( $opt_price ) ) {
		$opt_price = number_format( $opt_price, wc_get_price_decimals(), '.', '' );
	}

	/**
	 * Filters to format price with decimals.
	 *
	 * @since 3.0.0
	 */
	return apply_filters( 'epofw_format_price_with_decimals', $opt_price, $addon_price, $egppc_args, $fields_data );
}

/**
 * Function will returns the path for overriding the templates.
 *
 * @since 2.5
 * @return string
 */
function epofw_get_template_path() {
	/**
	 * Filters to override path.
	 *
	 * @since 3.0.0
	 */
	return apply_filters( 'epofw_template_override_path', EPOFW_TEMPLATE_CONSTANT . '/' );
}

/**
 * Function will returns the default path for the templates.
 *
 * @since 2.5
 * @return string
 */
function epofw_get_default_path() {
	/**
	 * Filters to get default template path.
	 *
	 * @since 3.0.0
	 */
	return apply_filters( 'epofw_default_template_path', EPOFW_TEMPLATE_PATH );
}

/**
 * Attr data for front side.
 *
 * @since 2.5
 *
 * @return array
 */
function epofw_data_attr_json() {
	$data_sub_attr  = array();
	$condition_type = 'prd';
	$data_attr      = wp_json_encode( $data_sub_attr );

	return array(
		'data_attr'      => $data_attr,
		'condition_type' => $condition_type,
	);
}

/**
 * Function will return field title.
 *
 * @since 2.5
 *
 * @param array $fields_data Field data.
 *
 * @return mixed|void
 */
function epofw_get_field_input_property( $fields_data ) {
	$field_input_property = ! empty( $fields_data['field'] ) ? $fields_data['field'] : array();

	/**
	 * Filters to get field input property.
	 *
	 * @since 3.0.0
	 */
	return apply_filters( 'epofw_get_field_input_property', $field_input_property, $fields_data );
}

/**
 * Function will return field title.
 *
 * @since 2.5
 *
 * @param array $fields_data Field data.
 *
 * @return mixed|void
 */
function epofw_get_field_type( $fields_data ) {
	$field_type = ! empty( $fields_data['field']['type'] ) ? $fields_data['field']['type'] : '';

	/**
	 * Filters to get field type.
	 *
	 * @since 3.0.0
	 */
	return apply_filters( 'epofw_get_field_type', $field_type, $fields_data );
}

/**
 * Function will return heading type.
 *
 * @since 2.5
 *
 * @param array $fields_data Field data.
 *
 * @return mixed|void
 */
function epofw_get_field_heading_type( $fields_data ) {
	$heading_type = ! empty( $fields_data['field']['heading_type'] ) ? $fields_data['field']['heading_type'] : '';

	/**
	 * Filters to get field heading type.
	 *
	 * @since 3.0.0
	 */
	return apply_filters( 'epofw_get_field_heading_type', $heading_type, $fields_data );
}

/**
 * Function will return content.
 *
 * @since 2.5
 *
 * @param array $fields_data Field data.
 *
 * @return mixed|void
 */
function epofw_get_field_content( $fields_data ) {
	$content = ! empty( $fields_data['field']['content'] ) ? $fields_data['field']['content'] : '';

	/**
	 * Filters to get field content.
	 *
	 * @since 3.0.0
	 */
	return apply_filters( 'epofw_get_field_content', $content, $fields_data );
}

/**
 * Function will return content type.
 *
 * @since 2.5
 *
 * @param array $fields_data Field data.
 *
 * @return mixed|void
 */
function epofw_get_field_content_type( $fields_data ) {
	$content_type = ! empty( $fields_data['field']['content_type'] ) ? $fields_data['field']['content_type'] : '';

	/**
	 * Filters to get field content type.
	 *
	 * @since 3.0.0
	 */
	return apply_filters( 'epofw_get_field_content_type', $content_type, $fields_data );
}

/**
 * Function will return field is required or not.
 *
 * @since 2.5
 *
 * @param array $fields_data Field data.
 *
 * @return mixed|void
 */
function epofw_get_field_required( $fields_data ) {
	$required = ! empty( $fields_data['field']['required'] ) ? $fields_data['field']['required'] : '';

	/**
	 * Filters to get field required.
	 *
	 * @since 3.0.0
	 */
	return apply_filters( 'epofw_get_field_required', $required, $fields_data );
}

/**
 * Function will get field label title.
 *
 * @since 2.5
 *
 * @param array $fields_data Field data.
 *
 * @return mixed|void
 */
function epofw_get_field_label_title( $fields_data ) {
	$field_label_title = ! empty( $fields_data['label']['title'] ) ? $fields_data['label']['title'] : '';

	/**
	 * Filters to get field label title.
	 *
	 * @since 3.0.0
	 */
	return apply_filters( 'epofw_get_field_label_title', $field_label_title, $fields_data );
}

/**
 * Function will get field label class.
 *
 * @since 2.5
 *
 * @param array $fields_data Field data.
 *
 * @return mixed|void
 */
function epofw_get_field_label_class( $fields_data ) {
	$field_label_class = ! empty( $fields_data['label']['class'] ) ? $fields_data['label']['class'] : '';

	/**
	 * Filters to get field label class.
	 *
	 * @since 3.0.0
	 */
	return apply_filters( 'epofw_get_field_label_class', $field_label_class, $fields_data );
}

/**
 * Function will get field label title type.
 *
 * @since 2.5
 *
 * @param array $fields_data Field data.
 *
 * @return mixed|void
 */
function epofw_get_field_label_title_type( $fields_data ) {
	$field_label_title_type = 'label';

	/**
	 * Filters to get field label title type.
	 *
	 * @since 3.0.0
	 */
	return apply_filters( 'epofw_get_field_label_title_type', $field_label_title_type, $fields_data );
}

/**
 * Function will get field label subtitle class.
 *
 * @since 2.5
 *
 * @param array $fields_data Field data.
 *
 * @return mixed|void
 */
function epofw_get_field_label_subtitle_class( $fields_data ) {
	$field_label_subtitle_class = ! empty( $fields_data['label']['subtitle_class'] ) ? $fields_data['label']['subtitle_class'] : '';

	/**
	 * Filters to get field label subtitle class.
	 *
	 * @since 3.0.0
	 */
	return apply_filters( 'epofw_get_field_label_subtitle_class', $field_label_subtitle_class, $fields_data );
}

/**
 * Function will get field label subtitle.
 *
 * @since 2.5
 *
 * @param array $fields_data Field data.
 *
 * @return mixed|void
 */
function epofw_get_field_label_subtitle( $fields_data ) {
	$field_label_subtitle = ! empty( $fields_data['label']['subtitle'] ) ? $fields_data['label']['subtitle'] : '';

	/**
	 * Filters to get field label subtitle.
	 *
	 * @since 3.0.0
	 */
	return apply_filters( 'epofw_get_field_label_subtitle', $field_label_subtitle, $fields_data );
}

/**
 * Function will get field label subtitle type.
 *
 * @since 2.5
 *
 * @param array $fields_data Field data.
 *
 * @return mixed|void
 */
function epofw_get_field_label_subtitle_type( $fields_data ) {
	$field_label_subtitle_type = 'label';

	/**
	 * Filters to field label subtitle type.
	 *
	 * @since 3.0.0
	 */
	return apply_filters( 'epofw_get_field_label_subtitle_type', $field_label_subtitle_type, $fields_data );
}

/**
 * Function will get field label title position.
 *
 * @since 2.5
 *
 * @param array $fields_data Field data.
 *
 * @return mixed|void
 */
function epofw_get_field_label_title_position( $fields_data ) {
	$field_label_title_position = 'left';

	/**
	 * Filters to get field label title position.
	 *
	 * @since 3.0.0
	 */
	return apply_filters( 'epofw_get_field_label_title_position', $field_label_title_position, $fields_data );
}

/**
 * Function will get field settings.
 *
 * @since 2.5
 *
 * @param array $fields_data Field data.
 *
 * @return mixed|void
 */
function epofw_get_field_settings( $fields_data ) {
	$field_settings = ! empty( $fields_data['epofw_field_settings'] ) ? $fields_data['epofw_field_settings'] : '';

	/**
	 * Filters to get field settings.
	 *
	 * @since 3.0.0
	 */
	return apply_filters( 'epofw_get_field_settings', $field_settings, $fields_data );
}

/**
 * Function will check field restriction is enable or not for text.
 *
 * @since 2.5
 *
 * @param array $fields_data Field data.
 *
 * @return mixed|void
 */
function epofw_get_field_restriction( $fields_data ) {
	$field_restriction = ! empty( $fields_data['epofw_field_settings']['field_restriction'] ) ? $fields_data['epofw_field_settings']['field_restriction'] : '';

	/**
	 * Filters to get field restriction.
	 *
	 * @since 3.0.0
	 */
	return apply_filters( 'epofw_get_field_restriction', $field_restriction, $fields_data );
}

/**
 * Function will check addon price is enable or not.
 *
 * @since 2.5
 *
 * @param array $fields_data Field data.
 *
 * @return mixed|void
 */
function epofw_check_enable_price_extra( $fields_data ) {
	$enable_price_extra = ! empty( $fields_data['epofw_field_settings']['enable_price_extra'] ) ? $fields_data['epofw_field_settings']['enable_price_extra'] : '';

	/**
	 * Filters to check enable extra price.
	 *
	 * @since 3.0.0
	 */
	return apply_filters( 'epofw_check_enable_price_extra', $enable_price_extra, $fields_data );
}

/**
 * Function will get addon price type.
 *
 * @since 2.5
 *
 * @param array $fields_data Field data.
 *
 * @return mixed|void
 */
function epofw_get_addon_price_type( $fields_data ) {
	$addon_price_type = ! empty( $fields_data['epofw_field_settings']['addon_price_type'] ) ? $fields_data['epofw_field_settings']['addon_price_type'] : '';

	/**
	 * Filters for get addon price type.
	 *
	 * @since 3.0.0
	 */
	return apply_filters( 'epofw_get_addon_price_type', $addon_price_type, $fields_data );
}

/**
 * Function will get addon price.
 *
 * @since 2.5
 *
 * @param array $fields_data Field data.
 *
 * @return mixed|void
 */
function epofw_get_addon_price( $fields_data ) {
	$addon_price = ! empty( $fields_data['epofw_field_settings']['addon_price'] ) ? $fields_data['epofw_field_settings']['addon_price'] : 0;

	/**
	 * Filters for get addon price.
	 *
	 * @since 3.0.0
	 */
	return apply_filters( 'epofw_get_addon_price', $addon_price, $fields_data );
}

/**
 * Function will return all field attr as json.
 *
 * @since 2.5
 *
 * @param array $args {
 * The array of data.
 *
 * @type object    $product_data   Data of the current product.
 * @type int|float $product_price  Product price.
 * @type string    $opt_price_type Price type - Fixed, Percentage of product price or etc.
 * @type string    $epofw_action   Page action - shop|product page.
 * @type array     $fields_data    Array of addon data.
 * }
 * @return mixed|void
 */
function epofw_all_fields_attr( $args ) {
	$field_attr_atrr             = array();
	$fields_data                 = isset( $args['epofwtwp_args']['fields_data'] ) ? $args['epofwtwp_args']['fields_data'] : array();
	$check_field_required        = epofw_get_field_required( $fields_data );
	$required_data['rd_status']  = $check_field_required;
	$field_attr_atrr['required'] = $required_data;
	$check_epofw_field_settings  = epofw_get_field_settings( $fields_data );
	$check_field_lbl_title       = epofw_get_field_label_title( $fields_data );
	$check_field_inp_type        = epofw_get_field_type( $fields_data );
	if ( ! empty( $check_epofw_field_settings ) ) {
		foreach ( $check_epofw_field_settings as $key => $value ) {
			if ( ! empty( $value ) ) {
				$field_attr_atrr[ $key ] = $value;
			}
			if ( 'options' === $key ) {
				$new_options = array();
				foreach ( $value as $opt_key => $opt_value ) {
					$opt_value_ex = explode( '||', $opt_value );
					if ( isset( $opt_value_ex[1] ) && isset( $opt_value_ex[2] ) ) {
						$args['epofwtwp_args']['opt_price']      = $opt_value_ex[2];
						$args['epofwtwp_args']['opt_price_type'] = $opt_value_ex[1];
						// Get price.
						$opt_value_ex[2] = epofw_price_filter( epofw_calculate_price_based_on_condition( $args['epofwtwp_args'], $fields_data ) );
					}
					$new_options[ $opt_key ] = $opt_value_ex;
				}
				$field_attr_atrr[ $key ] = $new_options;
			}
		}
	}
	$field_attr_atrr['data-label-name'] = $check_field_lbl_title;
	$check_field_restriction            = epofw_get_field_restriction( $fields_data );
	if ( $check_field_restriction ) {
		unset( $check_epofw_field_settings['field_restriction'] );
	}
	$field_attr_atrr['data_inp_type']      = $check_field_inp_type;
	$check_field_enable_price              = epofw_check_enable_price_extra( $fields_data );
	$check_field_addon_price_type          = epofw_get_addon_price_type( $fields_data );
	$check_field_addon_price               = epofw_get_addon_price( $fields_data );
	$field_attr_atrr['enable_price_extra'] = $check_field_enable_price;
	if ( 'on' === $check_field_enable_price ) {
		$field_attr_atrr['addon_price_type']     = $check_field_addon_price_type;
		$args['epofwtwp_args']['opt_price']      = $check_field_addon_price;
		$args['epofwtwp_args']['opt_price_type'] = $check_field_addon_price_type;
		// Get price.
		$field_attr_atrr['addon_price'] = epofw_price_filter( epofw_calculate_price_based_on_condition( $args['epofwtwp_args'], $fields_data ) );
	} else {
		$field_attr_atrr['addon_price_type'] = 'fixed';
		$field_attr_atrr['addon_price']      = 0.00;
	}

	/**
	 * Filters for All fields attribute.
	 *
	 * @since 3.0.0
	 */
	return apply_filters( 'epofw_all_fields_attr', wp_json_encode( array( $field_attr_atrr ) ), $args );
}

/**
 * Function will return tag based on structure.
 *
 * @since 2.5
 *
 * @param string $default_display_tag Tag name.
 *
 * @return string $default_display_tag Tag name.
 */
function epofw_get_tag_based_on_structure( $default_display_tag ) {
	return $default_display_tag;
}

/**
 * Function will return product prices with tax and without tax array based on cart item.
 *
 * @since 2.5
 *
 * @param array $cart_item_data Array of cart item data.
 *
 * @return array
 */
function epofw_product_price( $cart_item_data ) {
	$price         = wc_get_price_to_display(
		$cart_item_data['data'],
		array(
			'price' => $cart_item_data['data']->get_price( 'edit' ),
		)
	);
	$regular_price = wc_get_price_to_display(
		$cart_item_data['data'],
		array(
			'price' => $cart_item_data['data']->get_regular_price( 'edit' ),
		)
	);
	$sale_price    = wc_get_price_to_display(
		$cart_item_data['data'],
		array(
			'price' => $cart_item_data['data']->get_sale_price( 'edit' ),
		)
	);

	return array(
		'price'                     => (float) $price,
		'regular_price'             => (float) $regular_price,
		'sale_price'                => (float) $sale_price,
		'price_without_tax'         => (float) $cart_item_data['data']->get_price( 'edit' ),
		'regular_price_without_tax' => (float) $cart_item_data['data']->get_regular_price( 'edit' ),
		'sale_price_without_tax'    => (float) $cart_item_data['data']->get_sale_price( 'edit' ),
	);
}

/**
 * Function will sanitize input.
 *
 * @param array|string $data Array of data or input.
 *
 * @return array|string
 */
function sanitize_array( &$data ) {
	foreach ( $data as &$value ) {
		if ( ! is_array( $value ) ) {
			// Sanitize if value is not an array.
			$value = sanitize_text_field( wp_unslash( $value ) );
		} else {
			// Go inside this function again.
			sanitize_array( $value );
		}
	}

	return $data;
}
