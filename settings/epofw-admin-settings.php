<?php
/**
 * If this file is called directly, abort.
 *
 * @package    Extra_Product_Options_For_WooCommerce
 * @subpackage Extra_Product_Options_For_WooCommerce/settings
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$get_action  = filter_input( INPUT_GET, 'action', FILTER_SANITIZE_STRING );
$get_data    = '';
$field_type  = '';
$get_post_id = '';
if ( 'edit' === $get_action ) {
	$get_post_id = filter_input( INPUT_GET, 'post', FILTER_SANITIZE_STRING );
	$get_data    = epofw_get_data_from_db( $get_post_id );
}
$epofw_field                = epofw_field_act_arr_fn();
$check_general_data         = epofw_check_array_key_exists( 'general', $get_data );
$check_epofw_addon_status   = epofw_check_array_key_exists( 'epofw_addon_status', $get_data );
$check_epofw_addon_name     = epofw_check_array_key_exists( 'epofw_addon_name', $get_data );
$check_epofw_addon_position = epofw_check_array_key_exists( 'epofw_addon_position', $get_data );
?>
	<h1 class="wp-heading-inline"><?php echo esc_html( 'Add Product Addon', 'extra-product-options-for-woocommerce' ); ?></h1>
	<hr class="wp-header-end">
	<div class="epofw_main_form_section">
		<div class="epofw_main_left_section">
			<table class="form-table epofw_section epofw_field_info">
				<tbody>
				<tr>
					<td>
						<div class="cop_ft_field_section form-table epofw_section epofw_field_info">
							<div class="cop_ft_general_field_div">
								<div class="cop_ft_class cop_ft_main_field">
									<div scope="row1" class="col-251">
										<div scope="row" class="col-25">
											<label><?php esc_html_e( 'Status', 'extra-product-options-for-woocommerce' ); ?></label>
										</div>
									</div>
									<div class="forminp">
										<div class="forminp1">
											<input type="checkbox" name="epofw_data[epofw_addon_status]" id="epofw_addon_status_id" value="on" <?php checked( 'on', $check_epofw_addon_status ); ?>>
										</div>
									</div>
								</div>
								<div class="cop_ft_class cop_ft_main_field">
									<div scope="row1" class="col-251">
										<div scope="row" class="col-25 col-25-main-field">
											<label><?php esc_html_e( 'Name', 'extra-product-options-for-woocommerce' ); ?></label>
										</div>
									</div>
									<div class="forminp">
										<div class="forminp1">
											<input type="text" name="epofw_data[epofw_addon_name]" id="epofw_addon_id"
												value="<?php echo esc_attr( $check_epofw_addon_name ); ?>">
										</div>
									</div>
								</div>
								<?php
								do_action( 'epofw_additional_rules', $get_data );
								?>
								<div class="cop_ft_class cop_ft_main_field">
									<div scope="row1" class="col-251">
										<div scope="row" class="col-25 col-25-main-field">
											<label><?php esc_html_e( 'Display Position', 'extra-product-options-for-woocommerce' ); ?></label>
										</div>
									</div>
									<div class="forminp">
										<div class="forminp1">
											<select name="epofw_data[epofw_addon_position]" id="epofw_addon_position">
												<option value="before_add_to_cart" <?php selected( 'before_add_to_cart', $check_epofw_addon_position ) ?>><?php esc_html_e( 'Before Add to Cart', 'extra-product-options-for-woocommerce' ); ?></option>
												<option value="after_add_to_cart" <?php selected( 'after_add_to_cart', $check_epofw_addon_position ) ?>><?php esc_html_e( 'After Add to Cart', 'extra-product-options-for-woocommerce' ); ?></option>
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="addon_fields_main_div">
								<div class="addon_fields_header">
									<h2><?php esc_html_e( 'Extra Product Fields', 'extra-product-options-for-woocommerce' ); ?></h2>
								</div>
								<div class="addon_sub_field_data_div">
									<div class="addon_fields_sub_div">
										<div class="heading_label">
											<div class="heading_nu_label_title">
												<strong><?php esc_html_e( 'No.', 'extra-product-options-for-woocommerce' ); ?></strong>
											</div>
											<div class="heading_label_title">
												<strong><?php esc_html_e( 'Field Name', 'extra-product-options-for-woocommerce' ); ?></strong>
											</div>
											<div class="heading_label_title">
												<strong><?php esc_html_e( 'Field Type', 'extra-product-options-for-woocommerce' ); ?></strong>
											</div>
											<div class="heading_label_title">
												<strong><?php esc_html_e( 'Field Status', 'extra-product-options-for-woocommerce' ); ?></strong>
											</div>
											<div class="heading_label_title">
												<strong><?php esc_html_e( 'Field Required', 'extra-product-options-for-woocommerce' ); ?></strong>
											</div>
											<div class="heading_label_title">
												<strong><?php esc_html_e( 'Action', 'extra-product-options-for-woocommerce' ); ?></strong>
											</div>
										</div>
										<div class="addon_fields_accordian_data">
											<?php
											if ( $check_general_data ) {
												$i = 0;
												foreach ( $get_data['general'] as $gn_key => $gn_data ) {
													if ( ! empty( $gn_data ) ) {
														$i ++;
														$field_type     = epofw_check_general_field_data( $get_data, '', 'type', $gn_key );
														$field_title    = epofw_check_general_field_data( $get_data, 'label', 'title', $gn_key );
														$field_required = epofw_check_general_field_data( $get_data, 'field', 'required', $gn_key );
														$field_status   = epofw_check_general_field_data( $get_data, '', 'status', $gn_key );
														if ( 'on' === $field_required ) {
															$field_required = esc_html__( 'True', 'extra-product-options-for-woocommerce' );
														} else {
															$field_required = esc_html__( 'False', 'extra-product-options-for-woocommerce' );
														}
														if ( 'on' === $field_status ) {
															$field_status = esc_html__( 'Enable', 'extra-product-options-for-woocommerce' );
														} else {
															$field_status = esc_html__( 'Disable', 'extra-product-options-for-woocommerce' );
														}
														?>
														<div id="accordion_<?php echo esc_attr( $gn_key ); ?>" class="accordion_cls">
															<div class="accordion_cls_title">
																<div class="heading_nu_title">
																	<span><?php echo esc_html( $i ); ?></span>
																</div>
																<a href="javascript:void(0)" class="accordion_a_cls heading_title" id="<?php echo esc_attr( $gn_key ); ?>">
																	<span><?php echo esc_html( $field_title ); ?></span>
																</a>
																<div class="heading_title">
																	<span><?php echo esc_html( $field_type ); ?></span>
																</div>
																<div class="heading_title">
																	<span><?php echo esc_html( $field_status ); ?></span>
																</div>
																<div class="heading_title">
																	<span><?php echo esc_html( $field_required ); ?></span>
																</div>
																<a href="javascript:void(0)" class="accordion_a_cls_remove heading_title">
																	<span class="dashicons dashicons-trash"></span>
																</a>
															</div>
															<div class="accordion_ct_div postbox" id="poststuff">
																<div class="addon_fields" id="addon_fields_<?php echo esc_attr( $gn_key ); ?>">
																	<div class="addon_field" id="addon_field_<?php echo esc_attr( $gn_key ); ?>" data-id="<?php echo esc_attr( $gn_key ); ?>">
																		<?php
																		do_action( 'epofw_field_status', $get_data, $get_post_id, 'status', 'checkbox', $gn_key );
																		do_action( 'epofw_field_type', $get_data, $get_post_id, 'type', 'select', $gn_key );
																		?>
																		<?php
																		if ( ! empty( $get_data ) ) {
																			epofw_loop_fields_data( $epofw_field[ $field_type ], $get_data, $get_post_id, $gn_key );
																		} else {
																			epofw_loop_fields_data( $epofw_field['text'], $get_data, $get_post_id, $gn_key );
																		}
																		?>
																	</div>
																</div>
															</div>
														</div>
														<?php
													}
													?>
													<?php
												}
											} else {
												?>
												<div id="accordion_1" class="accordion_cls">
													<div class="accordion_cls_title">
														<div class="heading_nu_title">
															<span>1</span>
														</div>
														<a href="javascript:void(0)" class="accordion_a_cls heading_title" id="1">
															<span><?php echo esc_html( 'Field 1', 'extra-product-options-for-woocommerce' ); ?></span>
														</a>
														<div class="heading_title">
															<span><?php echo esc_html( 'text', 'extra-product-options-for-woocommerce' ); ?></span>
														</div>
														<div class="heading_title">
															<span><?php echo esc_html( 'Disable', 'extra-product-options-for-woocommerce' ); ?></span>
														</div>
														<div class="heading_title">
															<span><?php echo esc_html( 'False', 'extra-product-options-for-woocommerce' ); ?></span>
														</div>
														<a href="javascript:void(0)" class="accordion_a_cls_remove heading_title">
															<span class="dashicons dashicons-trash"></span>
														</a>
													</div>
													<div class="accordion_ct_div postbox" id="poststuff">
														<div class="addon_fields" id="addon_fields_1">
															<div class="addon_field" id="addon_field_1" data-id="1">
																<?php
																do_action( 'epofw_field_status', $get_data, $get_post_id, 'status', 'checkbox', '1' );
																do_action( 'epofw_field_type', $get_data, $get_post_id, 'type', 'select', '1' );
																?>
																<?php
																if ( ! empty( $get_data ) ) {
																	epofw_loop_fields_data( $epofw_field[ $field_type ], $get_data, $get_post_id, '1' );
																} else {
																	epofw_loop_fields_data( $epofw_field['text'], $get_data, $get_post_id, '1' );
																}
																?>
															</div>
														</div>
													</div>
												</div>
												<?php
											}
											?>
										</div>
									</div>
									<div class="add_new_field">
										<button type="button" class="button add_field_id">
											<?php esc_html_e( 'Add Field', 'extra-product-options-for-woocommerce' ); ?>
										</button>
									</div>
								</div>
							</div>
						</div>
					</td>
				</tr>
				</tbody>
			</table>

			<p class="submit">
				<input type="submit" class="button button-primary" name="epofw_save" value="<?php esc_html_e( 'Save Changes', 'extra-product-options-for-woocommerce' ); ?>">
			</p>
		</div>
	</div>
<?php
wp_nonce_field( 'woocommerce_save_method', 'woocommerce_save_method_nonce' );
