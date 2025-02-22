<?php
/**
 * Handle field imports.
 *
 * @package    Extra_Product_Options_For_WooCommerce
 * @subpackage Extra_Product_Options_For_WooCommerce/includes
 * @since      3.0.9
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class EPOFW_Import {

	/**
	 * Initialize the import functionality
	 */
	public static function init() {
		add_action( 'admin_post_epofw_import_all_fields', array( __CLASS__, 'import_all_fields' ) );
	}

	/**
	 * Handle importing all predefined fields
	 */
	public static function import_all_fields() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'extra-product-options-for-woocommerce' ) );
		}

		check_admin_referer( 'epofw_import_fields_nonce' );

		// Predefined fields array with complete field data structure.
		$fields = array(
			array(
				'epofw_addon_name' => 'Complete Field Collection',
				'epofw_addon_status' => 'on',
				'epofw_addon_position' => 'before_add_to_cart',
				'additional_rule_data' => array(
					'1687668893' => array(
						'condition' => 'product',
						'operator' => 'is_equal_to',
						'value' => array(
							'0' => '1216'
						)
					)
				),
				'general' => array(
					// Text field
					wp_rand() => array(
						'field_status' => 'on',
						'field' => array(
							'type' => 'text',
							'value' => '',
							'placeholder' => 'Enter custom text',
							'name' => 'epofw_field_' . wp_rand(),
							'id' => 'epofw_field_' . wp_rand(),
							'class' => 'epofw_field_' . wp_rand()
						),
						'label' => array(
							'title' => 'Custom Text Input',
							'class' => 'epofw_label_' . wp_rand(),
							'subtitle' => '',
							'subtitle_class' => ''
						),
						'epofw_field_settings' => array(
							'field_restriction' => 'all',
							'enable_price_extra' => 'on',
							'addon_price_type' => 'fixed',
							'addon_price' => '10'
						)
					),

					// Password field
					wp_rand() => array(
						'field_status' => 'on',
						'field' => array(
							'type' => 'password',
							'value' => '',
							'placeholder' => 'Enter password',
							'name' => 'epofw_field_' . wp_rand(),
							'id' => 'epofw_field_' . wp_rand(),
							'class' => 'epofw_field_' . wp_rand()
						),
						'label' => array(
							'title' => 'Secure Password Field',
							'class' => 'epofw_label_' . wp_rand(),
							'subtitle' => '',
							'subtitle_class' => ''
						),
						'epofw_field_settings' => array(
							'enable_price_extra' => 'on',
							'addon_price_type' => 'fixed',
							'addon_price' => '2'
						)
					),

					// Textarea field
					wp_rand() => array(
						'field_status' => 'on',
						'field' => array(
							'type' => 'textarea',
							'value' => '',
							'placeholder' => 'Enter your message',
							'name' => 'epofw_field_' . wp_rand(),
							'id' => 'epofw_field_' . wp_rand(),
							'class' => 'epofw_field_' . wp_rand(),
							'cols' => '30',
							'rows' => '5'
						),
						'label' => array(
							'title' => 'Message Box',
							'class' => 'epofw_label_' . wp_rand(),
							'subtitle' => '',
							'subtitle_class' => ''
						),
						'epofw_field_settings' => array(
							'enable_price_extra' => 'on',
							'addon_price_type' => 'fixed',
							'addon_price' => '15'
						)
					),

					// Number field
					wp_rand() => array(
						'field_status' => 'on',
						'field' => array(
							'type' => 'number',
							'value' => '',
							'name' => 'epofw_field_' . wp_rand(),
							'id' => 'epofw_field_' . wp_rand(),
							'class' => 'epofw_field_' . wp_rand(),
							'min' => '1',
							'max' => '10',
							'step' => '1'
						),
						'label' => array(
							'title' => 'Quantity Selector',
							'class' => 'epofw_label_' . wp_rand(),
							'subtitle' => '',
							'subtitle_class' => ''
						),
						'epofw_field_settings' => array(
							'enable_price_extra' => 'on',
							'addon_price_type' => 'fixed',
							'addon_price' => '10'
						)
					),

					// Select field
					wp_rand() => array(
						'field_status' => 'on',
						'field' => array(
							'type' => 'select',
							'name' => 'epofw_field_' . wp_rand(),
							'id' => 'epofw_field_' . wp_rand(),
							'class' => 'epofw_field_' . wp_rand()
						),
						'label' => array(
							'title' => 'Package Selection',
							'class' => 'epofw_label_' . wp_rand(),
							'subtitle' => '',
							'subtitle_class' => ''
						),
						'epofw_field_settings' => array(
							'options' => array(
								'Basic Package' => 'Basic Package||fixed||10',
								'Premium Package' => 'Premium Package||fixed||20',
								'Ultimate Package' => 'Ultimate Package||fixed||30'
							)
						)
					),

					// Multiselect field
					wp_rand() => array(
						'field_status' => 'on',
						'field' => array(
							'type' => 'multiselect',
							'name' => 'epofw_field_' . wp_rand(),
							'id' => 'epofw_field_' . wp_rand(),
							'class' => 'epofw_field_' . wp_rand()
						),
						'label' => array(
							'title' => 'Additional Features',
							'class' => 'epofw_label_' . wp_rand(),
							'subtitle' => '',
							'subtitle_class' => ''
						),
						'epofw_field_settings' => array(
							'options' => array(
								'Extended Warranty' => 'Extended Warranty||fixed||10',
								'Priority Support' => 'Priority Support||fixed||20',
								'Premium Delivery' => 'Premium Delivery||fixed||15'
							)
						)
					),

					// Checkbox field
					wp_rand() => array(
						'field_status' => 'on',
						'field' => array(
							'type' => 'checkbox',
							'name' => 'epofw_field_' . wp_rand(),
							'id' => 'epofw_field_' . wp_rand(),
							'class' => 'epofw_field_' . wp_rand()
						),
						'label' => array(
							'title' => 'Optional Add-ons',
							'class' => 'epofw_label_' . wp_rand(),
							'subtitle' => '',
							'subtitle_class' => ''
						),
						'epofw_field_settings' => array(
							'options' => array(
								'Gift Wrapping' => 'Gift Wrapping||fixed||5',
								'Insurance' => 'Insurance||fixed||10',
								'Express Processing' => 'Express Processing||fixed||15',
								'VIP Service' => 'VIP Service||fixed||20'
							)
						)
					),

					// Checkbox group
					wp_rand() => array(
						'field_status' => 'on',
						'field' => array(
							'type' => 'checkboxgroup',
							'name' => 'epofw_field_' . wp_rand(),
							'id' => 'epofw_field_' . wp_rand(),
							'class' => 'epofw_field_' . wp_rand()
						),
						'label' => array(
							'title' => 'Additional Services',
							'class' => 'epofw_label_' . wp_rand(),
							'subtitle' => '',
							'subtitle_class' => ''
						),
						'epofw_field_settings' => array(
							'options' => array(
								'Installation' => 'Installation||fixed||25',
								'Training' => 'Training||fixed||30',
								'Maintenance' => 'Maintenance||fixed||35'
							)
						)
					),

					// Radio group
					wp_rand() => array(
						'field_status' => 'on',
						'field' => array(
							'type' => 'radiogroup',
							'name' => 'epofw_field_' . wp_rand(),
							'id' => 'epofw_field_' . wp_rand(),
							'class' => 'epofw_field_' . wp_rand()
						),
						'label' => array(
							'title' => 'Warranty Options',
							'class' => 'epofw_label_' . wp_rand(),
							'subtitle' => '',
							'subtitle_class' => ''
						),
						'epofw_field_settings' => array(
							'options' => array(
								'Standard Warranty' => 'Standard Warranty||fixed||10',
								'Extended Warranty' => 'Extended Warranty||fixed||50'
							)
						)
					),

					// Datepicker
					wp_rand() => array(
						'field_status' => 'on',
						'field' => array(
							'type' => 'datepicker',
							'value' => '',
							'placeholder' => '',
							'name' => 'epofw_field_' . wp_rand(),
							'id' => 'epofw_field_' . wp_rand(),
							'class' => 'epofw_field_' . wp_rand()
						),
						'label' => array(
							'title' => 'Preferred Delivery Date',
							'class' => 'epofw_label_' . wp_rand(),
							'subtitle' => '',
							'subtitle_class' => ''
						),
						'epofw_field_settings' => array(
							'enable_price_extra' => 'on',
							'addon_price_type' => 'fixed',
							'addon_price' => '23.23'
						)
					),

					// Timepicker
					wp_rand() => array(
						'field_status' => 'on',
						'field' => array(
							'type' => 'timepicker',
							'value' => '',
							'placeholder' => '',
							'name' => 'epofw_field_' . wp_rand(),
							'id' => 'epofw_field_' . wp_rand(),
							'class' => 'epofw_field_' . wp_rand()
						),
						'label' => array(
							'title' => 'Preferred Delivery Time',
							'class' => 'epofw_label_' . wp_rand(),
							'subtitle' => '',
							'subtitle_class' => ''
						),
						'epofw_field_settings' => array(
							'enable_price_extra' => 'on',
							'addon_price_type' => 'fixed',
							'addon_price' => '12.22'
						)
					),

					// Colorpicker
					wp_rand() => array(
						'field_status' => 'on',
						'field' => array(
							'type' => 'colorpicker',
							'value' => '',
							'name' => 'epofw_field_' . wp_rand(),
							'id' => 'epofw_field_' . wp_rand(),
							'class' => 'epofw_field_' . wp_rand()
						),
						'label' => array(
							'title' => 'Custom Color Selection',
							'class' => 'epofw_label_' . wp_rand(),
							'subtitle' => '',
							'subtitle_class' => ''
						),
						'epofw_field_settings' => array(
							'enable_price_extra' => 'on',
							'addon_price_type' => 'fixed',
							'addon_price' => '99.99'
						)
					),

					// Hidden field
					wp_rand() => array(
						'field_status' => 'on',
						'field' => array(
							'type' => 'hidden',
							'value' => '',
							'name' => 'epofw_field_' . wp_rand(),
							'id' => 'epofw_field_' . wp_rand()
						),
						'label' => array(
							'title' => 'Hidden Field',
							'class' => 'epofw_label_' . wp_rand(),
							'subtitle' => '',
							'subtitle_class' => ''
						)
					),

					// Heading
					wp_rand() => array(
						'field_status' => 'on',
						'field' => array(
							'type' => 'heading',
							'id' => 'epofw_field_' . wp_rand(),
							'class' => 'epofw_field_' . wp_rand(),
							'heading_type' => 'label'
						),
						'label' => array(
							'title' => 'Product Customization Options',
							'class' => 'epofw_label_' . wp_rand()
						)
					),

					// Paragraph
					wp_rand() => array(
						'field_status' => 'on',
						'field' => array(
							'type' => 'paragraph',
							'id' => 'epofw_field_' . wp_rand(),
							'class' => 'epofw_field_' . wp_rand(),
							'content' => 'Please select your preferred options from the choices below.',
							'content_type' => 'p'
						),
						'label' => array(
							'title' => 'Instructions',
							'class' => 'epofw_label_' . wp_rand()
						)
					)
				)
			)
		);

		foreach ( $fields as $field_group ) {
			$post_data = array(
				'post_title'  => $field_group['epofw_addon_name'],
				'post_status' => 'publish',
				'post_type'   => EPOFW_DFT_POST_TYPE,
			);

			$post_id = wp_insert_post( $post_data );

			if ( $post_id ) {
				update_post_meta( $post_id, 'epofw_prd_opt_data', $field_group );
				update_post_meta( $post_id, 'epofw_mgr_status', true );
			}
		}

		wp_safe_redirect(
			add_query_arg(
				array(
					'page'    => 'epofw-main',
					'tab'     => 'field-section',
					'message' => 'imported',
				),
				admin_url( 'edit.php?post_type=product' )
			)
		);
		exit;
	}
}

EPOFW_Import::init();

$import_url = wp_nonce_url(
	admin_url('admin-post.php?action=epofw_import_all_fields'),
	'epofw_import_fields_nonce'
);
