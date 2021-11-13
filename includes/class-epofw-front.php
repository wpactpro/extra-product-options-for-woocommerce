<?php
/**
 * Admin section.
 *
 * @package    Extra_Product_Options_For_WooCommerce
 * @subpackage Extra_Product_Options_For_WooCommerce/includes
 */
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * EPOFW_Admin class.
 */
if ( ! class_exists( 'EPOFW_Front' ) ) {
	/**
	 * EPOFW_Admin class.
	 */
	class EPOFW_Front {
		protected static $_instance = null;

		/**
		 * The name of this plugin.
		 *
		 * @var      string $plugin_name The ID of this plugin.
		 *
		 * @since    1.0.0
		 */
		public function __construct() {
			$this->epofw_front_init();
		}

		/**
		 * Define the plugins name and versions and also call admin section.
		 *
		 * @since    1.0.0
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * Add filter in which add some functionality.
		 *
		 * @since    1.0.0
		 */
		public function epofw_front_init() {
			add_action(
				'woocommerce_before_add_to_cart_button',
				array(
					$this,
					'epofw_before_add_to_cart_button',
				),
				10
			);
			add_action(
				'woocommerce_after_add_to_cart_button',
				array(
					$this,
					'epofw_after_add_to_cart_button',
				),
				10
			);
			add_filter( 'woocommerce_add_cart_item_data', array( $this, 'epofw_add_cart_item_data' ), 10, 3 );
			add_filter( 'woocommerce_get_item_data', array( $this, 'epofw_get_item_data' ), 99, 2 );
			add_action( 'woocommerce_add_order_item_meta', array( $this, 'epofw_add_order_item_meta' ), 99, 2 );
			add_filter(
				'woocommerce_order_again_cart_item_data',
				array(
					$this,
					'epofw_order_again_cart_item_data',
				),
				10,
				2
			);
			add_filter(
				'woocommerce_order_item_get_formatted_meta_data',
				array(
					$this,
					'epofw_item_get_formatted_meta_data',
				),
				10,
				2
			);
			add_action( 'wp_enqueue_scripts', array( $this, 'cop_front_enqueue_scripts_fn' ) );
			add_action( 'woocommerce_before_calculate_totals', array( $this, 'epofw_before_calculate_totals' ), 10, 1 );
			add_filter( 'woocommerce_add_to_cart_validation', array( $this, 'epofw_add_to_cart_validation' ), 10, 2 );
		}

		/**
		 * Enqueue some js and css at front side.
		 *
		 * @since    1.0.0
		 */
		public function cop_front_enqueue_scripts_fn() {
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-ui-datepicker', array( 'jquery' ) );
			wp_enqueue_script(
				'jquery-ui-timepicker-js',
				EPOFW_PLUGIN_URL . 'assets/js/jquery-ui-timepicker.js',
				array(
					'jquery',
				),
				'1.0',
				true
			);
			wp_enqueue_style(
				'jquery-ui-timepicker-css',
				EPOFW_PLUGIN_URL . 'assets/css/jquery-ui-timepicker.css',
				array(),
				'all'
			);
			wp_enqueue_style(
				'select2-css',
				EPOFW_PLUGIN_URL . 'assets/css/select2.min.css',
				array(),
				'all'
			);
			wp_enqueue_script(
				'select2-js',
				EPOFW_PLUGIN_URL . 'assets/js/select2.full.min.js',
				array(),
				'all'
			);
			wp_enqueue_script(
				'epofw-front-js',
				EPOFW_PLUGIN_URL . 'assets/js/epofw-front.js',
				'',
				EPOFW_PLUGIN_VERSION,
				false
			);
			wp_enqueue_style(
				'epofw-public-css',
				EPOFW_PLUGIN_URL . 'assets/css/epofw-public.css',
				'',
				EPOFW_PLUGIN_VERSION,
				false
			);
			wp_register_style( 'jquery-ui-css', EPOFW_PLUGIN_URL . 'assets/css/jquery-ui.min.css' );
			wp_enqueue_style( 'jquery-ui-css' );
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script(
				'iris',
				admin_url( 'js/iris.min.js' ),
				array(
					'jquery-ui-draggable',
					'jquery-ui-slider',
					'jquery-touch-punch',
					'wp-i18n',
				),
				false,
				1
			);
			wp_enqueue_script(
				'wp-color-picker',
				admin_url( 'js/color-picker.min.js' ),
				array( 'iris' ),
				false,
				1
			);
			$colorpicker_l10n = array(
				'clear'         => __( 'Clear' ),
				'defaultString' => __( 'Default' ),
				'pick'          => __( 'Select Color' ),
				'current'       => __( 'Current Color' ),
			);
			wp_localize_script(
				'wp-color-picker',
				'wpColorPickerL10n',
				$colorpicker_l10n
			);
			wp_localize_script(
				'epofw-front-js',
				'epofw_front_var',
				array(
					'currency'           => get_woocommerce_currency_symbol(),
					'position'           => get_option( 'woocommerce_currency_pos' ),
					'decimal_separator'  => wc_get_price_decimal_separator(),
					'thousand_separator' => wc_get_price_thousand_separator(),
					'decimals'           => wc_get_price_decimals(),
				)
			);
		}

		/**
		 * Get match data from DB.
		 *
		 * @param int $match_field_id Matching field id.
		 *
		 * @return array $get_data_arr. Return array with general data.
		 *
		 * @since    1.0.0
		 */
		public function epofw_get_match_data_from_db( $match_field_id ) {
			$product_option_args = array(
				'post_type'      => EPOFW_DFT_POST_TYPE,
				'post_status'    => 'publish',
				'posts_per_page' => - 1,
				'post__in'       => $match_field_id,
				'orderby'        => 'ID',
				'order'          => 'DESC',
				'fields'         => 'ids',
			);
			$prd_wp_query        = new WP_Query( $product_option_args );
			$main_get_data_arr   = array();
			$get_data_arr        = array();
			if ( $prd_wp_query->have_posts() ) {
				foreach ( $prd_wp_query->posts as $f_id ) {
					$get_data_json = get_post_meta( $f_id, 'epofw_prd_opt_data', true );
					$get_data      = json_decode( $get_data_json, true );
					if ( ! empty( $get_data ) ) {
						$get_data_arr['addon_position'] = epofw_check_array_key_exists( 'epofw_addon_position', $get_data );
						if ( array_key_exists( 'general', $get_data ) ) {
							$get_data_arr['general'] = $get_data['general'];
						}
						$main_get_data_arr[] = $get_data_arr;
					}
				}
			}

			return apply_filters( 'epofw_get_match_data_from_db', $main_get_data_arr );
		}

		/**
		 * Find match id based on product id..
		 *
		 * @param int $current_prd_id Current product id.
		 *
		 * @return array $matched_id_arr. Return array with matched id.
		 *
		 * @since    1.0.0
		 */
		public function epofw_find_match_id( $current_prd_id ) {
			$product_option_args = array(
				'post_type'      => EPOFW_DFT_POST_TYPE,
				'post_status'    => 'publish',
				'posts_per_page' => - 1,
				'orderby'        => 'ID',
				'order'          => 'DESC',
				'fields'         => 'ids',
			);
			$prd_wp_query        = new WP_Query( $product_option_args );
			$matched_id_arr      = array();
			if ( $prd_wp_query->have_posts() ) {
				foreach ( $prd_wp_query->posts as $f_id ) {
					$get_data_json = get_post_meta( $f_id, 'epofw_prd_opt_data', true );
					$get_data      = json_decode( $get_data_json, true );
					if ( ! empty( $get_data ) ) {
						$aadditional_rule_data          = epofw_check_array_key_exists( 'additional_rule_data', $get_data );
						$aadditional_rule_data['value'] = ( isset( $aadditional_rule_data['value'] ) && is_array( $aadditional_rule_data['value'] ) ) ? array_map( 'intval', $aadditional_rule_data['value'] ) : array();
						if ( $aadditional_rule_data ) {
							if ( 'product' === $aadditional_rule_data['condition'] ) {
								if ( 'is_equal_to' === $aadditional_rule_data['operator'] ) {
									if ( isset( $aadditional_rule_data['value'] ) && is_array( $aadditional_rule_data['value'] ) && in_array( $current_prd_id, $aadditional_rule_data['value'], true ) ) {
										$matched_id_arr[] = $f_id;
									}
								} else {
									if ( isset( $aadditional_rule_data['value'] ) && is_array( $aadditional_rule_data['value'] ) && ! in_array( $current_prd_id, $aadditional_rule_data['value'], true ) ) {
										$matched_id_arr[] = $f_id;
									}
								}
							} else {
								$cart_product_category = wp_get_post_terms( $current_prd_id, 'product_cat', array( 'fields' => 'ids' ) );
								if ( 'is_equal_to' === $aadditional_rule_data['operator'] ) {
									if ( ! empty( $cart_product_category ) ) {
										foreach ( $cart_product_category as $cat_id ) {
											if ( isset( $aadditional_rule_data['value'] ) && is_array( $aadditional_rule_data['value'] ) && in_array( $cat_id, $aadditional_rule_data['value'], true ) ) {
												$matched_id_arr[] = $f_id;
											}
										}
									}
								} else {
									if ( ! empty( $cart_product_category ) ) {
										foreach ( $cart_product_category as $cat_id ) {
											if ( isset( $aadditional_rule_data['value'] ) && is_array( $aadditional_rule_data['value'] ) && ! in_array( $cat_id, $aadditional_rule_data['value'], true ) ) {
												$matched_id_arr[] = $f_id;
											}
										}
									}
								}
							}
						}
					}
				}
			}

			return apply_filters( 'epofw_find_match_id', $matched_id_arr );
		}

		/**
		 * Get fields data which matched.
		 *
		 * @param int $current_prd_id Current product id.
		 *
		 * @return array $get_data. Return array with matched data.
		 *
		 * @since    1.0.0
		 */
		function epofw_get_fields_data( $current_prd_id ) {
			$get_match_field_id = $this->epofw_find_match_id( $current_prd_id );
			$get_data           = '';
			if ( ! empty( $get_match_field_id ) ) {
				$get_data = $this->epofw_get_match_data_from_db( $get_match_field_id );
			}

			return apply_filters( 'epofw_get_fields_data', $get_data );
		}

		/**
		 * Get html for single product page
		 */
		public function epofw_get_html_field( $fields_data_arr, $product_name, $product_price ) {
			$prd_html = '';
			$prd_html .= '<table class="epofw_fields_table">';
			$prd_html .= '<tbody>';
			foreach ( $fields_data_arr as $fields_data ) {
				$get_exftpoc        = $this->exclude_field_type_on_cart_page();
				$check_field_label  = epofw_check_array_key_exists( 'label', $fields_data );
				$check_field_input  = epofw_check_array_key_exists( 'field', $fields_data );
				$check_field_status = '';
				if ( $check_field_input ) {
					$check_field_status = epofw_check_array_key_exists( 'status', $check_field_input );
				}
				if ( 'on' === $check_field_status ) {
					$check_field_lbl_class          = '';
					$check_field_lbl_subtitle_class = '';
					$check_field_lbl_title          = '';
					$check_field_lbl_title_type     = 'label';
					$check_field_lbl_subtitle       = '';
					$check_field_lbl_subtitle_type  = 'label';
					$check_field_title_position     = 'left';
					if ( $check_field_label ) {
						$check_field_lbl_class                 = epofw_check_array_key_exists( 'class', $check_field_label );
						$check_field_lbl_title                 = epofw_check_array_key_exists( 'title', $check_field_label );
						$check_field_input['data-label-name']  = $check_field_lbl_title;
						$check_field_lbl_enable_subtitle_extra = epofw_check_array_key_exists( 'enable_subtitle_extra', $check_field_label );
						if ( $check_field_lbl_enable_subtitle_extra ) {
							$check_field_lbl_subtitle_class = epofw_check_array_key_exists( 'subtitle_class', $check_field_label );
							$check_field_lbl_subtitle       = epofw_check_array_key_exists( 'subtitle', $check_field_label );
						}
					}
					$check_field_inp_type     = '';
					$check_field_heading_type = '';
					$check_field_content_type = '';
					$check_field_content      = '';
					$price_label_for_text     = '';
					if ( $check_field_input ) {
						$check_field_inp_type     = epofw_check_array_key_exists( 'type', $check_field_input );
						$check_field_heading_type = epofw_check_array_key_exists( 'heading_type', $check_field_input );
						$check_field_content_type = epofw_check_array_key_exists( 'content_type', $check_field_input );
						$check_field_content      = epofw_check_array_key_exists( 'content', $check_field_input );
						$check_field_restriction  = epofw_check_array_key_exists( 'field_restriction', $check_field_input );
						if ( $check_field_restriction ) {
							unset( $check_field_input['field_restriction'] );
						}
						$check_field_input['data-inp-type'] = $check_field_inp_type;
						$check_field_enable_price           = epofw_check_array_key_exists( 'enable_price_extra', $check_field_input );
						$check_field_addon_price_type       = epofw_check_array_key_exists( 'addon_price_type', $check_field_input );
						$check_field_addon_price            = epofw_check_array_key_exists( 'addon_price', $check_field_input );
						if ( 'on' === $check_field_enable_price ) {
							$addon_price_cal                  = epofw_calculate_price_based_on_condition( $check_field_addon_price_type, $check_field_addon_price );
							$check_field_input['addon_price'] = $addon_price_cal;
							if ( 'fixed' === $check_field_addon_price_type ) {
								$price_label_for_text = epofw_title_with_price( '', $check_field_addon_price );
							}
						} else {
							$check_field_input['addon_price_type'] = 'fixed';
							$check_field_input['addon_price']      = 0.00;
						}
					}
					$prd_html .= '<tr class="epofw_tr_se" id="epofw_' . esc_attr( $check_field_inp_type ) . '_' . wp_rand() . '">';
					if ( 'left' === $check_field_title_position ) {
						if ( 'heading' === $check_field_inp_type || 'paragraph' === $check_field_inp_type ) {
							$prd_html .= '<td class="label epofw_td_label" colspan="2">';
						} else {
							$prd_html .= '<td class="label epofw_td_label">';
						}
						if ( 'heading' === $check_field_inp_type ) {
							$prd_html .= '<' . $check_field_heading_type . ' class="' . $check_field_lbl_class . '">' . $check_field_lbl_title . '</' . $check_field_heading_type . '>';
						} elseif ( 'paragraph' === $check_field_inp_type ) {
							$prd_html .= '<' . $check_field_content_type . ' class="' . $check_field_lbl_class . '">' . $check_field_content . '</' . $check_field_content_type . '>';
						} else {
							$prd_html .= '<' . $check_field_lbl_title_type . ' class="' . $check_field_lbl_class . '" data-label-name="' . $check_field_lbl_title . '">' . $check_field_lbl_title . $price_label_for_text . '</' . $check_field_lbl_title_type . '>';
							if ( $check_field_lbl_subtitle ) {
								$prd_html .= '<' . $check_field_lbl_subtitle_type . ' class="' . $check_field_lbl_subtitle_class . '">' . $check_field_lbl_subtitle . '</' . $check_field_lbl_subtitle_type . '>';
							}
						}
						$prd_html .= '</td>';
					}
					if ( ! in_array( $check_field_inp_type, $get_exftpoc, true ) ) {
						$prd_html .= '<td class="value epofw_td_value epofw_' . $check_field_title_position . '">';
						$prd_html .= cp_render_fields_front( $check_field_input, $check_field_inp_type );
						$prd_html .= '</td>';
					}
					$prd_html .= '</tr>';
				}
			}
			$prd_html .= '</tbody>';
			$prd_html .= '</table>';
			return $prd_html;
		}

		/**
		 *
		 */
		public function epofw_get_addon_detail_html( $product_name, $product_price ) {
			$prd_html = '';
			$prd_html .= '<table id="addon_total" style="display: none;">';
			$prd_html .= '<tbody>';
			$prd_html .= '<tr id="addon_details">';
			$prd_html .= '<td colspan="2">';
			$prd_html .= '<strong>' . esc_html__( 'Addon Details', 'extra-product-options-for-woocommerce' ) . '</strong>';
			$prd_html .= '</td>';
			$prd_html .= '</tr>';
			$prd_html .= '<tr id="addon_prd_details">';
			$prd_html .= '<td>';
			$prd_html .= '<strong>' . $product_name . '</strong>';
			$prd_html .= '</td>';
			$prd_html .= '<td class="addon_price" data-addon-price="' . $product_price . '">';
			$prd_html .= '<strong>' . wc_price( $product_price ) . '</strong>';
			$prd_html .= '</td>';
			$prd_html .= '</tr>';
			$prd_html .= '<tr id="addon_subtotal">';
			$prd_html .= '<td>';
			$prd_html .= '<strong>';
			$prd_html .= esc_html__( 'Subtotal', 'extra-product-options-for-woocommerce' );
			$prd_html .= '</strong>';
			$prd_html .= '</td>';
			$prd_html .= '<td>';
			$prd_html .= '<strong>';
			$prd_html .= '</strong>';
			$prd_html .= '</td>';
			$prd_html .= '</tr>';
			$prd_html .= '</tbody>';
			$prd_html .= '</table>';
			return $prd_html;
		}

		/**
		 * Add fields before add to cart button.
		 *
		 * @since    1.0.0
		 */
		public function epofw_before_add_to_cart_button() {
			global $post;
			$main_fields_data_arr = $this->epofw_get_fields_data( $post->ID );
			$product_data         = wc_get_product( $post->ID );
			$product_name         = $product_data->get_name();
			$product_price        = $product_data->get_price();
			if ( ! empty( $main_fields_data_arr ) ) {
				foreach ( $main_fields_data_arr as $fields_data_arr ) {
					$addon_position  = epofw_check_array_key_exists( 'addon_position', $fields_data_arr );
					$fields_data_arr = epofw_check_array_key_exists( 'general', $fields_data_arr );
					if ( 'before_add_to_cart' === $addon_position ) {
						if ( ! empty( $fields_data_arr ) ) {
							echo $this->epofw_get_html_field( $fields_data_arr, $product_name, $product_price ); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
						}
					}
				}
				//echo $this->epofw_get_addon_detail_html( $product_name, $product_price );
			}
		}

		/**
		 * Add field after add to cart button.
		 */
		public function epofw_after_add_to_cart_button() {
			global $post;
			$main_fields_data_arr = $this->epofw_get_fields_data( $post->ID );
			$product_data         = wc_get_product( $post->ID );
			$product_name         = $product_data->get_name();
			$product_price        = $product_data->get_price();
			if ( ! empty( $main_fields_data_arr ) ) {
				foreach ( $main_fields_data_arr as $fields_data_arr ) {
					$addon_position  = epofw_check_array_key_exists( 'addon_position', $fields_data_arr );
					$fields_data_arr = epofw_check_array_key_exists( 'general', $fields_data_arr );
					if ( 'after_add_to_cart' === $addon_position ) {
						if ( ! empty( $fields_data_arr ) ) {
							echo $this->epofw_get_html_field( $fields_data_arr, $product_name, $product_price ); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
						}
					}
				}
				echo $this->epofw_get_addon_detail_html( $product_name, $product_price );
			}
		}

		/**
		 * Exclude field types which not include in meta section.
		 *
		 * @since    1.0.0
		 */
		public function exclude_field_type_on_cart_page() {
			$exclude_ftocp = array( 'heading', 'paragraph' );

			return $exclude_ftocp;
		}

		/**
		 * Add to cart validation for field data
		 *
		 * @return boolean TRUE|False if $fields_data_arr will empty otherwise return array $passed.
		 *
		 * @since    1.0.0
		 */
		public function epofw_add_to_cart_validation( $passed, $product_id ) {
			if ( ! isset( $_POST ) && empty( $product_id ) ) {
				return false;
			}
			$fields_data_arr = $this->epofw_get_fields_data( $product_id );
			$fields_data_arr = epofw_check_array_key_exists( 'general', $fields_data_arr );
			if ( ! empty( $fields_data_arr ) ) {
				foreach ( $fields_data_arr as $fields_data ) {
					$check_field_label     = epofw_check_array_key_exists( 'label', $fields_data );
					$check_field_input     = epofw_check_array_key_exists( 'field', $fields_data );
					$check_field_lbl_title = '';
					if ( $check_field_label ) {
						$check_field_lbl_title = epofw_check_array_key_exists( 'title', $check_field_label );
					}
					if ( $check_field_input ) {
						$check_field_name        = epofw_check_array_key_exists( 'name', $check_field_input );
						$check_field_restriction = epofw_check_array_key_exists( 'field_restriction', $check_field_input );
						if ( isset( $_POST[ $check_field_name ] ) ) {
							if ( $check_field_restriction ) {
								if ( 'only_number' === $check_field_restriction ) {
									if ( 1 !== preg_match( '/^[0-9]*$/', trim( sanitize_text_field( $_POST[ $check_field_name ] ) ) ) ) {
										wc_add_notice( sprintf( __( 'Only numbers are allowed for " % s".', 'extra-product-options-for-woocommerce' ), $check_field_lbl_title ), 'error' );

										return false;
									}
								}
								if ( 'all_number' === $check_field_restriction ) {
									if ( 1 !== preg_match( '/^[0-9]+(\\.[0-9]+)]*$/', trim( sanitize_text_field( $_POST[ $check_field_name ] ) ) ) ) {
										wc_add_notice( sprintf( __( 'Decimal numbers are allowed for " % s".', 'extra-product-options-for-woocommerce' ), $check_field_lbl_title ), 'error' );

										return false;
									}
								}
								if ( 'only_text' === $check_field_restriction ) {
									if ( 1 !== preg_match( '/^[a-zA-Z ]*$/i', trim( sanitize_text_field( $_POST[ $check_field_name ] ) ) ) ) {
										wc_add_notice( sprintf( __( 'Only texts are allowed for " % s".', 'extra-product-options-for-woocommerce' ), $check_field_lbl_title ), 'error' );

										return false;
									}
								}
								if ( 'text_number' === $check_field_restriction ) {
									if ( 1 !== preg_match( '/^[a-zA-Z0-9 ]*$/i', trim( sanitize_text_field( $_POST[ $check_field_name ] ) ) ) ) {
										wc_add_notice( sprintf( __( 'Only text and numbers are allowed for " % s".', 'extra-product-options-for-woocommerce' ), $check_field_lbl_title ), 'error' );

										return false;
									}
								}
								if ( 'email' === $check_field_restriction ) {
									if ( ! filter_var( trim( sanitize_text_field( $_POST[ $check_field_name ] ) ), FILTER_VALIDATE_EMAIL ) ) {
										wc_add_notice( sprintf( __( 'Invalid email format for " % s".', 'extra-product-options-for-woocommerce' ), $check_field_lbl_title ), 'error' );

										return false;
									}
								}
							}
						}
					}
				}
			}

			return $passed;
		}

		/**
		 * Add cart item data.
		 *
		 * @param int   $product_id Product ID.
		 *
		 * @param array $cart_item  Array of cart item.
		 *
		 * @return  array $cart_item Array of cart item.
		 *
		 * @throws Exception
		 * @since    1.0.0
		 */
		public function epofw_add_cart_item_data( $cart_item, $product_id ) {
			if ( isset( $_POST ) && ! empty( $product_id ) ) {
				$post_data = $_POST;
			} else {
				return false;
			}
			$fields_data_arr    = $this->epofw_get_fields_data( $product_id );
			$get_field_name_arr = $this->epofw_get_field_name_from_data( $fields_data_arr );
			$get_exftpoc        = $this->exclude_field_type_on_cart_page();
			if ( ! empty( $fields_data_arr ) ) {
				$passed_cart_data = array();
				if ( isset( $post_data ) ) {
					$epofw_post_data = array();
					foreach ( $post_data as $post_key => $post_value_data ) {
						if ( strpos( $post_key, 'epofw_field_' ) !== false ) {
							$epofw_post_data[ $post_key ] = $post_value_data;
						}
					}
					foreach ( $epofw_post_data as $post_key => $post_value_data ) {
						if ( ! empty( $post_value_data ) ) {
							$check_field_label = epofw_check_array_key_exists( 'label', $get_field_name_arr[ $post_key ] );
							$check_field_input = epofw_check_array_key_exists( 'field', $get_field_name_arr[ $post_key ] );
							if ( $check_field_label ) {
								$check_field_lbl_title = epofw_check_array_key_exists( 'title', $check_field_label );
							}
							$check_field_name = '';
							if ( $check_field_input ) {
								$check_field_inp_type = epofw_check_array_key_exists( 'type', $check_field_input );
								$check_field_name     = epofw_check_array_key_exists( 'name', $check_field_input );
							}
							if ( in_array( $check_field_inp_type, $get_exftpoc, true ) ) {
								unset( $get_field_name_arr[ $post_key ] );
							} else {
								if ( isset( $_POST[ $check_field_name ] ) ) {
									if ( ! in_array( $check_field_inp_type, $get_exftpoc, true ) ) {
										$passed_cart_data['epofw_label'] = $check_field_lbl_title;
									}
									if ( ! in_array( $check_field_inp_type, $get_exftpoc, true ) ) {
										$passed_cart_data['epofw_type'] = $check_field_inp_type;
										$passed_cart_data['epofw_name'] = $check_field_name;
										if ( is_array( $_POST[ $check_field_name ] ) ) {
											$post_check_field_name           = array_map( 'sanitize_text_field', wp_unslash( $_POST[ $check_field_name ] ) );
											$passed_cart_data['epofw_value'] = implode( ',', $post_check_field_name );
										} else {
											$post_check_field_name           = trim( sanitize_text_field( $_POST[ $check_field_name ] ) );
											$passed_cart_data['epofw_value'] = $post_check_field_name;
										}
										$find_price_based_on_name = $this->epofw_find_price_based_on_name( $check_field_input, $post_check_field_name );
										if ( $find_price_based_on_name ) {
											$check_addon_price                    = epofw_check_array_key_exists( 'addon_price', $find_price_based_on_name );
											$check_addon_price_type               = epofw_check_array_key_exists( 'addon_price_type', $find_price_based_on_name );
											$passed_cart_data['epofw_price']      = $check_addon_price;
											$passed_cart_data['epofw_price_type'] = $check_addon_price_type;
										} else {
											$passed_cart_data['epofw_price']      = 0;
											$passed_cart_data['epofw_price_type'] = 'fixed';
										}
										$passed_cart_data['epofw_form_data'] = $get_field_name_arr[ $post_key ];
									}
									if ( ! empty( $passed_cart_data ) ) {
										$cart_item['epofw_data'][ $check_field_name ] = $passed_cart_data;
									}
								}
							}
						}
					}
				}
			}

			return $cart_item;
		}

		/**
		 * Find price based on field name.
		 *
		 * @param array  $check_field_input     Array of field array data.
		 *
		 * @param string $check_field_name      Check field name.
		 *
		 * @param mixed  $post_check_field_name Post check field name.
		 *
		 * @return int|float $total_addon_price Addon price.
		 *
		 * @since    1.0.0
		 */
		public function epofw_find_price_based_on_name( $check_field_input, $post_check_field_name ) {
			$check_field_options = epofw_check_array_key_exists( 'options', $check_field_input );
			$chk_price_and_type  = array();
			if ( $check_field_options ) {
				$total_addon_price = 0;
				if ( is_array( $post_check_field_name ) ) {
					foreach ( $post_check_field_name as $post_check_field_val ) {
						$check_field_options_val_arr = epofw_check_array_key_exists( $post_check_field_val, $check_field_options );
						if ( $check_field_options_val_arr ) {
							if ( strpos( $check_field_options_val_arr, '||' ) !== false ) {
								$v_value_ex     = explode( '||', $check_field_options_val_arr );
								$opt_price_type = $v_value_ex[0];
								$opt_price      = $v_value_ex[1];
							} else {
								$opt_price_type = 'fixed';
								$opt_price      = '';
							}
							$total_addon_price                      += (float) $opt_price;
							$chk_price_and_type['addon_price']      = $total_addon_price;
							$chk_price_and_type['addon_price_type'] = $opt_price_type;
						}
					}
				} else {
					$check_field_options_val = epofw_check_array_key_exists( $post_check_field_name, $check_field_options );
					if ( $check_field_options_val ) {
						if ( strpos( $check_field_options_val, '||' ) !== false ) {
							$v_value_ex     = explode( '||', $check_field_options_val );
							$opt_price_type = $v_value_ex[0];
							$opt_price      = $v_value_ex[1];
						} else {
							$opt_price_type = 'fixed';
							$opt_price      = '';
						}
						$total_addon_price                      += $opt_price;
						$chk_price_and_type['addon_price']      = $total_addon_price;
						$chk_price_and_type['addon_price_type'] = $opt_price_type;
					}
				}
			} else {
				$check_field_enable_price = epofw_check_array_key_exists( 'enable_price_extra', $check_field_input );
				$total_addon_price        = 0;
				if ( $check_field_enable_price ) {
					$check_field_addon_price_type           = epofw_check_array_key_exists( 'addon_price_type', $check_field_input );
					$check_field_addon_price                = epofw_check_array_key_exists( 'addon_price', $check_field_input );
					$opt_price_type                         = $check_field_addon_price_type;
					$opt_price                              = $check_field_addon_price;
					$total_addon_price                      += $opt_price;
					$chk_price_and_type['addon_price']      = $total_addon_price;
					$chk_price_and_type['addon_price_type'] = $opt_price_type;
				}
			}

			return $chk_price_and_type;
		}

		/**
		 * Calculate price for cart section
		 *
		 * @param object $cart_obj Object of cart data.
		 *
		 * @since    1.0.0
		 */
		public function epofw_before_calculate_totals( $cart_obj ) {
			if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
				return;
			}
			foreach ( $cart_obj->get_cart() as $value ) {
				if ( isset( $value['epofw_data'] ) ) {
					if ( isset( $value['product_id'] ) ) {
						$product = wc_get_product( $value['product_id'] );
						if ( $product ) {
							$product_price = $product->get_price();
							if ( 'variable' === $product->get_type() ) {
								$variation_data = wc_get_product( $value['variation_id'] );
								if ( $variation_data ) {
									$product_price = $variation_data->get_price();
								}
							}
						}
					} else {
						$product_price = 0;
					}
					$total_price = $product_price;
					foreach ( $value['epofw_data'] as $epofw_data_value ) {
						$epofw_price_type = $epofw_data_value['epofw_price_type'];
						$addon_price      = $epofw_data_value['epofw_price'];
						$addon_price_cal  = epofw_calculate_price_based_on_condition( $epofw_price_type, $addon_price );
						$total_price      += $addon_price_cal;
					}
					$value['data']->set_price( ( $total_price ) );
				}
			}
		}

		/**
		 * Get cart item data.
		 *
		 * @param array $cart_data Array of cart data.
		 *
		 * @param array $cart_item Array of cart item.
		 *
		 * @return  array $meta_items Array of cart item.
		 *
		 * @since    1.0.0
		 */
		public function epofw_get_item_data( $cart_data, $cart_item = null ) {
			$meta_items = array();
			if ( ! empty( $cart_data ) ) {
				$meta_items = $cart_data;
			}
			if ( isset( $cart_item ) ) {
				$check_epofw_data = epofw_check_array_key_exists( 'epofw_data', $cart_item );
				if ( $check_epofw_data ) {
					foreach ( $check_epofw_data as $epofw_data_value ) {
						$epofw_price      = epofw_check_array_key_exists( 'epofw_price', $epofw_data_value );
						$epofw_price_type = epofw_check_array_key_exists( 'epofw_price_type', $epofw_data_value );
						$epofw_label      = epofw_check_array_key_exists( 'epofw_label', $epofw_data_value );
						if ( $epofw_price && 0 !== $epofw_price ) {
							$addon_price_cal = epofw_calculate_price_based_on_condition( $epofw_price_type, $epofw_price );
							$epofw_name      = $epofw_label . ' (' . wc_price( $addon_price_cal ) . ')';
						} else {
							$epofw_name = $epofw_label;
						}
						$meta_items[] = array(
							'name'  => $epofw_name,
							'value' => epofw_check_array_key_exists( 'epofw_value', $epofw_data_value ),
						);
					}
				}
			}

			return $meta_items;
		}

		/**
		 * Add field in order meta.
		 *
		 * @param int   $item_id Item id of cart.
		 *
		 * @param array $values  Array of cart values.
		 *
		 * @throws Exception
		 *
		 * @since    1.0.0
		 */
		public function epofw_add_order_item_meta( $item_id, $values ) {
			$check_epofw_data = epofw_check_array_key_exists( 'epofw_data', $values );
			if ( $check_epofw_data ) {
				foreach ( $check_epofw_data as $epofw_data_value ) {
					$epofw_data_name  = epofw_check_array_key_exists( 'epofw_name', $epofw_data_value );
					$epofw_data_value = epofw_check_array_key_exists( 'epofw_value', $epofw_data_value );
					wc_add_order_item_meta( $item_id, $epofw_data_name, $epofw_data_value );
				}
			}
		}

		/**
		 * Add field in order meta.
		 *
		 * @param array  $cart_item_data Array of cart items.
		 *
		 * @param array  $item           Array of item.
		 *
		 * @param object $order          Order detail.
		 *
		 * @return array $cart_item_data
		 *
		 * @throws Exception
		 *
		 * @since    1.0.0
		 */
		public function epofw_order_again_cart_item_data( $cart_item_data, $item ) {
			if ( $item ) {
				$product_id         = $item->get_product_id();
				$get_field_id_arr   = $this->epofw_find_match_id( $product_id );
				$fields_data_arr    = $this->epofw_get_match_data_from_db( $get_field_id_arr );
				$get_field_name_arr = $this->epofw_get_field_name_from_data( $fields_data_arr );
				$meta_data          = $item->get_meta_data();
				if ( $meta_data ) {
					$new_item_data_arr = array();
					foreach ( $meta_data as $meta_data_value ) {
						if ( array_key_exists( $meta_data_value->key, $get_field_name_arr ) ) {
							$get_display_key              = $this->epofwGetAddonTitle( $get_field_name_arr, $meta_data_value->key, $meta_data_value->value );
							$data_arr                     = array();
							$data_arr['epofw_name']       = $meta_data_value->key;
							$data_arr['epofw_label']      = $get_field_name_arr[ $meta_data_value->key ]['label']['title'];
							$data_arr['epofw_value']      = $meta_data_value->value;
							$data_arr['epofw_price']      = $get_display_key['epofw_price'];
							$data_arr['epofw_price_type'] = 'fixed';
							$new_item_data_arr[]          = $data_arr;
						}
					}
					$cart_item_data['epofw_data'] = $new_item_data_arr;
				}
			}

			return $cart_item_data;
		}

		/**
		 * Get field name from data. It will display in order detail at front side.
		 *
		 * @param array $fields_data_arr Array of fields data which fetched from DB.
		 *
		 * @return array $new_field_array
		 *
		 * @throws Exception
		 *
		 * @since    1.0.0
		 */
		public function epofw_get_field_name_from_data( $main_fields_data_arr ) {
			$new_field_array    = array();
			if ( ! empty( $main_fields_data_arr ) ) {
				foreach ( $main_fields_data_arr as $fields_data_arr ) {
					$general_value_data = epofw_check_array_key_exists( 'general', $fields_data_arr );
					if ( $general_value_data ) {
						foreach ( $general_value_data as $fields_value_data ) {
							$check_field = epofw_check_array_key_exists( 'field', $fields_value_data );
							if ( $check_field ) {
								$check_field_name = epofw_check_array_key_exists( 'name', $check_field );
								if ( $check_field_name ) {
									$new_field_array[ $check_field_name ] = $fields_value_data;
								}
							}
						}
					}
				}
			}
			return $new_field_array;
		}

		/**
		 * Formatted meta data for order detail page. Like change label title in order detail section.
		 *
		 * @param array $formatted_meta Array of meta data.
		 *
		 * @param array $order_item     Array of Order data.
		 *
		 * @return array $formatted_meta
		 *
		 * @throws Exception
		 *
		 * @since    1.0.0
		 */
		public function epofw_item_get_formatted_meta_data( $formatted_meta, $order_item ) {
			if ( $order_item ) {
				$product_id         = $order_item['product_id'];
				$get_field_id_arr   = $this->epofw_find_match_id( $product_id );
				$fields_data_arr    = $this->epofw_get_match_data_from_db( $get_field_id_arr );
				$get_field_name_arr = $this->epofw_get_field_name_from_data( $fields_data_arr );
				if ( $formatted_meta ) {
					foreach ( $formatted_meta as $key => $meta ) {
						if ( array_key_exists( $meta->key, $get_field_name_arr ) ) {
							$get_display_key        = $this->epofwGetAddonTitle( $get_field_name_arr, $meta->key, $meta->value );
							$formatted_meta[ $key ] = (object) array(
								'key'           => $meta->key,
								'value'         => $meta->value,
								'display_key'   => $get_display_key['epofw_label'],
								'display_value' => $meta->value,
							);
						}
					}
				}
			}

			return $formatted_meta;
		}

		/**
		 * Get Addon label name for order detail at front side.
		 *
		 * @param array  $get_field_name_arr Array of meta data.
		 *
		 * @param string $meta_key           Meta key.
		 *
		 * @return array $epofw_label and $opt_price Return label and Price for addon.
		 *
		 * @since    1.0.0
		 */
		public function epofwGetAddonTitle( $get_field_name_arr, $meta_key, $meta_value ) {
			if ( ! empty( $meta_key ) ) {
				$check_field    = epofw_check_array_key_exists( 'field', $get_field_name_arr[ $meta_key ] );
				$opt_price      = '';
				$epofw_label    = '';
				$opt_price_type = 'fixed';
				if ( $check_field ) {
					if ( strpos( $meta_value, ',' ) !== false ) {
						$meta_value_data = explode( ',', $meta_value );
					} else {
						$meta_value_data = $meta_value;
					}
					$find_price_based_on_name = $this->epofw_find_price_based_on_name( $check_field, $meta_value_data );
					if ( $find_price_based_on_name ) {
						$check_addon_price = epofw_check_array_key_exists( 'addon_price', $find_price_based_on_name );
						$opt_price         = $check_addon_price;
					} else {
						$opt_price = 0;
					}
				}
				$check_label = epofw_check_array_key_exists( 'label', $get_field_name_arr[ $meta_key ] );
				if ( $check_label ) {
					$check_title = epofw_check_array_key_exists( 'title', $check_label );
					if ( $check_title ) {
						$epofw_label = $check_title . ' (' . wc_price( $opt_price ) . ')';
					}
				}

				return array(
					'epofw_label'      => $epofw_label,
					'epofw_price'      => $opt_price,
					'epofw_price_type' => $opt_price_type,
				);
			}
		}
	}
}
$epofw_front = EPOFW_Front::instance();
