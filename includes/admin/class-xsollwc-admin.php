<?php
/**
 * The admin functionality of the plugin.
 *
 * @link       https://xfiniftysoft.com
 * @since      1.0.0
 *
 * @package    wc_order_limit_lite
 * @subpackage wc_order_limit_lite/includes/admin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

if ( ! class_exists( 'Xsollwc_Admin' ) ) {
	/**
	 * The Admin area functionality of the plugin.
	 *
	 * Admin class perform all function of admin area.
	 *
	 * @package    wc_order_limit_lite
	 * @subpackage wc_order_limit_lite/includes/admin
	 * @author     Xfinity Soft <xfinitysoft@gmail.com>
	 */
	class Xsollwc_Admin {
		/**
		 * Initialize the class and set its properties.
		 *
		 * @since    1.0.0
		 */
		public function __construct() {
			$this->xsollwc_menus();
			add_action( 'admin_enqueue_scripts', array( $this, 'XSOLLWC_enqueue_admin_script' ), 10, 1 );
		}
		/**
		 * Add Submenu in woocommerce menu in admin area.
		 *
		 * @since    1.0.0
		 */
		public function xsollwc_menus() {
			add_submenu_page( 'woocommerce', esc_html__( 'Order Limit Lite for WooCommerce', 'wc-order-limit-lite' ), esc_html__( 'Order Limit Lite for WooCommerce', 'wc-order-limit-lite' ), 'manage_options', 'order-limit-lite-wc', array( $this, 'wcol_menu_callback' ) );
		}

		/**
		 * Callback Function submenu.
		 *
		 * @since    1.0.0
		 */
		public function wcol_menu_callback() {
			$wcol_rule           = new xsollwc_rule();
			$wcol_product_rules  = $wcol_rule->get_product_rules();
			$wcol_category_rules = $wcol_rule->get_category_rules();
			$wcol_settings       = $wcol_rule->get_wcol_settings();
			require 'views/view-wcol-rules.php';
		}

		/**
		 * Enqueue Admin Script.
		 *
		 * @since    1.0.0
		 * @param      string $hook  The name of the page.
		 */
		public function xsollwc_enqueue_admin_script( $hook ) {
			global $post;
			// phpcs:ignore
			wp_register_script( 'select2', XSOLLWC_ROOT_URL . '/assets/js/select2.full.min.js', array( 'jquery' ) );
			// phpcs:ignore
			wp_register_script( 'wcoll-admin-js', XSOLLWC_ROOT_URL . '/assets/js/wcol-admin-script.js', array( 'jquery' ) );
			$script_vars = $this->get_wcol_script_vars();
			wp_localize_script( 'wcoll-admin-js', 'wcol_script_vars', $script_vars );
			// phpcs:ignore
			wp_register_style( 'select2', XSOLLWC_ROOT_URL . '/assets/css/select2.min.css', array() );
			// phpcs:ignore
			wp_register_style( 'wcoll-admin-css', XSOLLWC_ROOT_URL . '/assets/css/wcol-admin-styles.css', array() );
            // phpcs:ignore
			if ( ( isset( $_GET['page'] ) && $_GET['page'] == 'order-limit-lite-wc' ) || ( isset( $_GET['taxonomy'] ) && $_GET['taxonomy'] == 'product_cat' ) || ( $hook == 'post-new.php' && 'product' === $post->post_type ) || ( $hook == 'post.php' && 'product' === $post->post_type ) || $hook == 'user-edit.php' || $hook == 'profile.php' ) {
				wp_enqueue_style( 'select2' );
				wp_enqueue_script( 'select2' );
				wp_enqueue_script( 'wcoll-admin-js' );
				wp_enqueue_style( 'wcoll-admin-css' );
			}
		}

		/**
		 * Get All woocommerce product.
		 *
		 * @since    1.0.0
		 * @return array
		 */
		public function get_all_wc_products() {
			global $wpdb;
            //phpcs:ignore
			$products     = $wpdb->get_results( 
				$wpdb->prepare(
					"SELECT ID as id, post_title as text FROM {$wpdb->prefix}posts 
                WHERE post_status IN ('pending', 'publish', 'private') AND post_type=%s
				ORDER BY post_title",
				'product'
				),
				ARRAY_A
			);
			$all_products = array(
				array(
					'id'   => '-1',
					'text' => 'All Products ',
				),
			);
			$xs_products  = array_merge( $all_products, $products );
			return $xs_products;
		}

		/**
		 * Get All woocommerce product categories.
		 *
		 * @since    1.0.0
		 * @return array
		 */
		public function get_all_wc_products_cat() {
			$args          = array(
				'taxonomy'     => 'product_cat',
				'orderby'      => 'name',
				'show_count'   => 0,
				'pad_counts'   => 0,
				'hierarchical' => 0,
				'title_li'     => '',
				'hide_empty'   => 0,
			);
			$terms         = get_categories( $args );
			$product_cat   = array();
			$product_cat[] = array(
				'id'   => '-1',
				'text' => 'All Categories ',
			);
			if ( is_array( $terms ) ) {
				foreach ( $terms as $term ) {
					$product_cat[] = array(
						'id'   => $term->term_id,
						'text' => $term->name,
					);
				}
			}
			return $product_cat;
		}

		/**
		 * Get all user.
		 *
		 * @since    1.0.0
		 * @return array
		 */
		public function get_all_users() {
			$users = array();
			foreach ( get_users() as $user ) {
				$users[] = array(
					'id'   => $user->ID,
					'text' => $user->user_login,
				);
			}
			return $users;
		}

		/**
		 * Get all roles.
		 *
		 * @since    1.0.0
		 * @return array
		 */
		public function get_all_roles() {
			$roles = array();
			global $wp_roles;
			if ( is_array( $wp_roles->roles ) ) {
				foreach ( $wp_roles->roles as $key => $role ) {
					$roles[] = array(
						'id'   => $key,
						'text' => $role['name'],
					);
				}
			}
			return $roles;
		}

		/**
		 * Get All variable scripts.
		 *
		 * @since    1.0.0
		 * @return array
		 */
		public function get_wcol_script_vars() {
			if ( is_plugin_active( 'wc-vendors/class-wc-vendors.php' ) ) {
				$vendor_plugin = 1;
			} else {
				$vendor_plugin = 0;
			}
			$script_var = array(
				'ajax_url'      => admin_url( 'admin-ajax.php' ),
				'products'      => $this->get_all_wc_products(),
				'categories'    => $this->get_all_wc_products_cat(),
				'users'         => $this->get_all_users(),
				'user_roles'    => $this->get_all_roles(),
				'text1'         => esc_html__( 'Amount', 'wc-order-limit-lite' ),
				'text2'         => esc_html__( 'Quantity', 'wc-order-limit-lite' ),
				'text3'         => esc_html__( 'Sure you want to delete selected Rule(s)', 'wc-order-limit-lite' ),
				'vendor_plugin' => $vendor_plugin,
			);
			return $script_var;
		}

		/**
		 * Add tab in product data panel in woocommerce product.
		 *
		 * @since    1.0.0
		 */
		public function xsollwc_product_data_panel_tab() {
			?><li class="wcol_tab"><a href="#wcol_tab"><?php esc_html_e( 'Order Limit Lite for WooCommerce', 'wc-order-limit-lite' ); ?></a></li>
			<?php
		}

		/**
		 * Add product data panel in woocommerce product.
		 *
		 * @since    1.0.0
		 */
		public function xsollwc_product_data_panel() {
			global $post;
			$xsollwc_rule = new Xsollwc_Rule();
			$post_id      = (string) $post->ID;
			$xs_i         = 0;
			$wcol_rules   = $xsollwc_rule->get_wcol_options_admin( $post_id, 'product' );
			wp_nonce_field( 'wcol_save_rules', '_wcol_save_rules_nonce', true );
			?>
			<div id="wcol_tab" class="panel woocommerce_options_panel wc-metaboxes-wrapper">
				
				<div class="toolbar">
					<div class="">
						<span class="spinner wcol_spinner"></span>
						<?php wp_nonce_field( 'wcol_new_rule', '_wcol_new_rule_nonce', true ); ?>
						<a id="wcol_add_new_rule" class="button" href="#"><?php esc_html_e( 'Add New Rule', 'wc-order-limit-lite' ); ?></a>
					</div>
					<div class="clear"></div>
				</div>
				
				<div class="wc-metaboxes">
					<?php
					if ( is_array( $wcol_rules ) ) {
						foreach ( $wcol_rules as $mkey => $wcol_options ) {
							$max_limit = $wcol_options['wcol_max_order_limit'];
							$min_limit = $wcol_options['wcol_min_order_limit'];
							if ( empty( $max_limit ) || 'on' !== $wcol_options['enable-max-rule-limit'] ) {
								$max_limit = '<span style="font-size:20px; font-weight:bold;vertical-align: text-bottom;">∞</span>';
							} elseif ( 'amount' === $wcol_options['wcol_applied_on'] ) {
									$max_limit = wc_price( $max_limit );
							}
							if ( 'amount' === $wcol_options['wcol_applied_on'] ) {
								$min_limit = wc_price( $min_limit );
							}
							?>
							<div class="wc-metabox closed 
									<?php
									if ( isset( $wcol_options['accomulative'] ) && 'on' === $wcol_options['accomulative'] ) {
										echo 'wcol_accomulative_rule';}
									?>
									">
								<h3>
									<?php
										//phpcs:ignore
										echo esc_html__( 'Rule for all users', 'wc-order-limit-lite' ) . ' - ' . $min_limit . ' - ' . $max_limit;
									?>
									<span class="wcol-delete"><?php esc_html_e( 'Delete', 'wc-order-limit-lite' ); ?></span>
								</h3>
								<div class="wc-metabox-content" style="display:none;">
									<input type="hidden" value="<?php echo esc_html( $wcol_options['rule-id'] ); ?>" name="wcol_rules[rule-id][<?php echo esc_html( $mkey ); ?>]"/>
									<input type="hidden" value="<?php echo esc_html( $wcol_options['key'] ); ?>" name="wcol_rules[wcol_rule_key][<?php echo esc_html( $mkey ); ?>]"/>
									<?php if ( isset( $wcol_options['accomulative'] ) && 'on' === $wcol_options['accomulative'] ) { ?>
									<input type="hidden" class="wcol-loop-checkbox-hidden wcol_accomulative" value="<?php echo esc_html( $wcol_options['accomulative'] ); ?>" name="wcol_rules[accomulative][<?php echo esc_html( $mkey ); ?>]"/>
									<div class="options_group">
										<p class="form-field">
											<label><?php esc_html_e( 'Edit This Rule:', 'wc-order-limit-lite' ); ?></label>
											<span class="wcol-help-tip" style="float:none;">
												<span class="wcol-tip" > <?php esc_html_e( "This Product is included in a Rule that is being applied accomulatively with other products so if you edit this products's limit options then it will be excluded from that accomulative rule.", 'wc-order-limit-lite' ); ?> </span>
											</span>
											<input type="checkbox" class="wcol_edit_rule" />
										</p>
									</div>
									<?php } else { ?>
									<input type="hidden" class="wcol_accomulative" value="<?php echo esc_html( $wcol_options['accomulative'] ); ?>" name="wcol_rules[accomulative][<?php echo esc_html( $mkey ); ?>]"/>
									<?php } ?>
									
									<div class="options_group">
										<p class="form-field">
											<label><?php esc_html_e( 'Disable:', 'wc-order-limit-lite' ); ?></label>
											<input type="hidden" class="wcol-loop-checkbox-hidden" name="wcol_rules[disable-limit][<?php echo esc_html( $mkey ); ?>]" value="<?php echo esc_html( $wcol_options['disable-limit'] ); ?>"/>
											<input class="wcol-disable-rule-limit wcol-loop-checkbox" type="checkbox" 
											<?php
											if ( 'on' === $wcol_options['disable-limit'] ) {
												echo 'checked';}
											?>
											/>
										</p>
										<p class="wcol-description"><?php esc_html_e( 'Leave blank for no limit.', 'wc-order-limit-lite' ); ?></p>
									</div>
										
									<div class="options_group">
										<p class="form-field">
											<label><?php esc_html_e( 'Minimum Order:', 'wc-order-limit-lite' ); ?></label>
											<input type="number" min="0"  class="wcol-rule-min-limit 
											<?php
											if ( 'on' === $wcol_options['disable-limit'] ) {
												echo 'wcol-disabled';
											}
											?>
											" name="wcol_rules[wcol_min_order_limit][<?php echo esc_html( $mkey ); ?>]" value="<?php echo isset( $wcol_options['wcol_min_order_limit'] ) ? esc_html( $wcol_options['wcol_min_order_limit'] ) : ''; ?>" placeholder="<?php esc_html_e( 'Enter Minimum Order Limit', 'wc-order-limit-lite' ); ?>" />
										</p>
										<p class="wcol-description"><?php esc_html_e( 'Leave blank for no limit.', 'wc-order-limit-lite' ); ?></p>
									</div>
									<div class="options_group">
										<p class="form-field">
											<label><?php esc_html_e( 'Enable Maximum Limit:', 'wc-order-limit-lite' ); ?></label>
											<input type="hidden" class="enable-max-rule-limit-hidden wcol-loop-checkbox-hidden" value="<?php echo esc_html( $wcol_options['enable-max-rule-limit'] ); ?>" name="wcol_rules[enable-max-rule-limit][<?php echo esc_html( $mkey ); ?>]"/>
											<input type="checkbox" class="wcol-loop-checkbox enable-max-rule-limit 
											<?php
											if ( 'on' === $wcol_options['disable-limit'] ) {
												echo 'wcol-disabled';}
											?>
											"  min="0" 
											<?php
											if ( isset( $wcol_options['enable-max-rule-limit'] ) && $wcol_options['enable-max-rule-limit'] ) {
														echo 'checked';}
											?>
											/>
										</p>
										<p class="form-field 
										<?php
										if ( 'on' !== $wcol_options['enable-max-rule-limit'] ) {
											echo 'wcol-hidden';}
										?>
										">
											<label><?php esc_html_e( 'Maximum Order:', 'wc-order-limit-lite' ); ?></label>
											<input type="number" class="wcol-rule-max-limit 
											<?php
											if ( 'on' === $wcol_options['disable-limit'] ) {
												echo 'wcol-disabled';}
											?>
											" min="0" name="wcol_rules[wcol_max_order_limit][<?php echo esc_html( $mkey ); ?>]" value="<?php echo isset( $wcol_options['wcol_max_order_limit'] ) ? esc_html( $wcol_options['wcol_max_order_limit'] ) : ''; ?>" placeholder="<?php esc_html_e( 'Enter Maximum Order Limit', 'wc-order-limit-lite' ); ?>" />
										</p>
									</div>
									
									<div class="options_group">                                                                        
										<p class="form-field">
											<label><?php esc_html_e( 'Applied on:', 'wc-order-limit-lite' ); ?></label>
											<select class="wcol-applied-on 
											<?php
											if ( 'on' === $wcol_options['disable-limit'] ) {
												echo 'wcol-disabled';}
											?>
											" name="wcol_rules[wcol_applied_on][<?php echo esc_html( $mkey ); ?>]" >
												<option value="amount" 
												<?php
												if ( isset( $wcol_options['wcol_applied_on'] ) && 'amount' === $wcol_options['wcol_applied_on'] ) {
													echo 'selected'; }
												?>
												> <?php esc_html_e( 'Amount', 'wc-order-limit-lite' ); ?> </option>
												<option value="quantity" 
												<?php
												if ( isset( $wcol_options['wcol_applied_on'] ) && 'quantity' === $wcol_options['wcol_applied_on'] ) {
													echo 'selected'; }
												?>
												> <?php esc_html_e( 'Quantity', 'wc-order-limit-lite' ); ?> </option>
											</select>
										</p>
										<p class="wcol-description"><?php esc_html_e( 'Select if limit will be applied on quantity or amount.', 'wc-order-limit-lite' ); ?></p>
									</div>
								</div>	
							</div>
							<?php
							$xs_i = $mkey;
						}
					}
					?>
					<input type="hidden" class="xswcol-spid" value="<?php echo esc_html( $xs_i ); ?>">
				</div>
			</div>
			<?php
		}
		/**
		 * Save post meta product rule.
		 *
		 * @since    1.0.0
		 * @param string $post_id ID of the post.
		 */
		public function process_product_meta_xsollwc_tab( $post_id ) {
			$xsollwc_rule = new Xsollwc_Rule();
			$post_id      = (string) $post_id;
			$xsollwc_rule->save_wcol_options( $post_id, 'product' );
		}
		/**
		 * Add product category data panel.
		 *
		 * @since    1.0.0
		 * @param object $term Object woocommerce category.
		 */
		public function xsollwc_product_cat_fields( $term ) {
			$xsollwc_rule = new Xsollwc_Rule();
			$term_id      = (string) $term->term_id;
			$wcol_rules   = $xsollwc_rule->get_wcol_options_admin( $term_id, 'product_cat' );
			wp_nonce_field( 'wcol_save_rules', '_wcol_save_rules_nonce', true );
			?>
			<tr class="form-field">
				<td colspan="2">
					<h2> <?php esc_html_e( 'Order Limit Lite for WooCommerce', 'wc-order-limit-lite' ); ?> </h2>
					<div class="">
						<span class="spinner wcol_spinner"></span>
						<?php wp_nonce_field( 'wcol_new_rule', '_wcol_new_rule_nonce', true ); ?>
						<a id="wcol_add_new_rule" class="button" href="#"><?php esc_html_e( 'Add New Rule', 'wc-order-limit-lite' ); ?></a>
					</div>
					<div class="clear"></div>
					<div class="wcol_single_cat_rules">
						<?php
						if ( is_array( $wcol_rules ) ) {
							foreach ( $wcol_rules as $mkey => $wcol_options ) {
								$max_limit = $wcol_options['wcol_max_order_limit'];
								$min_limit = $wcol_options['wcol_min_order_limit'];
								if ( empty( $max_limit ) || 'on' !== $wcol_options['enable-max-rule-limit'] ) {
									$max_limit = '<span style="font-size:20px; font-weight:bold;vertical-align: text-bottom;">∞</span>';
								} elseif ( 'amount' === $wcol_options['wcol_applied_on'] ) {
										$max_limit = wc_price( $max_limit );
								}
								if ( 'amount' === $wcol_options['wcol_applied_on'] ) {
									$min_limit = wc_price( $min_limit );
								}
								?>
						<div class="wcol_single_cat_rule 
								<?php
								if ( isset( $wcol_options['accomulative'] ) && 'on' === $wcol_options['accomulative'] ) {
									echo 'wcol_accomulative_rule';}
								?>
								">
							<h3 class="wcol_cat_accordion">
								<?php
								//phpcs:ignore
								echo esc_html__( 'Rule for all users', 'wc-order-limit-lite' ) . ' - ' . $min_limit . ' - ' . $max_limit;
								?>
							<span class="wcol-delete"><?php esc_html_e( 'Delete', 'wc-order-limit-lite' ); ?></span>
							</h3>
							<div class="wcol_cat_panel">
								<input type="hidden" value="<?php echo esc_html( $wcol_options['rule-id'] ); ?>" name="wcol_rules[rule-id][<?php echo esc_html( $mkey ); ?>]"/>
								<input type="hidden" value="<?php echo esc_html( $wcol_options['key'] ); ?>" name="wcol_rules[wcol_rule_key][<?php echo esc_html( $mkey ); ?>]"/>
								<?php if ( isset( $wcol_options['accomulative'] ) && 'on' === $wcol_options['accomulative'] ) { ?>
								<input type="hidden" class="wcol-loop-checkbox-hidden wcol_accomulative" value="<?php echo esc_html( $wcol_options['accomulative'] ); ?>" name="wcol_rules[accomulative][<?php echo esc_html( $mkey ); ?>]"/>
								<div class="options_group">
									<p class="form-field">
										<label><?php esc_html_e( 'Edit This Rule:', 'wc-order-limit-lite' ); ?></label>
										<span class="wcol-help-tip" style="float:none;">
											<span class="wcol-tip" > <?php esc_html_e( "This Product is included in a Rule that is being applied accomulatively with other products so if you edit this products's limit options then it will be excluded from that accomulative rule.", 'wc-order-limit-lite' ); ?> </span>
										</span>
										<input type="checkbox" class="wcol_edit_rule" />
									</p>
								</div>
								<?php } else { ?>
								<input type="hidden" class="wcol_accomulative" value="<?php echo esc_html( $wcol_options['accomulative'] ); ?>" name="wcol_rules[accomulative][<?php echo esc_html( $mkey ); ?>]"/>
								<?php } ?>
								
								<div class="options_group">
									<p class="form-field">
										<label><?php esc_html_e( 'Disable:', 'wc-order-limit-lite' ); ?></label>
										<input type="hidden" class="wcol-loop-checkbox-hidden" name="wcol_rules[disable-limit][<?php echo esc_html( $mkey ); ?>]" value="<?php echo esc_html( $wcol_options['disable-limit'] ); ?>"/>
										<input class="wcol-disable-rule-limit wcol-loop-checkbox" type="checkbox" 
										<?php
										if ( 'on' === $wcol_options['disable-limit'] ) {
											echo 'checked';}
										?>
										/>
									</p>
									<p class="wcol-description"><?php esc_html_e( 'Leave blank for no limit.', 'wc-order-limit-lite' ); ?></p>
								</div>
								
								<div class="options_group">
									<p class="form-field">
										<label><?php esc_html_e( 'Minimum Order:', 'wc-order-limit-lite' ); ?></label>
										<input type="number" min="0"  name="wcol_rules[wcol_min_order_limit][<?php echo esc_html( $mkey ); ?>]" class="wcol-rule-min-limit 
										<?php
										if ( 'on' === $wcol_options['disable-limit'] ) {
											echo 'wcol-disabled';}
										?>
										" value="<?php echo isset( $wcol_options['wcol_min_order_limit'] ) ? esc_html( $wcol_options['wcol_min_order_limit'] ) : ''; ?>" placeholder="<?php esc_html_e( 'Enter Minimum Order Limit', 'wc-order-limit-lite' ); ?>" />
									</p>
									<p class="wcol-description"><?php esc_html_e( 'Leave blank for no limit.', 'wc-order-limit-lite' ); ?></p>
								</div>
									
								<div class="options_group">
									<p class="form-field">
										<label><?php esc_html_e( 'Enable Maximum Limit:', 'wc-order-limit-lite' ); ?></label>
										<input type="hidden" class="wcol-loop-checkbox-hidden enable-max-rule-limit-hidden" value="<?php echo esc_html( $wcol_options['enable-max-rule-limit'] ); ?>" name="wcol_rules[enable-max-rule-limit][<?php echo esc_html( $mkey ); ?>]"/>
										<input type="checkbox" class="wcol-loop-checkbox enable-max-rule-limit 
										<?php
										if ( 'on' === $wcol_options['disable-limit'] ) {
											echo 'wcol-disabled';}
										?>
										"  min="0" 
										<?php
										if ( isset( $wcol_options['enable-max-rule-limit'] ) && $wcol_options['enable-max-rule-limit'] ) {
													echo 'checked';}
										?>
										/>
									</p>
									<p class="form-field 
									<?php
									if ( 'on' !== $wcol_options['enable-max-rule-limit'] ) {
										echo 'wcol-hidden';}
									?>
									">
										<label><?php esc_html_e( 'Maximum Order:', 'wc-order-limit-lite' ); ?></label>
										<input type="number" class="wcol-rule-max-limit 
										<?php
										if ( 'on' === $wcol_options['disable-limit'] ) {
											echo 'wcol-disabled';}
										?>
										" min="0" name="wcol_rules[wcol_max_order_limit][<?php echo esc_html( $mkey ); ?>]" value="<?php echo isset( $wcol_options['wcol_max_order_limit'] ) ? esc_html( $wcol_options['wcol_max_order_limit'] ) : ''; ?>" placeholder="<?php esc_html_e( 'Enter Maximum Order Limit', 'wc-order-limit-lite' ); ?>" />
									</p>
								</div>
								
								<div class="options_group">                                                                        
									<p class="form-field">
										<label><?php esc_html_e( 'Applied on:', 'wc-order-limit-lite' ); ?></label>
										<select class="wcol-applied-on 
										<?php
										if ( 'on' === $wcol_options['disable-limit'] ) {
											echo 'wcol-disabled';}
										?>
										" name="wcol_rules[wcol_applied_on][<?php echo esc_html( $mkey ); ?>]" >
											<option value="amount" 
											<?php
											if ( isset( $wcol_options['wcol_applied_on'] ) && 'amount' === $wcol_options['wcol_applied_on'] ) {
												echo 'selected'; }
											?>
											> <?php esc_html_e( 'Amount', 'wc-order-limit-lite' ); ?> </option>
											<option value="quantity" 
											<?php
											if ( isset( $wcol_options['wcol_applied_on'] ) && 'quantity' === $wcol_options['wcol_applied_on'] ) {
												echo 'selected'; }
											?>
											> <?php esc_html_e( 'Quantity', 'wc-order-limit-lite' ); ?> </option>
										</select>
									</p>
									<p class="wcol-description"><?php esc_html_e( 'Select if limit will be applied on quantity or amount.', 'wc-order-limit-lite' ); ?></p>
								</div>
							</div>
						</div>
								<?php
								$xs_i = $mkey; }
						}
						?>
						<input type="hidden" name="xswcol-spcid" value="<?php echo esc_html( $xs_i ); ?>">
					</div>	
				</td>
			</tr>
			<?php
		}

		/**
		 * Save meta data product  category rule.
		 *
		 * @since    1.0.0
		 * @param string $term_id ID of the category.
		 */
		public function save_xsollwc_product_cat_fields( $term_id ) {
			$xsollwc_rule = new Xsollwc_Rule();
			$term_id      = (string) $term_id;
			$xsollwc_rule->save_wcol_options( $term_id, 'product_cat' );
		}
	}
}
