<?php
/**
 * This template displaying addon details for the selected addon item.
 *
 * This template can be overridden by copying it to yourtheme/eopfw-templates/epofw-addon-details.php
 *
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

global $product;
$product_id   = $product->get_id();
$product_data = wc_get_product( $product_id );
if ( ! empty( $product_data ) ) {
	$product_name  = $product_data->get_name();
	$product_price = epofw_display_product_price( $product_data, 'shop' );
}
$epofw_addon_details_title          = epofw_get_addon_details_title( 'epofw_addon_details_title' );
$epofw_addon_details_subtotal_title = epofw_get_addon_subtitle_title( 'epofw_addon_details_subtotal_title' );
/**
 * Below action fire before addon totals.
 *
 * @since 2.5
 */
do_action( 'before_epofw_addon_totals' );
?>
	<div class="epofw_addon_totals">
		<table id="addon_total"
			class="addon_total_tbl addon_total_hd">
			<tr id="addon_details">
				<td colspan="2">
					<strong><?php echo esc_html( $epofw_addon_details_title ); ?></strong>
				</td>
			</tr>
			<tr id="addon_prd_details">
				<td>
					<strong><?php echo wp_kses_post( $product_name ); ?></strong>
				</td>
				<td class="addon_price"
					data-addon-price="<?php echo esc_attr( $product_price ); ?>"
					data-epofw-prd-price="<?php echo esc_attr( $product_price ); ?>">
					<strong><?php echo wp_kses_post( wc_price( $product_price ) ); ?></strong>
				</td>
			</tr>
			<tr id="addon_subtotal">
				<td>
					<strong>
						<?php echo esc_html( $epofw_addon_details_subtotal_title ); ?>
					</strong>
				</td>
				<td>
					<strong></strong>
				</td>
			</tr>
		</table>
	</div>
<?php
/**
 * Below action fire after addon totals.
 *
 * @since 2.5
 */
do_action( 'after_epofw_addon_totals' );
