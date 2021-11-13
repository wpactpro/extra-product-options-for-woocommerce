<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Extra_Product_Options_For_WooCommerce
 * @subpackage Extra_Product_Options_For_WooCommerce/includes
 */
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * EPOFW_Field_Setting class.
 */
if ( ! class_exists( 'EPOFW_Field_Setting' ) ) {
	/**
	 * EPOFW_Field_Setting class.
	 */
	class EPOFW_Field_Setting {
		protected static $_instance = null;
		/**
		 * Post type.
		 *
		 * @var $post_type Store post type.
		 *
		 * @since 1.0.0
		 */
		private static $post_type = null;
		/**
		 * Admin object call.
		 *
		 * @var      string $epofw_admin_obj The class of external plugin.
		 *
		 * @since    1.0.0
		 */
		private static $epofw_admin_obj = null;
		/**
		 * Get current page.
		 *
		 * @var $current_page Store current page.
		 *
		 * @since 1.0.0
		 */
		private static $current_page = null;
		/**
		 * Get current tab.
		 *
		 * @var $current_tab Store current tab.
		 *
		 * @since 1.0.0
		 */
		private static $current_tab = null;
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
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			self::$epofw_admin_obj = new EPOFW_Admin();
			self::$current_page    = self::$epofw_admin_obj->epofw_current_page();
			self::$current_tab     = self::$epofw_admin_obj->epofw_current_tab();
			self::$post_type       = EPOFW_DFT_POST_TYPE;
			add_action( 'add_new_btn_prd_list', array( $this, 'add_new_btn_prd_list_fn' ), 10, 2 );
		}
		/**
		 * Display output.
		 *
		 * @since    1.0.0
		 *
		 * @uses     epofw_save_method
		 * @uses     epofw_add_product_option_form
		 * @uses     epofw_edit_method_screen
		 * @uses     epofw_delete_method
		 * @uses     epofw_duplicate_method
		 * @uses     epofw_list_methods_screen
		 * @uses     EPOFW_Admin::epofw_updated_message()
		 */
		public static function epofw_output() {
			$action          = filter_input( INPUT_GET, 'action', FILTER_SANITIZE_STRING );
			$post_id_request = filter_input( INPUT_GET, 'post', FILTER_SANITIZE_NUMBER_INT );
			$epofw_nonce     = filter_input( INPUT_GET, 'epofw_nonce', FILTER_SANITIZE_STRING );
			$get_epofw_add   = filter_input( INPUT_GET, '_wpnonce', FILTER_SANITIZE_STRING );
			$get_tab         = filter_input( INPUT_GET, 'tab', FILTER_SANITIZE_STRING );
			$message         = filter_input( INPUT_GET, 'message', FILTER_SANITIZE_STRING );
			if ( isset( $action ) && ! empty( $action ) ) {
				if ( 'add' === $action ) {
					self::epofw_save_method();
					self::epofw_add_product_option_form();
				} elseif ( 'edit' === $action ) {
					if ( isset( $epofw_nonce ) && ! empty( $epofw_nonce ) ) {
						$getnonce = wp_verify_nonce( $epofw_nonce, 'edit_' . $post_id_request );
						if ( isset( $getnonce ) && 1 === $getnonce ) {
							self::epofw_edit_method_screen( $post_id_request );
						} else {
							wp_safe_redirect(
								add_query_arg(
									array(
										'page' => 'epofw-start-page',
										'tab'  => 'extra_product_option',
									),
									admin_url( 'admin.php' )
								)
							);
							exit;
						}
					} elseif ( isset( $get_epofw_add ) && ! empty( $get_epofw_add ) ) {
						if ( ! wp_verify_nonce( $get_epofw_add, 'epofw_add' ) ) {
							$message = 'nonce_check';
						} else {
							self::epofw_edit_method_screen( $post_id_request );
						}
					}
				} elseif ( 'delete' === $action ) {
					self::epofw_delete_method( $post_id_request );
				} elseif ( 'duplicate' === $action ) {
					self::epofw_duplicate_method( $post_id_request );
				} else {
					self::epofw_list_methods_screen();
				}
			} else {
				self::epofw_list_methods_screen();
			}
			if ( isset( $message ) && ! empty( $message ) ) {
				self::$epofw_admin_obj->epofw_updated_message( $message, $get_tab, '' );
			}
		}
		/**
		 * Delete Field Option.
		 *
		 * @param int $id Get Field Option id.
		 *
		 * @uses     Extra_Product_Options_For_WooCommerce::epofw_updated_message()
		 *
		 * @since    1.0.0
		 */
		public function epofw_delete_method( $id ) {
			$epofw_nonce = filter_input( INPUT_GET, 'epofw_nonce', FILTER_SANITIZE_STRING );
			$get_tab     = filter_input( INPUT_GET, 'tab', FILTER_SANITIZE_STRING );
			$getnonce    = wp_verify_nonce( $epofw_nonce, 'del_' . $id );
			if ( isset( $getnonce ) && 1 === $getnonce ) {
				wp_delete_post( $id );
				$delet_action_redirect_url = self::$epofw_admin_obj->dynamic_url( self::$current_page, self::$current_tab, '', '', '', 'deleted' );
				wp_safe_redirect( $delet_action_redirect_url );
				exit;
			} else {
				self::$epofw_admin_obj->epofw_updated_message( 'nonce_check', $get_tab, '' );
			}
		}
		/**
		 * Duplicate Field Option.
		 *
		 * @param int $id Get Field Option id.
		 *
		 * @uses     Extra_Product_Options_For_WooCommerce::epofw_updated_message()
		 *
		 * @since    1.0.0
		 */
		public function epofw_duplicate_method( $id ) {
			$epofw_nonce = filter_input( INPUT_GET, 'epofw_nonce', FILTER_SANITIZE_STRING );
			$get_tab     = filter_input( INPUT_GET, 'tab', FILTER_SANITIZE_STRING );
			$getnonce    = wp_verify_nonce( $epofw_nonce, 'duplicate_' . $id );
			$epofw_add   = wp_create_nonce( 'epofw_add' );
			$post_id     = isset( $id ) ? absint( $id ) : '';
			$new_post_id = '';
			if ( isset( $getnonce ) && 1 === $getnonce ) {
				if ( ! empty( $post_id ) || '' !== $post_id ) {
					$post            = get_post( $post_id );
					$current_user    = wp_get_current_user();
					$new_post_author = $current_user->ID;
					if ( isset( $post ) && null !== $post ) {
						$args           = array(
							'comment_status' => $post->comment_status,
							'ping_status'    => $post->ping_status,
							'post_author'    => $new_post_author,
							'post_content'   => $post->post_content,
							'post_excerpt'   => $post->post_excerpt,
							'post_name'      => $post->post_name,
							'post_parent'    => $post->post_parent,
							'post_password'  => $post->post_password,
							'post_status'    => 'draft',
							'post_title'     => $post->post_title . '-duplicate',
							'post_type'      => self::$post_type,
							'to_ping'        => $post->to_ping,
							'menu_order'     => $post->menu_order,
						);
						$new_post_id    = wp_insert_post( $args );
						$post_meta_data = get_post_meta( $post_id );
						if ( 0 !== count( $post_meta_data ) ) {
							foreach ( $post_meta_data as $meta_key => $meta_data ) {
								if ( '_wp_old_slug' === $meta_key ) {
									continue;
								}
								if ( is_array( $meta_data[0] ) ) {
									$meta_value = maybe_unserialize( $meta_data[0] );
								} else {
									$meta_value = $meta_data[0];
								}
								update_post_meta( $new_post_id, $meta_key, $meta_value );
							}
						}
					}
					$duplicat_action_redirect_url = self::$epofw_admin_obj->dynamic_url( self::$current_page, self::$current_tab, 'edit', $new_post_id, esc_attr( $epofw_add ), 'duplicated' );
					wp_safe_redirect( $duplicat_action_redirect_url );
					exit();
				} else {
					$action_redirect_url = self::$epofw_admin_obj->dynamic_url( self::$current_page, self::$current_tab, '', '', '', 'failed' );
					wp_safe_redirect( $action_redirect_url );
					exit();
				}
			} else {
				self::$epofw_admin_obj->epofw_updated_message( 'nonce_check', $get_tab, '' );
			}
		}
		/**
		 * Count total Field Option.
		 *
		 * @return int $count_method Count total Field Option ID.
		 *
		 * @since    1.0.0
		 */
		public static function cposmp_sm_count_method() {
			$product_option_args = array(
				'post_type'      => self::$post_type,
				'post_status'    => array( 'publish', 'draft' ),
				'posts_per_page' => - 1,
				'orderby'        => 'ID',
				'order'          => 'DESC',
			);
			$sm_post_query       = new WP_Query( $product_option_args );
			$product_option_list = $sm_post_query->posts;
			return count( $product_option_list );
		}
		/**
		 * Save Field Option when add or edit.
		 *
		 * @param int $method_id Product Field id.
		 *
		 * @return bool false when nonce is not verified.
		 * @uses     cposmp_sm_count_method()
		 *
		 * @since    1.0.0
		 *
		 * @uses     Extra_Product_Options_For_WooCommerce::epofw_updated_message()
		 */
		private static function epofw_save_method( $method_id = 0 ) {
			$action                        = filter_input( INPUT_GET, 'action', FILTER_SANITIZE_STRING );
			$epofw_save                    = filter_input( INPUT_POST, 'epofw_save', FILTER_SANITIZE_STRING );
			$woocommerce_save_method_nonce = filter_input( INPUT_POST, 'woocommerce_save_method_nonce', FILTER_SANITIZE_STRING );
			if ( ( isset( $action ) && ! empty( $action ) ) ) {
				if ( isset( $epofw_save ) ) {
					if ( empty( $woocommerce_save_method_nonce ) || ! wp_verify_nonce( sanitize_text_field( $woocommerce_save_method_nonce ), 'woocommerce_save_method' ) ) {
						esc_html_e( 'Error with security check.', 'extra-product-options-for-woocommerce' );
						return false;
					}
					$epofw_data            = filter_input( INPUT_POST, 'epofw_data', FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY );
					$epofw_shipping_status = "";
					$post_title            = '';
					$new_epofw_data = array();
					if ( ! empty( $epofw_data ) ) {
						foreach ( $epofw_data as $epofw_key => $epofw_sub_data ) {
							if ( 'general' === $epofw_key ) {
								foreach ( $epofw_sub_data as $epofw_field_key => $epofw_field_value ) {
									foreach ( $epofw_field_value as $field_key => $field_value ) {
										if ( is_array( $field_value ) ) {
											foreach ( $field_value as $key => $gn_value ) {
												$new_field_op_arr = array();
												if ( $key === 'class' ) {
													unset( $new_epofw_data['general'][ $epofw_field_key ][ $field_key ][ $key ] );
													$modified_class    = $gn_value;
													$field_restriction = epofw_check_array_key_exists( 'field_restriction', $field_value );
													if ( $field_restriction ) {
														$modified_class .= '||epofw_' . $field_restriction;
													}
													$new_epofw_data['general'][ $epofw_field_key ][ $field_key ][ $key ] = $modified_class;
												} elseif ( $key === 'options' ) {
													$gn_label_value = epofw_check_array_key_exists( 'label', $gn_value );
													if ( $gn_label_value ) {
														foreach ( $gn_label_value as $l_key => $l_value ) {
															$gn_opt_price = epofw_check_array_key_exists( 'opt_price', $gn_value );
															if ( $gn_opt_price ) {
																foreach ( $gn_opt_price as $gop_key => $gop_value ) {
																	$gn_opt_price_type = epofw_check_array_key_exists( 'opt_price_type', $gn_value );
																	if ( $gn_opt_price_type ) {
																		foreach ( $gn_opt_price_type as $gopt_key => $gopt_value ) {
																			if ( $l_key === $gop_key
																			     && $l_key === $gopt_key
																			     && $gop_key === $gopt_key ) {
																				$new_field_op_arr[ $l_value ] = $gopt_value . "||" . $gop_value;
																			}
																		}
																	}
																}
															}
														}
													}
													$new_epofw_data['general'][ $epofw_field_key ][ $field_key ][ $key ] = $new_field_op_arr;
												} elseif ( 'name' === $key ) {
													if ( empty( $gn_value ) ) {
														$new_epofw_data['general'][ $epofw_field_key ][ $field_key ][ $key ] = 'epofw_' . $field_key . '_' . wp_rand();
													} else {
														$new_epofw_data['general'][ $epofw_field_key ][ $field_key ][ $key ] = $gn_value;
													}
												} else {
													$new_epofw_data['general'][ $epofw_field_key ][ $field_key ][ $key ] = $gn_value;
												}
											}
										}
									}
								}
							} else if ( 'additional_rule_data' === $epofw_key ) {
								$new_epofw_data['additional_rule_data'] = $epofw_data['additional_rule_data'];
							} else {
								if ( 'epofw_addon_name' === $epofw_key ) {
									$post_title = $epofw_sub_data;
								} else if ( 'epofw_addon_status' === $epofw_key ) {
									$epofw_shipping_status = $epofw_sub_data;
								}
								$new_epofw_data[ $epofw_key ] = $epofw_sub_data;
							}
						}
					}
					$product_option_count = self::cposmp_sm_count_method();
					$method_id            = (int) $method_id;
					if ( isset( $epofw_shipping_status ) && 'on' === $epofw_shipping_status ) {
						$post_status = 'publish';
					} else {
						$post_status = 'draft';
					}
					if ( '' !== $method_id && 0 !== $method_id ) {
						$fee_post  = array(
							'ID'          => $method_id,
							'post_title'  => $post_title,
							'post_status' => $post_status,
							'menu_order'  => $product_option_count + 1,
							'post_type'   => self::$post_type,
						);
						$method_id = wp_update_post( $fee_post );
					} else {
						$fee_post  = array(
							'post_title'  => $post_title,
							'post_status' => $post_status,
							'menu_order'  => $product_option_count + 1,
							'post_type'   => self::$post_type,
						);
						$method_id = wp_insert_post( $fee_post );
					}
					if ( '' !== $method_id && 0 !== $method_id ) {
						if ( $method_id > 0 ) {
							update_post_meta( $method_id, 'epofw_prd_opt_data', wp_json_encode( $new_epofw_data ) );
						}
					} else {
						echo '<div class="updated error"><p>' . esc_html__( 'Error saving Product Option.', 'extra-product-options-for-woocommerce' ) . '</p></div>';
						return false;
					}
					$epofw_add = wp_create_nonce( 'epofw_add' );
					if ( 'add' === $action ) {
						$add_action_redirect_url = self::$epofw_admin_obj->dynamic_url( self::$current_page, self::$current_tab, 'edit', $method_id, esc_attr( $epofw_add ), 'created' );
						wp_safe_redirect( $add_action_redirect_url );
						exit();
					}
					if ( 'edit' === $action ) {
						$edit_action_redirect_url = self::$epofw_admin_obj->dynamic_url( self::$current_page, self::$current_tab, 'edit', $method_id, esc_attr( $epofw_add ), 'saved' );
						wp_safe_redirect( $edit_action_redirect_url );
						exit();
					}
				}
			}
		}
		/**
		 * Edit Product Option screen.
		 *
		 * @param string $id Get Product Option id.
		 *
		 * @uses     epofw_save_method()
		 * @uses     epofw_edit_method()
		 *
		 * @since    1.0.0
		 */
		public static function epofw_edit_method_screen( $id ) {
			self::epofw_save_method( $id );
			self::epofw_edit_method();
		}
		/**
		 * Edit Product Option.
		 *
		 * @since    1.0.0
		 */
		public static function epofw_edit_method() {
			include EPOFW_PLUGIN_DIR . '/settings/epofw-admin-settings.php';
		}
		/**
		 * Add new button in Product Option list section.
		 *
		 * @param string $link_method_url Link method url.
		 *
		 * @param string $text            button text.
		 */
		public function add_new_btn_prd_list_fn( $link_method_url, $text ) {
			?>
			<a href="<?php echo esc_url( $link_method_url ); ?>"
			   class="page-title-action"><?php echo esc_html( $text ); ?>
			</a>
			<?php
		}
		/**
		 * List_product_options function.
		 *
		 * @since    1.0.0
		 *
		 * @uses     EPOFW_Field_Table class
		 * @uses     EPOFW_Field_Table::process_bulk_action()
		 * @uses     EPOFW_Field_Table::prepare_items()
		 * @uses     EPOFW_Field_Table::search_box()
		 * @uses     EPOFW_Field_Table::display()
		 */
		public static function epofw_list_methods_screen() {
			if ( ! class_exists( 'EPOFW_Field_Table' ) ) {
				require_once EPOFW_PLUGIN_DIR . '/includes/class-epofw-field-table.php';
			}
			$link_method_url = self::$epofw_admin_obj->dynamic_url( self::$current_page, self::$current_tab, 'add', '', '', '' );
			?>
			<h1 class="wp-heading-inline">
				<?php
				echo esc_html( esc_html__( 'Field Listing', 'extra-product-options-for-woocommerce' ) );
				?>
			</h1>
			<?php
			do_action( 'before_add_new_btn_prd_list' );
			do_action( 'add_new_btn_prd_list', $link_method_url, esc_html__( 'Add New', 'extra-product-options-for-woocommerce' ) );
			do_action( 'after_add_new_btn_prd_list' );
			$request_s = filter_input( INPUT_POST, 's', FILTER_SANITIZE_STRING );
			if ( isset( $request_s ) && ! empty( $request_s ) ) {
				?>
				<span class="subtitle">
					<?php
					esc_html_e( 'Search results for ', 'extra-product-options-for-woocommerce' ) . '&#8220;' . esc_html( $request_s ) . '&#8221;';
					?>
				</span>
				<?php
			}
			?>
			<hr class="wp-header-end">
			<?php
			$wc_product_options_table = new EPOFW_Field_Table();
			$wc_product_options_table->process_bulk_action();
			$wc_product_options_table->prepare_items();
			$wc_product_options_table->search_box(
				esc_html__(
					'Search Product Option',
					'extra-product-options-for-woocommerce'
				),
				'epofw-prd-opt'
			);
			$wc_product_options_table->display();
		}
		/**
		 * Add_product_option_form function.
		 *
		 * @since    1.0.0
		 */
		public static function epofw_add_product_option_form() {
			include EPOFW_PLUGIN_DIR . '/settings/epofw-admin-settings.php';
		}
	}
}
