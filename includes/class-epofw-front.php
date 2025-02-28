<?php
/**
 * Front section.
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
		/**
		 * The object of class.
		 *
		 * @since    1.0.0
		 * @var      string $instance Instance object.
		 */
		protected static $instance = null;

		/**
		 * The name of this plugin.
		 *
		 * @since    1.0.0
		 * @var      string $plugin_name The ID of this plugin.
		 */
		public function __construct() {
			$this->epofw_front_init();
		}

		/**
		 * Define the plugins name and versions and also call admin section.
		 *
		 * @since    1.0.0
		 * @return   object Instance of this class.
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
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
			add_filter(
				'woocommerce_order_again_cart_item_data',
				array(
					$this,
					'epofw_order_again_cart_item_data_pro',
				),
				10,
				2
			);
			add_filter(
				'woocommerce_order_item_get_formatted_meta_data',
				array(
					$this,
					'epofw_item_get_formatted_meta_data_pro',
				),
				10,
				2
			);
			add_action( 'wp_enqueue_scripts', array( $this, 'cop_front_enqueue_scripts_fn' ) );
			add_filter( 'woocommerce_add_to_cart_validation', array( $this, 'epofw_add_to_cart_validation' ), 10, 2 );
			add_filter(
				'woocommerce_order_item_display_meta_value',
				array(
					$this,
					'epofw_display_meta_value',
				),
				10,
				3
			);
			add_action(
				'woocommerce_checkout_create_order_line_item',
				array(
					$this,
					'checkout_create_order_line_item',
				),
				10,
				3
			);
			add_filter( 'woocommerce_add_cart_item', array( $this, 'epofw_add_cart_item' ), 10 );
			add_filter(
				'woocommerce_get_cart_item_from_session',
				array(
					$this,
					'epofw_get_cart_item_from_session',
				),
				99,
				2
			);
			add_action(
				'woocommerce_after_cart_item_quantity_update',
				array(
					$this,
					'epofw_update_price_on_quantity_update',
				),
				20,
				4
			);
			add_filter( 'woocommerce_cart_item_price', array( $this, 'epofw_woocommerce_cart_item_price' ), 10, 2 );
		}

		/**
		 * Add nonce field to the form.
		 *
		 * @since 3.0.9
		 * @return void
		 */
		public function epofw_add_nonce_field() {
			global $post;
			if ( ! $post ) {
				return;
			}

			// Generate unique nonce for this product and user.
			$nonce_action = 'epofw_add_to_cart_' . $post->ID . '_' . get_current_user_id();
			$nonce_name   = 'epofw_add_to_cart_nonce_' . $post->ID;

			wp_nonce_field( $nonce_action, $nonce_name );
		}

		/**
		 * Verify the nonce for add to cart actions.
		 *
		 * @since    1.0.0
		 * @param    int $product_id Product ID.
		 * @return   bool True if nonce is valid, false otherwise.
		 */
		private function verify_add_to_cart_nonce( $product_id ) {
			if ( empty( $product_id ) ) {
				return false;
			}

			// Get the nonce name based on product ID.
			$nonce_name = 'epofw_add_to_cart_nonce_' . $product_id;

			// Verify nonce exists and is valid.
			if ( ! isset( $_POST[ $nonce_name ] ) ) {
				return false;
			}

			$nonce = sanitize_text_field( wp_unslash( $_POST[ $nonce_name ] ) );

			// Generate the same nonce action as used when creating.
			$nonce_action = 'epofw_add_to_cart_' . $product_id . '_' . get_current_user_id();

			return wp_verify_nonce( $nonce, $nonce_action );
		}

		/**
		 * Enqueue some js and css at front side.
		 *
		 * @since    1.0.0
		 */
		public function cop_front_enqueue_scripts_fn() {
			if ( is_product() || is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy() ) {
				$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
				wp_enqueue_script( 'jquery' );
				wp_enqueue_script( 'jquery-ui-datepicker' );
				wp_enqueue_script(
					'jquery-ui-timepicker-js',
					EPOFW_PLUGIN_URL . 'assets/js/jquery-ui-timepicker' . $suffix . '.js',
					array(
						'jquery',
					),
					EPOFW_PLUGIN_VERSION,
					true
				);
				wp_enqueue_style(
					'jquery-ui-timepicker-css',
					EPOFW_PLUGIN_URL . 'assets/css/jquery-ui-timepicker' . $suffix . '.css',
					array(),
					EPOFW_PLUGIN_VERSION
				);
				wp_enqueue_style(
					'select2-css',
					EPOFW_PLUGIN_URL . 'assets/css/select2.min.css',
					array(),
					EPOFW_PLUGIN_VERSION
				);
				wp_enqueue_script(
					'select2-js',
					EPOFW_PLUGIN_URL . 'assets/js/select2.full.min.js',
					array(),
					EPOFW_PLUGIN_VERSION,
					true
				);
				wp_enqueue_style(
					'epofw-public-css',
					EPOFW_PLUGIN_URL . 'assets/css/epofw-public' . $suffix . '.css',
					'',
					EPOFW_PLUGIN_VERSION,
					false
				);
				$epofw_custom_css = epofw_general_settings( 'epofw_custom_css' );
				if ( ! empty( $epofw_custom_css ) ) {
					wp_add_inline_style( 'epofw-public-css', $epofw_custom_css );
				}
				wp_register_style( 'jquery-ui-css', EPOFW_PLUGIN_URL . 'assets/css/jquery-ui.min.css', '', EPOFW_PLUGIN_VERSION );
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
					EPOFW_PLUGIN_VERSION,
					false
				);
				wp_enqueue_script(
					'wp-color-picker',
					admin_url( 'js/color-picker.min.js' ),
					array( 'iris' ),
					EPOFW_PLUGIN_VERSION,
					false
				);
				$colorpicker_l10n = array(
					'clear'         => __( 'Clear', 'extra-product-options-for-woocommerce' ),
					'defaultString' => __( 'Default', 'extra-product-options-for-woocommerce' ),
					'pick'          => __( 'Select Color', 'extra-product-options-for-woocommerce' ),
					'current'       => __( 'Current Color', 'extra-product-options-for-woocommerce' ),
				);
				wp_localize_script(
					'wp-color-picker',
					'wpColorPickerL10n',
					$colorpicker_l10n
				);
				if ( is_product() ) {
					wp_enqueue_script(
						'epofw-front-js',
						EPOFW_PLUGIN_URL . 'assets/js/epofw-front' . $suffix . '.js',
						'',
						EPOFW_PLUGIN_VERSION,
						true
					);
					global $post;
					$product_data = wc_get_product( $post->ID );
					wp_localize_script(
						'epofw-front-js',
						'epofw_front_var',
						array(
							'ajaxurl'                      => admin_url( 'admin-ajax.php' ),
							'current_post_id'              => isset( $product_data ) && ! empty( $product_data ) ? $product_data->get_id() : '',
							'product_price'                => isset( $product_data ) && ! empty( $product_data ) ? epofw_display_product_price( $product_data, 'shop' ) : '',
							'currency'                     => get_woocommerce_currency_symbol(),
							'position'                     => get_option( 'woocommerce_currency_pos' ),
							'decimal_separator'            => wc_get_price_decimal_separator(),
							'thousand_separator'           => wc_get_price_thousand_separator(),
							'decimals'                     => wc_get_price_decimals(),
							'timepicker_select_validation' => __( 'Please select a valid time.', 'extra-product-options-for-woocommerce' ),
							'timepicker_change_validation' => __( 'Please enter a valid time.', 'extra-product-options-for-woocommerce' ),
							'datepicker_select_validation' => __( 'Please select a valid date.', 'extra-product-options-for-woocommerce' ),
							'datepicker_change_validation' => __( 'Please enter a valid date.', 'extra-product-options-for-woocommerce' ),
							'colorpicker_select_validation' => __( 'Please select a valid color code.', 'extra-product-options-for-woocommerce' ),
							'colorpicker_change_validation' => __( 'Please enter a valid color code.', 'extra-product-options-for-woocommerce' ),
						)
					);
				}
			}
		}

		/**
		 * Get match data from DB.
		 *
		 * @since    1.0.0
		 *
		 * @param array $match_field_id Matching field id.
		 *
		 * @return array $get_data_arr. Return array with general data.
		 */
		public function epofw_get_match_data_from_db( $match_field_id ) {
			$product_option_args = array(
				'post_type'      => EPOFW_DFT_POST_TYPE,
				'post_status'    => 'publish',
				'posts_per_page' => -1,
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
					$get_data = epofw_get_data_from_db( $f_id );
					if ( ! empty( $get_data ) ) {
						foreach ( $get_data as $gkey => $gdata ) {
							if ( 'general' !== $gkey ) {
								$get_data_arr[ $gkey ] = $gdata;
							} else {
								$new_get_data = array();
								if ( ! empty( $gdata ) ) {
									foreach ( $gdata as $vkey => $vdata ) {
										$get_field_status = epofw_check_array_key_exists( 'field_status', $vdata );
										if ( empty( $get_field_status ) ) {
											unset( $get_data['general'][ $vkey ] );
										} else {
											$new_get_data[ $vkey ] = $vdata;
										}
										$get_logical_operation = epofw_check_array_key_exists( 'logical_operation', $vdata );
										if ( $get_logical_operation ) {
											foreach ( (array) $get_logical_operation as $lodata ) {
												$get_epofw_conditional_logic_fields = epofw_check_array_key_exists( 'epofw_conditional_logic_fields', $lodata );
												if ( empty( $get_epofw_conditional_logic_fields ) ) {
													unset( $new_get_data[ $vkey ]['logical_operation'] );
												}
											}
										}
									}
								}
								$get_data_arr['general'] = $new_get_data;
							}
						}
					}
					$main_get_data_arr[] = $get_data_arr;
				}
			}

			/**
			 * Apply filter for get match data from DB.
			 *
			 * @since 1.0.0
			 */
			return apply_filters( 'epofw_get_match_data_from_db', $main_get_data_arr );
		}

		/**
		 * Find match id based on product id..
		 *
		 * @since 1.0.0
		 *
		 * @param int $current_prd_id Current product id.
		 *
		 * @return array $matched_id_arr. Return array with matched id.
		 */
		public function epofw_find_match_id( $current_prd_id ) {
			$current_prd_id      = strval( $current_prd_id );
			$product_option_args = array(
				'post_type'      => EPOFW_DFT_POST_TYPE,
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'orderby'        => 'ID',
				'order'          => 'DESC',
				'fields'         => 'ids',
			);
			$prd_wp_query        = new WP_Query( $product_option_args );
			$matched_id_arr      = array();
			if ( $prd_wp_query->have_posts() ) {
				foreach ( $prd_wp_query->posts as $f_id ) {
					$get_data         = epofw_get_data_from_db( $f_id );
					$matched_data_arr = array();
					if ( ! empty( $get_data ) ) {
						$aadditional_rule_detail = epofw_check_array_key_exists( 'additional_rule_data', $get_data );
						if ( ! empty( $aadditional_rule_detail ) ) {
							foreach ( (array) $aadditional_rule_detail as $aadditional_rule_data ) {
								$condition = epofw_check_array_key_exists( 'condition', $aadditional_rule_data );
								if ( $condition ) {
									$operator = epofw_check_array_key_exists( 'operator', $aadditional_rule_data );
									$value    = epofw_check_array_key_exists( 'value', $aadditional_rule_data );
									if ( ! empty( $value ) ) {
										$value = array_map( 'strval', $value );
									}
									if ( $value ) {
										if ( 'product' === $condition ) {
											$matched_data_arr['mpc'] = 'false';
											if ( 'is_equal_to' === $operator ) {
												if ( in_array( $current_prd_id, $value, true ) ) {
													$matched_data_arr['mpc'] = 'true';
												}
											} elseif ( ! in_array( $current_prd_id, $value, true ) ) {
												$matched_data_arr['mpc'] = 'true';
											}
										}
										if ( 'category' === $condition ) {
											$matched_data_arr['mcc'] = 'false';
											$cart_product_category   = wp_get_post_terms( $current_prd_id, 'product_cat', array( 'fields' => 'ids' ) );
											if ( 'is_equal_to' === $operator ) {
												if ( ! empty( $cart_product_category ) ) {
													foreach ( $cart_product_category as $cat_id ) {
														if ( in_array( strval( $cat_id ), $value, true ) ) {
															$matched_data_arr['mcc'] = 'true';
														}
													}
												}
											} elseif ( ! empty( $cart_product_category ) ) {
												foreach ( $cart_product_category as $cat_id ) {
													if ( ! in_array( strval( $cat_id ), $value, true ) ) {
														$matched_data_arr['mcc'] = 'true';
													}
												}
											}
										}
									}
								}
							}
						}
					}
					if ( ! empty( $matched_data_arr ) && ! in_array( 'false', $matched_data_arr, true ) ) {
						$matched_id_arr[] = $f_id;
					}
				}
			}

			/**
			 * Apply filter for find match id.
			 *
			 * @since 1.0.0
			 */
			return apply_filters( 'epofw_find_match_id', array_unique( $matched_id_arr ) );
		}

		/**
		 * Get fields data which matched.
		 *
		 * @since    1.0.0
		 *
		 * @param int $current_prd_id Current product id.
		 *
		 * @return array $get_data Return array with matched data.
		 */
		public function epofw_get_fields_data( $current_prd_id ) {
			$get_match_field_id = $this->epofw_find_match_id( $current_prd_id );
			$get_data           = '';
			if ( ! empty( $get_match_field_id ) ) {
				$get_data = $this->epofw_get_match_data_from_db( $get_match_field_id );
			}

			/**
			 * Apply filter for get field data.
			 *
			 * @since 1.0.0
			 */
			return apply_filters( 'epofw_get_fields_data', $get_data );
		}

		/**
		 * Add fields before add to cart button.
		 *
		 * @since 1.0.0
		 */
		public function epofw_before_add_to_cart_button() {
			global $post;
			$main_fields_data_arr = $this->epofw_get_fields_data( $post->ID );
			if ( ! empty( $main_fields_data_arr ) ) {

				// Add nonce field using the centralized function.
				$this->epofw_add_nonce_field();

				foreach ( $main_fields_data_arr as $fields_data_arr ) {
					$addon_position = epofw_check_array_key_exists( 'epofw_addon_position', $fields_data_arr );
					if ( 'before_add_to_cart' === $addon_position ) {
						if ( ! empty( $fields_data_arr ) ) {
							$this->epofw_front_html( $fields_data_arr, 'epofw_single' );
						}
					}
				}
			}
		}

		/**
		 * FUnction will return front html.
		 *
		 * @param array  $fields_data_arr Array of field data.
		 * @param string $epofw_action    Epofw action.
		 */
		public function epofw_front_html( $fields_data_arr, $epofw_action ) {
			$file_name = 'epofw-addon-table-html.php';
			wc_get_template(
				$file_name,
				array(
					'fields_data_arr' => $fields_data_arr,
					'epofw_action'    => $epofw_action,
				),
				epofw_get_template_path(),
				epofw_get_default_path()
			);
		}

		/**
		 * Function will return front html.
		 *
		 * @param string $epofw_action Action of current page.
		 */
		public function epofw_addon_html( $epofw_action ) {
			wc_get_template(
				'epofw-addon-details.php',
				array(
					'epofw_action' => $epofw_action,
				),
				epofw_get_template_path(),
				epofw_get_default_path()
			);
		}

		/**
		 * Add field after add to cart button.
		 *
		 * @since 1.0.0
		 */
		public function epofw_after_add_to_cart_button() {
			global $post;
			$main_fields_data_arr = $this->epofw_get_fields_data( $post->ID );
			if ( ! empty( $main_fields_data_arr ) ) {

				// Add nonce field using the centralized function.
				$this->epofw_add_nonce_field();

				foreach ( $main_fields_data_arr as $fields_data_arr ) {
					$addon_position = epofw_check_array_key_exists( 'epofw_addon_position', $fields_data_arr );
					if ( 'after_add_to_cart' === $addon_position ) {
						if ( ! empty( $fields_data_arr ) ) {
							$this->epofw_front_html( $fields_data_arr, 'epofw_single' );
						}
					}
					$this->epofw_addon_html( 'epofw_single' );
				}
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
		 * Add to cart validation for field data.
		 *
		 * @since    1.0.0
		 *
		 * @param string $passed     Passed array.
		 * @param int    $product_id Product id.
		 *
		 * @throws Exception Get Error.
		 * @return string|boolean
		 */
		public function epofw_add_to_cart_validation( $passed, $product_id ) {

			if ( ! isset( $_POST ) && empty( $product_id ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
				return false;
			}

			if ( ! isset( $_POST[ 'epofw_add_to_cart_nonce_' . $product_id ] ) ) {
				return $passed;
			}

			// Check if this is an "Order Again" request.
			if ( isset( $_GET['order_again'] ) ) {
				// Verify WooCommerce's order again nonce.
				if ( ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'woocommerce-order_again' ) ) {
					return false;
				}
				return $passed;
			}

			// Verify nonce.
			if ( ! $this->verify_add_to_cart_nonce( $product_id ) ) {
				wc_add_notice(
					esc_html__( 'Security check failed. Please refresh the page and try again.', 'extra-product-options-for-woocommerce' ),
					'error'
				);
				return false;
			}

			$get_post_data      = array_map( 'sanitize_text_field', wp_unslash( $_POST ) ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
			$fields_data_arr    = $this->epofw_get_fields_data( $product_id );
			$get_field_name_arr = $this->epofw_get_field_name_from_data( $fields_data_arr, $get_post_data );
			$field_err_status   = $this->epofw_check_validation( $get_post_data, $get_field_name_arr );
			if ( in_array( false, $field_err_status, true ) ) {
				$passed = false;
			}

			return $passed;
		}

		/**
		 * Check validation.
		 *
		 * @since 1.0.0
		 *
		 * @param array $get_post_data      Get posted data.
		 * @param array $get_field_name_arr Get field name array.
		 *
		 * @return array $field_err_status Status of uploaded file.
		 */
		public function epofw_check_validation( $get_post_data, $get_field_name_arr ) {
			$field_err_status = array();
			if ( isset( $get_post_data ) ) {
				$epofw_post_data = array();
				if ( ! empty( $get_post_data ) ) {
					foreach ( $get_post_data as $post_key => $post_value_data ) {
						if ( strpos( $post_key, 'epofw_field_' ) !== false ) {
							if ( ! empty( $post_value_data ) ) {
								$epofw_post_data[ $post_key ] = $post_value_data;
							}
						}
					}
				}

				if ( ! empty( $epofw_post_data ) ) {
					foreach ( $epofw_post_data as $post_data_key => $value ) {
						if ( ! empty( $value ) && ! empty( $get_field_name_arr ) && array_key_exists( $post_data_key, $get_field_name_arr ) ) {
							$check_field_label     = epofw_check_array_key_exists( 'label', $get_field_name_arr[ $post_data_key ] );
							$check_field_input     = epofw_check_array_key_exists( 'field', $get_field_name_arr[ $post_data_key ] );
							$check_field_lbl_title = '';
							if ( $check_field_label ) {
								$check_field_lbl_title = esc_html( epofw_check_array_key_exists( 'title', $check_field_label ) );
							}
							if ( $check_field_input ) {
								$check_field_name = epofw_check_array_key_exists( 'name', $check_field_input );
								$check_field_type = epofw_check_array_key_exists( 'type', $check_field_input );
								if ( isset( $get_post_data[ $check_field_name ] ) || isset( $get_post_data[ $check_field_name ]['value'] ) ) {
									if ( isset( $get_post_data[ $check_field_name ]['value'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
										$post_check_field_name = trim( sanitize_text_field( wp_unslash( $get_post_data[ $check_field_name ]['value'] ) ) );
									} else {
										$post_check_field_name = trim( sanitize_text_field( wp_unslash( $get_post_data[ $check_field_name ] ) ) );
									}
									if ( 'text' === $check_field_type ) {
										$check_field_restriction = isset( $get_field_name_arr[ $post_data_key ]['epofw_field_settings']['field_restriction'] ) ?
											sanitize_text_field( $get_field_name_arr[ $post_data_key ]['epofw_field_settings']['field_restriction'] ) : '';

										if ( $check_field_restriction ) {
											// Sanitize the field title once for all error messages.
											$safe_field_title = esc_html( $check_field_lbl_title );

											if ( 'only_number' === $check_field_restriction ) {
												if ( 1 !== preg_match( '/^[0-9]*$/', $post_check_field_name ) ) {
													/* translators: %1$s: Field label that only accepts numbers */
													$error_message = sprintf(
														/* translators: %1$s: Field label that only accepts numbers */
														esc_html__( 'Only numbers are allowed for "%1$s".', 'extra-product-options-for-woocommerce' ),
														esc_html( $safe_field_title )
													);
													$this->epofw_add_to_cart_error_msg( 'only_number', $error_message );
													$field_err_status[] = false;
												}
											}
											if ( 'all_number' === $check_field_restriction ) {
												if ( 1 !== preg_match( '/^[0-9]+(\\.[0-9]+)]*$/', $post_check_field_name ) ) {
													/* translators: 1: Field label */
													$error_message = sprintf( __( 'Decimal numbers are allowed for " %1$s".', 'extra-product-options-for-woocommerce' ), $check_field_lbl_title );
													$this->epofw_add_to_cart_error_msg( 'all_number', $error_message );
													$field_err_status[] = false;
												}
											}
											if ( 'only_text' === $check_field_restriction ) {
												if ( 1 !== preg_match( '/^[a-zA-Z]*$/i', $post_check_field_name ) ) {
													/* translators: 1: Field label */
													$error_message = sprintf( __( 'Only texts are allowed for " %1$s".', 'extra-product-options-for-woocommerce' ), $check_field_lbl_title );
													$this->epofw_add_to_cart_error_msg( 'only_text', $error_message );
													$field_err_status[] = false;
												}
											}
											if ( 'text_number' === $check_field_restriction ) {
												if ( 1 !== preg_match( '/^[a-zA-Z0-9]*$/i', $post_check_field_name ) ) {
													/* translators: 1: Field label */
													$error_message = sprintf( __( 'Only text and numbers are allowed for " %1$s".', 'extra-product-options-for-woocommerce' ), $check_field_lbl_title );
													$this->epofw_add_to_cart_error_msg( 'text_number', $error_message );
													$field_err_status[] = false;
												}
											}
											if ( 'email' === $check_field_restriction ) {
												if ( ! filter_var( $post_check_field_name, FILTER_VALIDATE_EMAIL ) ) {
													/* translators: 1: Field label */
													$error_message = sprintf( __( 'Invalid email format for " %1$s".', 'extra-product-options-for-woocommerce' ), $check_field_lbl_title );
													$this->epofw_add_to_cart_error_msg( 'email', $error_message );
													$field_err_status[] = false;
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}

			return $field_err_status;
		}

		/**
		 * Add cart item data.
		 *
		 * @since 1.0.0
		 * @param array $cart_item  Array of cart item.
		 * @param int   $product_id Product ID.
		 * @return array|false $cart_item Array of cart item on success, false on failure.
		 * @throws Exception When validation fails.
		 */
		public function epofw_add_cart_item_data( $cart_item, $product_id ) {
			// Verify nonce and product ID.
			$product_id = absint( $product_id );
			if ( ! $product_id || ! $this->verify_add_to_cart_nonce( $product_id ) ) {
				return false;
			}

			// Verify we have POST data and nonce.
			if ( ! isset( $_POST ) || empty( $_POST ) ) {
				return false;
			}

			$get_post_data = map_deep( wp_unslash( $_POST ), 'sanitize_text_field' );

			$post_data = array();
			if ( isset( $get_post_data ) && ! empty( $product_id ) ) {
				foreach ( $get_post_data as $post_key => $post_value_data ) {
					if ( strpos( $post_key, 'epofw_field_' ) !== false ) {
						if ( strpos( $post_key, 'hidden_epofw_field_' ) !== false ) {
							$post_key = str_replace( 'hidden_', '', $post_key );
						}
						$get_product_id = filter_input( INPUT_POST, 'product_id', FILTER_VALIDATE_INT );
						$get_product_id = isset( $get_product_id ) ? sanitize_text_field( wp_unslash( $get_product_id ) ) : '';
						if ( ! empty( $get_product_id ) ) {
							$search_key = 'epofw_shop_' . esc_attr( $get_product_id ) . '_';
							$post_key   = str_replace( $search_key, '', $post_key );
						}

						// Handle array values properly.
						if ( isset( $post_value_data['value'] ) ) {
							if ( is_array( $post_value_data['value'] ) ) {
								// Sanitize each array value.
								$post_data[ $post_key ] = array(
									'value' => array_map( 'sanitize_text_field', $post_value_data['value'] ),
								);
							} else {
								// Handle single value.
								$post_data[ $post_key ] = array(
									'value' => sanitize_text_field( $post_value_data['value'] ),
								);
							}
						} else {
							$post_data[ $post_key ] = $post_value_data;
						}
					} else {
						$post_data[ $post_key ] = $post_value_data;
					}
				}
			}

			// Here pass main product id.
			$fields_data_arr = $this->epofw_get_fields_data( $product_id );
			if ( isset( $post_data['variation_id'] ) ) {
				$product_id = $post_data['variation_id'];
			}

			$get_exftpoc      = $this->exclude_field_type_on_cart_page();
			$passed_cart_data = array();

			if ( isset( $post_data ) ) {
				$get_field_name_arr = $this->epofw_get_field_name_from_data( $fields_data_arr, $post_data );
				if ( ! empty( $get_field_name_arr ) ) {
					$epofw_post_data = array();
					$quantity        = 1;
					foreach ( $post_data as $post_key => $post_value_data ) {
						if ( strpos( $post_key, 'epofw_field_' ) !== false ) {
							if ( strpos( $post_key, 'hidden_epofw_field_' ) !== false ) {
								$post_key = str_replace( 'hidden_', '', $post_key );
							}
							$epofw_post_data[ $post_key ] = $post_value_data;
						}
						$quantity = $post_data['quantity'];
					}

					// Process each field value.
					if ( ! empty( $epofw_post_data ) ) {
						foreach ( $epofw_post_data as $post_key => $post_value_data ) {
							if ( ! empty( $post_value_data ) && array_key_exists( $post_key, $get_field_name_arr ) ) {
								$check_field_label = epofw_check_array_key_exists( 'label', $get_field_name_arr[ $post_key ] );
								$check_field_input = epofw_check_array_key_exists( 'field', $get_field_name_arr[ $post_key ] );
								if ( $check_field_label ) {
									$check_field_lbl_title = epofw_check_array_key_exists( 'title', $check_field_label );
								}
								$check_field_name     = '';
								$check_field_inp_type = '';
								if ( $check_field_input ) {
									$check_field_inp_type = epofw_check_array_key_exists( 'type', $check_field_input );
									$check_field_name     = epofw_check_array_key_exists( 'name', $check_field_input );
									if ( strpos( $check_field_name, 'epofw_field_' ) === false ) {
										$check_field_name = 'epofw_field_' . $check_field_name;
									}
								}
								if ( in_array( $check_field_inp_type, $get_exftpoc, true ) ) {
									unset( $get_field_name_arr[ $post_key ] );
								} elseif ( isset( $post_data[ $check_field_name ] ) ) {
									if ( is_array( $post_value_data ) ) {
										$epofw_field_value = isset( $post_value_data['value'] ) ? $post_value_data['value'] : '';
									} else {
										$epofw_field_value = $post_data[ $check_field_name ];
									}
									if ( ! in_array( $check_field_inp_type, $get_exftpoc, true ) ) {
										$passed_cart_data['epofw_label'] = $check_field_lbl_title;
									}
									if ( ! in_array( $check_field_inp_type, $get_exftpoc, true ) ) {
										$passed_cart_data['product_id'] = $product_id;
										$passed_cart_data['epofw_type'] = $check_field_inp_type;
										$passed_cart_data['epofw_name'] = $check_field_name;
										if ( is_array( $epofw_field_value ) ) {
											// Sanitize array values and remove any empty or malicious content.
											$post_check_field_name = array_filter(
												array_map(
													function ( $value ) {
														// Remove any HTML, extra whitespace, and sanitize.
														$clean_value = trim( sanitize_text_field( wp_unslash( $value ) ) );
														return '' !== $clean_value ? $clean_value : null;
													},
													$epofw_field_value
												)
											);

											// Join with comma and space, escape for display.
											$passed_cart_data['epofw_value'] = esc_html(
												implode( ', ', array_filter( $post_check_field_name ) )
											);
										} else {
											$post_check_field_name           = trim( sanitize_text_field( wp_unslash( esc_html( wp_strip_all_tags( $epofw_field_value ) ) ) ) );
											$passed_cart_data['epofw_value'] = $post_check_field_name;
										}
										$epofw_validate_option = $this->epofw_validate_options_exists( $post_check_field_name, $get_field_name_arr[ $post_key ] );
										if ( ! $epofw_validate_option ) {
											$message = apply_filters( 'epfow_addon_invalid_option', __( 'Option is invalid', 'extra-product-options-for-woocommerce' ), $product_id );
											throw new Exception( esc_html( $message ) );
										}
										$find_price_based_on_name = $this->epofw_find_price_based_on_name( $product_id, $post_check_field_name, $quantity, $get_field_name_arr[ $post_key ] );
										if ( $find_price_based_on_name ) {
											$check_addon_price                        = epofw_check_array_key_exists( 'addon_price', $find_price_based_on_name );
											$check_addon_price_type                   = epofw_check_array_key_exists( 'addon_price_type', $find_price_based_on_name );
											$passed_cart_data['epofw_price']          = $check_addon_price;
											$check_addon_original_price               = epofw_check_array_key_exists( 'addon_original_price', $find_price_based_on_name );
											$passed_cart_data['epofw_original_price'] = $check_addon_original_price;
											$passed_cart_data['epofw_price_type']     = $check_addon_price_type;
										} else {
											$passed_cart_data['epofw_price']          = 0;
											$passed_cart_data['epofw_original_price'] = 0;
											$passed_cart_data['epofw_price_type']     = 'fixed';
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
		 * Get per character price.
		 *
		 * @param array $egppc_args  Array of data.
		 * @param array $fields_data Array of fields data.
		 *
		 * @return int|float $check_addon_price
		 */
		public function epofw_get_dynamic_price( $egppc_args, $fields_data ) {
			$post_check_field_name = isset( $egppc_args['post_check_field_name'] ) ? $egppc_args['post_check_field_name'] : '';
			$check_addon_price     = isset( $egppc_args['opt_price'] ) ? $egppc_args['opt_price'] : '';
			$gpcp                  = 0;
			if ( ! empty( $post_check_field_name ) ) {
				$gpcp = $check_addon_price;
			}
			$egppc_args['opt_price'] = $gpcp;
			$gpcp                    = epofw_format_price_with_decimals( $gpcp, $egppc_args, $fields_data );

			return $gpcp;
		}

		/**
		 * Function to validate option exists.
		 *
		 * @since    3.0.5
		 *
		 * @param mixed $post_check_field_name Post check field name.
		 * @param array $fields_data           Get fields data.
		 *
		 * @return bool $is_valid Is valid.
		 */
		public function epofw_validate_options_exists( $post_check_field_name, $fields_data ) {
			$check_field_options  = isset( $fields_data['epofw_field_settings']['options'] ) ? $fields_data['epofw_field_settings']['options'] : array();
			$check_field_inp_type = isset( $fields_data['field']['type'] ) ? $fields_data['field']['type'] : '';
			$is_valid             = true;

			if (
				'select' === $check_field_inp_type ||
				'radiogroup' === $check_field_inp_type ||
				'checkbox' === $check_field_inp_type ||
				'checkboxgroup' === $check_field_inp_type
			) {
				if ( $check_field_options ) {
					if ( ! empty( $post_check_field_name ) && is_array( $post_check_field_name ) ) {
						foreach ( $post_check_field_name as $post_check_field_val ) {
							$check_field_options_val_arr = epofw_check_array_key_exists( $post_check_field_val, $check_field_options );
							if ( ! $check_field_options_val_arr ) {
								$is_valid = false;
							}
						}
					} else {
						$check_field_options_val = epofw_check_array_key_exists( $post_check_field_name, $check_field_options );
						if ( ! $check_field_options_val ) {
							$is_valid = false;
						}
					}
				}
			}

			return $is_valid;
		}

		/**
		 * Find price based on field name.
		 *
		 * @since    1.0.0
		 *
		 * @param int   $product_id            Product Id.
		 * @param mixed $post_check_field_name Post check field name.
		 * @param int   $quantity              Product quantity.
		 * @param array $fields_data           Get fields data.
		 *
		 * @return array $chk_price_and_type Addon price and type.
		 */
		public function epofw_find_price_based_on_name( $product_id, $post_check_field_name, $quantity, $fields_data ) {
			$product_data               = wc_get_product( $product_id );
			$product_price              = epofw_display_product_price( $product_data, 'shop' );
			$check_epofw_field_settings = isset( $fields_data['epofw_field_settings'] ) ? $fields_data['epofw_field_settings'] : array();
			$check_field_options        = isset( $fields_data['epofw_field_settings']['options'] ) ? $fields_data['epofw_field_settings']['options'] : array();
			$check_field_inp_type       = isset( $fields_data['field']['type'] ) ? $fields_data['field']['type'] : '';
			$check_apodp_lop            = 'datepicker' === $check_field_inp_type && isset( $fields_data['apodp_logical_operation'] ) ? $fields_data['apodp_logical_operation'] : array();
			$egppc_args                 = array(
				'product_data'          => $product_data,
				'post_check_field_name' => $post_check_field_name,
				'product_price'         => $product_price,
				'qty'                   => $quantity,
			);
			$chk_price_and_type         = array();
			if ( $check_field_options ) {
				$total_addon_price          = 0;
				$total_addon_original_price = 0;
				if ( ! empty( $post_check_field_name ) && is_array( $post_check_field_name ) ) {
					foreach ( $post_check_field_name as $post_check_field_val ) {
						$check_field_options_val_arr = epofw_check_array_key_exists( $post_check_field_val, $check_field_options );
						if ( $check_field_options_val_arr ) {
							$opt_grp_data                      = epofw_explore_label_from_opt_group( $check_field_options_val_arr );
							$opt_price_type                    = $opt_grp_data['opt_price_type'];
							$get_opt_price                     = $opt_grp_data['opt_price'];
							$egppc_args['opt_price']           = $get_opt_price;
							$egppc_args['opt_price_type']      = $opt_price_type;
							$opt_price                         = $this->epofw_get_dynamic_price( $egppc_args, $fields_data );
							$total_addon_price                += (float) $opt_price;
							$chk_price_and_type['addon_price'] = $total_addon_price;
							// Change $get_opt_price to $opt_price because its creating issue once we add price with custom formula - {ppv}*4.
							$total_addon_original_price                += (float) $opt_price;
							$chk_price_and_type['addon_original_price'] = $total_addon_original_price;
							$chk_price_and_type['addon_price_type']     = $opt_price_type;
						}
					}
				} else {
					$check_field_options_val = epofw_check_array_key_exists( $post_check_field_name, $check_field_options );
					if ( $check_field_options_val ) {
						$opt_grp_data                      = epofw_explore_label_from_opt_group( $check_field_options_val );
						$opt_price_type                    = $opt_grp_data['opt_price_type'];
						$get_opt_price                     = $opt_grp_data['opt_price'];
						$egppc_args['opt_price']           = $get_opt_price;
						$egppc_args['opt_price_type']      = $opt_price_type;
						$opt_price                         = $this->epofw_get_dynamic_price( $egppc_args, $fields_data );
						$total_addon_price                += (float) $opt_price;
						$chk_price_and_type['addon_price'] = $total_addon_price;
						// Change $get_opt_price to $opt_price because its creating issue once we add price with custom formula - {ppv}*4.
						$total_addon_original_price                += (float) $opt_price;
						$chk_price_and_type['addon_original_price'] = $total_addon_original_price;
						$chk_price_and_type['addon_price_type']     = $opt_price_type;
					}
				}
			} else {
				$check_field_enable_price   = epofw_check_array_key_exists( 'enable_price_extra', $check_epofw_field_settings );
				$total_addon_inp_price      = 0;
				$total_addon_original_price = 0;
				if ( $check_field_enable_price ) {
					$date_addon_extra_price = 0;
					if ( ! empty( $check_apodp_lop ) && is_array( $check_apodp_lop ) ) {
						$post_check_field_name_date = strtotime( $post_check_field_name );
						foreach ( $check_apodp_lop as $check_apodp_lop_data ) {
							$epofw_cnd_start_date = strtotime( $check_apodp_lop_data['epofw_cnd_start_date'] );
							$epofw_cnd_end_date   = strtotime( $check_apodp_lop_data['epofw_cnd_end_date'] );
							if ( $post_check_field_name_date >= $epofw_cnd_start_date && $post_check_field_name_date <= $epofw_cnd_end_date ) {
								$date_addon_extra_price = $check_apodp_lop_data['epofw_cnd_price'];
							}
						}
					}
					$check_field_addon_price_type = epofw_check_array_key_exists( 'addon_price_type', $check_epofw_field_settings );
					$check_field_addon_price      = epofw_check_array_key_exists( 'addon_price', $check_epofw_field_settings );
					$opt_price_type               = $check_field_addon_price_type;
					$get_opt_price                = $check_field_addon_price;
					$egppc_args['opt_price']      = $get_opt_price;
					$egppc_args['opt_price_type'] = $opt_price_type;
					$opt_price                    = $this->epofw_get_dynamic_price( $egppc_args, $fields_data );
					$total_addon_inp_price       += (float) $opt_price;
					// Change $get_opt_price to $opt_price because its creating issue once we add price with custom formula - {ppv}*4.
					$total_addon_inp_price                     += (float) $date_addon_extra_price;
					$total_addon_original_price                += (float) $total_addon_inp_price;
					$chk_price_and_type['addon_original_price'] = $total_addon_original_price;
					$chk_price_and_type['addon_price']          = $total_addon_inp_price;
					$chk_price_and_type['addon_price_type']     = $opt_price_type;
				}
			}

			return $chk_price_and_type;
		}

		/**
		 * Get cart item data.
		 *
		 * @since    1.0.0
		 *
		 * @param array $cart_data Array of cart data.
		 * @param array $cart_item Array of cart item.
		 *
		 * @return  array $meta_items Array of cart item.
		 */
		public function epofw_get_item_data( $cart_data, $cart_item = null ) {
			// Verify request method and nonce for any POST request.
			if ( isset( $_SERVER['REQUEST_METHOD'] ) && 'POST' === $_SERVER['REQUEST_METHOD'] ) {
				$product_id = isset( $cart_item['product_id'] ) ? absint( $cart_item['product_id'] ) : 0;

				// Verify nonce and return early if invalid.
				if ( ! $product_id || ! $this->verify_add_to_cart_nonce( $product_id ) ) {
					return $cart_data;
				}
			}

			$meta_items = array();
			if ( ! empty( $cart_data ) ) {
				$meta_items = $cart_data;
			}
			if ( isset( $cart_item ) ) {
				$check_epofw_data = epofw_check_array_key_exists( 'epofw_data', $cart_item );
				if ( ! empty( $check_epofw_data ) && is_array( $check_epofw_data ) ) {
					$custom_meta_data = array();
					foreach ( $check_epofw_data as $key => $epofw_data_value ) {
						$get_epofw_value = epofw_check_array_key_exists( 'epofw_value', $epofw_data_value );
						if ( ! empty( $get_epofw_value ) && isset( $epofw_data_value['epofw_form_data'] ) ) {
							$epofw_label                       = epofw_check_array_key_exists( 'epofw_label', $epofw_data_value );
							$custom_meta_data[ $key ]['key']   = $epofw_label;
							$custom_meta_data[ $key ]['name']  = $this->epofw_display_name_in_cart( $epofw_data_value, '', '' );
							$custom_meta_data[ $key ]['value'] = $this->epofw_display_value_in_cart( $epofw_data_value );
						}
					}
					if ( ! empty( $custom_meta_data ) ) {
						foreach ( $custom_meta_data as $data ) {
							$meta_items[] = $data;
						}
					}
				}
			}

			return $meta_items;
		}

		/**
		 * Display field name in cart section.
		 *
		 * @since 1.0.0
		 *
		 * @param array $epofw_data_value   Array of field data.
		 * @param bool  $check_epofw_haoic  Hide addon order in cart page.
		 * @param bool  $check_epofw_haopic Hide addon order price in cart page.
		 *
		 * @return string $epofw_name Return string.
		 */
		public function epofw_display_name_in_cart( $epofw_data_value, $check_epofw_haoic, $check_epofw_haopic ) {
			$epofw_price = epofw_check_array_key_exists( 'epofw_price', $epofw_data_value );
			$epofw_label = epofw_check_array_key_exists( 'epofw_label', $epofw_data_value );

			// Sanitize and escape the label.
			$epofw_label = esc_html( wp_strip_all_tags( $epofw_label ) );

			if ( $epofw_price && 0 !== $epofw_price ) {
				$epofw_name = $epofw_label;
				// Price is already sanitized by wc_price().
				$epofw_name .= ' (' . wc_price( epofw_price_filter( $epofw_price ) ) . ')';
			} else {
				$epofw_name = $epofw_label;
			}

			/**
			 * Apply filter for display name in cart.
			 *
			 * @since 1.0.0
			 */
			return apply_filters( 'epofw_display_name_in_cart', $epofw_name, $epofw_data_value, $check_epofw_haoic, $check_epofw_haopic );
		}

		/**
		 * Display field value in cart section.
		 *
		 * @since 1.0.0
		 *
		 * @param array $epofw_data_value Array of field data.
		 *
		 * @return mixed $epofw_value Return html or string.
		 */
		public function epofw_display_value_in_cart( $epofw_data_value ) {
			$epofw_type      = epofw_check_array_key_exists( 'epofw_type', $epofw_data_value );
			$get_epofw_value = epofw_check_array_key_exists( 'epofw_value', $epofw_data_value );
			if ( 'colorpicker' === $epofw_type ) {
				$epofw_value = $this->epofw_render_color( $get_epofw_value );
			} else {
				// Sanitize and escape the value.
				$epofw_value = esc_html( wp_strip_all_tags( $get_epofw_value ) );
			}

			/**
			 * Apply filter for display value in cart.
			 *
			 * @since 1.0.0
			 */
			return apply_filters( 'epofw_display_value_in_cart', $epofw_value, $epofw_type, $epofw_data_value );
		}

		/**
		 * Function will render color html.
		 *
		 * @since 2.4.4
		 * @param string $get_epofw_value Value of car data.
		 * @return string $epofw_value Return html for color data.
		 */
		public function epofw_render_color( $get_epofw_value ) {
			$epofw_value = '';
			if ( ! empty( $get_epofw_value ) ) {
				// Sanitize and escape the color value.
				$safe_color = sanitize_hex_color( $get_epofw_value );
				if ( ! $safe_color ) {
					$safe_color = sanitize_text_field( $get_epofw_value );
				}

				$epofw_value .= sprintf(
					'<span style="color:%1$s;font-size: 20px;padding: 0;line-height: 0">■</span>&nbsp;',
					esc_attr( $safe_color )
				);
				$epofw_value .= '</span>';

				// Escape the value before adding to filter.
				/**
				 * Apply filter for render color code.
				 *
				 * @since 1.0.0
				 */
				$epofw_value .= apply_filters( 'epofw_render_color_code', esc_html( $get_epofw_value ) );
			}

			/**
			 * Apply filter for render color html.
			 *
			 * @since 1.0.0
			 */
			return apply_filters( 'epofw_render_color_html', $epofw_value, esc_html( $get_epofw_value ) );
		}

		/**
		 * Add field in order meta.
		 *
		 * @since    1.0.0
		 *
		 * @param mixed  $item          Item of cart.
		 * @param string $cart_item_key key of cart item.
		 * @param array  $values        Array of cart values.
		 *
		 * @throws Exception Get error.
		 */
		public function checkout_create_order_line_item( $item, $cart_item_key, $values ) {
			$check_epofw_data = epofw_check_array_key_exists( 'epofw_data', $values );
			if ( ! empty( $check_epofw_data ) && is_array( $check_epofw_data ) ) {
				foreach ( $check_epofw_data as $epofw_data_value ) {
					$epofw_data_name = epofw_check_array_key_exists( 'epofw_name', $epofw_data_value );
					$epofw_value     = epofw_check_array_key_exists( 'epofw_value', $epofw_data_value );
					if ( ! empty( $epofw_value ) ) {
						$new_check_epofw_data                     = array();
						$new_check_epofw_data[ $epofw_data_name ] = $epofw_data_value;
						$item->add_meta_data( $epofw_data_name, wp_json_encode( $new_check_epofw_data ) );
					}
				}
			}
		}

		/**
		 * Display meta value in cart section.
		 *
		 * @since 1.0.0
		 *
		 * @param string $display_value Display value in cart.
		 * @param object $meta          Object of cart data.
		 * @param array  $item          Array of cart item data.
		 *
		 * @throws Exception Get error.
		 * @return string Return moxed data.
		 */
		public function epofw_display_meta_value( $display_value, $meta = null, $item = null ) {
			$out_display_value = '';
			if ( '' !== $item && '' !== $meta ) {
				$product_id         = $item['product_id'];
				$get_field_id_arr   = $this->epofw_find_match_id( $product_id );
				$fields_data_arr    = $this->epofw_get_match_data_from_db( $get_field_id_arr );
				$get_field_name_arr = $this->epofw_get_field_name_from_data( $fields_data_arr, array() );
				if ( is_array( json_decode( $meta->value, true ) ) ) {
					$meta_value_data = json_decode( $meta->value, true );
					if ( ! empty( $meta_value_data ) ) {
						foreach ( $meta_value_data as $meta_value_details ) {
							if ( isset( $meta_value_details['epofw_type'] ) && 'colorpicker' === $meta_value_details['epofw_type'] ) {
								if ( isset( $meta_value_details['epofw_value'] ) && ! empty( $meta_value_details['epofw_value'] ) ) {
									$out_display_value .= $this->epofw_render_color( $meta_value_details['epofw_value'] );
								}
							} else {
								$out_display_value = isset( $meta_value_details['epofw_value'] ) ? $meta_value_details['epofw_value'] : '';
							}
						}
					}
				} else {
					$get_type = isset( $get_field_name_arr[ $meta->key ]['field'] ) && isset( $get_field_name_arr[ $meta->key ]['field']['type'] ) ? $get_field_name_arr[ $meta->key ]['field']['type'] : '';
					if ( isset( $get_type ) && 'colorpicker' === $get_type ) {
						if ( isset( $meta->value ) && ! empty( $meta->value ) ) {
							$out_display_value .= $this->epofw_render_color( $meta->value );
						}
					} else {
						$out_display_value = $display_value;
					}
				}

				/**
				 * Apply filter for order item display meta value.
				 *
				 * @since 1.0.0
				 */
				return apply_filters( 'epofw_order_item_display_meta_value', $out_display_value, $display_value, $item );
			}
		}

		/**
		 * Add field in order meta.
		 *
		 * @since    1.0.0
		 *
		 * @param array  $cart_item_data Array of cart items.
		 * @param object $item           Object of item.
		 *
		 * @throws Exception Get error.
		 * @return array $cart_item_data
		 */
		public function epofw_order_again_cart_item_data_pro( $cart_item_data, $item ) {
			if ( $item ) {
				$product_id         = $item->get_product_id();
				$get_field_id_arr   = $this->epofw_find_match_id( $product_id );
				$fields_data_arr    = $this->epofw_get_match_data_from_db( $get_field_id_arr );
				$get_field_name_arr = $this->epofw_get_field_name_from_data( $fields_data_arr, array() );
				$meta_data          = $item->get_meta_data();
				$new_item_data_arr  = array();
				if ( ! empty( $meta_data ) ) {
					foreach ( $meta_data as $meta_data_value ) {
						if ( is_array( json_decode( $meta_data_value->value, true ) ) ) {
							$meta_value_data = json_decode( $meta_data_value->value, true );
							if ( array_key_exists( $meta_data_value->key, $meta_value_data ) ) {
								$addon_value                      = $meta_value_data[ $meta_data_value->key ]['epofw_value'];
								$data_arr                         = array();
								$data_arr['epofw_name']           = $meta_data_value->key;
								$data_arr['epofw_label']          = $meta_value_data[ $meta_data_value->key ]['epofw_form_data']['label']['title'];
								$data_arr['epofw_value']          = $addon_value;
								$data_arr['epofw_price']          = $meta_value_data[ $meta_data_value->key ]['epofw_price'];
								$data_arr['epofw_original_price'] = epofw_price_filter( $meta_value_data[ $meta_data_value->key ]['epofw_original_price'] );
								$data_arr['epofw_price_type']     = 'fixed';
								$data_arr['epofw_type']           = $meta_value_data[ $meta_data_value->key ]['epofw_form_data']['field']['type'];
								if ( isset( $meta_value_data[ $meta_data_value->key ]['epofw_form_data']['common'] ) ) {
									$data_arr['epofw_form_data']['common'] = $meta_value_data[ $meta_data_value->key ]['epofw_form_data']['common'];
								}
								if ( isset( $meta_value_data[ $meta_data_value->key ]['epofw_form_data']['epofw_field_settings'] ) ) {
									$data_arr['epofw_form_data']['epofw_field_settings'] = $meta_value_data[ $meta_data_value->key ]['epofw_form_data']['epofw_field_settings'];
								}
								$new_item_data_arr[ $meta_data_value->key ] = $data_arr;
							}
						} elseif ( array_key_exists( $meta_data_value->key, $get_field_name_arr ) ) {
							$get_display_key                       = $this->epofw_get_addon_title_pro( $get_field_name_arr, $meta_data_value->key );
							$data_arr                              = array();
							$data_arr['epofw_name']                = $meta_data_value->key;
							$data_arr['epofw_label']               = $get_field_name_arr[ $meta_data_value->key ]['label']['title'];
							$data_arr['epofw_value']               = $meta_data_value->value;
							$data_arr['epofw_price']               = epofw_price_filter( $get_display_key['epofw_price'] );
							$data_arr['epofw_original_price']      = epofw_price_filter( $get_display_key['epofw_price'] );
							$data_arr['epofw_price_type']          = 'fixed';
							$data_arr['epofw_type']                = $get_field_name_arr[ $meta_data_value->key ]['field']['type'];
							$data_arr['epofw_form_data']['common'] = $get_field_name_arr[ $meta_data_value->key ]['common'];

							$data_arr['epofw_form_data']['epofw_field_settings'] = $get_field_name_arr[ $meta_data_value->key ]['epofw_field_settings'];
							$new_item_data_arr[ $meta_data_value->key ]          = $data_arr;
						}
					}
				}
				$cart_item_data['epofw_data'] = $new_item_data_arr;
			}

			return $cart_item_data;
		}

		/**
		 * Get field name from data.
		 *
		 * @since    1.0.0
		 *
		 * @param array $fields_data_arr Array of fields data which fetched from DB.
		 * @param array $post_data       Array of post data.
		 *
		 * @throws Exception Get error.
		 * @return array $new_field_array
		 */
		public function epofw_get_field_name_from_data( $fields_data_arr, $post_data = array() ) {
			$new_field_array = array();
			if ( ! empty( $fields_data_arr ) ) {
				foreach ( $fields_data_arr as $sub_fields_data_arr ) {
					$fields_value_data_arr = epofw_check_array_key_exists( 'general', $sub_fields_data_arr );
					if ( ! empty( $fields_value_data_arr ) ) {
						foreach ( $fields_value_data_arr as $fields_value_data ) {
							$check_field = epofw_check_array_key_exists( 'field', $fields_value_data );
							if ( $check_field ) {
								$check_field_name = epofw_check_array_key_exists( 'name', $check_field );
								if ( $check_field_name ) {
									if ( strpos( $check_field_name, 'epofw_field_' ) === false ) {
										$check_field_name = 'epofw_field_' . $check_field_name;
									}
								}
								if ( ! empty( $post_data ) ) {
									$new_field_array[ $check_field_name ] = $fields_value_data;
								}
							}
						}
					}
				}
			}
			$new1 = array();
			if ( $new_field_array ) {
				if ( ! empty( $post_data ) ) {
					foreach ( $post_data as $post_data_key => $post_data_value ) {
						if ( isset( $new_field_array[ $post_data_key ] ) ) {
							if ( isset( $post_data_value['value'] ) && ! empty( $post_data_value['value'] ) ) {
								$new1[ $post_data_key ] = $new_field_array[ $post_data_key ];
							}
						}
					}
				}
			}

			return $new1;
		}

		/**
		 * Formatted meta data.
		 *
		 * @since 1.0.0
		 *
		 * @param array $formatted_meta Array of meta data.
		 * @param array $order_item     Array of Order data.
		 *
		 * @throws Exception Get error.
		 * @return array $formatted_meta
		 */
		public function epofw_item_get_formatted_meta_data_pro( $formatted_meta, $order_item ) {
			if ( $order_item ) {
				$product_id         = $order_item['product_id'];
				$get_field_id_arr   = $this->epofw_find_match_id( $product_id );
				$fields_data_arr    = $this->epofw_get_match_data_from_db( $get_field_id_arr );
				$get_field_name_arr = $this->epofw_get_field_name_from_data( $fields_data_arr, array() );
				foreach ( $formatted_meta as $key => $meta ) {
					if ( is_array( json_decode( $meta->value, true ) ) ) {
						$meta_value_data = json_decode( $meta->value, true );
						if ( isset( $meta_value_data[ $meta->key ] ) ) {
							$get_display_key = $this->epofw_get_addon_title_pro( $meta_value_data, $meta->key );
							/**
							 * Apply filters for get formatted display value.
							 *
							 * @since 1.0.0
							 */
							$meta->display_value = apply_filters( 'epofw_item_get_formatted_meta_display_value', $meta->display_value, $meta_value_data[ $meta->key ], $formatted_meta, $order_item, $get_field_name_arr );
							if ( ! empty( $get_display_key['epofw_label'] ) ) {
								$formatted_meta[ $key ] = (object) array(
									'key'           => $meta->key,
									'value'         => $meta->value,
									'display_key'   => $get_display_key['epofw_label'],
									'display_value' => $meta->display_value, // $addon_value. // If we use this $meta->display_value then if we have multiple option then last option display in the all options.
								);
							} else {
								unset( $formatted_meta[ $key ] );
							}
						} else {
							unset( $formatted_meta[ $key ] );
						}
					} elseif ( array_key_exists( $meta->key, $get_field_name_arr ) ) {
						$get_display_key = $this->epofw_get_addon_title_pro( $get_field_name_arr, $meta->key );
						if ( ! empty( $get_display_key['epofw_label'] ) ) {
							$formatted_meta[ $key ] = (object) array(
								'key'           => $meta->key,
								'value'         => $meta->value,
								'display_key'   => $get_display_key['epofw_label'],
								'display_value' => $meta->display_value,
							);
						} else {
							unset( $formatted_meta[ $key ] );
						}
					}
				}
			}

			return $formatted_meta;
		}

		/**
		 * Get Addon label name and price for order detail on the front side.
		 * Retrieves the addon label name and price based on the provided parameters.
		 *
		 * @since 1.0.0
		 *
		 * @param array  $get_field_name_arr Array of meta data.
		 * @param string $meta_key           Meta key.
		 *
		 * @return array $epofw_label and $opt_price Return label and Price for addon.
		 */
		public function epofw_get_addon_title_pro( $get_field_name_arr, $meta_key ) {
			if ( ! empty( $meta_key ) ) {
				$check_epofw_form_data = epofw_check_array_key_exists( 'epofw_form_data', $get_field_name_arr[ $meta_key ] );
				$check_field_input     = epofw_check_array_key_exists( 'field', $check_epofw_form_data );
				$opt_price             = '';
				$opt_price_type        = 'fixed';
				if ( $check_field_input ) {
					$check_addon_price = epofw_check_array_key_exists( 'epofw_price', $get_field_name_arr[ $meta_key ] );
					$opt_price         = 0;
					if ( $check_addon_price ) {
						$opt_price = $check_addon_price;
					}
				}
				$epofw_label = '';
				$check_label = epofw_check_array_key_exists( 'label', $check_epofw_form_data );
				if ( $check_label ) {
					$check_title = epofw_check_array_key_exists( 'title', $check_label );
					if ( $check_title ) {
						$epofw_label  = $check_title;
						$epofw_label .= ' (' . wc_price( epofw_price_filter( $opt_price ) ) . ')';
					}
				}

				return array(
					'epofw_label'      => $epofw_label,
					'epofw_price'      => $opt_price,
					'epofw_price_type' => $opt_price_type,
				);
			}
		}

		/**
		 * Error message.
		 *
		 * @since 1.0.0
		 *
		 * @param string $filter_name   Filter name.
		 * @param string $error_message Error Message.
		 */
		public function epofw_add_to_cart_error_msg( $filter_name, $error_message ) {
			wc_add_notice(
			/**
			 * Apply filter for error message.
			 *
			 * @since 1.0.0
			 */
				apply_filters(
					'epofw_' . $filter_name . '_field_error_msg',
					$error_message
				),
				'error'
			);
		}

		/**
		 * Function will check cart item price.
		 *
		 * @since    1.0.0
		 *
		 * @param int|float $product_price  Product price.
		 * @param array     $cart_item_data Cart item data.
		 *
		 * @return string
		 */
		public function epofw_woocommerce_cart_item_price( $product_price, $cart_item_data ) {
			// Set without tax price becaue wc_get_price_to_display function will calucalte tax based on original price.
			if ( isset( $cart_item_data['epofw_product_price_without_tax'] ) ) {
				$product_price = wc_price(
					wc_get_price_to_display(
						$cart_item_data['data'],
						array(
							'price' => $cart_item_data['epofw_product_price_without_tax'],
						)
					)
				);
			}

			return $product_price;
		}

		/**
		 * Function will fires after add cart item data filter.
		 *
		 * @since    1.0.0
		 *
		 * @param array $cart_item_data Cart item meta data.
		 *
		 * @return array
		 */
		public function epofw_add_cart_item( $cart_item_data ) {
			$prices = epofw_product_price( $cart_item_data );

			return $this->epofw_set_product_price( $cart_item_data, $cart_item_data['quantity'], $prices );
		}

		/**
		 * Function will set product price.
		 *
		 * @since    1.0.0
		 *
		 * @param array $cart_item_data Cart item data.
		 * @param int   $quantity       Product quantity.
		 * @param array $prices         Prices array.
		 *
		 * @return array
		 */
		public function epofw_set_product_price( $cart_item_data, $quantity, $prices ) {
			if ( ! empty( $cart_item_data['epofw_data'] ) ) {
				/**
				 * Apply filter for price without tax.
				 *
				 * @since 1.0.0
				 */
				$price_without_tax = apply_filters( 'epofw_original_price_without_tax', $prices['price_without_tax'], $cart_item_data );
				/**
				 * Apply filter for regular price without tax.
				 *
				 * @since 1.0.0
				 */
				$regular_price_without_tax = apply_filters( 'epofw_original_regular_price_without_tax', $prices['regular_price_without_tax'], $cart_item_data );
				/**
				 * Apply filter for sale price without tax.
				 *
				 * @since 1.0.0
				 */
				$sale_price_without_tax = apply_filters( 'epofw_original_sale_price_without_tax', $prices['sale_price_without_tax'], $cart_item_data );
				/**
				 * Apply filter for price before calculation.
				 *
				 * @since 1.0.0
				 */
				$price = apply_filters( 'epofw_price_before_calculation', $prices['price'], $cart_item_data );
				/**
				 * Apply filter for regular price before calculation.
				 *
				 * @since 1.0.0
				 */
				$regular_price = apply_filters( 'epofw_regular_price_before_calculation', $prices['regular_price'], $cart_item_data );
				/**
				 * Apply filter for sale price before calculation.
				 *
				 * @since 1.0.0
				 */
				$sale_price = apply_filters( 'epofw_sale_price_before_calculation', $prices['sale_price'], $cart_item_data );

				$cart_item_data['epofw_product_price_without_tax']  = (float) $price_without_tax;
				$cart_item_data['epofw_regular_price_without_tax']  = (float) $regular_price_without_tax;
				$cart_item_data['epofw_sale_price_without_tax']     = (float) $sale_price_without_tax;
				$cart_item_data['addons_price_before_calc']         = (float) $price;
				$cart_item_data['addons_regular_price_before_calc'] = (float) $regular_price;
				$cart_item_data['addons_sale_price_before_calc']    = (float) $sale_price;
				/**
				 * Apply filter for set product price.
				 *
				 * @since 1.0.0
				 */
				$price = apply_filters( 'epofw_set_product_price_after', $price, $quantity );
				/**
				 * Apply filter for set product regular price.
				 *
				 * @since 1.0.0
				 */
				$regular_price = apply_filters( 'epofw_set_product_regular_price_after', $regular_price, $quantity );
				/**
				 * Apply filter for set product sale price.
				 *
				 * @since 1.0.0
				 */
				$sale_price = apply_filters( 'epofw_set_product_sale_price_after', $sale_price, $quantity );
				if ( ! empty( $cart_item_data ) && isset( $cart_item_data['epofw_data'] ) ) {
					$addon_price = 0;
					foreach ( $cart_item_data['epofw_data'] as $addon ) {
						// We will not add option field's price into product for cart if that option have enable wc tax option. ( Enable WooCommerce Options - Enable Addon Tax ).
						if ( isset( $addon['epofw_original_price'] ) ) {
							$addon_original_price = epofw_calculated_price_based_on_condition( $addon['epofw_original_price'], $addon['epofw_price_type'], $price );
							$addon_price         += $addon_original_price * $quantity;
						}
					}
					$updated_addon_price = (float) ( $addon_price / $quantity ); // $addon_price;
					/**
					 * Apply filter for set addon price.
					 *
					 * @since 1.0.0
					 */
					$updated_addon_price = apply_filters( 'epofw_set_addon_price_after', $updated_addon_price, $addon_price, false, $quantity );
					$price              += $updated_addon_price;
					$regular_price      += $updated_addon_price;
					$sale_price         += $updated_addon_price;
				}
				$cart_item_data['data']->set_price( $price );
				$has_regular_price = is_numeric( $cart_item_data['data']->get_regular_price( 'edit' ) );
				if ( $has_regular_price ) {
					$cart_item_data['data']->set_regular_price( $regular_price );
				}
				$has_sale_price = is_numeric( $cart_item_data['data']->get_sale_price( 'edit' ) );
				if ( $has_sale_price ) {
					$cart_item_data['data']->set_sale_price( $sale_price );
				}
			}

			return $cart_item_data;
		}

		/**
		 * Get cart item from session.
		 *
		 * @since    1.0.0
		 *
		 * @param array $cart_item_data Cart item data.
		 * @param array $values         Addon fields data.
		 *
		 * @return array
		 */
		public function epofw_get_cart_item_from_session( $cart_item_data, $values ) {
			if ( ! empty( $values['epofw_data'] ) ) {
				$prices                       = epofw_product_price( $cart_item_data );
				$cart_item_data['epofw_data'] = $values['epofw_data'];
				$cart_item_data               = $this->epofw_set_product_price( $cart_item_data, $cart_item_data['quantity'], $prices );
			}

			return $cart_item_data;
		}

		/**
		 * Function will update price when quantity update.
		 *
		 * @since    1.0.0
		 *
		 * @param string $cart_item_key Cart item key.
		 * @param int    $quantity      Updated product quantity.
		 * @param int    $old_quantity  Old product quantity.
		 * @param object $cart          Cart data.
		 *
		 * @return array|void
		 */
		public function epofw_update_price_on_quantity_update( $cart_item_key, $quantity, $old_quantity, $cart ) {
			$cart_item_data = $cart->get_cart_item( $cart_item_key );
			if ( ! empty( $cart_item_data['epofw_data'] ) ) {
				$prices = array(
					'price'                     => $cart_item_data['addons_price_before_calc'],
					'regular_price'             => $cart_item_data['addons_regular_price_before_calc'],
					'sale_price'                => $cart_item_data['addons_sale_price_before_calc'],
					'price_without_tax'         => $cart_item_data['epofw_product_price_without_tax'],
					'regular_price_without_tax' => $cart_item_data['epofw_regular_price_without_tax'],
					'sale_price_without_tax'    => $cart_item_data['epofw_sale_price_without_tax'],
				);

				return $this->epofw_set_product_price( $cart_item_data, $quantity, $prices );
			}
		}
	}
}
