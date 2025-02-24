<?php
/**
 * The admin-specific functionality of the plugin.
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
		/**
		 * The object of class.
		 *
		 * @since    1.0.0
		 * @var      string $instance instance object.
		 */
		protected static $instance = null;

		/**
		 * Post type.
		 *
		 * @since 1.0.0
		 * @var $post_type string Store post type.
		 */
		private static $post_type = null;

		/**
		 * Admin object call.
		 *
		 * @since    1.0.0
		 * @var      string $epofw_admin_obj The class of external plugin.
		 */
		private static $epofw_admin_obj = null;

		/**
		 * Get current page.
		 *
		 * @since 1.0.0
		 * @var $current_page string Store current page.
		 */
		private static $current_page = null;

		/**
		 * Get current tab.
		 *
		 * @since 1.0.0
		 * @var $current_tab string Store current tab.
		 */
		private static $current_tab = null;

		/**
		 * Define the plugins name and versions and also call admin section.
		 *
		 * @since    1.0.0
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'extra-product-options-for-woocommerce' ) );
			}
			self::$epofw_admin_obj = new EPOFW_Admin();
			self::$current_page    = EPOFW_Admin::epofw_current_page();
			self::$current_tab     = EPOFW_Admin::epofw_current_tab();
			self::$post_type       = EPOFW_DFT_POST_TYPE;
			add_action( 'add_new_btn_prd_list', array( $this, 'add_new_btn_prd_list_fn' ), 10, 2 );
		}

		/**
		 * Display output.
		 *
		 * @since    1.0.0
		 * @uses     epofw_save_method
		 * @uses     epofw_add_product_option_form
		 * @uses     epofw_edit_method_screen
		 * @uses     epofw_delete_method
		 * @uses     epofw_duplicate_method
		 * @uses     epofw_list_methods_screen
		 * @uses     EPOFW_Admin::epofw_updated_message()
		 */
		public static function epofw_output() {
			$action          = filter_input( INPUT_GET, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			$action          = ! empty( $action ) ? sanitize_text_field( wp_unslash( $action ) ) : '';
			$allowed_actions = array( 'add', 'edit', 'delete', 'duplicate' );
			$post_id_request = filter_input( INPUT_GET, 'post', FILTER_SANITIZE_NUMBER_INT );
			$post_id_request = isset( $post_id_request ) ? sanitize_text_field( wp_unslash( $post_id_request ) ) : '';
			$epofw_nonce     = filter_input( INPUT_GET, 'epofw_nonce', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			$epofw_nonce     = isset( $epofw_nonce ) ? sanitize_text_field( wp_unslash( $epofw_nonce ) ) : '';
			$get_epofw_add   = filter_input( INPUT_GET, '_wpnonce', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			$get_epofw_add   = isset( $get_epofw_add ) ? sanitize_text_field( wp_unslash( $get_epofw_add ) ) : '';
			$get_tab         = filter_input( INPUT_GET, 'tab', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			$get_tab         = isset( $get_tab ) ? sanitize_text_field( wp_unslash( $get_tab ) ) : '';
			$message         = filter_input( INPUT_GET, 'message', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			$message         = isset( $message ) ? sanitize_text_field( wp_unslash( $message ) ) : '';
			if ( ! empty( $action ) && in_array( $action, $allowed_actions, true ) ) {
				if ( 'add' === $action ) {
					self::epofw_save_method();
					self::epofw_add_product_option_form();
				} elseif ( 'edit' === $action ) {
					if ( ! empty( $epofw_nonce ) ) {
						$getnonce = wp_verify_nonce( $epofw_nonce, 'edit_' . $post_id_request );
						if ( isset( $getnonce ) && 1 === $getnonce ) {
							self::epofw_edit_method_screen( $post_id_request );
						} else {
							wp_safe_redirect(
								esc_url_raw(
									add_query_arg(
										array(
											'page' => 'epofw-start-page',
											'tab'  => 'extra_product_option',
										),
										admin_url( 'admin.php' )
									)
								)
							);
							exit;
						}
					} elseif ( ! empty( $get_epofw_add ) ) {
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
			if ( ! empty( $message ) ) {
				EPOFW_Admin::epofw_updated_message( $message, $get_tab, '' );
			}
		}

		/**
		 * Delete Field Option.
		 *
		 * @since    1.0.0
		 *
		 * @param int $id Get Field Option id.
		 *
		 * @uses     Extra_Product_Options_For_WooCommerce::epofw_updated_message()
		 */
		public static function epofw_delete_method( $id ) {
			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'extra-product-options-for-woocommerce' ) );
			}
			$epofw_nonce = filter_input( INPUT_GET, 'epofw_nonce', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			$get_tab     = filter_input( INPUT_GET, 'tab', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			$get_tab     = isset( $get_tab ) ? sanitize_text_field( wp_unslash( $get_tab ) ) : '';
			$getnonce    = wp_verify_nonce( sanitize_text_field( wp_unslash( $epofw_nonce ) ), 'del_' . $id );
			if ( isset( $getnonce ) && 1 === $getnonce ) {
				wp_delete_post( $id );
				$delet_action_redirect_url = EPOFW_Admin::dynamic_url(
					self::$current_page,
					self::$current_tab,
					'',
					'',
					'',
					'deleted'
				);
				wp_safe_redirect( $delet_action_redirect_url );
				exit;
			} else {
				EPOFW_Admin::epofw_updated_message( 'nonce_check', $get_tab, '' );
			}
		}

		/**
		 * Duplicate Field Option.
		 *
		 * @since    1.0.0
		 *
		 * @param int $id Get Field Option id.
		 *
		 * @uses     Extra_Product_Options_For_WooCommerce::epofw_updated_message()
		 */
		public static function epofw_duplicate_method( $id ) {
			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'extra-product-options-for-woocommerce' ) );
			}
			$epofw_nonce = filter_input( INPUT_GET, 'epofw_nonce', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			$get_tab     = filter_input( INPUT_GET, 'tab', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			$get_tab     = isset( $get_tab ) ? sanitize_text_field( wp_unslash( $get_tab ) ) : '';
			$getnonce    = wp_verify_nonce( sanitize_text_field( wp_unslash( $epofw_nonce ) ), 'duplicate_' . $id );
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
								$meta_value = maybe_unserialize( $meta_data[0] );
								update_post_meta( $new_post_id, $meta_key, $meta_value );
							}
						}
					}
					$duplicat_action_redirect_url = EPOFW_Admin::dynamic_url(
						self::$current_page,
						self::$current_tab,
						'edit',
						$new_post_id,
						esc_attr( $epofw_add ),
						'duplicated'
					);
					wp_safe_redirect( $duplicat_action_redirect_url );
					exit();
				} else {
					$action_redirect_url = EPOFW_Admin::dynamic_url(
						self::$current_page,
						self::$current_tab,
						'',
						'',
						'',
						'failed'
					);
					wp_safe_redirect( $action_redirect_url );
					exit();
				}
			} else {
				EPOFW_Admin::epofw_updated_message( 'nonce_check', $get_tab, '' );
			}
		}

		/**
		 * Count total Field Option.
		 *
		 * @since    1.0.0
		 * @return int $count_method Count total Field Option ID.
		 */
		public static function epofw_count_method() {
			$product_option_args = array(
				'post_type'      => self::$post_type,
				'post_status'    => array( 'publish', 'draft' ),
				'posts_per_page' => -1,
				'orderby'        => 'ID',
				'order'          => 'DESC',
			);
			$sm_post_query       = new WP_Query( $product_option_args );
			$product_option_list = $sm_post_query->posts;

			return count( $product_option_list );
		}

		/**
		 * Option field array.
		 *
		 * @since 1.1
		 *
		 * @param array $gn_value         Option data array.
		 * @param array $new_field_op_arr New Field data array.
		 *
		 * @return array
		 */
		private static function epofw_option_field_arr( $gn_value, $new_field_op_arr ) {
			$gn_label_value = epofw_check_array_key_exists( 'label', $gn_value );
			if ( $gn_label_value ) {
				foreach ( $gn_label_value as $l_key => $l_value ) {
					$gn_opt_price = epofw_check_array_key_exists( 'opt_price', $gn_value );
					if ( $gn_opt_price ) {
						foreach ( $gn_opt_price as $gop_key => $gop_value ) {
							$gn_opt_price_type = epofw_check_array_key_exists( 'opt_price_type', $gn_value );
							if ( $gn_opt_price_type ) {
								foreach ( $gn_opt_price_type as $gopt_key => $gopt_value ) {
									$gn_opt_cs = epofw_check_array_key_exists( 'epofw_cs_switcher', $gn_value );
									if ( $gn_opt_cs ) {
										foreach ( $gn_opt_cs as $gocs_key => $gocs_value ) {
											if (
												$l_key === $gop_key
												&& $l_key === $gopt_key
												&& $gop_key === $gopt_key
												&& $l_key === $gocs_key
												&& $gop_key === $gocs_key
												&& $gopt_key === $gocs_key
											) {
												$new_field_op_arr[ $gocs_value ] = $l_value . '||' . $gopt_value . '||' . $gop_value . '||' . $gocs_value;
											}
										}
									} elseif ( $l_key === $gop_key && $l_key === $gopt_key && $gop_key === $gopt_key ) {
										$new_field_op_arr[ $l_value ] = $l_value . '||' . $gopt_value . '||' . $gop_value;
									}
								}
							}
						}
					}
				}
			}

			return $new_field_op_arr;
		}

		/**
		 * Save Field Option when add or edit.
		 *
		 * @since    1.0.0
		 *
		 * @param int $method_id Product Field id.
		 *
		 * @return bool false when nonce is not verified.
		 * @uses     epofw_count_method()
		 * @uses     Extra_Product_Options_For_WooCommerce::epofw_updated_message()
		 */
		private static function epofw_save_method( $method_id = 0 ) {
			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'extra-product-options-for-woocommerce' ) );
			}
			$action                        = filter_input( INPUT_GET, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			$epofw_save                    = filter_input( INPUT_POST, 'epofw_save', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			$epofw_save                    = isset( $epofw_save ) ? sanitize_text_field( wp_unslash( $epofw_save ) ) : '';
			$woocommerce_save_method_nonce = filter_input( INPUT_POST, 'woocommerce_save_method_nonce', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			if ( ( isset( $action ) && ! empty( $action ) ) ) {
				if ( ! empty( $epofw_save ) ) {
					if (
						! isset( $_POST['woocommerce_save_method_nonce'] ) ||
						! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['woocommerce_save_method_nonce'] ) ), 'woocommerce_save_method' )
					) {
						wp_die( esc_html__( 'Security check failed.', 'extra-product-options-for-woocommerce' ) );
					}
					$epofw_data            = ! empty( $_POST['epofw_data'] ) ? sanitize_array( $_POST['epofw_data'] ) : array(); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized, WordPress.Security.ValidatedSanitizedInput.MissingUnslash
					$epofw_shipping_status = '';
					$post_title            = '';
					$new_epofw_data        = array();
					if ( ! empty( $epofw_data ) ) {
						foreach ( $epofw_data as $epofw_key => $epofw_sub_data ) {
							if ( 'general' === $epofw_key && ! empty( $epofw_sub_data ) ) {
								foreach ( $epofw_sub_data as $epofw_field_key => $epofw_field_value ) {
									if ( ! empty( $epofw_field_value ) ) {
										foreach ( $epofw_field_value as $field_key => $field_value ) {
											if ( ! empty( $field_value ) ) {
												if ( ! empty( $field_value ) && is_array( $field_value ) ) {
													foreach ( $field_value as $key => $gn_value ) {
														$new_field_op_arr = array();
														if ( 'class' === $key ) {
															unset( $new_epofw_data['general'][ $epofw_field_key ][ $field_key ][ $key ] );
															$modified_class    = $gn_value;
															$field_restriction = epofw_check_array_key_exists( 'field_restriction', $field_value );
															if ( $field_restriction ) {
																$modified_class .= '||epofw_' . $field_restriction;
															}
															$new_epofw_data['general'][ $epofw_field_key ][ $field_key ][ $key ] = $modified_class;
														} elseif ( 'options' === $key ) {
															$new_field_op_arr_data = self::epofw_option_field_arr( $gn_value, $new_field_op_arr );

															$new_epofw_data['general'][ $epofw_field_key ][ $field_key ][ $key ] = $new_field_op_arr_data;
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
												} else {
													$new_epofw_data['general'][ $epofw_field_key ][ $field_key ] = $field_value;
												}
											}
										}
									}
								}
							} elseif ( 'additional_rule_data' === $epofw_key ) {
								$new_epofw_additional = array();
								if ( ! empty( $epofw_data ) && isset( $epofw_data['additional_rule_data'] ) ) {
									$new_epofw_additional = $epofw_data['additional_rule_data'];
								}
								$new_epofw_data['additional_rule_data'] = $new_epofw_additional;
							} else {
								if ( 'epofw_addon_name' === $epofw_key ) {
									$post_title = $epofw_sub_data;
								} elseif ( 'epofw_addon_status' === $epofw_key ) {
									$epofw_shipping_status = $epofw_sub_data;
								}
								$new_epofw_data[ $epofw_key ] = $epofw_sub_data;
							}
						}
					}
					$product_option_count = self::epofw_count_method();
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
							update_post_meta( $method_id, 'epofw_prd_opt_data', $new_epofw_data );
							update_post_meta( $method_id, 'epofw_mgr_status', true );
						}
					} else {
						echo '<div class="updated error"><p>' . esc_html__( 'Error saving Product Option.', 'extra-product-options-for-woocommerce' ) . '</p></div>';

						return false;
					}
					$epofw_add = wp_create_nonce( 'epofw_add' );
					if ( 'add' === $action ) {
						$add_action_redirect_url = EPOFW_Admin::dynamic_url(
							self::$current_page,
							self::$current_tab,
							'edit',
							$method_id,
							esc_attr( $epofw_add ),
							'created'
						);
						wp_safe_redirect( $add_action_redirect_url );
						exit();
					}
					if ( 'edit' === $action ) {
						$edit_action_redirect_url = EPOFW_Admin::dynamic_url(
							self::$current_page,
							self::$current_tab,
							'edit',
							$method_id,
							esc_attr( $epofw_add ),
							'saved'
						);
						wp_safe_redirect( $edit_action_redirect_url );
						exit();
					}
				}
			}
		}

		/**
		 * Edit Product Option screen.
		 *
		 * @since    1.0.0
		 *
		 * @param string $id Get Product Option id.
		 *
		 * @uses     epofw_edit_method()
		 * @uses     epofw_save_method()
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
		 * @param string $text            button text.
		 */
		public function add_new_btn_prd_list_fn( $link_method_url, $text ) {
			?>
			<a href="<?php echo esc_url( $link_method_url ); ?>" class="page-title-action">
				<?php echo esc_html( $text ); ?>
			</a>
			<a href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=epofw_import_all_fields' ), 'epofw_import_fields_nonce' ) ); ?>" class="page-title-action">
				<?php esc_html_e( 'Import Dummy Fields', 'extra-product-options-for-woocommerce' ); ?>
			</a>
			<?php
		}

		/**
		 * List_product_options function.
		 *
		 * @since    1.0.0
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
			$link_method_url = EPOFW_Admin::dynamic_url(
				self::$current_page,
				self::$current_tab,
				'add',
				'',
				'',
				''
			);
			?>
			<h1 class="wp-heading-inline">
				<?php
				esc_html_e( 'Field Listing', 'extra-product-options-for-woocommerce' );
				?>
			</h1>
			<?php
			/**
			 * Fired action before add button for product list.
			 *
			 * @since 1.0.0
			 */
			do_action( 'before_add_new_btn_prd_list' );
			/**
			 * Fired action to add button for product list.
			 *
			 * @since 1.0.0
			 */
			do_action( 'add_new_btn_prd_list', $link_method_url, esc_html__( 'Add New', 'extra-product-options-for-woocommerce' ) );
			/**
			 * Fired action after add button for product list.
			 *
			 * @since 1.0.0
			 */
			do_action( 'after_add_new_btn_prd_list' );
			$request_s = filter_input( INPUT_POST, 's', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			$request_s = isset( $request_s ) ? sanitize_text_field( wp_unslash( $request_s ) ) : '';
			if ( ! empty( $request_s ) ) {
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
