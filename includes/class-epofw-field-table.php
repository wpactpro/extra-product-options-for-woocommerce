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
if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}
/**
 * EPOFW_Field_Table class.
 *
 * @extends WP_List_Table
 */
if ( ! class_exists( 'EPOFW_Field_Table' ) ) {
	/**
	 * EPOFW_Field_Table class.
	 */
	class EPOFW_Field_Table extends WP_List_Table {
		/**
		 * Count total items
		 *
		 * @var      string $epofw_found_items store count of post.
		 *
		 * @since    1.0
		 */
		private static $epofw_found_items = 0;
		/**
		 * Get post type
		 *
		 * @var $post_type string store post type.
		 *
		 * @since 1.0.0
		 */
		private static $post_type = null;
		/**
		 * Admin object call.
		 *
		 * @var      string $admin_object The class of external plugin.
		 *
		 * @since    1.0.0
		 */
		private static $admin_object = null;
		/**
		 * Get current page.
		 *
		 * @var      string $current_page Getting current page.
		 *
		 * @since 1.0.0
		 */
		private static $current_page = null;
		/**
		 * Get current tab.
		 *
		 * @var      string $current_tab Getting current tab.
		 *
		 * @since 1.0.0
		 */
		private static $current_tab = null;
		/**
		 * Get_columns function.
		 *
		 * @return  array
		 *
		 * @since 3.5
		 */
		public function get_columns() {
			return array(
				'cb'     => '<input type="checkbox" />',
				'title'  => esc_html__( 'Field Title', 'extra-product-options-for-woocommerce' ),
				'status' => esc_html__( 'Status', 'extra-product-options-for-woocommerce' ),
				'date'   => esc_html__( 'Date', 'extra-product-options-for-woocommerce' ),
			);
		}
		/**
		 * Get_sortable_columns function.
		 *
		 * @return array
		 *
		 * @since 1.0.0
		 */
		protected function get_sortable_columns() {
			$columns = array(
				'title' => array( 'title', true ),
				'date'  => array( 'date', false ),
			);
			return $columns;
		}
		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			parent::__construct(
				array(
					'singular' => 'post',
					'plural'   => 'posts',
					'ajax'     => false,
				)
			);
			self::$admin_object = new EPOFW_Admin();
			self::$current_page = self::$admin_object->epofw_current_page();
			self::$current_tab  = self::$admin_object->epofw_current_tab();
			self::$post_type    = EPOFW_DFT_POST_TYPE;
		}
		/**
		 * Get Methods to display.
		 *
		 * @since 1.0.0
		 */
		public function prepare_items() {
			$this->prepare_column_headers();
			$per_page    = $this->get_items_per_page( 'epofw_per_page' );
			$get_search  = filter_input( INPUT_POST, 's', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			$get_search  = isset( $get_search ) ? sanitize_text_field( wp_unslash( $get_search ) ) : '';
			$get_orderby = filter_input( INPUT_GET, 'orderby', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			$get_orderby = isset( $get_orderby ) ? sanitize_text_field( wp_unslash( $get_orderby ) ) : '';
			$get_order   = filter_input( INPUT_GET, 'order', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			$get_order   = isset( $get_order ) ? sanitize_text_field( wp_unslash( $get_order ) ) : '';
			$args        = array(
				'posts_per_page' => $per_page,
				'orderby'        => 'ID',
				'order'          => 'DESC',
				'offset'         => ( $this->get_pagenum() - 1 ) * $per_page,
			);
			if ( ! empty( $get_search ) ) {
				$args['s'] = trim( wp_unslash( $get_search ) );
			}
			if ( ! empty( $get_orderby ) ) {
				if ( 'title' === $get_orderby ) {
					$args['orderby'] = 'title';
				} elseif ( 'date' === $get_orderby ) {
					$args['orderby'] = 'date';
				}
			}
			if ( ! empty( $get_order ) ) {
				if ( 'asc' === strtolower( $get_order ) ) {
					$args['order'] = 'ASC';
				} elseif ( 'desc' === strtolower( $get_order ) ) {
					$args['order'] = 'DESC';
				}
			}
			$this->items = $this->epofw_find( $get_orderby, $args );
			$total_items = $this->epofw_count();
			$total_pages = ceil( $total_items / $per_page );
			$this->set_pagination_args(
				array(
					'total_items' => $total_items,
					'total_pages' => $total_pages,
					'per_page'    => $per_page,
				)
			);
		}
		/**
		 * If no listing found then display message.
		 *
		 * @since 1.0.0
		 */
		public function no_items() {
			esc_html_e( 'No Field Option found.', 'extra-product-options-for-woocommerce' );
		}

		/**
		 * Checkbox column.
		 *
		 * @since 1.0.0
		 *
		 * @param object $item Get Field Option id.
		 *
		 * @return string|void
		 */
		public function column_cb( $item ) {
			if ( ! $item->ID ) {
				return;
			}
			return sprintf( '<input type="checkbox" name="%1$s[]" value="%2$s" />', 'method_id_cb', esc_attr( $item->ID ) );
		}
		/**
		 * Output the shipping name column.
		 *
		 * @param object $item Get Field Option id.
		 *
		 * @since 1.0.0
		 */
		public function column_title( $item ) {
			$editurl     = self::$admin_object->dynamic_url( self::$current_page, self::$current_tab, 'edit', $item->ID );
			$method_name = '<strong>
                            <a href="' . wp_nonce_url( $editurl, 'edit_' . $item->ID, 'epofw_nonce' ) . '" class="row-title">' . esc_html( $item->post_title ) . '</a>
                        </strong>';
			echo wp_kses(
				$method_name,
				array(
					'strong' => array(),
					'a'      => array(
						'href'  => array(),
						'class' => array(),
					),
				)
			);
		}
		/**
		 * Generates and displays row action links.
		 *
		 * @param object $item        Link being acted upon.
		 *
		 * @param string $column_name Current column name.
		 *
		 * @param string $primary     Primary column name.
		 *
		 * @return string Row action output for links.
		 *
		 * @since 1.0.0
		 */
		protected function handle_row_actions( $item, $column_name, $primary ) {
			if ( $primary !== $column_name ) {
				return '';
			}
			$editurl              = self::$admin_object->dynamic_url( self::$current_page, self::$current_tab, 'edit', $item->ID );
			$delurl               = self::$admin_object->dynamic_url( self::$current_page, self::$current_tab, 'delete', $item->ID );
			$duplicateurl         = self::$admin_object->dynamic_url( self::$current_page, self::$current_tab, 'duplicate', $item->ID );
			$actions              = array();
			$actions['edit']      = '<a href="' . wp_nonce_url( $editurl, 'edit_' . $item->ID, 'epofw_nonce' ) . '">' . esc_html__( 'Edit', 'extra-product-options-for-woocommerce' ) . '</a>';
			$actions['delete']    = '<a href="' . wp_nonce_url( $delurl, 'del_' . $item->ID, 'epofw_nonce' ) . '">' . esc_html__( 'Delete', 'extra-product-options-for-woocommerce' ) . '</a>';
			$actions['duplicate'] = '<a href="' . wp_nonce_url( $duplicateurl, 'duplicate_' . $item->ID, 'epofw_nonce' ) . '">' . esc_html__( 'Duplicate', 'extra-product-options-for-woocommerce' ) . '</a>';
			return $this->row_actions( $actions );
		}
		/**
		 * Output the method enabled column.
		 *
		 * @param object $item Get Field Option id.
		 *
		 * @return string
		 *
		 * @since 1.0.0
		 */
		public function column_status( $item ) {
			if ( 0 === $item->ID ) {
				return esc_html__( 'Everywhere', 'extra-product-options-for-woocommerce' );
			}
			if ( 'publish' === $item->post_status ) {
				$status = esc_html__( 'Enable', 'extra-product-options-for-woocommerce' );
			} else {
				$status = esc_html__( 'Disable', 'extra-product-options-for-woocommerce' );
			}
			return $status;
		}
		/**
		 * Output the method amount column.
		 *
		 * @param object $item Get Field Option id.
		 *
		 * @return mixed $item->post_date.
		 *
		 * @since 1.0.0
		 */
		public function column_date( $item ) {
			if ( 0 === $item->ID ) {
				return esc_html__( 'Everywhere', 'extra-product-options-for-woocommerce' );
			}
			return $item->post_date;
		}
		/**
		 * Display bulk action in filter.
		 *
		 * @return array $actions
		 *
		 * @since 1.0.0
		 */
		public function get_bulk_actions() {
			$actions = array(
				'disable' => esc_html__( 'Disable', 'extra-product-options-for-woocommerce' ),
				'enable'  => esc_html__( 'Enable', 'extra-product-options-for-woocommerce' ),
				'delete'  => esc_html__( 'Delete', 'extra-product-options-for-woocommerce' ),
			);
			return $actions;
		}
		/**
		 * Process bulk actions.
		 *
		 * @since 1.0.0
		 */
		public function process_bulk_action() {
			$delete_nonce = filter_input( INPUT_POST, '_wpnonce', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			$delete_nonce = isset( $delete_nonce ) ? sanitize_text_field( wp_unslash( $delete_nonce ) ) : '';
			if ( empty( $delete_nonce ) || ! wp_verify_nonce( $delete_nonce, 'bulk-shippingmethods' ) ) {
				return;
			}
			$get_method_id_cb = filter_input( INPUT_POST, 'method_id_cb', FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY );
			$method_id_cb     = ! empty( $get_method_id_cb ) ? array_map( 'sanitize_text_field', wp_unslash( $get_method_id_cb ) ) : array();
			if ( empty( $method_id_cb ) ) {
				return;
			}
			$get_tab = filter_input( INPUT_GET, 'tab', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			$get_tab = isset( $get_tab ) ? sanitize_text_field( wp_unslash( $get_tab ) ) : '';
			if ( empty( $get_tab ) ) {
				$get_tab = 'general';
			}
			$action = $this->current_action();
			if ( ! in_array( $action, array( 'delete', 'enable', 'disable' ), true ) ) {
				return;
			}
			$items = array_filter( array_map( 'absint', $method_id_cb ) );
			if ( ! $items ) {
				return;
			}
			if ( 'delete' === $action ) {
				if ( ! empty( $items ) ) {
					foreach ( $items as $id ) {
						wp_delete_post( $id );
					}
				}
				self::$admin_object->epofw_updated_message( 'deleted', $get_tab, '' );
			} elseif ( 'enable' === $action ) {
				if ( ! empty( $items ) ) {
					foreach ( $items as $id ) {
						$enable_post = array(
							'post_type'   => self::$post_type,
							'ID'          => $id,
							'post_status' => 'publish',
						);
						wp_update_post( $enable_post );
					}
				}
				self::$admin_object->epofw_updated_message( 'enabled', $get_tab, '' );
			} elseif ( 'disable' === $action ) {
				if ( ! empty( $items ) ) {
					foreach ( $items as $id ) {
						$disable_post = array(
							'post_type'   => self::$post_type,
							'ID'          => $id,
							'post_status' => 'draft',
						);
						wp_update_post( $disable_post );
					}
				}
				self::$admin_object->epofw_updated_message( 'disabled', $get_tab, '' );
			}
		}
		/**
		 * Find post data.
		 *
		 * @param string $get_orderby pass order by for listing.
		 * @param mixed  $args        pass query args.
		 *
		 * @return array $posts
		 *
		 * @since 1.0.0
		 */
		public static function epofw_find( $get_orderby, $args = '' ) {
			$defaults          = array(
				'post_status'    => 'any',
				'posts_per_page' => - 1,
				'offset'         => 0,
				'orderby'        => 'ID',
				'order'          => 'ASC',
			);
			$args              = wp_parse_args( $args, $defaults );
			$args['post_type'] = self::$post_type;
			$epofw_query       = new WP_Query( $args );
			$posts             = $epofw_query->query( $args );
			if ( ! isset( $get_orderby ) ) {
				$sort_order     = array();
				$get_sort_order = get_option( 'sm_sortable_order' );
				if ( ! empty( $get_sort_order ) ) {
					foreach ( $get_sort_order as $sort ) {
						$sort_order[ $sort ] = array();
					}
				}
				if ( ! empty( $posts ) ) {
					foreach ( $posts as $carrier_id => $carrier ) {
						$carrier_name = $carrier->ID;
						if ( array_key_exists( $carrier_name, $sort_order ) ) {
							$sort_order[ $carrier_name ][ $carrier_id ] = $posts[ $carrier_id ];
							unset( $posts[ $carrier_id ] );
						}
					}
				}
				if ( ! empty( $sort_order ) ) {
					foreach ( $sort_order as $carriers ) {
						$posts = array_merge( $posts, $carriers );
					}
				}
			}
			self::$epofw_found_items = $epofw_query->found_posts;
			return $posts;
		}
		/**
		 * Count post data.
		 *
		 * @return string
		 *
		 * @since 1.0.0
		 */
		public static function epofw_count() {
			return self::$epofw_found_items;
		}
		/**
		 * Set column_headers property for table list.
		 *
		 * @since 1.0.0
		 */
		protected function prepare_column_headers() {
			$this->_column_headers = array(
				$this->get_columns(),
				array(),
				$this->get_sortable_columns(),
			);
		}
	}
}
