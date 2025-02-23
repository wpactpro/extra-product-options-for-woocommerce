<?php
/**
 * Extra Product Options for WooCommerce Actions
 *
 * Handles all action and filter hooks for the plugin.
 *
 * @package Extra_Product_Options_For_WooCommerce
 * @since   2.5
 */

/**
 * Function will add class for label.
 *
 * @since 2.5
 *
 * @param string $field_label_class Label of the class.
 *
 * @return string $field_label_class Label of the class.
 */
function epofw_get_field_label_class_callback( $field_label_class ) {
	$field_label_class = $field_label_class . ' epofw_td_label';

	return $field_label_class;
}

add_filter( 'epofw_get_field_label_class', 'epofw_get_field_label_class_callback', 10, 1 );

/**
 * Function will display field label html.
 *
 * @since 2.5
 *
 * @param array $field_input_property Array of field input.
 * @param array $fields_data          Array of fields data.
 *
 * @return array $field_input_property Array of field input.
 */
function epofw_get_field_input_property_callback( $field_input_property, $fields_data ) {
	$check_field_lbl_title                   = epofw_get_field_label_title( $fields_data );
	$field_input_property['data-label-name'] = $check_field_lbl_title;

	return $field_input_property;
}

add_filter( 'epofw_get_field_input_property', 'epofw_get_field_input_property_callback', 10, 2 );

/**
 * Function will display field label html.
 *
 * @since 2.5
 *
 * @param array $args {
 *     The array of data.
 *
 *     @type object    $product_data   Data of the current product.
 *     @type int|float $product_price  Product price.
 *     @type string    $opt_price_type Price type - Fixed, Percentage of product price or etc.
 *     @type string    $epofw_action   Page action - shop|product page.
 *     @type array     $fields_data    Array of addon data.
 * }
 */
function epofw_html_table_field_label_td_callback( $args ) {
	wc_get_template(
		'epofw-field-label-html.php',
		array(
			'epofwtwp_args' => $args,
		),
		epofw_get_template_path(),
		epofw_get_default_path()
	);
}

add_action( 'epofw_html_table_field_label_td', 'epofw_html_table_field_label_td_callback', 10, 1 );

/**
 * Function will display field input html.
 *
 * @since 2.5
 *
 * @param array $args {
 *                                 The array of data.
 *
 * @type object    $product_data   Data of the current product.
 * @type int|float $product_price  Product price.
 * @type string    $opt_price_type Price type - Fixed, Percentage of product price or etc.
 * @type string    $epofw_action   Page action - shop|product page.
 * @type array     $fields_data    Array of addon data.
 * }
 */
function epofw_html_table_field_input_td_callback( $args ) {
	wc_get_template(
		'epofw-field-input-html.php',
		array(
			'epofwtwp_args' => $args,
		),
		epofw_get_template_path(),
		epofw_get_default_path()
	);
}

add_action( 'epofw_html_table_field_input_td', 'epofw_html_table_field_input_td_callback', 10, 1 );

/**
 * Function will display field title.
 *
 * @since 2.5
 *
 * @param array $args {
 *                                 The array of data.
 *
 * @type object    $product_data   Data of the current product.
 * @type int|float $product_price  Product price.
 * @type string    $opt_price_type Price type - Fixed, Percentage of product price or etc.
 * @type string    $epofw_action   Page action - shop|product page.
 * @type array     $fields_data    Array of addon data.
 * }
 */
function epofw_field_title_callback( $args ) {
	$fields_data                = isset( $args['epofwtwp_args']['fields_data'] ) ? $args['epofwtwp_args']['fields_data'] : array();
	$check_field_inp_type       = epofw_get_field_type( $fields_data );
	$check_field_lbl_title_type = epofw_get_field_label_title_type( $fields_data );
	$check_field_lbl_title      = epofw_get_field_label_title( $fields_data );
	$check_field_lbl_data_name  = '';
	if ( $check_field_lbl_title ) {
		$check_field_lbl_data_name = 'data-label-name="' . $check_field_lbl_title . '"';
	}
	$check_field_lbl_class = epofw_get_field_label_class( $fields_data );
	$heading_type          = $check_field_lbl_title_type;
	$title_or_content      = $check_field_lbl_title;
	if ( $check_field_lbl_class ) {
		/**
		 * Filter for title label class.
		 *
		 * @since 1.0.0
		 */
		$check_field_lbl_class = apply_filters( 'epofw_field_title_lbl_class', $check_field_lbl_class, $args );
		$check_field_lbl_class = 'class="' . $check_field_lbl_class . '"';
	}
	if (
		isset( $fields_data['epofw_field_settings']['enable_price_extra'] ) &&
		'on' === $fields_data['epofw_field_settings']['enable_price_extra']
	) {
		$price_label_for_text = epofw_title_with_price( $args['epofwtwp_args'], $fields_data );
		$title_or_content     = $title_or_content . $price_label_for_text;
	}
	if ( 'heading' === $check_field_inp_type ) {
		$heading_type     = epofw_get_field_heading_type( $fields_data );
		$title_or_content = epofw_get_field_label_title( $fields_data );
	}
	if ( 'paragraph' === $check_field_inp_type ) {
		$heading_type     = epofw_get_field_content_type( $fields_data );
		$title_or_content = epofw_get_field_content( $fields_data );
	}
	$html = '<' . $heading_type . ' ' . $check_field_lbl_class . ' ' . $check_field_lbl_data_name . '>' . $title_or_content . '</' . $heading_type . '>';
	/**
	 * Filter for title action.
	 *
	 * @since 1.0.0
	 */
	echo wp_kses_post( apply_filters( 'epofw_field_title_action', $html, $args ) );
}

add_action( 'epofw_field_title', 'epofw_field_title_callback', 10, 2 );

/**
 * Function will display field subtitle.
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
 */
function epofw_field_subtitle_callback( $args ) {
	$fields_data                    = isset( $args['epofwtwp_args']['fields_data'] ) ? $args['epofwtwp_args']['fields_data'] : array();
	$html                           = '';
	$check_field_lbl_subtitle       = epofw_get_field_label_subtitle( $fields_data );
	$check_field_lbl_subtitle_type  = epofw_get_field_label_subtitle_type( $fields_data );
	$check_field_lbl_subtitle_class = epofw_get_field_label_subtitle_class( $fields_data );
	/**
	 * Filter for subtitle label class.
	 *
	 * @since 1.0.0
	 */
	$check_field_lbl_subtitle_class = ! empty( $check_field_lbl_subtitle_class ) ? 'class="' . apply_filters( 'epofw_field_subtitle_lbl_subtitle', $check_field_lbl_subtitle_class, $args ) . '"' : '';
	if ( $check_field_lbl_subtitle ) {
		$html = '<' . $check_field_lbl_subtitle_type . ' ' . $check_field_lbl_subtitle_class . '>' . $check_field_lbl_subtitle . '</' . $check_field_lbl_subtitle_type . '>';
	}
	/**
	 * Filter for subtitle action.
	 *
	 * @since 1.0.0
	 */
	echo wp_kses_post( apply_filters( 'epofw_field_subtitle_action', $html, $args ) );
}

add_action( 'epofw_field_subtitle', 'epofw_field_subtitle_callback', 10, 1 );

/**
 * Function will display start td html.
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
 */
function epofw_field_label_start_td_callback( $args ) {
	$fields_data          = isset( $args['epofwtwp_args']['fields_data'] ) ? $args['epofwtwp_args']['fields_data'] : array();
	$check_field_inp_type = epofw_get_field_type( $fields_data );
	/**
	 * Filter for start label tag.
	 *
	 * @since 1.0.0
	 */
	$tag = apply_filters( 'epofw_field_label_start_tag_display', epofw_get_tag_based_on_structure( 'td' ), $args );
	/**
	 * Filter for td label class.
	 *
	 * @since 1.0.0
	 */
	$label_class = apply_filters( 'epofw_field_td_label_class', 'label epofw_td_label', $args );
	?>
	<<?php echo esc_html( $tag ); ?> class="<?php echo esc_attr( $label_class ); ?>"
	<?php
	if ( 'heading' === $check_field_inp_type || 'paragraph' === $check_field_inp_type ) {
		echo 'colspan="2"';
	}
	?>
	>
	<?php
}

add_action( 'epofw_field_label_start_td', 'epofw_field_label_start_td_callback', 10, 1 );

/**
 * Function will display start td html.
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
 */
function epofw_field_label_end_td_callback( $args ) {
	/**
	 * Filter for end label tag class.
	 *
	 * @since 1.0.0
	 */
	$tag = apply_filters( 'epofw_field_label_end_tag_display', epofw_get_tag_based_on_structure( 'td' ), $args );
	?>
	</<?php echo esc_html( $tag ); ?>>
	<?php
}

add_action( 'epofw_field_label_end_td', 'epofw_field_label_end_td_callback', 10, 1 );

/**
 * Function will display start td html.
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
 */
function epofw_field_input_start_td_callback( $args ) {
	$fields_data                = isset( $args['epofwtwp_args']['fields_data'] ) ? $args['epofwtwp_args']['fields_data'] : array();
	$check_field_title_position = epofw_get_field_label_title_position( $fields_data );
	/**
	 * Filter for input start tag.
	 *
	 * @since 1.0.0
	 */
	$tag = apply_filters( 'epofw_field_input_start_tag_display', epofw_get_tag_based_on_structure( 'td' ), $args );
	/**
	 * Filter for td class.
	 *
	 * @since 1.0.0
	 */
	$input_class = apply_filters( 'epofw_field_td_input_class', 'value epofw_td_value epofw_' . $check_field_title_position, $args );
	?>
	<<?php echo esc_html( $tag ); ?> class="<?php echo esc_attr( $input_class ); ?>"
	<?php
	if ( ! empty( $args ) ) {
		echo 'data-epofw_sa="' . esc_attr( wc_esc_json( epofw_all_fields_attr( $args ) ) ) . '"';
	}
	?>
	>
	<?php
}

add_action( 'epofw_field_input_start_td', 'epofw_field_input_start_td_callback', 10, 1 );

/**
 * Function will display start td html.
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
 */
function epofw_field_input_end_td_callback( $args ) {
	/**
	 * Filter for end input tag.
	 *
	 * @since 1.0.0
	 */
	$tag = apply_filters( 'epofw_field_input_end_tag_display', epofw_get_tag_based_on_structure( 'td' ), $args );
	?>
	</<?php echo esc_html( $tag ); ?>>
	<?php
}

add_action( 'epofw_field_input_end_td', 'epofw_field_input_end_td_callback', 10, 1 );

/**
 * Function will modify input id in shop page because should be unique in shop page.
 *
 * @since 2.5
 *
 * @param string $attr_value Old input id value.
 *
 * @return string
 */
function epofw_modifiy_field_id_property_callback( $attr_value ) {
	return $attr_value;
}

add_action( 'epofw_field_property_text_id', 'epofw_modifiy_field_id_property_callback', 10, 1 );
add_action( 'epofw_field_property_password_id', 'epofw_modifiy_field_id_property_callback', 10, 1 );
add_action( 'epofw_field_property_hidden_id', 'epofw_modifiy_field_id_property_callback', 10, 1 );
add_action( 'epofw_field_property_number_id', 'epofw_modifiy_field_id_property_callback', 10, 1 );
add_action( 'epofw_field_property_datepicker_id', 'epofw_modifiy_field_id_property_callback', 10, 1 );
add_action( 'epofw_field_property_colorpicker_id', 'epofw_modifiy_field_id_property_callback', 10, 1 );
add_action( 'epofw_field_property_timepicker_id', 'epofw_modifiy_field_id_property_callback', 10, 1 );
add_action( 'epofw_field_property_checkbox_id', 'epofw_modifiy_field_id_property_callback', 10, 1 );
add_action( 'epofw_field_property_checkboxgroup_id', 'epofw_modifiy_field_id_property_callback', 10, 1 );
add_action( 'epofw_field_property_radiogroup_id', 'epofw_modifiy_field_id_property_callback', 10, 1 );
add_action( 'epofw_field_property_textarea_id', 'epofw_modifiy_field_id_property_callback', 10, 1 );
add_action( 'epofw_field_property_select_id', 'epofw_modifiy_field_id_property_callback', 10, 1 );
add_action( 'epofw_field_property_multiselect_id', 'epofw_modifiy_field_id_property_callback', 10, 1 );

/**
 * Function will modify input name in shop page because should be unique in shop page.
 *
 * @since 2.5
 *
 * @param string $attr_value Old input name value.
 *
 * @return string
 */
function epofw_modifiy_field_name_property_callback( $attr_value ) {
	return $attr_value;
}

add_action( 'epofw_field_property_checkbox_name', 'epofw_modifiy_field_name_property_callback', 10, 1 );
add_action( 'epofw_field_property_checkboxgroup_name', 'epofw_modifiy_field_name_property_callback', 10, 1 );
add_action( 'epofw_field_property_radiogroup_name', 'epofw_modifiy_field_name_property_callback', 10, 1 );

/**
 * Function will print start of tr.
 *
 * @since 2.5
 *
 * @param array $args Array of args.
 */
function epofw_html_start_tr_display_callback( $args ) {
	$fields_data                = isset( $args['fields_data'] ) ? $args['fields_data'] : array();
	$fields_key                 = isset( $args['fields_key'] ) ? $args['fields_key'] : '';
	$check_field_title_position = epofw_get_field_label_title_position( $fields_data );
	$check_field_inp_type       = epofw_get_field_type( $fields_data );
	/**
	 * Filter for tr tag.
	 *
	 * @since 1.0.0
	 */
	$tag = apply_filters( 'epofw_html_start_tr_tag_display', epofw_get_tag_based_on_structure( 'tr' ), $args );
	/**
	 * Filter for tr class.
	 *
	 * @since 1.0.0
	 */
	$tr_class = apply_filters( 'epofw_html_tr_class_display', 'epofw_tr_se epofw_label_' . $check_field_title_position, $args );
	?>
	<<?php echo esc_html( $tag ); ?> class="<?php echo esc_attr( $tr_class ); ?>"  id="epofw_<?php echo esc_attr( $check_field_inp_type ); ?>_<?php echo esc_attr( $fields_key ); ?>">
	<?php
}

add_action( 'epofw_html_start_tr_display', 'epofw_html_start_tr_display_callback', 10, 1 );

/**
 * Function will print end of tr.
 *
 * @since 2.5
 *
 * @param array $args Array of args.
 */
function epofw_html_end_tr_display_callback( $args ) {
	/**
	 * Filter for end tr tag.
	 *
	 * @since 1.0.0
	 */
	$tag = apply_filters( 'epofw_html_end_tr_tag_display', epofw_get_tag_based_on_structure( 'tr' ), $args );
	?>
	</<?php echo esc_html( $tag ); ?>>
	<?php
}

add_action( 'epofw_html_end_tr_display', 'epofw_html_end_tr_display_callback', 10, 1 );

/**
 * Function will print start table and tbody.
 *
 * @since 2.5
 *
 * @param array  $fields_data_arr Fields data array.
 * @param object $product_data    Product data.
 */
function epofw_html_start_table_display_callback( $fields_data_arr, $product_data ) {
	$epofw_tbl_class = 'epofw_field_dl';
	$additional_data = epofw_data_attr_json();
	$fields_data_arr = epofw_check_array_key_exists( 'general', $fields_data_arr );
	$data_attr       = isset( $additional_data['data_attr'] ) ? $additional_data['data_attr'] : array();
	$condition_type  = isset( $additional_data['condition_type'] ) ? $additional_data['condition_type'] : '';
	/**
	 * Filter for start main tag.
	 *
	 * @since 1.0.0
	 */
	$main_tag = apply_filters( 'epofw_html_start_main_tag_display', epofw_get_tag_based_on_structure( 'table' ), $fields_data_arr );
	/**
	 * Filter for start child tag.
	 *
	 * @since 1.0.0
	 */
	$child_tag = apply_filters( 'epofw_html_start_child_tag_display', epofw_get_tag_based_on_structure( 'tbody' ), $fields_data_arr );
	/**
	 * Filter for main tag class.
	 *
	 * @since 1.0.0
	 */
	$main_tag_class = apply_filters( 'epofw_html_main_tag_class_display', 'epofw_fields_table ' . $epofw_tbl_class, $fields_data_arr );
	/**
	 * Filter for child tag class.
	 *
	 * @since 1.0.0
	 */
	$child_tag_class = apply_filters( 'epofw_html_child_tag_class_display', 'epofw_middle_tg', $fields_data_arr );
	?>
	<<?php echo esc_html( $main_tag ); ?> class="<?php echo esc_attr( $main_tag_class ); ?>"  data-prd-type="<?php echo esc_attr( $condition_type ); ?>" data-epofw_attr="<?php echo esc_attr( wc_esc_json( $data_attr ) ); ?>"> <<?php echo esc_html( $child_tag ); ?> class="<?php echo esc_attr( $child_tag_class ); ?>">
	<?php
}

add_action( 'epofw_html_start_table_display', 'epofw_html_start_table_display_callback', 10, 2 );

/**
 * Function will print end of table and tbody.
 *
 * @since 2.5
 */
function epofw_html_end_table_display_callback() {
	/**
	 * Filter for end main tag.
	 *
	 * @since 1.0.0
	 */
	$main_tag = apply_filters( 'epofw_html_end_main_tag_display', epofw_get_tag_based_on_structure( 'table' ) );
	/**
	 * Filter for end child tag.
	 *
	 * @since 1.0.0
	 */
	$child_tag = apply_filters( 'epofw_html_end_child_tag_display', epofw_get_tag_based_on_structure( 'tbody' ) );
	?>
	</<?php echo esc_html( $child_tag ); ?>>
	</<?php echo esc_html( $main_tag ); ?>>
	<?php
}

add_action( 'epofw_html_end_table_display', 'epofw_html_end_table_display_callback' );
