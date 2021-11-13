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
?>
<hr class="wp-header-end">
<div class="epofw_main_form_section">
	<div class="epofw_main_left_section">
		<table class="form-table epofw_section epofw_getting_started_info">
			<tbody>
			<tr>
				<td class="fr-2">
					<p class="epofw_gs aboutinfo">
						<strong><?php esc_html_e( 'Getting Started', 'extra-product-options-for-woocommerce' ); ?></strong>
					</p>
					<p class="epofw_gs info_text">
						<?php esc_html_e( 'Extra Product options are much easier, more flexible, and faster to use than variable products.
						Instead of generating thousands of variations, Enable customers to customize products with
						additional options such as text fields, checkboxes, radio buttons, dropdowns, and more. You can
						add extra product options to selected Products or selected Categories.', 'extra-product-options-for-woocommerce' ); ?></p>
					<p class="epofw_gs info_text">
						<strong><?php esc_html_e( 'Step 1:', 'extra-product-options-for-woocommerce' ); ?> </strong>
						<?php esc_html_e( 'You can add product option based on different field types.', 'extra-product-options-for-woocommerce' ); ?>
						<span class="aboutinfo">
							<img src="<?php echo esc_url( EPOFW_PLUGIN_URL . 'assets/images/admin_field_option.png' ) ?>">
						</span>
					</p>
					<p class="epofw_gs info_text">
						<strong><?php esc_html_e( 'Step 2:', 'extra-product-options-for-woocommerce' ); ?> </strong>
						<?php esc_html_e( 'Product page.', 'extra-product-options-for-woocommerce' ); ?>
						<span class="aboutinfo">
							<img src="<?php echo esc_url( EPOFW_PLUGIN_URL . 'assets/images/front_field_option.png' ) ?>">
						</span>
					</p>
					<p class="epofw_gs info_text">
						<strong><?php esc_html_e( 'Step 3:', 'extra-product-options-for-woocommerce' ); ?>
						</strong><?php esc_html_e( 'Cart Page', 'extra-product-options-for-woocommerce' ); ?>
						<span class="aboutinfo">
							<img src="<?php echo esc_url( EPOFW_PLUGIN_URL . 'assets/images/cart_field_option.png' ) ?>">
						</span>
					</p>
					<p class="epofw_gs info_text">
						<strong><?php esc_html_e( 'Step 4:', 'extra-product-options-for-woocommerce' ); ?> </strong>
						<?php esc_html_e( 'Order Detail Page (After Place Order)', 'extra-product-options-for-woocommerce' ); ?>
						<span class="aboutinfo">
							<img src="<?php echo esc_url( EPOFW_PLUGIN_URL . 'assets/images/order_detail_field_option.png' ) ?>">
						</span>
					</p>
					<p class="epofw_gs info_text">
						<strong><?php esc_html_e( 'Step 5:', 'extra-product-options-for-woocommerce' ); ?> </strong>
						<?php esc_html_e( 'Order Detail Page (Admin)', 'extra-product-options-for-woocommerce' ); ?>
						<span class="aboutinfo">
							<img src="<?php echo esc_url( EPOFW_PLUGIN_URL . 'assets/images/admin_order_detail.png' ) ?>">
						</span>
					</p>
				</td>
			</tr>
			</tbody>
		</table>
	</div>
</div>