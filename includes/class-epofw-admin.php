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
if ( ! class_exists( 'EPOFW_Admin' ) ) {
	/**
	 * EPOFW_Admin class.
	 */
	class EPOFW_Admin {
		protected static $_instance = null;
		/**
		 * The name of this plugin.
		 *
		 * @since    1.0.0
		 * @var      string $plugin_name The ID of this plugin.
		 */
		private $plugin_name;
		/**
		 * The version of this plugin.
		 *
		 * @since    1.0.0
		 * @var      string $version The current version of this plugin.
		 */
		private $version;
		/**
		 * Get current page.
		 *
		 * @var $page Store current page.
		 *
		 * @since 1.0.0
		 */
		private $page;
		/**
		 * Get current tab.
		 *
		 * @var $current_tab Store current tab.
		 *
		 * @since 1.0.0
		 */
		private $current_tab;
		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			$this->plugin_name = 'Extra Product Options For WooCommerce';
			$this->version     = EPOFW_PLUGIN_VERSION;
			require_once EPOFW_PLUGIN_DIR . '/includes/class-epofw-field-setting.php';
			require_once EPOFW_PLUGIN_DIR . '/includes/class-epofw-admin-notice.php';
			$this->epofw_init();
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
		 * Register actions and filters.
		 *
		 * @since    1.0.0
		 */
		public function epofw_init() {
			$prefix = is_network_admin() ? 'network_admin_' : '';
			add_action( 'admin_menu', array( $this, 'epofw_menu' ) );
			add_action( 'init', array( $this, 'epofw_post_type' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'epofw_enqueue_scripts_fn' ) );
			add_filter(
				'epofw_getting_page',
				array(
					$this,
					'epofw_getting_page_fn',
				),
				10
			);
			add_filter(
				'epofw_ie_admin_tab_ft',
				array(
					$this,
					'epofw_admin_tab',
				),
				10
			);
			add_filter(
				"{$prefix}plugin_action_links_" . plugin_basename( __FILE__ ),
				array(
					$this,
					'epofw_plugin_action_links',
				),
				10
			);
			add_action( 'wp_ajax_epofw_change_field_basedon_type', array( $this, 'epofw_change_field_basedon_type' ) );
			add_action( 'wp_ajax_nopriv_epofw_change_field_basedon_type', array(
				$this,
				'epofw_change_field_basedon_type',
			) );
			add_action( 'wp_ajax_epofw_get_data_based_on_cd', array( $this, 'epofw_get_data_based_on_cd' ) );
			add_action( 'wp_ajax_nopriv_epofw_get_data_based_on_cd', array( $this, 'epofw_get_data_based_on_cd' ) );
		}
		/**
		 * Post type register
		 *
		 * @since 1.0.0
		 */
		public function epofw_post_type() {
			register_post_type(
				EPOFW_DFT_POST_TYPE,
				array(
					'labels' => array(
						'name'          => esc_html__( 'Extra Product Option', 'extra-product-options-for-woocommerce' ),
						'singular_name' => esc_html__( 'Extra Product Option', 'extra-product-options-for-woocommerce' ),
					),
				)
			);
		}
		/**
		 * Where condition for WP_Query.
		 *
		 * @param mixed $where    Where condition for WP_Query.
		 *
		 * @param mixed $wp_query WP_Query - For getting posts data.
		 *
		 * @return mixed $where Where condition for WP_Query.
		 *
		 * @since    1.0.0
		 */
		public function epofw_posts_where( $where, $wp_query ) {
			global $wpdb;
			$search_term = $wp_query->get( 'search_pro_title' );
			if ( ! empty( $search_term ) ) {
				$search_term_like = $wpdb->esc_like( $search_term );
				$where            .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( $search_term_like ) . '%\'';
			}
			return $where;
		}
		/**
		 * Get data based on conditional rule.
		 *
		 * @since    1.0.0
		 */
		public function epofw_get_data_based_on_cd() {
			$request_value     = filter_input( INPUT_POST, 'value', FILTER_SANITIZE_STRING );
			$post_value        = isset( $request_value ) ? sanitize_text_field( epofw_get_cyric_string_to_latin( $request_value ) ) : '';
			$current_condition = filter_input( INPUT_POST, 'current_condition', FILTER_SANITIZE_STRING );
			$current_val       = isset( $current_condition ) ? sanitize_text_field( $current_condition ) : 'product';
			$data_array        = array();
			if ( 'product' === $current_val ) {
				$args = array(
					'post_type'      => 'product',
					'post_status'    => 'publish',
					'posts_per_page' => '-1',
					'fields'         => 'ids',
				);
				if ( isset( $post_value ) ) {
					$args['search_pro_title'] = $post_value;
					add_filter( 'posts_where', array( $this, 'epofw_posts_where' ), 10, 2 );
					$prd_query = new WP_Query( $args );
					remove_filter( 'posts_where', array( $this, 'epofw_posts_where' ), 10, 2 );
				} else {
					$prd_query = new WP_Query( $args );
				}
				if ( ! empty( $prd_query ) ) {
					foreach ( $prd_query->posts as $prd_id ) {
						$data_array[] = array( $prd_id, get_the_title( $prd_id ) );
					}
				}
			} else if ( 'category' === $current_val ) {
				$args               = array(
					'taxonomy'   => "product_cat",
					'orderby'    => 'name',
					'hide_empty' => '',
				);
				$product_categories = get_terms( $args );
				if ( ! empty( $product_categories ) ) {
					foreach ( $product_categories as $product_categories_data ) {
						$data_array[] = array( $product_categories_data->term_id, $product_categories_data->name );
					}
				}
			}
			echo wp_json_encode( $data_array );
			wp_die();
		}
		/**
		 * Change field dynamically based on field type.
		 *
		 * @since    1.0.0
		 */
		public function epofw_change_field_basedon_type() {
			$epofw_field = epofw_field_act_arr_fn();
			$current_val     = filter_input( INPUT_POST, 'current_val', FILTER_SANITIZE_STRING );
			$get_post_id     = filter_input( INPUT_POST, 'post', FILTER_SANITIZE_STRING );
			$parent_id       = filter_input( INPUT_POST, 'parent_id', FILTER_SANITIZE_NUMBER_INT );
			$get_post_id_val = isset( $get_post_id ) ? $get_post_id : '';
			ob_start();
			epofw_loop_fields_data( $epofw_field[ $current_val ], '', $get_post_id_val, $parent_id );
			$get_obj_data = ob_get_contents();
			ob_end_clean();
			echo $get_obj_data; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
			wp_die();
		}
		/**
		 * Using tab array.
		 *
		 * @return array $tab_array
		 *
		 * @since 1.0.0
		 */
		public static function epofw_admin_action_tab_fn() {
			$current_tab_array = array(
				'field-section' => esc_html__( 'Product Option', 'extra-product-options-for-woocommerce' ),
				'about_info'    => esc_html__( 'Getting Started', 'extra-product-options-for-woocommerce' ),
			);
			return $current_tab_array;
		}
		/**
		 * Getting Tab array.
		 *
		 * @param array $aon_tab_array Checking array tab.
		 *
		 * @return array $tab_array Checking array tab.
		 *
		 * @since 1.0.0
		 */
		public function epofw_admin_tab( $aon_tab_array ) {
			$current_tab_array = $this->epofw_admin_action_tab_fn();
			if ( ! empty( $aon_tab_array ) ) {
				$tab_array = array_merge( $current_tab_array, $aon_tab_array );
			} else {
				$tab_array = $current_tab_array;
			}
			return $tab_array;
		}
		/**
		 * Add menu in woocommerce main menu.
		 *
		 * @since 1.0.0
		 */
		public function epofw_menu() {
			$this->screen_id = add_submenu_page(
				'edit.php?post_type=product',
				'Extra Product Addons',
				'Extra Product Addons',
				'edit_products',
				'epofw-main',
				array(
					$this,
					'epofw_main_fn',
				)
			);
		}
		/**
		 * Enqueue plugins css and js for admin purpose.
		 *
		 * @since 1.0.0
		 */
		public function epofw_enqueue_scripts_fn( $hook ) {
			wp_enqueue_style( 'epofw-admin-css', EPOFW_PLUGIN_URL . 'assets/css/epofw-admin.css', array(), 'all' );
			if ( false !== strpos( $hook, 'epofw-main' ) ) {
				$get_post_id = filter_input( INPUT_GET, 'post', FILTER_SANITIZE_NUMBER_INT );
				wp_enqueue_style( 'select2-min-css', EPOFW_PLUGIN_URL . 'assets/css/select2.min.css', array(), 'all' );
				if ( class_exists( 'Woocommerce' ) ) {
					wp_enqueue_style( 'woocommerce_admin_styles', WC()->plugin_url() . '/assets/css/admin.css', array(), 'all' );
				}
				wp_enqueue_script(
					'select2-min-js',
					EPOFW_PLUGIN_URL . 'assets/js/select2.full.min.js',
					array(
						'jquery'
					),
					$this->version,
					true
				);
				wp_enqueue_script('jquery-ui-sortable');
				wp_enqueue_script('jquery-ui-datepicker');
				wp_enqueue_script(
					'jquery-ui-timepicker-js',
					EPOFW_PLUGIN_URL . 'assets/js/jquery-ui-timepicker.js',
					array(
						'jquery',
					),
					$this->version,
					true
				);
				wp_enqueue_style(
					'jquery-ui-timepicker-css',
					EPOFW_PLUGIN_URL . 'assets/css/jquery-ui-timepicker.css',
					array(),
					'all'
				);
				wp_enqueue_style( 'wp-color-picker' );
				wp_enqueue_style( 'jquery-ui-css', EPOFW_PLUGIN_URL . 'assets/css/jquery-ui.min.css' );
				wp_enqueue_script(
					'epofw-admin-js',
					EPOFW_PLUGIN_URL . 'assets/js/epofw-admin.js',
					array(
						'jquery',
						'jquery-tiptip',
						'jquery-ui-datepicker',
						'wp-color-picker',
					),
					$this->version,
					true
				);
				wp_localize_script( 'epofw-admin-js', 'epofw_var',
					array(
						'ajaxurl'     => admin_url( 'admin-ajax.php' ),
						'get_post_id' => $get_post_id,
					)
				);
			}
		}
		/**
		 * Manage Field List Page.
		 *
		 * @since    1.0.0
		 */
		public function epofw_main_fn() {
			$this->page        = self::epofw_current_page();
			$this->current_tab = self::epofw_current_tab();
			$current_tab_array = do_action( 'epofw_admin_action_current_tab' );
			if ( has_filter( 'epofw_ie_admin_tab_ft' ) ) {
				$tabing_array = apply_filters( 'epofw_ie_admin_tab_ft', $current_tab_array );
			} else {
				$tabing_array = apply_filters( 'epofw_admin_tab_ft', '' );
			}
			?>
			<div class="wrap woocommerce">
				<form method="post" enctype="multipart/form-data">
					<nav class="nav-tab-wrapper woo-nav-tab-wrapper">
						<?php
						foreach ( $tabing_array as $name => $label ) {
							$url = self::dynamic_url( $this->page, $name );
							echo '<a href="' . esc_url( $url ) . '" class="nav-tab ';
							if ( $this->current_tab === $name ) {
								echo 'nav-tab-active';
							}
							echo '">' . esc_html( $label ) . '</a>';
						}
						?>
					</nav>
					<?php
					if ( has_filter( 'epofw_ie_admin_page_ft' ) ) {
						apply_filters( 'epofw_ie_admin_page_ft', $this->current_tab );
						apply_filters( 'epofw_getting_page', $this->current_tab );
					} else {
						apply_filters( 'epofw_getting_page', $this->current_tab );
					}
					?>
				</form>
			</div>
			<?php
		}
		/**
		 * Getting dynamic url.
		 *
		 * @param string $page_name Getting page name.
		 *
		 * @param string $tab_name  Getting tab name.
		 *
		 * @param string $action    Getting action.
		 *
		 * @param string $post_id   Getting current post id.
		 *
		 * @param string $nonce     Checking nonce if available in url.
		 *
		 * @param string $message   Checking if any dynamic messages pass in url.
		 *
		 * @return mixed $url return url.
		 *
		 * @since 1.0.0
		 */
		public function dynamic_url( $page_name, $tab_name, $action = '', $post_id = '', $nonce = '', $message = '' ) {
			$url_param = array();
			if ( ! empty( $page_name ) ) {
				$url_param['page'] = $page_name;
			}
			if ( ! empty( $tab_name ) ) {
				$url_param['tab'] = $tab_name;
			}
			if ( ! empty( $action ) ) {
				$url_param['action'] = $action;
			}
			if ( ! empty( $post_id ) ) {
				$url_param['post'] = $post_id;
			}
			if ( ! empty( $nonce ) ) {
				$url_param['_wpnonce'] = $nonce;
			}
			if ( ! empty( $message ) ) {
				$url_param['message'] = $message;
			}
			$url = add_query_arg(
				$url_param,
				admin_url( 'edit.php?post_type=product' )
			);
			return $url;
		}
		/**
		 * Getting Page.
		 *
		 * @param string $current_tab Getting current tab name.
		 *
		 * @since 1.0.0
		 */
		public function epofw_getting_page_fn( $current_tab ) {
			if ( 'field-section' === $current_tab ) {
				$epofw_sms = new EPOFW_Field_Setting();
				$epofw_sms->epofw_output();
			} else if ( 'about_info' === $current_tab ) {
				include_once EPOFW_PLUGIN_DIR . '/settings/epofw-about-info.php';
			}
		}
		/**
		 * Get current page.
		 *
		 * @return string $current_page Getting current page name.
		 *
		 * @since 1.0.0
		 */
		public function epofw_current_page() {
			$current_page = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRING );
			return $current_page;
		}
		/**
		 * Get current tab.
		 *
		 * @return string $current_tab Getting current tab name.
		 *
		 * @since 1.0.0
		 */
		public function epofw_current_tab() {
			$current_tab = filter_input( INPUT_GET, 'tab', FILTER_SANITIZE_STRING );
			if ( ! isset( $current_tab ) ) {
				$current_tab = 'field-section';
			}
			return $current_tab;
		}
		/**
		 * Validate message for plugins form.
		 *
		 * @param string $message        Custom Validate message for plugins form.
		 *
		 * @param string $tab            Get current tab for current page.
		 *
		 * @param string $validation_msg Display validation error.
		 *
		 * @return bool
		 *
		 * @since 1.0.0
		 */
		public function epofw_updated_message( $message, $tab, $validation_msg ) {
			if ( empty( $message ) ) {
				return false;
			}
			if ( 'field-section' === $tab ) {
				if ( 'created' === $message ) {
					$updated_message = esc_html__( 'Product Field successfully created.', 'extra-product-options-for-woocommerce' );
				} elseif ( 'saved' === $message ) {
					$updated_message = esc_html__( 'Product Field successfully updated.', 'extra-product-options-for-woocommerce' );
				} elseif ( 'deleted' === $message ) {
					$updated_message = esc_html__( 'Product Field deleted.', 'extra-product-options-for-woocommerce' );
				} elseif ( 'duplicated' === $message ) {
					$updated_message = esc_html__( 'Product Field duplicated.', 'extra-product-options-for-woocommerce' );
				} elseif ( 'disabled' === $message ) {
					$updated_message = esc_html__( 'Product Field disabled.', 'extra-product-options-for-woocommerce' );
				} elseif ( 'enabled' === $message ) {
					$updated_message = esc_html__( 'Product Field enabled.', 'extra-product-options-for-woocommerce' );
				}
				if ( 'failed' === $message ) {
					$failed_messsage = esc_html__( 'There was an error with saving data.', 'extra-product-options-for-woocommerce' );
				} elseif ( 'nonce_check' === $message ) {
					$failed_messsage = esc_html__( 'There was an error with security check.', 'extra-product-options-for-woocommerce' );
				}
				if ( 'validated' === $message ) {
					$validated_messsage = esc_html( $validation_msg );
				}
			} else {
				if ( 'saved' === $message ) {
					$updated_message = esc_html__( 'Settings save successfully', 'extra-product-options-for-woocommerce' );
				}
				if ( 'nonce_check' === $message ) {
					$failed_messsage = esc_html__( 'There was an error with security check.', 'custom-product-option' );
				}
				if ( 'validated' === $message ) {
					$validated_messsage = esc_html( $validation_msg );
				}
			}
			if ( ! empty( $updated_message ) ) {
				echo sprintf( '<div id="message" class="notice notice-success is-dismissible"><p>%s</p></div>', esc_html( $updated_message ) );
				return false;
			}
			if ( ! empty( $failed_messsage ) ) {
				echo sprintf( '<div id="message" class="notice notice-error is-dismissible"><p>%s</p></div>', esc_html( $failed_messsage ) );
				return false;
			}
			if ( ! empty( $validated_messsage ) ) {
				echo sprintf( '<div id="message" class="notice notice-error is-dismissible"><p>%s</p></div>', esc_html( $validated_messsage ) );
				return false;
			}
		}
	}
}
$epofw_admin = new EPOFW_Admin();
