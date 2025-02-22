<?php
/**
 * Migration section.
 *
 * @package    Extra_Product_Options_For_WooCommerce
 * @subpackage Extra_Product_Options_For_WooCommerce/includes
 */

if ( ! class_exists( 'WC_Background_Process', false ) ) {
	include_once WP_PLUGIN_DIR . '/woocommerce/includes/abstracts/class-wc-background-process.php';
}

/**
 * EPOFW_Bg_Process class.
 */
class EPOFW_Bg_Process extends WC_Background_Process {

	/**
	 * Action.
	 *
	 * @var string
	 */
	protected $action = 'epofw_bg_process';

	/**
	 * Task
	 * Override this method to perform any actions required on each
	 * queue item. Return the modified item for further processing
	 * in the next pass through. Or, return false to remove the
	 * item from the queue.
	 *
	 * @param array $old_data Old data.
	 *
	 * @return mixed
	 */
	protected function task( $old_data ) {
		// Actions to perform.
		foreach ( $old_data as $f_id ) {
			if ( ! get_post_meta( $f_id, 'migration_complete', true ) ) {
				$epofw_data = epofw_get_data_from_db( $f_id );
				if ( ! empty( $epofw_data ) ) {
					$new_epofw_data = array();
					foreach ( $epofw_data as $epofw_key => $epofw_sub_data ) {
						if ( 'general' === $epofw_key ) {
							foreach ( $epofw_sub_data as $epofw_field_key => $epofw_field_value ) {
								foreach ( $epofw_field_value as $field_key => $field_value ) {
									if ( 'field' === $field_key ) {
										if ( is_array( $field_value ) ) {
											foreach ( $field_value as $key => $gn_value ) {
												if (
													'type' === $key ||
													'maxlength' === $key ||
													'value' === $key ||
													'placeholder' === $key ||
													'name' === $key ||
													'id' === $key ||
													'name' === $key ||
													'class' === $key ||
													'readonly' === $key ||
													'min' === $key ||
													'max' === $key ||
													'step' === $key ||
													'heading_type' === $key ||
													'heading_color' === $key ||
													'content' === $key ||
													'content_type' === $key ||
													'content_color' === $key ||
													'required' === $key
												) {
													if ( 'class' === $key ) {
														unset( $new_epofw_data['general'][ $epofw_field_key ][ $field_key ][ $key ] );
														$modified_class    = $gn_value;
														$field_restriction = epofw_check_array_key_exists( 'field_restriction', $field_value );
														if ( $field_restriction ) {
															$modified_class .= '||epofw_' . $field_restriction;
														}
														$new_epofw_data['general'][ $epofw_field_key ][ $field_key ][ $key ] = $modified_class;
													} elseif ( 'name' === $key ) {
														if ( empty( $gn_value ) ) {
															$new_epofw_data['general'][ $epofw_field_key ][ $field_key ][ $key ] = 'epofw_' . $field_key . '_' . wp_rand();
														} else {
															$new_epofw_data['general'][ $epofw_field_key ][ $field_key ][ $key ] = $gn_value;
														}
													} else {
														if ( ! is_array( $gn_value ) ) {
															$gn_value = sanitize_text_field( $gn_value );
														}
														$new_epofw_data['general'][ $epofw_field_key ][ $field_key ][ $key ] = $gn_value;
													}
												} elseif ( 'status' === $key ) {
													$new_epofw_data['general'][ $epofw_field_key ]['field_status'] = $gn_value;
												} else {
													if ( ! is_array( $gn_value ) ) {
														$gn_value = sanitize_text_field( $gn_value );
													}
													if ( 'options' === $key ) {
														if ( ! empty( $gn_value ) ) {
															$new_options_array = array();
															foreach ( $gn_value as $gn_value_key => $gn_value_v ) {
																$new_options_array[ $gn_value_key ] = $gn_value_key . '||' . $gn_value_v;
															}
														}
														$new_epofw_data['general'][ $epofw_field_key ]['epofw_field_settings'][ $key ] = $new_options_array;
													} else {
														$new_epofw_data['general'][ $epofw_field_key ]['epofw_field_settings'][ $key ] = $gn_value;
													}
												}
											}
										}
									} else {
										$new_epofw_data['general'][ $epofw_field_key ][ $field_key ] = $field_value;
									}
								}
							}
						} elseif ( 'additional_rule_data' === $epofw_key ) {
							$new_epofw_additional = array();
							foreach ( $epofw_data['additional_rule_data'] as $key => $epofw_ard_data ) {
								$epofw_ard_key                = wp_rand();
								$new_epofw_additional[ $key ] = $epofw_ard_data;
							}
							$new_epofw_data['additional_rule_data'][ $epofw_ard_key ] = $new_epofw_additional;
						} else {
							if ( 'epofw_addon_name' === $epofw_key ) {
								$post_title = $epofw_sub_data;
							} elseif ( 'epofw_addon_status' === $epofw_key ) {
								$epofw_shipping_status = $epofw_sub_data;
							}
							if ( isset( $epofw_shipping_status ) && 'on' === $epofw_shipping_status ) {
								$post_status = 'publish';
							} else {
								$post_status = 'draft';
							}
							wp_update_post(
								array(
									'ID'          => $f_id,
									'post_status' => $post_status,
								)
							);
							$new_epofw_data[ $epofw_key ] = $epofw_sub_data;
						}
					}
					update_post_meta( $f_id, 'epofw_prd_opt_data', $new_epofw_data );
					update_post_meta( $f_id, 'epofw_mgr_status', true );
					update_post_meta( $f_id, 'migration_complete', true );
					$get_epofw_migration_count = get_option( 'epofw_migration_count' );
					if ( $get_epofw_migration_count ) {
						$get_epofw_migration_count = ++$get_epofw_migration_count;
					} else {
						$get_epofw_migration_count = 1;
					}
					update_option( 'epofw_migration_count', $get_epofw_migration_count );
				}
			}
		}

		return false;
	}

	/**
	 * Is the updater running?
	 *
	 * @return boolean
	 */
	public function is_updating() {
		return false === $this->is_queue_empty();
	}

	/**
	 * Complete
	 * Override if applicable, but ensure that the below actions are
	 * performed, or, call parent::complete().
	 */
	protected function complete() {
		parent::complete();
		wc_print_notice( 'Background process complete' );
	}
}
