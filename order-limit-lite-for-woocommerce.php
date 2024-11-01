<?php
/**
 * Plugin Name:         Order Limit Lite for WooCommerce
 * Plugin URI:          http://www.xfinitysoft.com
 * Description:         Set Order limits i.e Minimum Order Limit for vendors, Minimum Order Limit for products, Minimum Order Limit for product categories, Minimum Order Limit for complete order.
 * Author:              Xfinity Soft
 * Author URI:          http://www.xfinitysoft.com/
 *
 * Version:             2.2.3
 * Requires at least:   4.4.0
 * Tested up to:        6.6.1
 *
 * Requires PHP:        7.4
 * Text Domain:         wc-order-limit-lite
 * Domain Path:         /languages
 *
 * @category            Plugin
 * @author              Xfinity Soft
 * @package             WC Order Limit Lite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}
if ( ! class_exists( 'Order_Limit_Lite_Wc' ) ) {
	/**
	 * The Admin area functionality of the plugin.
	 *
	 * Main Class of plugin run.
	 *
	 * @package    wc_order_limit_lite
	 * @subpackage wc_order_limit_lite
	 * @author     Xfinity Soft <xfinitysoft@gmail.com>
	 */
	class Order_Limit_Lite_Wc {
		/**
		 * The Admin of this plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 * @var      string    $xsollwc_admin    The admin of this plugin.
		 */
		private $xsollwc_admin;
		/**
		 * Constructor.
		 *
		 * @since    1.0.0
		 */
		public function __construct() {
			register_activation_hook( __FILE__, array( $this, 'order_limit_lite_wc_activation_hook' ) );
			add_action( 'admin_init', array( $this, 'xsollwc_check_pro_version' ) );
			add_action( 'init', array( $this, 'xsollwc_load_translation_files' ) );
			add_action( 'init', array( $this, 'xsollwc_define_constants' ) );
			add_action( 'init', array( $this, 'load_plugins_files' ) );
			add_action( 'admin_menu', array( $this, 'load_xsollwc_admin_menu' ) );
			add_action( 'admin_init', array( $this, 'load_xsollwc_admin' ) );
		}
		/**
		 * Check if WooCommerce is installed and activated.
		 *
		 * @since    1.0.0
		 */
		public function order_limit_lite_wc_activation_hook() {
			if ( ! class_exists( 'WooCommerce' ) ) {
				deactivate_plugins( plugin_basename( __FILE__ ) );
				wp_die( esc_html__( 'WC Order Limit Lite requires WooCommerce to run. Please install WooCommerce and activate before attempting to activate again.', 'wc-order-limit-lite' ) );
			}
			if ( class_exists( 'WC_Order_limit' ) ) {
				deactivate_plugins( plugin_basename( __FILE__ ) );
				add_action( 'admin_notices', array( $this, 'xsollwc_admin_notice__error' ) );
			}
			$this->create_xsollwc_defaults();
		}
		/**
		 * Set default option.
		 *
		 * @since    1.0.0
		 */
		public function create_xsollwc_defaults() {
			$defaults = array(
				'wcol_limit_rules'    => array(),
				'wcol_customer_rules' => array(),
				'wcol_settings'       => array(
					'product_limit_message'               => '{product-name} product minimum {applied-on} should be greater than {min-limit} and less than {max-limit}.',
					'product_limit_message_across_all_orders' => 'You can buy maximum {max-limit} items of {product-name} {time-span}, your limit is reached. You will be able to place buy more after {limit-reset-day}.',
					'product_limit_message_accomulative'  => 'Following products accomulative {applied-on} should be greater than {min-limit} and less than {max-limit}.<br/>{product-names}.',
					'category_limit_message'              => '{category-name} category item minimum {applied-on} should be greater than {min-limit} and less than {max-limit}.',
					'category_limit_message_across_all_orders' => 'You can buy maximum {max-limit} items of {category-name} {time-span}, your limit is reached. You will be able to place buy more after {limit-reset-day}.',
					'category_limit_message_accomulative' => 'Following Categorys products accomulative {applied-on} should be greater than {min-limit} and less than {max-limit}.<br/>{category-names}.',
					'vendor_limit_message'                => '{vendor-shop-name} item minimum {applied-on} should be greater than {min-limit} and less than {max-limit}.',
					'cart_total_limit_message'            => 'You must have an order with a minimum of {min-limit} and maximum of {max-limit} {applied-on} to place this order.',
					'customer_message'                    => 'You can place {rule-limit} order(s) {time-span}, your limit is reached. You will be able to place your order after {limit-reset-day}.',
					'customer_message_total_amount'       => 'You can order maximum of {rule-limit} amount {time-span}, your limit is reached. You will be able to place order after {limit-reset-day}.',
					'enable_product_limit'                => 'on',
					'enable_category_limit'               => 'on',
					'enable_cart_total_limit'             => 'on',
					'enable_checkout_button'              => 'on',
					'enable_vendor_limit'                 => 'off',
					'enable_customer_limit'               => 'off',
					'weekly_limit_reset_date'             => 'monday',
					'monthly_limit_reset_date'            => '1',
				),

			);
			$wcol_options = get_option( 'wcol_options' );
			if ( empty( $wcol_options ) || ! is_array( $wcol_options ) ) {
				add_option( 'wcol_options', $defaults );
			} elseif ( ! isset( $wcol_options['wcol_settings']['customer_message'] ) ) {
				$wcol_options['wcol_settings']['customer_message']              = 'You can place {rule-limit} order(s) {time-span}, your limit is reached. You will be able to place your order after {limit-reset-day}.';
				$wcol_options['wcol_settings']['customer_message_total_amount'] = 'You can order maximum of {rule-limit} amount {time-span}, your limit is reached. You will be able to place order after {limit-reset-day}.';
				$wcol_options['wcol_settings']['weekly_limit_reset_date']       = 'monday';
				$wcol_options['wcol_settings']['monthly_limit_reset_date']      = '1';
				$wcol_options['wcol_settings']['enable_customer_limit']         = 'on';
				update_option( 'wcol_options', $wcol_options );
			} elseif ( ! isset( $wcol_options['wcol_settings']['product_limit_message_across_all_orders'] ) ) {
				$wcol_options['wcol_settings']['product_limit_message_across_all_orders']  = 'You can buy maximum {max-limit} items of {product-name} {time-span}, your limit is reached. You will be able to place buy more after {limit-reset-day}.';
				$wcol_options['wcol_settings']['product_limit_message_accomulative']       = 'Following products accomulative {applied-on} should be greater than {min-limit} and less than {max-limit}.<br/>{product-names}.';
				$wcol_options['wcol_settings']['category_limit_message_across_all_orders'] = 'You can buy maximum {max-limit} items of {category-name} {time-span}, your limit is reached. You will be able to place buy more after {limit-reset-day}.';
				$wcol_options['wcol_settings']['category_limit_message_accomulative']      = "Following Category's products accomulative {applied-on} should be greater than {min-limit} and less than {max-limit}.<br/>{category-name}.";
				update_option( 'wcol_options', $wcol_options );
			}
		}
		/**
		 * Show Error notice.
		 *
		 * @since    1.0.0
		 */
		public function xsollwc_admin_notice__error() {
			$class   = 'notice notice-error';
			$message = esc_html__( 'WC Order Limit has activated so WC Order Limit Lite  is deactivate beacuse  both version not run at same time', 'wc-order-limit-lite' );

			printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
		}

		/**
		 * Check pro version is install or not.
		 *
		 * @since    1.0.0
		 */
		public function xsollwc_check_pro_version() {
			if ( class_exists( 'WC_Order_limit' ) ) {
				deactivate_plugins( plugin_basename( __FILE__ ) );
				add_action( 'admin_notices', 'xsollwc_admin_notice__error' );
			}
		}

		/**
		 * Define constants.
		 *
		 * @since    1.0.0
		 */
		public function xsollwc_define_constants() {
			define( 'XSOLLWC_ROOT_FILE', __FILE__ );
			define( 'XSOLLWC_ROOT_PATH', __DIR__ );
			define( 'XSOLLWC_ROOT_URL', plugins_url( '', __FILE__ ) );
			define( 'XSOLLWC_PLUGIN_SLUG', basename( __DIR__ ) );
			define( 'XSOLLWC_PLUGIN_BASE', plugin_basename( __FILE__ ) );
		}

		/**
		 * Call admin hooks.
		 *
		 * @since    1.0.0
		 */
		public function load_xsollwc_admin() {
			add_action( 'woocommerce_product_write_panel_tabs', array( $this->xsollwc_admin, 'XSOLLWC_product_data_panel_tab' ) );
			add_action( 'woocommerce_product_data_panels', array( $this->xsollwc_admin, 'XSOLLWC_product_data_panel' ) );
			add_action( 'woocommerce_process_product_meta', array( $this->xsollwc_admin, 'process_product_meta_xsollwc_tab' ), 10, 2 );
			add_action( 'product_cat_add_form_fields', array( $this->xsollwc_admin, 'XSOLLWC_product_cat_fields' ), 10, 1 );
			add_action( 'product_cat_edit_form_fields', array( $this->xsollwc_admin, 'XSOLLWC_product_cat_fields' ), 10, 1 );
			add_action( 'edited_product_cat', array( $this->xsollwc_admin, 'save_xsollwc_product_cat_fields' ), 10, 1 );
			add_action( 'created_product_cat', array( $this->xsollwc_admin, 'save_xsollwc_product_cat_fields_on_add_new' ), 10, 2 );
		}

		/**
		 * Load admin menu.
		 *
		 * @since    1.0.0
		 */
		public function load_xsollwc_admin_menu() {
			$this->xsollwc_admin = new Xsollwc_Admin();
		}

		/**
		 * Load plugins files.
		 *
		 * @since    1.0.0
		 */
		public function load_plugins_files() {
			include XSOLLWC_ROOT_PATH . '/includes/class-xsollwc-rule.php';
			include XSOLLWC_ROOT_PATH . '/includes/admin/class-xsollwc-admin.php';
			do_action( 'xsollwc_rule_inherit' );
		}

		/**
		 * Load plugins translate file.
		 *
		 * @since    1.0.0
		 */
		public function xsollwc_load_translation_files() {
			load_plugin_textdomain( 'wc-order-limit-lite', false, basename( __DIR__ ) . '/languages' );
		}
	}
}
$order_limit_lite_wc = new Order_Limit_Lite_Wc();
