<?php
/**
 * This template displaying addon items in shop/single product page.
 * This template can be overridden by copying it to yourtheme/eopfw-templates/epofw-addon-table-html.php
 * NOTE, on occasion Extra Product Options for WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @package Extra_Product_Options_For_WooCommerce/Templates
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;
global $product;
$product_id   = $product->get_id();
$product_data = wc_get_product( $product_id );
if ( ! empty( $product_data ) ) {
	$product_price = epofw_display_product_price( $product_data, '' );
}
$fields_data_arr         = isset( $args['fields_data_arr'] ) ? $args['fields_data_arr'] : '';
$epofw_action            = isset( $args['epofw_action'] ) ? $args['epofw_action'] : '';
$fields_general_data_arr = epofw_check_array_key_exists( 'general', $fields_data_arr );
$data_prd_attr           = '';
if ( 'epofw_shop' === $epofw_action ) {
	$data_prd_attr = 'data-prd-attr="' . esc_attr( $product_id ) . '"';
}
$data_unique_div_attr = 'data-uqd-attr="epofw_uqd_' . wp_rand() . '"';
if ( ! empty( $fields_general_data_arr ) ) {
	/**
	 * Start of table html.
	 *
	 * @since 2.5
	 */
	do_action( 'epofw_addon_table_html_start' );
	?>
	<div class="epofw_addon_html epofw_addon_str_table <?php echo esc_attr( $epofw_action ); ?>" <?php echo esc_attr( $data_prd_attr ); ?> <?php echo esc_attr( $data_unique_div_attr ); ?>>
		<?php
		/**
		 * Start of tbody and table.
		 *
		 * @since 2.5
		 */
		do_action( 'epofw_html_start_table_display', $fields_data_arr, $product_data );
		foreach ( $fields_general_data_arr as $fields_key => $fields_data ) {
			$epofwtwp_args = array(
				'product_data'    => $product_data,
				'product_price'   => $product_price,
				'opt_price'       => isset( $fields_data['epofw_field_settings']['enable_price_extra'] ) && 'on' === $fields_data['epofw_field_settings']['enable_price_extra'] && isset( $fields_data['epofw_field_settings']['addon_price'] ) ? $fields_data['epofw_field_settings']['addon_price'] : 0,
				'opt_price_type'  => isset( $fields_data['epofw_field_settings']['enable_price_extra'] ) && 'on' === $fields_data['epofw_field_settings']['enable_price_extra'] && isset( $fields_data['epofw_field_settings']['addon_price_type'] ) ? $fields_data['epofw_field_settings']['addon_price_type'] : 'fixed',
				'epofw_action'    => $epofw_action,
				'fields_data'     => $fields_data,
				'fields_key'      => $fields_key,
				'fields_data_arr' => $fields_general_data_arr,
			);
			/**
			 * Start of tr.
			 *
			 * @since 2.5
			 */
			do_action( 'epofw_html_start_tr_display', $epofwtwp_args );
			/**
			 * Before label html call.
			 *
			 * @since 2.5
			 *
			 * @param array    $epofwtwp_args  {
			 *                                 The array of data.
			 *
			 * @type object    $product_data   Data of the current product.
			 * @type int|float $product_price  Product price.
			 * @type string    $opt_price_type Price type - Fixed, Percentage of product price or etc.
			 * @type string    $epofw_action   Page action - shop|product page.
			 * @type array     $fields_data    Array of addon data.
			 *                                 }
			 */
			do_action( 'epofw_before_html_table_field_label_td', $epofwtwp_args );
			/**
			 * Field label html call.
			 *
			 * @since 2.5
			 *
			 * @param array    $epofwtwp_args  {
			 *                                 The array of data.
			 *
			 * @type object    $product_data   Data of the current product.
			 * @type int|float $product_price  Product price.
			 * @type string    $opt_price_type Price type - Fixed, Percentage of product price or etc.
			 * @type string    $epofw_action   Page action - shop|product page.
			 * @type array     $fields_data    Array of addon data.
			 *                                 }
			 */
			do_action( 'epofw_html_table_field_label_td', $epofwtwp_args );
			/**
			 * Field input html call.
			 *
			 * @since 2.5
			 *
			 * @param array    $epofwtwp_args  {
			 *                                 The array of data.
			 *
			 * @type object    $product_data   Data of the current product.
			 * @type int|float $product_price  Product price.
			 * @type string    $opt_price_type Price type - Fixed, Percentage of product price or etc.
			 * @type string    $epofw_action   Page action - shop|product page.
			 * @type array     $fields_data    Array of addon data.
			 *                                 }
			 */
			do_action( 'epofw_html_table_field_input_td', $epofwtwp_args );
			/**
			 * After label html call.
			 *
			 * @since 2.5
			 *
			 * @param array    $epofwtwp_args  {
			 *                                 The array of data.
			 *
			 * @type object    $product_data   Data of the current product.
			 * @type int|float $product_price  Product price.
			 * @type string    $opt_price_type Price type - Fixed, Percentage of product price or etc.
			 * @type string    $epofw_action   Page action - shop|product page.
			 * @type array     $fields_data    Array of addon data.
			 *                                 }
			 */
			do_action( 'epofw_after_html_table_field_label_td', $epofwtwp_args );
			/**
			 * End of tr.
			 *
			 * @since 2.5
			 */
			do_action( 'epofw_html_end_tr_display', $epofwtwp_args );
		}
		/**
		 * End of tbody and table.
		 *
		 * @since 2.5
		 */
		do_action( 'epofw_html_end_table_display' );

		/**
		 * Add nonce field for addon field data.
		 */
		$nonce_action = 'epfow_addon_field_nonce_' . absint( $product_id );
		wp_nonce_field( $nonce_action );
		?>
	</div>
	<?php
	/**
	 * End of table.
	 *
	 * @since 2.5
	 */
	do_action( 'epofw_addon_table_html_end' );
}