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
$epofw_gs = filter_input( INPUT_POST, 'epofw_gs', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
$epofw_gs = isset( $epofw_gs ) ? sanitize_text_field( wp_unslash( $epofw_gs ) ) : '';
if ( ! empty( $epofw_gs ) ) {
	$epofw_general_save_method_nonce = filter_input( INPUT_POST, 'epofw_general_save_method_nonce', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
	if ( empty( $epofw_general_save_method_nonce ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $epofw_general_save_method_nonce ) ), 'epofw_general_save_method' ) ) {
		esc_html_e( 'Error with security check.', 'extra-product-options-for-woocommerce' );

		return false;
	}
	$epofw_general_data = filter_input( INPUT_POST, 'epofw_general_data', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY );

	if ( ! empty( $epofw_general_data ) ) {
		$sanitized_general_data = array_map( 'sanitize_text_field', $epofw_general_data );
		update_option( 'epofw_general_data', $sanitized_general_data );
	}
}
$epofw_addon_details_title          = epofw_get_addon_details_title( 'epofw_addon_details_title' );
$epofw_addon_details_subtotal_title = epofw_get_addon_subtitle_title( 'epofw_addon_details_subtotal_title' );
?>
	<h1 class="wp-heading-inline"><?php echo esc_html__( 'General Settings', 'extra-product-options-for-woocommerce' ); ?></h1>
	<hr class="wp-header-end">
	<div class="epofw_main_form_section">
		<div class="epofw_main_left_section">
			<div class="form-table epofw_section epofw_field_info">
				<div>
					<div>
						<div class="cop_ft_field_section form-table epofw_section epofw_field_info">
							<div class="cop_ft_general_field_div">
								<?php
								/**
								 * Fire action before addon details title.
								 *
								 * @since 1.0.0
								 */
								do_action( 'epofw_before_addon_details_title' );
								?>
								<div class="cop_ft_class cop_ft_main_field">
									<div scope="row1"
										class="col-251">
										<div scope="row"
											class="col-25">
											<label><?php echo esc_html__( 'Addon Details Title', 'extra-product-options-for-woocommerce' ); ?></label>
											<?php
											echo wp_kses_post(
												wc_help_tip(
													esc_html__( 'You can change Addon details title.', 'extra-product-options-for-woocommerce' )
												)
											);
											?>
										</div>
									</div>
									<div class="forminp">
										<div class="forminp1">
											<input type="text"
												name="epofw_general_data[epofw_addon_details_title]"
												id="epofw_addon_details_title"
												value="<?php echo esc_attr( $epofw_addon_details_title ); ?>">
										</div>
									</div>
								</div>
								<div class="cop_ft_class cop_ft_main_field">
									<div scope="row1"
										class="col-251">
										<div scope="row"
											class="col-25">
											<label><?php echo esc_html__( 'Subtotal Title', 'extra-product-options-for-woocommerce' ); ?></label>
											<?php
											echo wp_kses_post(
												wc_help_tip(
													esc_html__( 'You can change Subtotal title.', 'extra-product-options-for-woocommerce' )
												)
											);
											?>
										</div>
									</div>
									<div class="forminp">
										<div class="forminp1">
											<input type="text"
												name="epofw_general_data[epofw_addon_details_subtotal_title]"
												id="epofw_addon_details_subtotal_title"
												value="<?php echo esc_attr( $epofw_addon_details_subtotal_title ); ?>">
										</div>
									</div>
								</div>
								<?php
								/**
								 * Fire action after addon details title.
								 *
								 * @since 1.0.0
								 */
								do_action( 'epofw_after_addon_details_title' );
								?>
							</div>
						</div>
					</div>
				</div>
			</div>

			<p class="submit">
				<input type="submit"
					class="button button-primary"
					name="epofw_gs"
					value="<?php esc_attr_e( 'Save Changes', 'extra-product-options-for-woocommerce' ); ?>">
			</p>
		</div>
	</div>
<?php
wp_nonce_field( 'epofw_general_save_method', 'epofw_general_save_method_nonce' );
